<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worktype extends Model
{
    public function worktypeModelGet($wherecolumn,$wheredata) {
        $where = [
            $wherecolumn => $wheredata
        ];
        $worksubs = DB::table('worktypes')->where($where)->get();
        return $worksubs;
    }

    public function worktypecountModelGet() {
        $worksubcounts = DB::table('worktypes')->count();
        return $worksubcounts;
    }
}
