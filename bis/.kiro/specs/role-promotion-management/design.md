# Design Document — Role Promotion Management

## Overview

The Role Promotion Management feature gives the barangay secretary a dedicated page — the **Promotion Manager** — for upgrading an existing `resident` user account to an official role (`captain`, `secretary`, or `sk`) and for reversing that change back to `resident`. No new accounts are created; only the `role` field in the `users` table is changed. The promoted user's credentials, household link, email, and status are untouched.

Key design goals:

- **In-place role mutation**: one field update, no record duplication.
- **Single-holder invariant**: at most one active holder per official role, enforced at the controller _and_ model layers.
- **Live session propagation**: if the affected user is currently logged in, their session's `role` value is patched immediately via CodeIgniter 4's session library pointed at the same session store.
- **Age gating**: age is computed from linked census data (`households` or `household_members`) rather than a field on the `users` table.
- **Layered access control**: routes are guarded by the existing `auth` + `role:secretary` filter chain, and every mutation method re-checks the caller's session role before touching the DB.

---

## Architecture

The feature fits cleanly into the existing CI4 MVC structure. No new libraries or framework configuration are required.

```
┌─────────────────────────────────────────────────────────────────┐
│  Browser (Secretary)                                            │
│   GET /secretary/promotion-manager                              │
│   POST /secretary/promote                                       │
│   POST /secretary/demote/{id}                                   │
└──────────────────┬──────────────────────────────────────────────┘
                   │  HTTP
┌──────────────────▼──────────────────────────────────────────────┐
│  app/Config/Filters.php  (registered aliases)                   │
│  auth  →  AuthFilter     (checks session user_id)               │
│  role  →  RoleFilter     (checks session role vs. allowed list) │
└──────────────────┬──────────────────────────────────────────────┘
                   │  passes
┌──────────────────▼──────────────────────────────────────────────┐
│  app/Controllers/PromotionController.php                        │
│   index()   — loads view with eligible residents & role holders │
│   promote() — validates, calls model, patches session, redirects│
│   demote()  — validates, calls model, patches session, redirects│
└──────┬──────────────────────────────────────────┬───────────────┘
       │ reads/writes                              │ session_id lookup
┌──────▼────────────────────┐      ┌──────────────▼───────────────┐
│  app/Models/UserModel.php │      │  CI4 Session store (files/DB)│
│   getEligibleResidents()  │      │   $_SESSION['role'] update   │
│   getRoleHolders()        │      └──────────────────────────────┘
│   promoteUser()           │
│   demoteUser()            │
└──────┬────────────────────┘
       │ SQL
┌──────▼────────────────────────────────────────────────────────────┐
│  MySQL                                                            │
│   users          (role, status, household_no, …)                 │
│   households     (household_no PK, date_of_birth, …)            │
│   household_members (household_no FK, date_of_birth, …)         │
└───────────────────────────────────────────────────────────────────┘
```

### Data Flow — Promotion

```
Secretary submits POST /secretary/promote
  │
  ▼
PromotionController::promote()
  1. Re-verify session role === 'secretary'           [guard]
  2. Validate POST params (user_id, target_role)      [input]
  3. userModel->find(user_id)
     └─ check role === 'resident', status === 'active' [eligibility]
  4. userModel->getActiveByRole(target_role)
     └─ must return null                              [single-holder]
  5. userModel->promoteUser(user_id, target_role)
     └─ UPDATE users SET role=? WHERE id=? AND role='resident' AND status='active'
  6. patchSessionIfLoggedIn(user_id, 'role', target_role)
  7. redirect()->to('/secretary/promotion-manager')->with('success', …)
```

### Data Flow — Demotion

```
Secretary submits POST /secretary/demote/{id}
  │
  ▼
PromotionController::demote()
  1. Re-verify session role === 'secretary'
  2. Block self-demotion (target_id === session user_id)
  3. userModel->find(id)
     └─ check role is in [captain, secretary, sk]
  4. userModel->demoteUser(id)
     └─ UPDATE users SET role='resident' WHERE id=? AND role IN (…)
  5. patchSessionIfLoggedIn(id, 'role', 'resident')
  6. redirect()->to('/secretary/promotion-manager')->with('success', …)
```

---

## Components and Interfaces

### 1. New Controller — `app/Controllers/PromotionController.php`

