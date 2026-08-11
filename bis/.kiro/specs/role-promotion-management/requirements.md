# Requirements Document

## Introduction

This feature allows the barangay secretary to promote existing resident accounts to official roles (captain, secretary, or SK) directly from the registered users list, rather than creating brand-new accounts. When an official's term ends or they are replaced, the secretary demotes their role back to resident and promotes a different eligible resident instead. The promoted resident's account role is upgraded in place — their username, email, password, and household link remain unchanged — and after promotion they are routed to the new role's dashboard on their next login. If they are currently logged in, their session is updated to reflect the new role immediately.

---

## Glossary

- **Secretary**: The barangay official with super-admin privileges who can manage user accounts and perform promotions/demotions.
- **Resident**: An active, approved barangay user account with the `resident` role.
- **Eligible_Resident**: An active resident whose age, computed from the linked census record (`households.date_of_birth` for the household head, or `household_members.date_of_birth` for members), is 18 years or older.
- **Official_Role**: One of the three exclusive roles that can be assigned via promotion: `captain`, `secretary`, or `sk`.
- **Promotion**: The action of changing a resident's `role` field from `resident` to an Official_Role without creating a new account.
- **Demotion**: The action of changing an official's `role` field back to `resident`.
- **Role_Holder**: The single active user currently holding a given Official_Role.
- **Promotion_Manager**: The UI page within the secretary dashboard that lists Eligible_Residents and currently active Role_Holders for promotion and demotion actions.
- **Session**: The server-side PHP session managed by CodeIgniter 4 that stores `user_id`, `role`, `username`, and related user data.
- **User**: A row in the `users` table, identified by `id`.

---

## Requirements

### Requirement 1: Eligible Resident List

**User Story:** As a secretary, I want to see a list of active residents who are eligible for promotion, so that I can choose who to promote to an official role.

#### Acceptance Criteria

1. WHEN the secretary navigates to the Promotion_Manager page, THE Promotion_Manager SHALL display all users whose `role` is `resident`, `status` is `active`, and whose age computed from the linked census record (`households.date_of_birth` or `household_members.date_of_birth`) is 18 or older.
2. WHEN a resident's linked census record does not contain a `date_of_birth`, THE Promotion_Manager SHALL exclude that resident from the eligible list, but SHALL retain the resident account in the system.
3. THE Promotion_Manager SHALL display each eligible resident's full name, username, email, and computed age.
4. THE Promotion_Manager SHALL display the list sorted alphabetically by last name, then first name.
5. WHEN the secretary searches by name or username, THE Promotion_Manager SHALL filter the displayed list to show only residents whose name or username contains the search string (case-insensitive).

---

### Requirement 2: Current Role Holders Display

**User Story:** As a secretary, I want to see who currently holds each official role, so that I know whether I need to demote someone before a new promotion.

#### Acceptance Criteria

1. WHEN the secretary views the Promotion_Manager page, THE Promotion_Manager SHALL display the currently active Role_Holder (if any) for each of the three Official_Roles: captain, secretary, and SK.
2. WHEN no active Role_Holder exists for an Official_Role, THE Promotion_Manager SHALL indicate that the position is vacant.
3. THE Promotion_Manager SHALL display each Role_Holder's full name, username, and the role they currently hold.
4. IF the Promotion_Manager fails to retrieve Role_Holder information from the database, THEN THE Promotion_Manager SHALL display an error message in the role holders section indicating that the information could not be loaded.

---

### Requirement 3: Promote Resident to Official Role

**User Story:** As a secretary, I want to promote an eligible resident to an official role, so that they can access the corresponding dashboard and perform official duties.

#### Acceptance Criteria

1. WHEN the secretary submits a promotion request for an Eligible_Resident to an Official_Role, THE Promotion_Manager SHALL verify that no active Role_Holder currently exists for that Official_Role before applying the change.
2. IF an active Role_Holder already exists for the target Official_Role, THEN THE Promotion_Manager SHALL reject the promotion request and return an error message naming the current Role_Holder.
3. WHEN the promotion is permitted, THE Promotion_Manager SHALL update the target user's `role` field in the `users` table to the selected Official_Role without modifying `username`, `email`, `password`, `household_no`, or `status`.
4. WHEN the promotion is saved, THE Promotion_Manager SHALL redirect to the Promotion_Manager page with a success message identifying the promoted user and the new role.
5. WHEN the secretary attempts to promote a user who does not have `role = resident` and `status = active`, THEN THE Promotion_Manager SHALL reject the request and return an error message.

