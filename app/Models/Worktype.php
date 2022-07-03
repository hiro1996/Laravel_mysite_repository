<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worktype extends Model
{
    public function worktypeModelGet() {
        $worksubs = DB::table('worktypes')->get();
        return $worksubs;
    }

    public function worktypecountModelGet() {
        $worksubcounts = DB::table('worktypes')->count();
        return $worksubcounts;
    }
}
