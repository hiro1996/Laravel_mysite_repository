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

    public function workModelGet($key,$table,$wherecolumn,$wheredata,$select,$column,$groupname) {
        $works = DB::table('works');
        if ($key == 'where') {
            $works->join('worksubs','works.workid','=','worksubs.workid') 
                ->leftjoin('worktransinfos','worksubs.worktransinfoid','=','worktransinfos.id')
            ->where(''.$table.'.'.$wherecolumn,'=',$wheredata);
        } elseif ($key == 'workindetail') {
            $works->join('worksubs','works.workid','=','worksubs.workid') 
                ->join('worktypes','works.work_type','=','worktypes.worktypeid')
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
                $wherecolumn => $wheredata
            ];
            $works->join('worksubs','works.workid','=','worksubs.workid') 
                ->join('worktransinfos','worksubs.worktransinfoid','=','worktransinfos.id')
            ->where($where)
            ->orderBy('worksubs.siteviewday_1','ASC');
        } elseif ($key == 'recommendpostreport') {
            $where = [
                'created_at' => date('Y-m-d')
            ];
            $works->join('worksubs','works.workid','=','worksubs.workid') 
                ->join('posts','worksubs.id','=','posts.worksubid')
                ->where($where)
                ->where('poststar','>=',7);
        } elseif ($key == 'workmenuname') {
            $works = $works->join('worksubs','works.workid','=','worksubs.workid')
            ->select($select,DB::raw('count('.$table.'.'.$column.') AS '.$groupname.''))
            ->groupBy($select)
            ->orderBy($select,'ASC');
        } else {
            $where = [
                $wherecolumn => $wheredata
            ];
            $works->join('worksubs',function($join) {
                $join->on('works.workid','=','worksubs.workid');
            })->where($where);
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

    public function worksearchresultModelGet($where) {
        $worksearchresults = DB::table('works')
            ->join('worksubs','works.workid','=','worksubs.workid') 
            ->join('worktypes','works.work_type','=','worktypes.worktypeid') 
            ->where($where)
            ->get();
        return $worksearchresults;
    }

}
