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
        $browsehistories = DB::table('browsehistories')->where($where)->orderBy('history_time','DESC')->limit($getcount)->get();
        return $browsehistories;
    }

    public function browsehistoryDataModelGet($workid) {
        $where = [
            'workid' => $workid
        ];
        $browsedatas = DB::table('works')->where($where)->get();
        return $browsedatas;
    }

    public function browsehistoryModelInsert($loginid,$workid) {
        $insert = [
            'loginid' => $loginid,
            'workid' => $workid,
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

    public function browsehistoryModelExist($loginid,$workid) {
        $where1 = [
            'loginid' => $loginid,
        ];
        $where2 = [
            'workid' => $workid,
        ];
        $exist = DB::table('browsehistories')->where($where1)->where($where2)->exists();
        return $exist;
    }
}
