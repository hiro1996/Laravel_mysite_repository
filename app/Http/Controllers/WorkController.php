<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Browsehistory;
use App\Models\Favorite;
use App\Models\Genrepost;
use App\Models\Genrepostanswer;
use App\Models\Goodiconhistory;
use App\Models\Guestrecord;
use App\Models\Post;
use App\Models\Record;
use App\Models\Work;
use App\Models\Worktype;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;

class WorkController extends Controller
{
    public function worksearch() {
        return view('work.worksearch');
    }

    //worksearch = キー
    //furigana = 作品検索画面内の「五十音検索」のid
    //word = 単語
    //workanimes = 検索する対象テーブル
    public function worksearchajax(Request $request, Work $work) {
        $word = $request->only('word','work','artist','keyword');
        $works = $work->workModelWhere('worksearch','furigana',$word["word"],$word["work"],$word["artist"],$word["keyword"],'works');
        return response()->json(
            [
                "data" => $works
            ],
        );
    }

    public function workhistory(Browsehistory $browsehistory) {
        $browsehistories = $browsehistory->browsehistoryModelGet('normal','loginid',session('loginid'),NULL,NULL,10);
        $i = 0;
        foreach ($browsehistories as $browsehist) {
            $browsehistorydatas['title'][$i] = $browsehist->title;
            $browsehistorydatas['img'][$i] = $browsehist->img;
            $browsehistorydatas['historydate'][$i] = $browsehist->history_time;
            $i++;
        }
        return view('work.workhistory',compact('browsehistorydatas'));
    }

