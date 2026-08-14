<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangaySettingsModel extends Model
{
    protected $table      = 'barangay_settings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['setting_key', 'setting_value', 'label', 'group', 'sort_order'];

    /** Check whether the table has been created yet (migration guard). */
    public function tableExists(): bool
    {
        return $this->db !== null && $this->db->tableExists($this->table);
    }

    /**
     * Always read the active captain's full name from the users table.
     * Returns an uppercased string or empty string if no captain is appointed.
     */
    public function getLiveCaptainName(): string
    {
        $row = $this->db->table('users')
            ->select('first_name, middle_name, last_name')
            ->where('role', 'captain')
            ->where('status', 'active')
            ->get()
            ->getRowArray();

        if (! $row) {
            return '';
        }

        $parts = array_filter([
            trim($row['first_name']   ?? ''),
            trim($row['middle_name']  ?? ''),
            trim($row['last_name']    ?? ''),
        ]);

        return strtoupper(implode(' ', $parts));
    }

    /**
     * Return all settings as a flat key→value map.
     * captain_name is always overridden with the live value from users table.
     * Falls back to safe defaults if the table does not exist yet.
     *
     * @return array<string, string>
     */
    public function getAll(): array
    {
        if (! $this->tableExists()) {
            $defaults = $this->getDefaults();
            $defaults['captain_name'] = $this->getLiveCaptainName() ?: $defaults['captain_name'];
            return $defaults;
        }

        $rows = $this->orderBy('sort_order')->findAll();
        $map  = [];
        foreach ($rows as $row) {
            $map[$row['setting_key']] = $row['setting_value'] ?? '';
        }

        $merged = array_merge($this->getDefaults(), $map);

        // Always override captain_name with the live appointed captain
        $liveCaptain = $this->getLiveCaptainName();
        if ($liveCaptain !== '') {
            $merged['captain_name'] = $liveCaptain;
        }

        return $merged;
    }

    /**
     * Return all rows grouped by their 'group' column (for the edit form).
     * captain_name row is excluded — it's managed automatically from users table.
     *
     * @return array<string, array>
     */
    public function getAllGrouped(): array
    {
        if (! $this->tableExists()) {
            return [];
        }

        $rows   = $this->orderBy('sort_order')->findAll();
        $groups = [];
        foreach ($rows as $row) {
            // Skip captain_name — it's always pulled live from users table
            if ($row['setting_key'] === 'captain_name') {
                continue;
            }
            $groups[$row['group']][] = $row;
        }

        return $groups;
    }

    /**
     * Get a single setting value by key.
     * captain_name is always resolved live from users table.
     */
    public function getValue(string $key, string $default = ''): string
    {
        if ($key === 'captain_name') {
            return $this->getLiveCaptainName() ?: $default;
        }

        if (! $this->tableExists()) {
            return $this->getDefaults()[$key] ?? $default;
        }

        $row = $this->where('setting_key', $key)->first();
        return $row ? ($row['setting_value'] ?? $default) : $default;
    }

    /**
     * Upsert a batch of key→value pairs.
     * captain_name is intentionally ignored — managed from users table.
     *
     * @param array<string, string> $data
     */
    public function saveAll(array $data): void
    {
        // Never allow overwriting captain_name via settings form
        unset($data['captain_name']);

        foreach ($data as $key => $value) {
            $existing = $this->where('setting_key', $key)->first();
            if ($existing) {
                $this->update($existing['id'], ['setting_value' => $value]);
            }
            // Skip unknown keys — only seeded keys are editable.
        }
    }

    /**
     * Hard-coded fallback defaults used before the migration runs.
     *
     * @return array<string, string>
     */
    public function getDefaults(): array
    {
        return [
            'barangay_name'  => 'BARANGAY BACOLOD',
            'municipality'   => 'Municipality of Bato',
            'province'       => 'Province of Camarines Sur',
            'region'         => 'Region V',
            'country'        => 'Republic of the Philippines',
            'full_address'   => 'Barangay Bacolod, Bato, Camarines Sur',
            'office_header'  => 'OFFICE OF THE PUNONG BARANGAY',
            'captain_name'   => 'PUNONG BARANGAY',
            'captain_title'  => 'Punong Barangay',
            'secretary_name' => '',
            'treasurer_name' => '',
            'clearance_fee'  => '₱50.00',
            'residency_fee'  => '₱30.00',
            'indigency_fee'  => 'Free',
        ];
    }
}
