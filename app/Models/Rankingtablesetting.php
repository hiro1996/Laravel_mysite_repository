<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rankingtablesetting extends Model
{
    public function rankingtablesettingModelInsert($loginid,$genresumnum) {
        $insert = [
            'loginid' => $loginid,
            'rankingtablesetting_default_flag' => 1,
            'genresumnum' => $genresumnum,
            'user_value_id' => 1
        ];
        $rankingtablesettings = DB::table('rankingtablesettings')->insert($insert);
        return $rankingtablesettings;
    }

    public function rankingtablesettingModelGet($where,$select) {
        $rankingtablesettings = DB::table('rankingtablesettings')
            ->where($where)
            ->select($select)
            ->get();
        return $rankingtablesettings;
    }

    public function rankingtablesettingModelUpdate($rankingtablesetting,$title,$data) {
        $set = DB::table('rankingtablesettings');
        $where = [
            'loginid' => session('loginid')
        ];
        switch ($rankingtablesetting) {
            case 'rankingtablesettingdefaultflag':
                $update = [
                    'rankingtablesetting_default_flag' => $data
                ];
                $set->where($where)->update($update);
                break;
            case 'work':
                $update = [
                    $title => $data
                ];
                $set->where($where)->update($update);
                break;
        }
    }
}
