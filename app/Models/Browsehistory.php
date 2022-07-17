<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Browsehistory extends Model
{
    public function browsehistoryModelGet($getcount) {
        $where = [
            'loginid' => session('loginid')
        ];
        $browsehistories = DB::table('browsehistories')
            ->join('worksubs','browsehistories.worksubid','=','worksubs.id') 
            ->join('works','worksubs.workid','=','works.workid') 
            ->where($where)
            ->orderBy('history_time','DESC')->limit($getcount)->get();
        return $browsehistories;
    }

    public function browsehistoryModelInsert($loginid,$worksubid) {
        $insert = [
            'loginid' => $loginid,
            'worksubid' => $worksubid,
            'history_time' => now()
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
        $where1 = [
            'loginid' => $loginid,
        ];
        $where2 = [
            'worksubid' => $worksubid,
        ];
        $exist = DB::table('browsehistories')->where($where1)->where($where2)->exists();
        return $exist;
    }
}
