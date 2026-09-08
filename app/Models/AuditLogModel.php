<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'skpd_id',
        'action_event',
        'table_affected',
        'record_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $useTimestamps = false;

    /**
     * Helper untuk mencatat log aktivitas sistem
     */
    public static function record(
        string $actionEvent,
        string $tableAffected,
        string $recordId,
        ?array $oldValues = null,
        ?array $newValues = null
    ) {
        $session = session();
        $request = Services::request();

        $userId = $session->get('user_id');
        $skpdId = $session->get('skpd_id');

        $data = [
            'user_id'        => $userId,
            'skpd_id'        => $skpdId,
            'action_event'   => $actionEvent,
            'table_affected' => $tableAffected,
            'record_id'      => (string)$recordId,
            'old_values'     => $oldValues ? json_encode($oldValues) : null,
            'new_values'     => $newValues ? json_encode($newValues) : null,
            'ip_address'     => $request->getIPAddress(),
            'user_agent'     => substr((string) $request->getUserAgent(), 0, 255),
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $model = new self();
        return $model->insert($data);
    }
}
