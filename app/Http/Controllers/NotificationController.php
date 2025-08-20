<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    function index(Request $request)
    {
        // Fetch notifications for the authenticated user
        $notifications = $request->user()->notifications()->paginate(1);

        // Mark notifications as read
        $request->user()->unreadNotifications->markAsRead();

        // Return the view with notifications
        return view('notifications.index', compact('notifications'));
    }
}
