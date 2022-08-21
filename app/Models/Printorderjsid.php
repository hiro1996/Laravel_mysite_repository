<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Printorderjsid extends Model
{
    public function printorderjsidModelGet($where,$select) {
        $printorderjsids = DB::table('printorderjsids')
            ->where($where)
            ->select($select)
            ->get();
        return $printorderjsids;
    }
}