    public function workindetail(Work $work, $url, $url2, $url3, Favorite $favorite, Post $post, Record $record, Guestrecord $guestrecord, Genrepost $genrepost, Genrepostanswer $genrepostanswer, Browsehistory $browsehistory, Goodiconhistory $goodiconhistory) {
        /**
         * コンテンツトップでどの作品をクリックしたかを判別するURLを取得し、urlからどの作品DBのデータを参照するか確認
         */
        $urlstr = $url.'/'.$url2.'/'.$url3;

        /**
         * 人気急上昇タグを表示
         */
        $ninkitag = [];
        for ($date = 1;$date <= 3;$date++) {
            if ($date == 1) {
                $startdate = date('Y-m-d');
                $findate = date('Y-m-d', strtotime('-1 day'));
                $contentstop['ninkitodayyesterday_button'][$date] = '本日の人気急上昇作品';
            } elseif ($date == 2) {
                $weekno = date('w',strtotime(date('Y-m-d')));
                $startdate = date('Y-m-d',strtotime("-{$weekno} day",strtotime(date('Y-m-d'))));
                $daysleft = 6 - $weekno;
                $findate = date('Y-m-d',strtotime("+{$daysleft} day",strtotime(date('Y-m-d'))));
                $contentstop['ninkitodayyesterday_button'][$date] = '今週の人気急上昇作品';
            } else {
                $startdate = date('Y-m-01');
                $findate = date('Y-m-t');
                $contentstop['ninkitodayyesterday_button'][$date] = '今月の人気急上昇作品';
            }

            $ninkistodayyesterday = $browsehistory->browsehistoryModelGet(NULL,'history_time_date',$findate,'history_time_date',$startdate,4);
            foreach ($ninkistodayyesterday as $ninkity) {
                array_push($ninkitag,$ninkity->worksubid);
            }
        }

        /**
         * どの作品DBから参照するかとクリックした作品のURLをキーとして、作品詳細画面で表示する作品情報を取得
         */
        $workdata = $work->workModelGet('workindetail','worksubs','url',$urlstr);

        foreach ($workdata as $workd) {
            $workdata['img'] = $workd->img;
            if ($workd->volume != NULL) {
                $workdata['title'] = $workd->title.''.$workd->volume;
            } else {
                $workdata['title'] = $workd->title;
            }
            $workdata['furigana'] = $workd->furigana;
            $workdata['explaining'] = $workd->explaining;
            $workdata['workgenre'] = $workd->worktype_name;
            $workdata['publisher'] = $workd->publisher;
            $workdata['publicationmagazine_label'] = $workd->publicationmagazine_label;
            $workdata['auther'] = $workd->auther;
            $workdata['newtag'] = FALSE;
            if ($workd->worktransinfoid == 2) {
                $newtagviewmax = date('Y-m-d',strtotime($workd->siteviewday_1.'+ '.$workd->setvalue.'days'));
                if (date('Y-m-d') < $newtagviewmax) {
                    $workdata['newtag'] = TRUE;
                }
            }
        }

        /**
         * 閲覧履歴テーブル(browsehistories)に作品IDとログインしているユーザーIDもしくは未ログイン時のユーザーを登録
         * すでに登録されている作品IDとユーザーIDの組み合わせがある場合、閲覧日を更新
         */
        $workids = $work->workidModelGet($urlstr);
        $workdata['ninkitag'] = FALSE;
        foreach ($workids as $id) {
            $workdata['worksubid'] = $id->id;
            //コンテンツトップの人気急上昇に入っている作品に対して人気急上昇タグを表示する
            if (in_array($workdata['worksubid'],$ninkitag)) $workdata['ninkitag'] = TRUE;
        }
 
        $loginid = 'Guest';
        if (session('loginid')) {
            $loginid = session('loginid');
            if ($browsehistory->browsehistoryModelExist($loginid,$workdata['worksubid'])) {
                $browsehistory->browsehistoryModelUpdate('loginid',$loginid,'worksubid',$workdata['worksubid'],'history_time',now());
            } else {
                $browsehistory->browsehistoryModelInsert($loginid,$workdata['worksubid']);
            }
        } 

        /**
         * 記録テーブル(records)もしくは未ログインユーザー記録テーブル(guestrecords)に履歴閲覧回数を登録しに行く
         */
        if (session('loginid')) {
            $records = $record->recordModelGet();
            foreach ($records as $reco) {
                $record->recordModelUpdate('loginid',session('loginid'),'workid',$workdata['worksubid'],'browsehistory_sum',$reco->browsehistory_sum + 1); //閲覧回数が更新されない
            }
        } else {
            $guestrecords = $guestrecord->guestrecordModelGet();
            foreach ($guestrecords as $guestreco) {
                $guestrecord->guestrecordModelUpdate('workid',$workdata['worksubid'],'browsehistory_sum',$guestreco->browsehistory_sum + 1); //閲覧回数が更新されない
            }
        }

        /**
         * お気に入りテーブル(favorites)からお気に入りに設定している作品IDを取得し、リストに入れる。
         * リストの中で、作品詳細を開こうとしている作品IDがあれば、デフォルト表示を「お気に入りに登録済み」にする。
         */
        $favorites = $favorite->favoriteAllModelGet();

        $favoritelist = [];
        if (count($favorites) > 0) {
            foreach ($favorites as $favo) {
                array_push($favoritelist,$favo->workid);
            }
        }

        if (in_array($workdata['worksubid'],$favoritelist)) {
            $favoriteclass = 'btn btn-secondary btn-block';
            $favoritetext = 'お気に入りに登録済み';
        } else {
            $favoriteclass = 'btn btn-primary btn-block';
            $favoritetext = 'お気に入りに登録';
        }

        /**
         * 投稿テーブル(posts)から作品詳細を開こうとしている作品IDに紐づく投稿を取得
         */
        $workdata['posts'] = $post->postModelGet('worksubid',$workdata['worksubid'],NULL,NULL,NULL);

        /**
         * ジャンル投票用のデータを取得
         */
        $genreposts = $genrepost->genrepostModelGet();
        $arrangementone = 1;
        $arrangementtwo = 1;
        foreach ($genreposts as $genre) {
            if ($genre->genrepost_select_id == 1) {
                $category[1][$arrangementone][] = $genre->genre;
                if (count($category[1][$arrangementone]) == 7) $arrangementone++;
            } else {
                $category[2][$arrangementtwo][] = $genre->genre;
                if (count($category[2][$arrangementtwo]) == 7) $arrangementtwo++;
            }
        }
        $workdata["category"] = $category;

        $workdata["genrepostanswers"] = FALSE;
        if ($genrepostanswer->genrepostanswerModelSearch($workdata['worksubid'])) {
            for ($i = 1;$i < 3;$i++) {
                $genrepostanswers[$i] = $genrepostanswer->genrepostanswerModelGet($workdata['worksubid'],$i);
                $j = 0;
                foreach ($genrepostanswers[$i] as $genre) {
                    $genrepostanswersdata[$i][$j] = $genre->genre;
                    $j++;
                }
            }
            $workdata["genrepostanswers"] = $genrepostanswersdata;
        }

        /**
         * ログインユーザーが当画面にログインした場合、すでにいいねを押したレビューだけ黄goodアイコン、それ以外は白goodアイコン
         * 未ログインユーザーが当画面にログインした場合、デフォルト表示は必ず白goodアイコン
         * 各作品IDとレビューIDから各レビューを取得
         */
        if (count($workdata["posts"]) != 0) {
            if (session('loginid')) {
                for ($i = 1;$i <= count($workdata["posts"]);$i++) {
                    $goodiconurl[$i] = 'http://127.0.0.1:8000/assets/img/icon/workindetail/goodicon.png';
                    $forurljudge[$i] = 'beforeclick'.$i;
                    $login_iconcount = $goodiconhistory->goodiconhistoryModelGet('login_iconcount',$loginid,$workdata['worksubid'],$i);
                    if ($login_iconcount > 0) {
                        $goodiconurl[$i] = 'http://127.0.0.1:8000/assets/img/icon/workindetail/goodiconpush.png';
                        $forurljudge[$i] = 'afterclick'.$i;
                    }
                    $counts[$i] = $goodiconhistory->goodiconhistoryModelGet('iconcount',NULL,$workdata['worksubid'],$i);
                }
            } else {
                for ($i = 1;$i <= count($workdata["posts"]);$i++) {
                    $goodiconurl[$i] = 'http://127.0.0.1:8000/assets/img/icon/workindetail/goodicon.png';
                    $forurljudge[$i] = 'beforeclick'.$i;
                    $counts[$i] = $goodiconhistory->goodiconhistoryModelGet('iconcount',NULL,$workdata['worksubid'],$i);
                }
            }
            $workdata["count"] = $counts;
            $workdata["goodiconurl"] = $goodiconurl;
            $workdata["forurljudgeclass"] = $forurljudge;
        } 
        

        return view('work.workindetail',compact('workdata','favoriteclass','favoritetext'));
    }

