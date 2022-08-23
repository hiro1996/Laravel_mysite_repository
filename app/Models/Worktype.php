<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worktype extends Model
{
    public function worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit) {
        $worktypes = DB::table('worktypes');
        if (in_array('works',$needDB)) {
            $worktypes = $worktypes->join('works','worktypes.worktypeid','=','works.work_type');
        }
        if (in_array('worksubs',$needDB)) {
            $worktypes = $worktypes->join('worksubs','works.workid','=','worksubs.workid');
        }
        $worktypes = $worktypes
            ->where($where)
            ->select($select);
        if ($groupby != NULL) {
            $worktypes = $worktypes->groupBy($groupby);
        }
        if ($orderby != NULL) {
            $worktypes = $worktypes->orderBy($orderby,$orderbyascdesc);
        }
        if ($limit != NULL) {
            $worktypes = $worktypes->limit($limit);
        }
        $worktypes = $worktypes->get();
        return $worktypes;
    }
}