```php
namespace App\Controllers;

class PromotionController extends BaseController
{
    protected UserModel $userModel;

    public function __construct() { … }

    /**
     * GET /secretary/promotion-manager
     * Loads eligible resident list and current role holders for the view.
     */
    public function index(): string { … }

    /**
     * POST /secretary/promote
     * Promotes an eligible resident to a selected Official_Role.
     * Redirects back with success or error flash message.
     */
    public function promote(): RedirectResponse { … }

    /**
     * POST /secretary/demote/{id}
     * Demotes an official back to resident.
     * Redirects back with success or error flash message.
     */
    public function demote(int $id): RedirectResponse { … }

    /**
     * Private helper: mutate the target user's live session role value
     * if they currently have an active session in the CI4 session store.
     *
     * CI4 stores sessions as files named ci_session_{session_id}.
     * We use the session handler directly to read/write the correct file
     * via \Config\Services::session() with a forced session ID.
     */
    private function patchSessionIfLoggedIn(int $userId, string $key, string $value): void { … }
}
```

**Method responsibilities:**

| Method | Reads from model | Writes to model | Session side-effect |
|---|---|---|---|
| `index()` | `getEligibleResidents()`, `getRoleHolders()` | — | — |
| `promote()` | `find()`, `getActiveByRole()` | `promoteUser()` | patch target session role |
| `demote()` | `find()` | `demoteUser()` | patch target session role |

---

### 2. New Model Methods — `app/Models/UserModel.php` additions

#### `getEligibleResidents(?string $search = null): array`

Returns all active residents aged ≥ 18, joined to census data for DOB.

```sql
SELECT
    u.id,
    u.last_name,
    u.first_name,
    u.middle_name,
    u.username,
    u.email,
    u.household_no,
    -- Prefer household head DOB; fall back to household_members DOB
    COALESCE(h.date_of_birth, hm.date_of_birth) AS date_of_birth,
    TIMESTAMPDIFF(YEAR,
        COALESCE(h.date_of_birth, hm.date_of_birth),
        CURDATE()
    ) AS age
FROM users u
LEFT JOIN households h
    ON h.household_no = u.household_no
LEFT JOIN household_members hm
    ON hm.household_no = u.household_no
    AND UPPER(TRIM(CONCAT(u.first_name,' ',u.last_name)))
        = UPPER(TRIM(CONCAT(hm.first_name,' ',hm.last_name)))
WHERE u.role   = 'resident'
  AND u.status = 'active'
  AND COALESCE(h.date_of_birth, hm.date_of_birth) IS NOT NULL
  AND TIMESTAMPDIFF(YEAR,
        COALESCE(h.date_of_birth, hm.date_of_birth),
        CURDATE()
      ) >= 18
  -- optional search filter applied in PHP before binding:
  -- AND (CONCAT(u.first_name,' ',u.last_name) LIKE ? OR u.username LIKE ?)
ORDER BY u.last_name ASC, u.first_name ASC
```

The name-matching JOIN to `household_members` mirrors the approach already used in `AuthController::register()`.

#### `getRoleHolders(): array`

Returns an associative array keyed by official role name:

```php
[
  'captain'   => ['id'=>…, 'last_name'=>…, 'first_name'=>…, 'username'=>…] | null,
  'secretary' => … | null,
  'sk'        => … | null,
]
```

Internally calls `getActiveByRole()` (already implemented) for each role.

#### `promoteUser(int $userId, string $targetRole): bool`

Atomically updates `role` only for a row that is still `resident` + `active`:

```sql
UPDATE users
SET role = ?, updated_at = NOW()
WHERE id     = ?
  AND role   = 'resident'
  AND status = 'active'
```

Returns `true` if exactly one row was affected; `false` otherwise (race condition guard).

#### `demoteUser(int $userId): bool`

```sql
UPDATE users
SET role = 'resident', updated_at = NOW()
WHERE id   = ?
  AND role IN ('captain','secretary','sk')
```

Returns `true` if exactly one row was affected.

---

### 3. Session Update Strategy — `patchSessionIfLoggedIn()`

**Problem**: CodeIgniter 4 sessions are per-request — there is no built-in cross-session write API. We need to update another user's session without their request.

**Approach**: CI4 file-based sessions are stored in `writable/session/` as files named `ci_session{id}`. Database-backed sessions (if configured) are in the `ci_sessions` table. We use a stored `session_id` approach:

1. Add a `session_id` column to the `users` table (or use a separate `user_sessions` lookup table) — **preferred approach**: store the session ID on login.
2. On login (`AuthController::login()`), after `session()->set(…)`, call:
   ```php
   $this->userModel->update($userId, ['session_id' => session_id()]);
   ```
