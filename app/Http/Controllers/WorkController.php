<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Browsehistory;
use App\Models\Favorite;
use App\Models\Genrepost;
use App\Models\Guestrecord;
use App\Models\Post;
use App\Models\Record;
use App\Models\Work;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    public function worksearch() {
        return view('work.worksearch');
    }

    //worksearch = キー
    //furigana = 作品検索画面内の「五十音検索」のid
    //word = 単語
    //workanimes = 検索する対象テーブル
    public function worksearchAjax(Request $request, Work $work) {
        $word = $request->only('word','work','artist','keyword');
        $works = $work->workModelWhere('worksearch','furigana',$word["word"],$word["work"],$word["artist"],$word["keyword"],'workanimes');
        return response()->json(
            [
                "data" => $works
            ],
        );
    }

    public function workhistory(Browsehistory $browsehistory) {
        $browsehistories = $browsehistory->browsehistoryModelGet();
        $i = 0;
        foreach ($browsehistories as $browsehist) {
            $browsedatas = $browsehistory->browsehistoryDataModelGet($browsehist->workid,$browsehist->DB_table_name);
            foreach ($browsedatas as $data) {
                $browsehistorydatas['title'][$i] = $data->title;
                $browsehistorydatas['img'][$i] = $data->img;
                $browsehistorydatas['historydate'][$i] = $browsehist->history_time;
            }
            $i++;
        }
        return view('work.workhistory',compact('browsehistorydatas'));
    }

    public function workindetail(Work $work, $url, $url2, Favorite $favorite, Post $post, Record $record, Guestrecord $guestrecord, Browsehistory $browsehistory) {
        /**
         * コンテンツトップでどの作品をクリックしたかを判別するURLを取得し、urlからどの作品DBのデータを参照するか確認
         */
        $urlstr = $url.'/'.$url2;
        $db = $work->workDBModelGet(NULL,NULL,NULL,NULL,$url,NULL);

        /**
         * どの作品DBから参照するかとクリックした作品のURLをキーとして、作品詳細画面で表示する作品情報を取得
         */
        $workdata = $work->workModelGet($db,'url',$urlstr);

        foreach ($workdata as $workd) {
            $workdata['workid'] = $workd->workid;
            $workdata['img'] = $workd->img;
            $workdata['title'] = $workd->title;
            $workdata['furigana'] = $workd->furigana;
            $workdata['explaining'] = $workd->explaining;
        }

        /**
         * 閲覧履歴テーブル(browsehistories)に作品IDとログインしているユーザーIDもしくは未ログイン時のユーザーを登録
         * すでに登録されている作品IDとユーザーIDの組み合わせがある場合、閲覧日を更新
         */
        $loginid = 'Guest';
        if (session('loginid')) {
            $loginid = session('loginid');
            if ($browsehistory->browsehistoryModelExist($loginid,$workdata['workid'])) {
                $browsehistory->browsehistoryModelUpdate('loginid',$loginid,'workid',$workdata['workid'],'history_time',now());
            } else {
                $browsehistory->browsehistoryModelInsert($loginid,$workdata['workid'],$db);
            }
        } 

        /**
         * 記録テーブル(records)もしくは未ログインユーザー記録テーブル(guestrecords)に履歴閲覧回数を登録しに行く
         */
        if (session('loginid')) {
            $records = $record->recordModelGet();
            foreach ($records as $reco) {
                $record->recordModelUpdate('loginid',session('loginid'),'workid',$workdata['workid'],'browsehistory_sum',$reco->browsehistory_sum + 1); //閲覧回数が更新されない
            }
        } else {
            $guestrecords = $guestrecord->guestrecordModelGet();
            foreach ($guestrecords as $guestreco) {
                $guestrecord->guestrecordModelUpdate('workid',$workdata['workid'],'browsehistory_sum',$guestreco->browsehistory_sum + 1); //閲覧回数が更新されない
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

        if (in_array($workdata['workid'],$favoritelist)) {
            $favoriteclass = 'btn btn-secondary btn-block';
            $favoritetext = 'お気に入りに登録済み';
        } else {
            $favoriteclass = 'btn btn-primary btn-block';
            $favoritetext = 'お気に入りに登録';
        }

        /**
         * 投稿テーブル(posts)から作品詳細を開こうとしている作品IDに紐づく投稿を取得
         */
        $workdata['posts'] = $post->postModelGet($workdata['workid']);

        return view('work.workindetail',compact('workdata','favoriteclass','favoritetext'));
    }

    public function workindetailfavoriteadd(Request $request, Work $work, Favorite $favorite) {
        /**
         * 「お気に入りに登録」を押下時に、お気に入りテーブル(favorites)に作品IDとその作品IDがどの作品DBにあるかを登録
         */
        $workindetails = $request->only('url');
        $url = explode("/",$workindetails["url"]);
        $urlstr = str_replace("/work_indetail/","",$workindetails["url"]);
        
        $db = $work->workDBModelGet(NULL,NULL,NULL,NULL,$url[2],NULL);
        $works = $work->workModelGet($db,'url',$urlstr);

        foreach ($works as $work) {
            $workid = $work->workid;
        }
        $favorite->favoriteModelInsert($workid,$db);

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
        
        $db = $work->workDBModelGet(NULL,NULL,NULL,NULL,$url[2],NULL);
        $works = $work->workModelGet($db,'url',$urlstr);

        foreach ($works as $work) {
            $workid = $work->workid;
        }
        $favorite->favoriteModelDelete($workid,$db);
        

        return response()->json(
            [
                "data" => $workid
            ],
        );
    }

    public function workgenrepost(Genrepost $genrepost) {

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

        return view('work.workgenrepost',compact('category'));
    }
}
