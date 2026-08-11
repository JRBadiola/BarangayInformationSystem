<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'username',
        'password',
        'role',
        'status',
        'contact_number',
        'avatar',
        'household_no',
        'verify_token',
        'verify_token_expires',
        'email_verified',
    ];

    // Never return the password hash in query results by default
    protected $hidden = ['password'];

    protected $validationRules = [
        'last_name'  => 'required|min_length[2]|max_length[80]',
        'first_name' => 'required|min_length[2]|max_length[80]',
        'middle_name' => 'permit_empty|max_length[80]',
        'email'      => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username'   => 'required|min_length[3]|max_length[80]|is_unique[users.username,id,{id}]',
        'password'   => 'required|min_length[8]',
        'role'       => 'required|in_list[captain,secretary,treasurer,sk,resident]',
    ];

    protected $validationMessages = [
        'email'    => ['is_unique' => 'That email is already registered.'],
        'username' => ['is_unique' => 'That username is already taken.'],
    ];

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Find a user by username and verify password.
     * Returns the user row (with password) or null.
     */
    public function findByCredentials(string $username, string $password): ?array
    {
        // Temporarily allow password in result for verification
        $user = $this->select('id, last_name, first_name, middle_name, username, email, role, status, email_verified, avatar, password')
            ->where('username', $username)
            ->first();

        if (! $user) {
            return null;
        }

        if (! password_verify($password, $user['password'])) {
            return null;
        }

        unset($user['password']);
        return $user;
    }

    /**
     * Get all pending accounts (SK and Resident registrations awaiting approval).
     */
    public function getPendingAccounts(): array
    {
        return $this->where('status', 'pending')
            ->whereIn('role', ['sk', 'resident'])
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    /**
     * Approve a user account.
     */
    public function approveUser(int $id): bool
    {
        return $this->update($id, ['status' => 'active']);
    }

    /**
     * Reject a user account.
     */
    public function rejectUser(int $id): bool
    {
        return $this->update($id, ['status' => 'rejected']);
    }

    /**
     * Find a user by their email verification token.
     */
    public function findByVerifyToken(string $token): ?array
    {
        return $this->where('verify_token', $token)
            ->where('email_verified', 0)
            ->first();
    }

    /**
     * Mark email as verified and set status to pending (awaiting captain/secretary approval).
     */
    public function markEmailVerified(int $id): bool
    {
        return $this->update($id, [
            'email_verified'       => 1,
            'verify_token'         => null,
            'verify_token_expires' => null,
            'status'               => 'pending',
        ]);
    }

    /**
     * Get the active account for a single-instance role (captain or secretary).
     * Returns the user row or null if none exists.
     */
    public function getActiveByRole(string $role): ?array
    {
        return $this->select('id, last_name, first_name, middle_name, username, email, status')
            ->where('role', $role)
            ->where('status', 'active')
            ->first();
    }
}