3. In `patchSessionIfLoggedIn()`, look up `users.session_id` for the target user. If non-null, instantiate a new CI4 session handler pointed at that session ID and set the `role` key.

**Alternative (simpler, no DB change)**: Write a flag to a lightweight `role_change_queue` PHP array/file that is checked at the top of every authenticated controller. On the target user's next request, their session is refreshed from the DB. This avoids direct session file manipulation.

**Chosen approach for this design**: The **flag-based refresh** pattern, since it requires no additional DB column and is safe across any session driver:

- When a role change is saved, store `['pending_role_refresh' => $userId]` in the `users` table (a tiny `role_refreshed_at` timestamp or `needs_refresh` flag column).
- A `before()` hook in `AuthFilter` (or `BaseController::initController()`) checks: if the current session user's `role` does not match the DB value, update the session and redirect to the new role's dashboard.

**Concrete implementation** in `BaseController::initController()`:

```php
$userId = session()->get('user_id');
if ($userId) {
    $user = $this->userModel->select('role')->find($userId);
    if ($user && $user['role'] !== session()->get('role')) {
        session()->set('role', $user['role']);
        // Redirect to new role dashboard handled by RoleFilter on next access
    }
}
```

This is a single cheap query per authenticated request. The session is corrected transparently on the very next page load of the affected user.

---

### 4. New Routes — added to `/secretary` group in `app/Config/Routes.php`

```php
// Role Promotion Manager
$routes->get('promotion-manager',        'PromotionController::index');
$routes->post('promote',                 'PromotionController::promote');
$routes->post('demote/(:num)',           'PromotionController::demote/$1');
```

These are placed inside the existing `$routes->group('/secretary', ['filter' => ['auth', 'role:secretary']], …)` closure.

---

### 5. Sidebar Navigation Update — `app/Views/dashboard/sidebar.php`

Add one entry to the `'secretary'` array:

```php
['icon' => 'fas fa-exchange-alt', 'label' => 'Promotion Manager', 'key' => 'promotion_manager', 'href' => '/secretary/promotion-manager'],
```

Insert it after the `'create_account'` entry so it appears at the bottom of administrative items.

---

### 6. View — `app/Views/dashboard/secretary/promotion_manager.php`

The view is divided into two main sections:

#### Section A — Current Role Holders (top card)

A three-column card showing the active holder (or "Vacant") for captain, secretary, and SK. Each tile has:
- Role icon + label
- Holder's full name and username (or italic "— Vacant —")
- A "Demote" button (POST form to `/secretary/demote/{id}`), disabled/hidden when vacant

#### Section B — Eligible Residents (bottom card)

- Search bar (client-side JS filter on name/username)
- Table columns: Full Name | Username | Email | Age | Action
- Each row has a "Promote" button that opens a confirmation modal
- Modal asks: "Promote [Name] to which role?" — three radio buttons for captain, secretary, sk
- Roles that already have a holder are visually disabled/labelled in the modal (JS checks the `roleHolders` data passed from controller)

#### UI Wireframe (text)

```
┌─────────────────────────────────────────────────────────────────┐
│  [HEADER GRADIENT]  Promotion Manager                           │
│  Promote active residents to official roles.                     │
└─────────────────────────────────────────────────────────────────┘

┌─── Current Role Holders ────────────────────────────────────────┐
│  ┌─ Captain ──────┐  ┌─ Secretary ────┐  ┌─ SK ───────────┐   │
│  │ Juan dela Cruz │  │  — Vacant —    │  │ Maria Santos   │   │
│  │ @juandc        │  │                │  │ @marias        │   │
│  │ [Demote]       │  │                │  │ [Demote]       │   │
│  └────────────────┘  └────────────────┘  └────────────────┘   │
└─────────────────────────────────────────────────────────────────┘

┌─── Eligible Residents ──────────────────────────────────────────┐
│  [Search bar: name or username…]                                │
│                                                                 │
│  Full Name        │ Username   │ Email              │ Age │ Act │
│  ─────────────────┼────────────┼────────────────────┼─────┼─── │
│  Bautista, Ana    │ @anab      │ ana@example.com    │ 24  │[+] │
│  Reyes, Carlo     │ @carlor    │ carlo@example.com  │ 31  │[+] │
│  …                                                             │
└─────────────────────────────────────────────────────────────────┘

[Promote Modal]
  Promote Ana Bautista to:
  ○ Captain (occupied — Juan dela Cruz)
  ● Secretary
  ○ SK (occupied — Maria Santos)
  [Cancel]  [Confirm Promotion]
```

