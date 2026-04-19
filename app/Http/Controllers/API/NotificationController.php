<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/notifications
     * List paginated notifications for the authenticated user.
     * Pass ?unread=true to filter unread only.
     */
    public function index(Request $request): JsonResponse
    {
        $query = $request->user()->notifications();

        if ($request->boolean('unread')) {
            $query = $request->user()->unreadNotifications();
        }

        $notifications = $query->paginate(20);

        return $this->successResponse([
            'unread_count'  => $request->user()->unreadNotifications()->count(),
            'notifications' => $notifications,
        ], 'Notifications retrieved.');
    }

    /**
     * PUT /api/notifications/{id}/read
     * Mark a single notification as read.
     */
    public function markRead(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return $this->successResponse(null, 'Notification marked as read.');
    }

    /**
     * PUT /api/notifications/read-all
     * Mark every unread notification as read.
     */
    public function markAllRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return $this->successResponse(null, 'All notifications marked as read.');
    }

    /**
     * DELETE /api/notifications/{id}
     * Delete a single notification.
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $request->user()
            ->notifications()
            ->where('id', $id)
            ->delete();

        return $this->successResponse(null, 'Notification deleted.');
    }
}
