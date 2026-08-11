<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected NotificationModel $model;

    public function __construct()
    {
        $this->model = new NotificationModel();
    }

    // ── GET /resident/notifications/poll  (JSON, for topbar bell) ─────────────
    public function poll(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userId = (int) session()->get('user_id');
        if (! $userId) {
            return $this->response->setJSON(['unread' => 0]);
        }
        return $this->response->setJSON([
            'unread' => $this->model->countUnread($userId),
        ]);
    }

    // ── POST /resident/notifications/read/{id}  (AJAX) ───────────────────────
    public function markRead(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        $userId = (int) session()->get('user_id');
        if ($userId) {
            $this->model->markReadById($id, $userId);
        }
        return $this->response->setJSON(['ok' => true]);
    }

    // ── POST /resident/notifications/read-all  (AJAX) ────────────────────────
    public function markAllRead(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userId = (int) session()->get('user_id');
        if ($userId) {
            $this->model->markAllRead($userId);
        }
        return $this->response->setJSON(['ok' => true]);
    }
}
