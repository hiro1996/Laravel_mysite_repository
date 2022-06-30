<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    public function notificationModelGet() {
        $notifications = DB::table('notifications')->orderBy('printing_order','DESC')->get();
        return $notifications;
    }
}
