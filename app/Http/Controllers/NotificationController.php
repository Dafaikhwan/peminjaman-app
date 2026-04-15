<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Tandai satu notifikasi sebagai terbaca
    public function markAsRead(Request $request)
    {
        if (!auth()->check() || !$request->id) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $notification = auth()->user()->notifications()->find($request->id);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }

        public function index(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 'unauthorized'
            ], 401);
        }

        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->data['judul'] ?? 'Notifikasi',
                    'message' => $notif->data['pesan'] ?? $notif->data['message'],
                    'read_at' => $notif->read_at,
                    'created_at' => $notif->created_at,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $notifications
        ]);
    }

    // Tandai semua notifikasi sebagai terbaca
    public function markAllNotificationsAsRead()
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['status' => 'success']);
    }

    public function unreadCount()
{
    if (!auth()->check()) {
        return response()->json(['status' => 'unauthorized'], 401);
    }

    return response()->json([
        'status' => true,
        'count' => auth()->user()->unreadNotifications()->count()
    ]);
}

public function destroy($id)
{
    $notification = auth()->user()
        ->notifications()
        ->find($id);

    if (!$notification) {
        return response()->json([
            'status' => false,
            'message' => 'Notifikasi tidak ditemukan'
        ], 404);
    }

    $notification->delete();

    return response()->json([
        'status' => true,
        'message' => 'Notifikasi berhasil dihapus'
    ]);
}

}