    public function workindetailfavoriteadd(Request $request, Work $work, Favorite $favorite) {
        /**
         * 「お気に入りに登録」を押下時に、お気に入りテーブル(favorites)に作品IDとその作品IDがどの作品DBにあるかを登録
         */
        $workindetails = $request->only('url');
        $url = explode("/",$workindetails["url"]);
        $urlstr = str_replace("/work_indetail/","",$workindetails["url"]);
        
        $works = $work->workModelGet('where','worksubs','url',$urlstr);

        foreach ($works as $work) {
            $workid = $work->workid;
        }
        $favorite->favoriteModelInsert($workid);
        return response()->json(
            [
                "data" => $workid
            ],
        );
    }

    public function workindetailfavoritedelete(Request $request, Work $work, Favorite $favorite) {
        /**
         * 「お気に入りに登録済み」を押下時に、お気に入りテーブル(favorites)から作品IDとその作品IDがどの作品DBにあるかを登録したものを削除
         */
        $workindetails = $request->only('url');
        $url = explode("/",$workindetails["url"]);
        $urlstr = str_replace("/work_indetail/","",$workindetails["url"]);
        
        $works = $work->workModelGet('where','worksubs','url',$urlstr);

        foreach ($works as $work) {
            $workid = $work->workid;
        }
        $favorite->favoriteModelDelete($workid);
        return response()->json(
            [
                "data" => $workid
            ],
        );
    }

    public function workgenrepostcomplete(Request $request, Genrepost $genrepost, Genrepostanswer $genrepostanswer) {
        $genrepostsreq = $request->only('genrepost','workid');

        $loginid = 'Guest';
        if (session('loginid')) {
            $loginid = session('loginid'); 
            if ($genrepostanswer->genrepostanswerModelExist($loginid,$genrepostsreq['workid'])) {
                $genrepostanswer->genrepostanswerModelDelete($loginid,$genrepostsreq['workid']);
            }
        }
        for ($i = 0;$i < count($genrepostsreq['genrepost']);$i++) {
            $genrepostid = $genrepost->genrepostModelSearch('genre',$genrepostsreq['genrepost'][$i],'genrepostid');
            $genrepostselectid = $genrepost->genrepostModelSearch('genre',$genrepostsreq['genrepost'][$i],'genrepostselectid');
            $genrepostanswer->genrepostanswerModelInsert($loginid,$genrepostsreq['workid'],$genrepostid,$genrepostselectid);
        }
        for ($i = 1;$i < 3;$i++) {
            $genrepostanswers[$i] = $genrepostanswer->genrepostanswerModelGet($genrepostsreq['workid'],$i);
            $j = 0;
            foreach ($genrepostanswers[$i] as $genre) {
                $genrepostanswersdata[$i][$j] = $genre->genre;
                $j++;
            }
        }
        return response()->json(
            [
                "result" => 'OK',
                "genrepostdata" => $genrepostanswersdata
            ],
        );
    }

