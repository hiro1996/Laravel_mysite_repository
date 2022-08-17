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

    public function workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit) {
        $works = DB::table('works');
            if (in_array('worksubs',$needDB)) {
                $works = $works->join('worksubs','works.workid','=','worksubs.workid');
            }
            if (in_array('posts',$needDB)) {
                $works = $works->join('posts','worksubs.id','=','posts.worksubid');
            }
            if (in_array('worktypes',$needDB)) {
                $works = $works->join('worktypes','works.work_type','=','worktypes.worktypeid');
            }
            if (in_array('worktransinfos',$needDB)) {
                $works = $works->leftjoin('worktransinfos','worksubs.worktransinfoid','=','worktransinfos.id');
            }
            $works = $works->where($where)
            ->select($select);
            if ($groupby != NULL) {
                $works = $works->groupBy($groupby);
            }
            if ($orderby != NULL) {
                $works = $works->orderBy($orderby,$orderbyascdesc);
            }
            if ($limit != NULL) {
                $works = $works->limit($limit);
            }
            $works = $works->get();
        return $works;
    }


    public function workidModelGet($table,$wherecolumn,$wheredata) {
        $where = [
            $wherecolumn => $wheredata
        ];
        $workdatas = DB::table($table)->where($where)->get();
        return $workdatas;
    }

    public function worktitleConvert($title,$titlelength) {
        $titleconvert = $title;
        if (mb_strlen($title) > $titlelength) {
            $tmp = strstr($title,mb_substr($title,$titlelength),TRUE);
            $titleconvert = $tmp.'...';
        } 
        return $titleconvert;
    }

    public function worksearchresultModelGet($where,$select) {
        $worksearchresults = DB::table('works')
            ->join('worksubs','works.workid','=','worksubs.workid') 
            ->join('worktypes','works.work_type','=','worktypes.worktypeid') 
            ->where($where)
            ->select($select)
            ->get();
        return $worksearchresults;
    }

}
