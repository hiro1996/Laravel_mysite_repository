<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Browsehistory extends Model
{
    public function browsehistoryModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit) {
        $browsehistories = DB::table('browsehistories');
        if (in_array('worksubs',$needDB)) {
            $browsehistories = $browsehistories->join('worksubs','browsehistories.worksubid','=','worksubs.id');
        }
        if (in_array('works',$needDB)) {
            $browsehistories = $browsehistories->join('works','worksubs.workid','=','works.workid');
        }
        if (in_array('worktypes',$needDB)) {
            $browsehistories = $browsehistories->join('worktypes','works.work_type','=','worktypes.worktypeid');
        }
        if (in_array('orwhere',$needDB)) {
            $minus = substr_count($where,'*');
            $wheretmp = explode("+",$where);
            $plus = count($wheretmp)-$minus;
            $where1 = $wheretmp[0];
            $where2 = [];
            for ($i = 1;$i < $plus;$i++) {
                array_push($where2,$wheretmp[$i]);
            }
            $browsehistories = $browsehistories->whereIn($where1,$where2);

            if ($minus != 0) {
                $where3 = $wheretmp[$plus];
                $where4 = [];
                for ($i = $plus+1;$i < count($wheretmp);$i++) {
                    array_push($where4,$wheretmp[$i]);
                }
                // -を削除
                $where3 = str_replace('*', '', $where3);
                for ($i = 0;$i < count($where4);$i++) {
                    $where4[$i] = str_replace('*', '', $where4[$i]);
                }
                $browsehistories = $browsehistories->whereNotIn($where3,$where4);
            }
        } else {
            $browsehistories = $browsehistories->where($where);
        }
        $browsehistories = $browsehistories->select($select);
        if ($groupby != NULL) {
            $browsehistories = $browsehistories->groupBy($groupby);
        }
        if ($orderby != NULL) {
            $browsehistories = $browsehistories->orderBy($orderby,$orderbyascdesc);
        }
        if ($limit != NULL) {
            $browsehistories = $browsehistories->limit($limit);
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