---

### Requirement 4: Enforce Single Role Holder Per Official Role

**User Story:** As a secretary, I want the system to prevent duplicate holders of the same official role, so that there is always at most one active captain, one active secretary, and one active SK.

#### Acceptance Criteria

1. THE Promotion_Manager SHALL enforce that at most one user with `status = active` holds the `captain` role at any given time.
2. THE Promotion_Manager SHALL enforce that at most one user with `status = active` holds the `secretary` role at any given time.
3. THE Promotion_Manager SHALL enforce that at most one user with `status = active` holds the `sk` role at any given time.
4. IF a promotion would result in more than one active holder of an Official_Role, THEN THE Promotion_Manager SHALL reject the promotion and return a descriptive error message.

---

### Requirement 5: Demote Official Back to Resident

**User Story:** As a secretary, I want to demote an active official back to resident, so that I can replace them or end their term without deactivating their account.

#### Acceptance Criteria

1. WHEN the secretary submits a demotion request for an active Role_Holder, THE Promotion_Manager SHALL update that user's `role` field to `resident` without modifying `username`, `email`, `password`, `household_no`, or `status`.
2. WHEN the demotion is saved, THE Promotion_Manager SHALL redirect to the Promotion_Manager page with a success message identifying the demoted user.
3. WHEN the secretary attempts to demote a user whose `role` is not an Official_Role, THEN THE Promotion_Manager SHALL reject the request and return an error message.
4. WHEN the secretary attempts to demote their own account (the currently logged-in secretary), THE Promotion_Manager SHALL reject the request and return an error message stating that self-demotion is not allowed.

---

### Requirement 6: Session Update After Role Change

**User Story:** As a promoted or demoted official, I want my session to reflect my new role so that I am routed to the correct dashboard without needing to log out and back in.

#### Acceptance Criteria

1. WHEN the secretary submits a promotion request for a user who has been promoted, THE Promotion_Manager SHALL update that user's session `role` value to the new Official_Role.
2. WHEN the secretary demotes a user who has been demoted and is currently logged in, THE Promotion_Manager SHALL update that user's session `role` value to `resident`.
3. WHEN a user whose role has changed logs in, THE Login_Controller SHALL route them to the dashboard corresponding to their current `role` value in the `users` table.
4. WHEN a user with a changed role tries to access a dashboard route that no longer matches their current role, THE RoleFilter SHALL redirect them to the login page.

---

### Requirement 7: Age Verification from Census Data

**User Story:** As a secretary, I want the system to compute a resident's age from census records, so that only residents aged 18 or older are eligible for promotion.

#### Acceptance Criteria

1. WHEN computing eligibility, THE Promotion_Manager SHALL first check the `users.household_no` field to locate the linked census record.
2. WHEN the resident is the household head (matched by name against `households`), THE Promotion_Manager SHALL compute age from `households.date_of_birth`.
3. WHEN the resident is a household member (matched by name against `household_members`), THE Promotion_Manager SHALL compute age from `household_members.date_of_birth`.
4. THE Promotion_Manager SHALL compute age as the number of full years elapsed since `date_of_birth` relative to the current date.
5. IF a resident's computed age is less than 18, THEN THE Promotion_Manager SHALL exclude them from the eligible resident list and, only when a promotion request is actually submitted for them, SHALL reject the request and return an error message stating the resident does not meet the minimum age requirement.

---

### Requirement 8: Access Control

**User Story:** As a system administrator, I want only the secretary to be able to perform promotions and demotions, so that role management cannot be done by unauthorized users.

#### Acceptance Criteria

1. THE RoleFilter SHALL restrict access to the Promotion_Manager page and all promotion/demotion endpoints to users whose session `role` is `secretary`, displaying an error message on the current page without redirecting when access is denied.
2. IF a non-secretary user accesses a Promotion_Manager route, THEN THE RoleFilter SHALL display an error message on the current page without redirecting to the login page.
3. WHEN a promotion or demotion action is submitted, THE Promotion_Manager SHALL re-verify the caller's session `role` is `secretary` before applying any database changes, and SHALL block all database changes if re-verification fails.
