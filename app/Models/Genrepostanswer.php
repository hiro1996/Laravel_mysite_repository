<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Genrepostanswer extends Model
{
    public function genrepostanswerModelInsert($loginid,$worksubid,$genrepostid,$genrepostselectid) {
        $insert = [
            'loginid' => $loginid,
            'worksubid' => $worksubid,
            'genrepostid' => $genrepostid,
            'genrepostselectid' => $genrepostselectid
        ];
        DB::table('genrepostanswers')->insert($insert);
    }

    // limitで上位何データかを取得できる
    public function genrepostanswerModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit) {
        $genrepostanswers = DB::table('genrepostanswers');
        if (in_array('genreposts',$needDB)) {
            $genrepostanswers = $genrepostanswers->join('genreposts','genrepostanswers.genrepostid','=','genreposts.genrepostid');
        }
        $genrepostanswers = $genrepostanswers
            ->where($where)
            ->select($select);
        if ($groupby != NULL) {
            $genrepostanswers = $genrepostanswers->groupBy($groupby);
        }
        if ($orderby != NULL) {
            $genrepostanswers = $genrepostanswers->orderBy($orderby,$orderbyascdesc);
        }
        if ($limit != NULL) {
            $genrepostanswers = $genrepostanswers->limit($limit);
        }
        $genrepostanswers = $genrepostanswers->get();
        return $genrepostanswers;
    }

    public function genrepostanswerModelExist($loginid,$workid) {
        $where1 = [
            'loginid' => $loginid
        ];
        $where2 = [
            'workid' => $workid
        ];
        $genrepostanswers = DB::table('genrepostanswers')->where($where1)->where($where2)->exists();
        return $genrepostanswers;
    }

    public function genrepostanswerModelDelete($loginid,$workid) {
        $where1 = [
            'loginid' => $loginid
        ];
        $where2 = [
            'workid' => $workid
        ];
        DB::table('genrepostanswers')->where($where1)->where($where2)->delete();
    }

    public function genrepostanswerModelSearch($worksubid) {
        $where = [
            'worksubid' => $worksubid
        ];
        $genrepostanswers = DB::table('genrepostanswers')->where($where)->exists();
        return $genrepostanswers;
    }

    
}
