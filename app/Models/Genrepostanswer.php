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
    public function genrepostanswerModelGet($worksubid,$genrepostselectid) {
        $genrepostanswers = DB::table('genrepostanswers')
        ->join('genreposts','genrepostanswers.genrepostid','=','genreposts.genrepostid');
        if ($worksubid != NULL) {
            $where1 = [
                'worksubid' => $worksubid
            ];
            $genrepostanswers = $genrepostanswers->where($where1);
        }
        if ($genrepostselectid != NULL) {
            $where2 = [
                'genrepostselectid' => $genrepostselectid
            ];
            $genrepostanswers = $genrepostanswers->where($where2);
        }
        $genrepostanswers = $genrepostanswers->select('genreposts.genre','genreposts.background_color',DB::raw('count(genrepostanswers.genrepostid) AS genrepost_count'))
        ->groupBy('genreposts.genre','genreposts.background_color')
        ->orderBy('genrepost_count','DESC')->get();
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
