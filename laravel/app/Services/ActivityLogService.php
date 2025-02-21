<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log($module, $action, $targetId = null, $targetType = null, $description = '', $changes = null)
    {
        return ActivityLog::create([
            'module' => $module,
            'action' => $action,
            'user_id' => Auth::id(),
            'target_id' => $targetId,
            'target_type' => $targetType,
            'description' => $description,
            'changes' => $changes
        ]);
    }
}