<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentTemplateModel extends Model
{
    protected $table      = 'document_templates';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['template_key', 'name', 'fields', 'html'];
    protected $useTimestamps = true;

    public function tableExists(): bool
    {
        return $this->db !== null && $this->db->tableExists($this->table);
    }

    protected function normalizeRows(array $rows): array
    {
        foreach ($rows as &$row) {
            if (! is_array($row)) {
                continue;
            }
            $row['fields'] = json_decode($row['fields'] ?? '[]', true) ?: [];
        }

        return $rows;
    }

    public function getDefaultTemplates(): array
    {
        return [
            'clearance' => [
                'id' => 0,
                'template_key' => 'clearance',
                'name' => 'Barangay Clearance',
                'fields' => [],
                'html' => '<div class="doc-template"><div class="doc-header"><h2>Barangay Clearance</h2></div><p>Template data is missing because the document_templates table has not been created yet.</p></div>',
            ],
            'residency' => [
                'id' => 0,
                'template_key' => 'residency',
                'name' => 'Barangay Certification',
                'fields' => [],
                'html' => '<div class="doc-template"><div class="doc-header"><h2>Barangay Certification</h2></div><p>Template data is missing because the document_templates table has not been created yet.</p></div>',
            ],
        ];
    }

    public function getTemplate(string $key): ?array
    {
        if (! $this->tableExists()) {
            return $this->getDefaultTemplates()[$key] ?? null;
        }

        $row = $this->where('template_key', $key)->first();
        if (! $row) {
            return null;
        }

        $row['fields'] = json_decode($row['fields'] ?? '[]', true) ?: [];
        return $row;
    }

    public function getTemplatesIndexedByKey(): array
    {
        if (! $this->tableExists()) {
            return $this->getDefaultTemplates();
        }

        $rows = $this->normalizeRows($this->orderBy('id')->findAll());
        return array_column($rows, null, 'template_key');
    }

    public function getAllTemplates(): array
    {
        if (! $this->tableExists()) {
            return array_values($this->getDefaultTemplates());
        }

        return $this->normalizeRows($this->orderBy('id')->findAll());
    }
}
