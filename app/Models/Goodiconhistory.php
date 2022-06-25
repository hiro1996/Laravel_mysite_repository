<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Goodiconhistory extends Model
{
    public function goodiconhistoryModelInsert($loginid,$workid,$reviewid) {
        $insert = [
            'loginid' => $loginid,
            'workid' => $workid,
            'reviewid' => $reviewid
        ];
        DB::table('goodiconhistories')->insert($insert);
    }

    public function goodiconhistoryModelDelete($loginid,$workid,$reviewid) {
        $where1 = [
            'loginid' => $loginid
        ];
        $where2 = [
            'workid' => $workid
        ];
        $where3 = [
            'reviewid' => $reviewid
        ];
        $id = DB::table('goodiconhistories')->where($where1)->where($where2)->where($where3)->max('id');
        $where4 = [
           'id' => $id
        ];
        DB::table('goodiconhistories')->where($where4)->delete();
    }

    public function goodiconhistoryModelGet($key,$loginid = NULL,$workid,$reviewid) {
        $where1 = [
            'workid' => $workid
        ];
        $where2 = [
            'reviewid' => $reviewid
        ];
        $goodiconhistories = DB::table('goodiconhistories')
        ->where($where1)->where($where2);

        switch ($key) {
            case 'login_iconcount':
                $where3 = [
                    'loginid' => $loginid
                ];
                $login_iconcount = $goodiconhistories->where($where3)->count();
            return $login_iconcount;

            case 'guest_iconcount':
                $where4 = [
                    'loginid' => 'Guest'
                ];
                $guest_iconcount = $goodiconhistories->where($where4)->max('id');
            return $guest_iconcount;

            case 'iconcount':
                $count = $goodiconhistories->count();
            return $count;
        }
    }




}
