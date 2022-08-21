<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Workresult extends Model
{
    public function workresultModelGet($where,$select) {
        $workresults = DB::table('workresults')
            ->where($where)
            ->select($select)
            ->get();
        return $workresults;
    }
}
