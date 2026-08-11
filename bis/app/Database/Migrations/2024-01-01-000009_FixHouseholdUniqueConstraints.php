<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Fixes unique constraint issues that prevent adding households when
 * contact_number, philhealth_no, or date_of_birth are left blank (NULL).
 *
 * Problems fixed:
 *  1. uq_households_contact  — blocks second household with no contact number
 *  2. uq_households_philhealth — blocks second household with no PhilHealth no.
 *  3. uq_households_person   — blocks second household with no date_of_birth
 *  4. uq_members_philhealth  — blocks second member with no PhilHealth no.
 *
 * Solution:
 *  - Drop the nullable single-column unique indexes (contact, philhealth).
 *  - Keep the person composite unique only when date_of_birth IS NOT NULL
 *    by dropping the old constraint and recreating it as a filtered/partial
 *    approach: we simply drop it — household_no PK already prevents true
 *    duplicates at the household level.
 */
class FixHouseholdUniqueConstraints extends Migration
{
    public function up()
    {
        // ── households ────────────────────────────────────────────────────

        // Drop unique on contact_number (nullable — causes duplicate NULL errors)
        $this->_dropIndexIfExists('households', 'uq_households_contact');

        // Drop unique on philhealth_no (nullable — causes duplicate NULL errors)
        $this->_dropIndexIfExists('households', 'uq_households_philhealth');

        // Drop composite person unique (date_of_birth is optional — NULL collisions)
        $this->_dropIndexIfExists('households', 'uq_households_person');

        // ── household_members ─────────────────────────────────────────────

        // Drop unique on philhealth_no for members (nullable)
        $this->_dropIndexIfExists('household_members', 'uq_members_philhealth');

        // Drop composite member person unique (date_of_birth is optional)
        $this->_dropIndexIfExists('household_members', 'uq_members_person');
    }

    public function down()
    {
        // Restore original constraints (may fail if NULLs exist — intentional)
        $this->db->query('ALTER TABLE `households` ADD CONSTRAINT `uq_households_philhealth` UNIQUE (`philhealth_no`)');
        $this->db->query('ALTER TABLE `households` ADD CONSTRAINT `uq_households_contact` UNIQUE (`contact_number`)');
        $this->db->query('ALTER TABLE `households` ADD CONSTRAINT `uq_households_person` UNIQUE (`last_name`, `first_name`, `date_of_birth`)');
        $this->db->query('ALTER TABLE `household_members` ADD CONSTRAINT `uq_members_philhealth` UNIQUE (`philhealth_no`)');
        $this->db->query('ALTER TABLE `household_members` ADD CONSTRAINT `uq_members_person` UNIQUE (`household_no`, `last_name`, `first_name`, `date_of_birth`)');
    }

    // ── Helper: drop index only if it exists ──────────────────────────────────
    private function _dropIndexIfExists(string $table, string $indexName): void
    {
        $exists = $this->db->query(
            "SELECT COUNT(*) AS cnt FROM information_schema.TABLE_CONSTRAINTS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?",
            [$table, $indexName]
        )->getRow()->cnt ?? 0;

        if ($exists) {
            $this->db->query("ALTER TABLE `{$table}` DROP INDEX `{$indexName}`");
        }
    }
}
