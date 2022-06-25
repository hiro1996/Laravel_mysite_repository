<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Genrepostanswer extends Model
{
    public function genrepostanswerModelInsert($loginid,$workid,$genrepostid,$genrepostselectid) {
        $insert = [
            'loginid' => $loginid,
            'workid' => $workid,
            'genrepostid' => $genrepostid,
            'genrepostselectid' => $genrepostselectid
        ];
        DB::table('genrepostanswers')->insert($insert);
    }

    // limitで上位何データかを取得できる
    public function genrepostanswerModelGet($workid,$genrepostselectid) {
        $where1 = [
            'workid' => $workid
        ];
        $where2 = [
            'genrepostselectid' => $genrepostselectid
        ];
        $genrepostanswers = DB::table('genrepostanswers')
        ->join('genreposts',function($join) use ($where1,$where2) {
            $join->on('genrepostanswers.genrepostid','=','genreposts.genrepostid')
                ->where($where1)->where($where2);
        })->select('genreposts.genre',DB::raw('count(genrepostanswers.genrepostid) AS genrepost_count'))
        ->groupBy('genreposts.genre')
        ->orderBy('genrepost_count','DESC')->limit(2)->get();
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

    public function genrepostanswerModelSearch($workid) {
        $where = [
            'workid' => $workid
        ];
        $genrepostanswers = DB::table('genrepostanswers')->where($where)->exists();
        return $genrepostanswers;
    }

    
}
