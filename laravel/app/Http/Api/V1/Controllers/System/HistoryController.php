<?php

namespace App\Http\Api\V1\Controllers\System;

use App\Http\Api\V1\Controllers\BaseController;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HistoryController extends BaseController
{
    public function getHistory(Request $request): JsonResponse
    {
        try {
            /** @var LengthAwarePaginator $activities */
            $activities = ActivityLog::with('user')
                ->when($request->module, function ($q) use ($request) {
                    return $q->where('module', $request->module);
                })
                ->when($request->action, function ($q) use ($request) {
                    return $q->where('action', $request->action);
                })
                ->when($request->date_from, function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->date_to);
                })
                ->when($request->search, function ($q) use ($request) {
                    return $q->where(function ($query) use ($request) {
                        $query->where('description', 'like', '%' . $request->search . '%')
                            ->orWhereHas('user', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->search . '%');
                            });
                    });
                })
                ->latest()
                ->paginate($request->per_page ?? 10);

            return $this->responseSuccess($activities->toArray());
        } catch (\Exception $e) {
            return $this->responseError('Failed to fetch history');
        }
    }
}