---

## Data Models

### Existing `users` table — relevant columns

| Column | Type | Notes |
|---|---|---|
| `id` | INT PK | |
| `last_name` | VARCHAR(80) | |
| `first_name` | VARCHAR(80) | |
| `middle_name` | VARCHAR(80) | nullable |
| `username` | VARCHAR(80) | unique |
| `email` | VARCHAR(150) | unique |
| `password` | VARCHAR(255) | bcrypt, not touched by promotion |
| `role` | ENUM(`captain`,`secretary`,`treasurer`,`sk`,`resident`) | mutated by promotion/demotion |
| `status` | ENUM(`active`,`pending`,`inactive`,`rejected`) | not touched by promotion |
| `household_no` | VARCHAR(10) | FK → households; used for DOB JOIN |
| `updated_at` | TIMESTAMP | auto-updated |

### Age Computation JOIN path

```
users.household_no
    └── households.household_no  (head record — use households.date_of_birth)
    └── household_members.household_no  (member record)
            matched by: UPPER(TRIM(user first_name + last_name))
                     == UPPER(TRIM(member first_name + last_name))
            use: household_members.date_of_birth
```

The `COALESCE(h.date_of_birth, hm.date_of_birth)` expression in `getEligibleResidents()` picks whichever source has a value. If both are null (resident not found in census at all), the resident is excluded by the `IS NOT NULL` filter.

### Age formula

```sql
TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())
```

`TIMESTAMPDIFF` correctly handles leap years and produces the number of complete years elapsed, matching the requirement's definition of "full years".

---

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system — essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Eligible Resident Filter Completeness

*For any* population of users with varying roles, statuses, ages, and DOB availability, every user returned by `getEligibleResidents()` SHALL have `role = 'resident'`, `status = 'active'`, a non-null `date_of_birth`, and a computed age ≥ 18; and no user satisfying all those conditions SHALL be absent from the result.

**Validates: Requirements 1.1, 1.2, 7.4, 7.5**

---

### Property 2: Result Sort Order

*For any* non-empty list of eligible residents returned by `getEligibleResidents()`, the list SHALL be sorted such that for every adjacent pair `[i]` and `[i+1]`, either `last_name[i] < last_name[i+1]`, or `last_name[i] == last_name[i+1]` and `first_name[i] <= first_name[i+1]`.

**Validates: Requirements 1.4**

---

### Property 3: Search Filter Soundness

*For any* search string `q` and any resident returned by `getEligibleResidents($q)`, the resident's full name (concatenated `first_name + ' ' + last_name`) or `username` SHALL contain `q` as a case-insensitive substring.

**Validates: Requirements 1.5**

---

### Property 4: Role Holder Result Shape

*For any* state of the `users` table, `getRoleHolders()` SHALL return an array with exactly the keys `['captain', 'secretary', 'sk']`; each value is either `null` (vacant) or an array containing at minimum `id`, `last_name`, `first_name`, `username`, and `role` fields.

**Validates: Requirements 2.1, 2.2, 2.3**

---

### Property 5: Field Preservation on Promotion

*For any* eligible resident `u` who is successfully promoted to any Official_Role, the values of `u.username`, `u.email`, `u.password`, `u.household_no`, and `u.status` in the `users` table SHALL be identical before and after the promotion; only `u.role` SHALL differ.

**Validates: Requirements 3.3**

---

### Property 6: Field Preservation on Demotion

*For any* active official `u` who is successfully demoted, the values of `u.username`, `u.email`, `u.password`, `u.household_no`, and `u.status` SHALL be identical before and after; only `u.role` SHALL change to `'resident'`.

**Validates: Requirements 5.1**

---

### Property 7: Single Active Holder Invariant

*For any* sequence of promotion and demotion operations, and for each Official_Role in `['captain', 'secretary', 'sk']`, the count of users with `status = 'active'` and that role in the `users` table SHALL never exceed 1.

**Validates: Requirements 4.1, 4.2, 4.3, 4.4**

---

### Property 8: Promotion Blocks Non-Resident/Non-Active Users

*For any* user `u` where `u.role != 'resident'` OR `u.status != 'active'`, attempting to promote `u` SHALL be rejected (no DB mutation shall occur, and an error response is returned).

**Validates: Requirements 3.5**

---

### Property 9: Demotion Blocks Non-Official Roles

*For any* user `u` where `u.role` is not in `['captain', 'secretary', 'sk']`, attempting to demote `u` SHALL be rejected (no DB mutation shall occur, and an error response is returned).

