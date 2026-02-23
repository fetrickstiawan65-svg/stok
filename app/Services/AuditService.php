<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditService
{
    public function log(string $action, string $entity, ?int $entityId, int $userId, array $meta = []): void
    {
        AuditLog::create([
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
            'meta_json' => $meta,
            'user_id' => $userId,
        ]);
    }
}
