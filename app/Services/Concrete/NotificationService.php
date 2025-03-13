<?php

namespace App\Services\Concrete;

use App\Models\Notification;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    protected $model;
    public function __construct()
    {
        // set the model
        $this->model = new Repository(new Notification);
    }

    public function getByCurrentUser()
    {
        return $this->model->getModel()::where('user_id', Auth::user()->id)->where('is_read', false)->get();
    }

    //single read
    public function singleMarkAsRead($id)
    {
        $notification = $this->model->getModel()::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($notification) {
            $notification->update(['is_read' => true]);
            return true;
        }
        return false;
    }
    // all read
    public function markAllAsRead(){
        $notification = $this->model->getModel()::where('user_id', Auth::user()->id)->update(['is_read' => true]);
        if ($notification) {
            $notification->update(['is_read' => true]);
            return true;
        }
        return false;
    }
    // save
    public function save($obj)
    {
        $saved_obj = $this->model->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

}
