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
            $works->join('worksubs','works.workid','=','worksubs.workid') 
                ->leftjoin('worktransinfos','worksubs.worktransinfoid','=','worktransinfos.id')
            ->where(''.$table.'.'.$wherecolumn,'=',$wheredata);
        } elseif ($key == 'select') {
            $works->join('worksubs',function($join) {
                $join->on('works.workid','=','worksubs.workid');
            })->select($wherecolumn);
        } elseif ($key == 'sum') {
            $works->join('worksubs',function($join) {
                $join->on('works.workid','=','worksubs.workid');
            })->select(DB::raw('works.title,worksubs.url,worksubs.img,worksubs.browse_record * worksubs.notificate_record  AS record_times'));
        } elseif ($key == 'reserve') {
            $where = [
                'worktransinfoid' => 1
            ];
            $works->join('worksubs','works.workid','=','worksubs.workid') 
                ->join('worktransinfos','worksubs.worktransinfoid','=','worktransinfos.id')
            ->where($where)
            ->orderBy('worksubs.siteviewday','ASC');
        } elseif ($key == 'recommendpostreport') {
            $where1 = [
                'created_day' => date('Y-m-d')
            ];
            $where2 = [
                'poststar','>=',4
            ];
            $works->join('worksubs','works.workid','=','worksubs.workid') 
                ->leftjoin('posts','worksubs.id','=','posts.worksubid')
                ->where($where1);
        } else {
            $works->join('worksubs',function($join) {
                $join->on('works.workid','=','worksubs.workid');
            });
        }
        $works = $works->get();
        return $works;
    }

    public function worktitleConvert($title,$titlelength) {
        $titleconvert = $title;
        if (mb_strlen($title) > $titlelength) {
            $tmp = strstr($title,mb_substr($title,$titlelength),TRUE);
            $titleconvert = $tmp.'...';
        } 
        return $titleconvert;
    }

}