    public function workindetailgoodiconadd(Request $request, Goodiconhistory $goodiconhistory) {
        $count = $request->only('workid','reviewid');

        $loginid = 'Guest';
        if (session('loginid')) $loginid = session('loginid');
        $goodiconhistory->goodiconhistoryModelInsert($loginid,$count["workid"],$count["reviewid"]);

        $goodicon = 'http://127.0.0.1:8000/assets/img/icon/workindetail/goodiconpush.png';
        $counts = $goodiconhistory->goodiconhistoryModelGet('iconcount',NULL,$count["workid"],$count["reviewid"]);
        return response()->json(
            [
                "count" => $counts,
                "icon" => $goodicon
            ],
        );
    }

    public function workindetailgoodicondelete(Request $request, Goodiconhistory $goodiconhistory) {
        $count = $request->only('workid','reviewid');

        $loginid = 'Guest';
        if (session('loginid')) $loginid = session('loginid');
        $goodiconhistory->goodiconhistoryModelDelete($loginid,$count["workid"],$count["reviewid"]);

        $goodicon = 'http://127.0.0.1:8000/assets/img/icon/workindetail/goodicon.png';
        $counts = $goodiconhistory->goodiconhistoryModelGet('iconcount',NULL,$count["workid"],$count["reviewid"]);
        return response()->json(
            [
                "count" => $counts,
                "icon" => $goodicon
            ],
        );
    }

    public function worksearchresult(Request $request, Work $work, Worktype $worktype, Post $post) {
        $category = $request->category;
        $category_genre = $request->category_genre;

        $where_list = [];
        if ($category) {
            $worktypes = $worktype->worktypeModelGet('worktype_name',$category);
            foreach ($worktypes as $workt) {
                $category_list = $workt->worktypeid;
            }
            $where_list = ['work_type' => $category_list];
        }
        if ($category_genre) {
            $where_list = ['category_name' => $category_genre];
        }
        
        $worksearchresults = $work->worksearchresultModelGet($where_list);
        $i = 0;
        foreach ($worksearchresults as $result) {
            if ($result->volume != NULL) {
                $worksearchresult['worksearchresult_title'][$i] = $result->title.''.$result->volume;
            } else {
                $worksearchresult['worksearchresult_title'][$i] = $result->title;
            }
            $worksearchresult['worksearchresult_furigana'][$i] = $result->furigana;
            $worksearchresult['worksearchresult_categoryname'][$i] = $result->category_name;
            $worksearchresult['worksearchresult_url'][$i] = asset($result->url);
            $worksearchresult['worksearchresult_img'][$i] = $result->img;
            $worksearchresult['worksearchresult_worktypename'][$i] = $result->worktype_name;
            $worksearchresult['worksearchresult_label'][$i] = $result->publicationmagazine_label;
            $worksearchresult['worksearchresult_auther'][$i] = $result->auther;
            $worksubids = $work->workidModelGet($result->url);
            foreach ($worksubids as $id) {
                $poststars = $post->postModelGet('worksubid',$id->id,NULL,NULL,NULL);
                if (count($poststars) != 0) {
                    $poststarnum = 0;
                    foreach ($poststars as $star) {
                        $poststarnum = $poststarnum + $star->poststar;
                    }
                    $shosu = $poststarnum  / count($poststars) ;
                    $worksearchresult['worksearchresult_poststaravg'][$i] = ''.(floor($shosu * 10)) / 10 .'';
                } else {
                    $worksearchresult['worksearchresult_poststaravg'][$i] = '0.0';
                }
            }
            $i++;
        }
        return view('worksearchresult',compact('worksearchresult'));
    }
}
