<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Work extends Model
{

    public function workModelWhere($key,$whereColumn,$word = NULL,$work = NULL,$artist = NULL,$keyword = NULL) {
        switch ($key) {
            case 'worksindetail':
                $where = [
                    $whereColumn => $word,
                ];
                $works = DB::table('worksubs')->where($where)->get();
                break;
            //五十音検索のひらがなで始まる検索
            case 'worksearch':
                $works = DB::table('worksubs');
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

    public function workModelGet($key,$table,$wherecolumn,$wheredata) {
        $works = DB::table('works');
        if ($key == 'where') {
            $works->join('worksubs',function($join) use ($table,$wherecolumn,$wheredata) {
                $join->on('works.workid','=','worksubs.workid')
                    ->where(''.$table.'.'.$wherecolumn,'=',$wheredata);
            });
        } elseif ($key == 'select') {
            $works->join('worksubs',function($join) {
                $join->on('works.workid','=','worksubs.workid');
            })->select($wherecolumn);
        } elseif ($key == 'sum') {
            $works->join('worksubs',function($join) {
                $join->on('works.workid','=','worksubs.workid');
            })->select(DB::raw('works.title,worksubs.url,worksubs.img,worksubs.browse_record * worksubs.notificate_record  AS record_times'));
        } else {
            $works->join('worksubs',function($join) {
                $join->on('works.workid','=','worksubs.workid');
            });
        }
        $works = $works->get();
        return $works;
    }

}
