<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Browsehistory extends Model
{
    public function browsehistoryModelGet($key,$wherecolumn1,$wheredata1,$wherecolumn2,$wheredata2,$getcount) {
        $browsehistories = DB::table('browsehistories')
            ->join('worksubs','browsehistories.worksubid','=','worksubs.id') 
            ->join('works','worksubs.workid','=','works.workid')
            ->join('worktypes','works.work_type','=','worktypes.worktypeid');
        if ($key == 'normal') {
            $where = [
                $wherecolumn1 => $wheredata1
            ];
            $browsehistories = $browsehistories
                ->where($where)
                ->orderBy('history_time','DESC')
                ->limit($getcount);
        } elseif ($key == 'genderattention') {
            if (count($wheredata1) > 1) {
                $browsehistories = $browsehistories->whereIn($wherecolumn1,$wheredata1);
            } else {
                $where = [
                    $wherecolumn1 => $wheredata1
                ];
                $browsehistories = $browsehistories->where($where);
            }
            $browsehistories = $browsehistories
                ->select('works.title','worktypes.worktype_name','worksubs.img','worksubs.url','browsehistories.worksubid',DB::raw('count(browsehistories.worksubid) AS loginidOfsameworksubid_count'))
                ->groupBy('browsehistories.worksubid','worktypes.worktype_name')
                ->orderBy('loginidOfsameworksubid_count','DESC')
                ->limit($getcount);
        } else {
            $where1 = [
                $wherecolumn1 => $wheredata1
            ];
            $where2 = [
                $wherecolumn2 => $wheredata2
            ];
            $browsehistories = $browsehistories
                ->where($where1)
                ->OrWhere($where2)
                ->select('browsehistories.worksubid','browsehistories.history_time_date',DB::raw('count(browsehistories.worksubid) AS sameworksubid_count'))
                ->groupBy('browsehistories.worksubid','browsehistories.history_time_date')
                ->orderBy('browsehistories.history_time_date','ASC')
                ->limit($getcount);
        }
        $browsehistories = $browsehistories->get();
        return $browsehistories;
    }

    public function browsehistorycountModelGet() {
        $browsehistoriescount = DB::table('browsehistories')->max('worksubid');
        return $browsehistoriescount;
    }

    public function browsehistoryModelInsert($loginid,$worksubid) {
        $insert = [
            'loginid' => $loginid,
            'worksubid' => $worksubid,
            'history_time' => now(),
            'history_time_date' => date('Y-m-d')
        ];
        DB::table('browsehistories')->insert($insert);
    }

    public function browsehistoryModelUpdate($whereColumn1,$whereOutput1,$whereColumn2,$whereOutput2,$updateColumn,$updateOutput) {
        $where1 = [
            $whereColumn1 => $whereOutput1,
        ];
        $where2 = [
            $whereColumn2 => $whereOutput2,
        ];
        $update = [
            $updateColumn => $updateOutput,
        ];
        DB::table('browsehistories')->where($where1)->where($where2)->update($update);
    }

    public function browsehistoryModelExist($loginid,$worksubid) {
        $exist = DB::table('browsehistories');
        $where1 = [
            'loginid' => $loginid,
        ];
        $exist = $exist->where($where1);
        if ($worksubid != NULL) {
            $where2 = [
                'worksubid' => $worksubid,
            ];
            $exist = $exist->where($where2);
        }
        $exist = $exist->exists();
        return $exist;
    }
}
