<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table      = 'notifications';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'user_id',
        'type',
        'title',
        'body',
        'link',
        'read_at',
    ];

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Get all notifications for a user (own + broadcasts).
     */
    public function getForUser(int $userId): array
    {
        return $this->db->table('notifications')
            ->where('user_id', $userId)
            ->orWhere('user_id IS NULL')
            ->orderBy('created_at', 'DESC')
            ->limit(50)
            ->get()->getResultArray();
    }

    /**
     * Count unread notifications for a user.
     */
    public function countUnread(int $userId): int
    {
        return (int) $this->db->table('notifications')
            ->where('read_at IS NULL')
            ->groupStart()
            ->where('user_id', $userId)
            ->orWhere('user_id IS NULL')
            ->groupEnd()
            ->countAllResults();
    }

    /**
     * Mark one notification read for a given user.
     * Broadcasts (user_id IS NULL) get a personal read record — we handle this
     * by inserting a per-user copy only when creating notifications, so we can
     * simply update by id + user_id / null.
     */
    public function markReadById(int $notifId, int $userId): void
    {
        $this->db->table('notifications')
            ->where('id', $notifId)
            ->groupStart()
            ->where('user_id', $userId)
            ->orWhere('user_id IS NULL')
            ->groupEnd()
            ->update(['read_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Mark all unread notifications read for a user.
     */
    public function markAllRead(int $userId): void
    {
        $this->db->table('notifications')
            ->where('read_at IS NULL')
            ->groupStart()
            ->where('user_id', $userId)
            ->orWhere('user_id IS NULL')
            ->groupEnd()
            ->update(['read_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Push a notification for a specific user.
     */
    public static function push(int $userId, string $type, string $title, string $body = '', string $link = ''): void
    {
        $model = new self();
        $model->insert([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'body'    => $body ?: null,
            'link'    => $link ?: null,
            'read_at' => null,
        ]);
    }

    /**
     * Push a broadcast notification to all residents (user_id = NULL).
     */
    public static function broadcast(string $type, string $title, string $body = '', string $link = ''): void
    {
        $model = new self();
        $model->insert([
            'user_id' => null,
            'type'    => $type,
            'title'   => $title,
            'body'    => $body ?: null,
            'link'    => $link ?: null,
            'read_at' => null,
        ]);
    }
}
