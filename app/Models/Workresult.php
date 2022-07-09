<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Workresult extends Model
{
    public function workresultModelGet() {
        $where = [];
        $workresults = DB::table('workresults')->get();
        return $workresults;
    }
}
