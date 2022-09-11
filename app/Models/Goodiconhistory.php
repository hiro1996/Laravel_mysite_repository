<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Goodiconhistory extends Model
{
    public function goodiconhistoryModelInsert($loginid,$worksubid,$reviewid) {
        $insert = [
            'loginid' => $loginid,
            'worksubid' => $worksubid,
            'reviewid' => $reviewid
        ];
        DB::table('goodiconhistories')->insert($insert);
    }

    public function goodiconhistoryModelDelete($where) {
        $id = DB::table('goodiconhistories')->where($where)->max('id');
        $whereid = [
           'id' => $id
        ];
        DB::table('goodiconhistories')->where($whereid)->delete();
    }

    public function goodiconhistoryModelGet($where,$select,$groupby,$having) {
        $goodiconhistories = DB::table('goodiconhistories')
            ->where($where)
            ->select($select);
            if ($groupby != NULL) {
                $goodiconhistories = $goodiconhistories->groupBy($groupby);
            }
            if ($having != NULL) {
                $goodiconhistories = $goodiconhistories->havingRaw($having);
            }
            $goodiconhistories = $goodiconhistories->get();
            return $goodiconhistories;
    }




}
