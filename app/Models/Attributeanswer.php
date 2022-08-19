<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attributeanswer extends Model
{
    public function attributeanswerModelInsert($ans) {
        $insert = [
            'loginid' => session('loginid'),
            'ans_id' => $ans,
            'created_at' => date('Y-m-d')
        ];
        DB::table('attributeanswers')->insert($insert);
    }

    public function attributeanswerModelGet($needDB,$where,$select) {
        $attributeanswers = DB::table('attributeanswers');
        if (in_array('attributes',$needDB)) {
            $attributeanswers = $attributeanswers->join('attributes','attributeanswers.ans_id','=','attributes.answer_id');
        }
        $attributeanswers = $attributeanswers
            ->where($where)
            ->select($select)
            ->get();
        return $attributeanswers;
    }

    public function attributeanswerModelDelete() {
        $where = [
            'loginid' => session('loginid')
        ];
        DB::table('attributeanswers')->where($where)->delete();
    }
}
