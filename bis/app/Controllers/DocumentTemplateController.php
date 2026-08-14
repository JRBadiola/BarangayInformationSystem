<?php

namespace App\Controllers;

use App\Models\DocumentTemplateModel;
use App\Models\BarangaySettingsModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DocumentTemplateController extends BaseController
{
    protected DocumentTemplateModel  $templateModel;
    protected BarangaySettingsModel  $settingsModel;

    public function __construct()
    {
        $this->templateModel = new DocumentTemplateModel();
        $this->settingsModel = new BarangaySettingsModel();
    }

    /**
     * Build the barangay settings array with captain_name always resolved
     * live from the users table (never from the static stored value).
     */
    private function getSettings(): array
    {
        // getAll() already overrides captain_name with the live value
        return $this->settingsModel->getAll();
    }

    // ── Document Templates ────────────────────────────────────────────────────

    public function index()
    {
        return view('dashboard/secretary/document_templates_index', [
            'templates'         => $this->templateModel->getAllTemplates(),
            'barangaySettings'  => $this->getSettings(),
        ]);
    }

    public function edit(string $key)
    {
        $template = $this->templateModel->getTemplate($key);
        if (! $template) {
            throw new PageNotFoundException('Template not found');
        }

        return view('dashboard/secretary/document_templates_edit', [
            'template'         => $template,
            'barangaySettings' => $this->getSettings(),
        ]);
    }

    public function update(string $key)
    {
        $template = $this->templateModel->getTemplate($key);
        if (! $template) {
            return redirect()->back()->with('error', 'Template not found');
        }

        $fields = $template['fields'];
        foreach ($fields as &$field) {
            if (! empty($field['name'])) {
                $posted = $this->request->getPost($field['name']);
                if ($posted !== null) {
                    $field['value'] = $posted;
                }
            }
        }
        unset($field);

        $newHtml = $this->request->getPost('html');
        $updateData = [
            'fields' => json_encode($fields, JSON_UNESCAPED_UNICODE),
            'html'   => $newHtml,
        ];

        if (! $this->templateModel->update($template['id'], $updateData)) {
            return redirect()->back()->with('error', 'Unable to save template changes');
        }

        return redirect()->to(site_url('secretary/templates/edit/' . $key))
            ->with('success', 'Template updated successfully');
    }

    // ── Barangay Settings ─────────────────────────────────────────────────────

    /**
     * Show the barangay information settings page.
     */
    public function barangaySettings()
    {
        return view('dashboard/secretary/barangay_settings', [
            'settingsGrouped'  => $this->settingsModel->getAllGrouped(),
            'barangaySettings' => $this->getSettings(),
        ]);
    }

    /**
     * Save updated barangay settings.
     */
    public function saveBarangaySettings()
    {
        if (! $this->settingsModel->tableExists()) {
            return redirect()->back()->with('error', 'Please run database migrations first.');
        }

        $post = $this->request->getPost();
        // Strip CSRF and non-setting fields
        unset($post[$this->request->getCsrfTokenName() ?? csrf_token()]);

        // Only save known keys that exist in the DB
        $this->settingsModel->saveAll($post);

        return redirect()->to(site_url('secretary/barangay-settings'))
            ->with('success', 'Barangay information updated successfully.');
    }
}