**Validates: Requirements 5.3**

---

### Property 10: Access Control Exclusivity

*For any* HTTP request to a Promotion Manager route made with a session whose `role` is not `'secretary'`, the request SHALL be blocked — no promotion/demotion DB changes shall occur, and an error message SHALL be returned.

**Validates: Requirements 8.1, 8.3**

---

### Property 11: Age Computation Correctness

*For any* `date_of_birth` value `dob` and reference date `today`, the computed age SHALL equal the number of complete calendar years between `dob` and `today` — i.e., `TIMESTAMPDIFF(YEAR, dob, today)` — correctly handling leap years and year boundaries.

**Validates: Requirements 7.4**

---

## Error Handling

| Scenario | Detection Point | Response |
|---|---|---|
| Non-secretary accesses route | `RoleFilter::before()` | Redirect to `/login` with error flash |
| Caller session role changed mid-request | Re-check in `promote()`/`demote()` | Redirect to `/login` with "Unauthorized" |
| Target user not found | `userModel->find()` returns null | Redirect back with "User not found" error |
| Target user is not resident/active | Pre-check in `promote()` | Redirect back with descriptive error |
| Target role already occupied | `getActiveByRole()` returns a user | Redirect back with holder's name in error |
| Race condition: two simultaneous promotes | `promoteUser()` returns 0 rows affected | Redirect back with "Action could not be completed, please try again" |
| Self-demotion attempt | `$targetId === session user_id` | Redirect back with "Self-demotion is not allowed" |
| Target is not an official role | `demoteUser()` returns 0 rows affected / pre-check | Redirect back with "User is not an official" |
| DB query failure | Try/catch around model calls | Log error, redirect back with generic error |

All errors are returned as flash messages and displayed via the existing `.ca-alert--error` style pattern. The secretary is never left on a blank page.

---

## Testing Strategy

### Unit Tests (PHPUnit)

Unit tests cover the model methods in isolation using a test database or mocks.

- `getEligibleResidents()` with varied user/census data
- `getRoleHolders()` returns correct structure for all three roles, including vacancies
- `promoteUser()` / `demoteUser()` return values and affected row counts
- Age calculation via `TIMESTAMPDIFF` against known dates
- `PromotionController::promote()` error path when role is already occupied
- `PromotionController::demote()` self-demotion rejection

### Property-Based Tests (PHPUnit + infection/phpunit-property or `eris/eris`)

The PHP property-based testing library recommended is **[eris/eris](https://github.com/giorgiosironi/eris)** (well-maintained, PHPUnit-compatible).

Each property test runs a minimum of **100 iterations**.

Tag format: `// Feature: role-promotion-management, Property {N}: {property_text}`

| Property | Test Class | Generator inputs |
|---|---|---|
| P1: Eligible filter completeness | `EligibleResidentFilterTest` | Random user rows with varying role/status/dob |
| P2: Sort order | `EligibleResidentSortTest` | Random eligible user lists |
| P3: Search filter soundness | `SearchFilterTest` | Random residents + random search strings |
| P4: Role holder result shape | `RoleHolderShapeTest` | Random DB states for official roles |
| P5: Field preservation on promotion | `PromotionFieldPreservationTest` | Random eligible residents × official roles |
| P6: Field preservation on demotion | `DemotionFieldPreservationTest` | Random officials |
| P7: Single active holder invariant | `SingleHolderInvariantTest` | Random sequences of promote/demote ops |
| P8: Blocks non-resident/non-active | `InvalidPromotionRejectionTest` | Users with any non-eligible role/status |
| P9: Blocks non-official demotion | `InvalidDemotionRejectionTest` | Users with resident/treasurer/non-official roles |
| P10: Access control exclusivity | `AccessControlTest` | All non-secretary roles |
| P11: Age computation correctness | `AgeComputationTest` | Random DOBs across a 100-year span |

### Integration Tests

- Full HTTP request cycle: promote → check DB → check session flag refresh on next request
- Full HTTP request cycle: demote → check DB → verify old-role route is blocked by RoleFilter
- Role holder display when database query fails (mock DB, verify error message)
- Login routing after role change: user with updated DB role is sent to correct dashboard

### Manual / Smoke Tests

- Verify sidebar "Promotion Manager" link appears only in secretary dashboard
- Verify promoted user is redirected to new role's dashboard on next login
- Verify self-demotion button is hidden/blocked in UI for the currently logged-in secretary
