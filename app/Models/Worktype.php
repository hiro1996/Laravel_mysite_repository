<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worktype extends Model
{
    public function worktypeModelGet($wherecolumn,$wheredata) {
        $worksubs = DB::table('worktypes');
        if ($wherecolumn != NULL) {
            $where = [
                $wherecolumn => $wheredata
            ];
            $worksubs = $worksubs->where($where);
        }
        $worksubs = $worksubs->get();
        return $worksubs;
    }

    public function worktypecountModelGet() {
        $worksubcounts = DB::table('worktypes')->count();
        return $worksubcounts;
    }

    public function worktypemenuModelGet($where) {
        $worktypemenus = DB::table('worktypes')
            ->join('works', function($join) {
                $join->on('worktypes.worktypeid','=','works.work_type');
            })->select('worktypes.worktype_name','works.category_name',DB::raw('count(works.category_name) AS category_name_count'))
            ->groupBy('worktypes.worktype_name','works.category_name');
            if ($where) {
                $worktypemenus = $worktypemenus->where($where);
            }
            $worktypemenus = $worktypemenus->get();
        return $worktypemenus;
    }

    public function worktypemenusideModelGet() {
        $worktypesidemenus = DB::table('worktypes')
            ->join('works','worktypes.worktypeid','=','works.work_type')
            ->select('worktypes.worktypeid','worktypes.worktype_name','works.category_name')
            ->get();
        return $worktypesidemenus;
    }
}
