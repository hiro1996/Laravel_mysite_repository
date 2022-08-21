<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    public function notificationModelGet($where,$select,$orderby,$orderbyascdesc) {
        $notifications = DB::table('notifications')
            ->where($where)
            ->select($select);
        if ($orderby != NULL) {
            $notifications = $notifications->orderBy($orderby,$orderbyascdesc);
        }
        $notifications = $notifications->get();
        return $notifications;
    }
}
