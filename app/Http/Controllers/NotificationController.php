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

    // Tandai semua notifikasi sebagai terbaca
    public function markAllNotificationsAsRead()
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['status' => 'success']);
    }
}
