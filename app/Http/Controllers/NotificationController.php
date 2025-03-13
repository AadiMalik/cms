<?php

namespace App\Http\Controllers;

use App\Services\Concrete\NotificationService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use JsonResponse;
    protected $notification_service;
    public function __construct(NotificationService $notification_service)
    {
        $this->notification_service = $notification_service;
    }
    public function index()
    {
        $notifications = $this->notification_service->getByCurrentUser();
        return $this->success(config('enum.success'),$notifications,false);
    }

    // Mark a single notification as read
    public function markAsRead($id)
    {
        $notification = $this->notification_service->singleMarkAsRead($id);
         
        if ($notification) {
            return $this->success(config('enum.success'),[],true);
        }
        return $this->error(config('enum.error'));
    }

    // Mark all notifications as read
    public function markAllAsRead()
    {
        $notification = $this->notification_service->markAllAsRead();
         
        if ($notification) {
            return $this->success(config('enum.success'),[],true);
        }
        return $this->error(config('enum.error'));
    }

}
