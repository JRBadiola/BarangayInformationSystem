<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds unique constraints across the census tables:
 *
 * users:
 *   - email (already unique via column def, ensure index exists)
 *   - username (already unique via column def, ensure index exists)
 *
 * households (head of family):
 *   - philhealth_no — each PhilHealth number must belong to one person only
 *   - contact_number — one contact number per household head
 *   - (last_name + first_name + date_of_birth) — prevents duplicate head records
 *
 * household_members:
 *   - philhealth_no — globally unique across all members
 *   - (household_no + last_name + first_name + date_of_birth) — no duplicate
 *     member within the same household
 */
class AddUniqueConstraints extends Migration
{
    public function up()
    {
        $existingHouseholdFields  = $this->db->getFieldNames('households');
        $existingMemberFields     = $this->db->getFieldNames('household_members');
        $existingUserFields       = $this->db->getFieldNames('users');

        // ── households ────────────────────────────────────────────────────

        // Unique PhilHealth number for household head (nullable — skip NULLs)
        if (in_array('philhealth_no', $existingHouseholdFields)) {
            $this->db->query('
                ALTER TABLE `households`
                ADD CONSTRAINT `uq_households_philhealth`
                UNIQUE (`philhealth_no`)
            ');
        }

        // Unique contact number for household head (nullable)
        if (in_array('contact_number', $existingHouseholdFields)) {
            $this->db->query('
                ALTER TABLE `households`
                ADD CONSTRAINT `uq_households_contact`
                UNIQUE (`contact_number`)
            ');
        }

        // Composite unique: same person cannot be registered as head twice
        // (last_name + first_name + date_of_birth)
        $this->db->query('
            ALTER TABLE `households`
            ADD CONSTRAINT `uq_households_person`
            UNIQUE (`last_name`, `first_name`, `date_of_birth`)
        ');

        // ── household_members ─────────────────────────────────────────────

        // Unique PhilHealth number across all members
        if (in_array('philhealth_no', $existingMemberFields)) {
            $this->db->query('
                ALTER TABLE `household_members`
                ADD CONSTRAINT `uq_members_philhealth`
                UNIQUE (`philhealth_no`)
            ');
        }

        // Composite unique: same person cannot appear twice in the same household
        $this->db->query('
            ALTER TABLE `household_members`
            ADD CONSTRAINT `uq_members_person`
            UNIQUE (`household_no`, `last_name`, `first_name`, `date_of_birth`)
        ');

        // ── users ─────────────────────────────────────────────────────────
        // email and username are already UNIQUE from the column definition.
        // Ensure the indexes exist (safe to run even if already present).
        $indexes = $this->db->query("SHOW INDEX FROM `users` WHERE Key_name = 'email'")->getResultArray();
        if (empty($indexes)) {
            $this->db->query('ALTER TABLE `users` ADD UNIQUE (`email`)');
        }

        $indexes = $this->db->query("SHOW INDEX FROM `users` WHERE Key_name = 'username'")->getResultArray();
        if (empty($indexes)) {
            $this->db->query('ALTER TABLE `users` ADD UNIQUE (`username`)');
        }
    }

    public function down()
    {
        // Drop constraints safely
        $this->db->query('ALTER TABLE `households` DROP INDEX IF EXISTS `uq_households_philhealth`');
        $this->db->query('ALTER TABLE `households` DROP INDEX IF EXISTS `uq_households_contact`');
        $this->db->query('ALTER TABLE `households` DROP INDEX IF EXISTS `uq_households_person`');
        $this->db->query('ALTER TABLE `household_members` DROP INDEX IF EXISTS `uq_members_philhealth`');
        $this->db->query('ALTER TABLE `household_members` DROP INDEX IF EXISTS `uq_members_person`');
    }
}
