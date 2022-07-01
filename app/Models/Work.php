<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Work extends Model
{

    public function workNameModelGet() {
        $works = DB::table('works')->get();

        $i = 0;
        foreach ($works as $work) {
            $workall[$i] = $work->title;
            $i++;
        }

        /**
         * 作品名でソートの仕方がわからない
         * ※配列で渡した作品が何のジャンルかがわかるようになっていること前提
         */
        return $workall;
    }

    public function workModelWhere($key,$whereColumn,$word = NULL,$work = NULL,$artist = NULL,$keyword = NULL) {
        switch ($key) {
            case 'worksindetail':
                $where = [
                    $whereColumn => $word,
                ];
                $works = DB::table('works')->where($where)->get();
                break;
            //五十音検索のひらがなで始まる検索
            case 'worksearch':
                $works = DB::table('works');
                if ($word) {
                    $works = $works->where('furigana','like',''.$word[0].'%');
                    if (count($word) > 1) {
                        for ($i = 1;$i < count($word);$i++) {
                            $works = $works->OrWhere('furigana','like',''.$word[$i].'%');
                        }
                    }
                }
                if ($work) $works = $works->where('furigana','like',"%$work%");
                if ($keyword) $works = $works->where('explaining','like',"%$keyword%");
                $works = $works->get();
                break;
        }
        return $works;
    }

    public function workModelGet($wherecolumn,$wheredata) {
        $works = DB::table('works');
        if ($wherecolumn != NULL) {
            $where = [
                $wherecolumn => $wheredata,
            ];
            $works = $works->where($where);
        }
        $works = $works->get();
        return $works;
    }

}
