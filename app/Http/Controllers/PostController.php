<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Browsehistory;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function post(Request $request, User $user, Work $work, Favorite $favorite, Browsehistory $browsehistory) {

        $posts['nickname'] = 'Guest';
        if (session('loginid')) { //ログインしている時
            $where = [['login','=',session('loginid')]];
            $select = [
                'nickname',
            ];
            $users = $user->userModelGet($where,$select);
            foreach ($users as $ur) {
                $posts['nickname'] = $ur->nickname;
            };
        } 

        $needDB = [
            'worksubs',
            'worktypes',
            'worktransinfos',
        ];
        $where = NULL;
        $select = ['title'];
        $groupby = NULL;
        $orderby = NULL;
        $orderbyascdesc = NULL;
        $limit = NULL;
        $worktitles = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);

        $posts['wotkalltitle'] = FALSE;
        if (count($worktitles) != 0) {
            $i = 0;
            foreach ($worktitles as $title) {
                $posts['wotkalltitle'][$i] = $title->title;
                $i++;
            }   
        }


        $needDB = [
            'worksubs',
            'works',
        ];
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'title',
        ];
        $favorites = $favorite->favoriteModelGet($needDB,$where,$select);

        $posts['favoritetitle'] = FALSE;
        if (count($favorites) != 0) {
            $i = 0;
            foreach ($favorites as $favotmp) {
                $posts['favoritetitle'][$i] = $favotmp->title;
            }
            $i++;
        } 

        $needDB = [
            'worksubs',
            'works',
            'worktypes',
        ];
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'worksubid',
            'history_time',
        ];
        $groupby = NULL;
        $orderby = 'history_time';
        $orderbyascdesc = 'DESC';
        $limit = 10;
        $browseworks = $browsehistory->browsehistoryModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
        $posts['browsehistorytime'] = FALSE;
        $posts['browsehistorytitle'] = FALSE;
        if (count($browseworks) != 0) {
            $i = 0;
            foreach ($browseworks as $browse) {
                $needDB = [
                    'worksubs',
                    'worktypes',
                    'worktransinfos',
                ];
                $where = [['worksubs.workid','=',$browse->worksubid]];
                $select = ['title'];
                $groupby = NULL;
                $orderby = NULL;
                $orderbyascdesc = NULL;
                $limit = NULL;
                $browsehistoriesworks = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                
                $posts['browsehistorytime'][$i] = $browse->history_time;
                foreach ($browsehistoriesworks as $history) {
                    $posts['browsehistorytitle'][$i] = $history->title;
                }
                $i++;
            }
        }

        $posts['worktitle'] = FALSE;
        if ($request->worktitle) $posts['worktitle'] = $request->worktitle;
        return view('post.post',compact('posts'));

    }

    public function postconf(Request $request) {
        $postconf['nickname'] = $request->nickname;
        $postconf['workname'] = $request->workname;
        $postconf['poststar'] = $request->poststar;
        $postconf['postbody'] = $request->postbody;

        $request->validate([
            'workname' => 'required|exists:works,title',
            'poststar' => 'required',
            'postbody' => 'required|max:250',
        ],
        [
            'workname.required' => 'レビュー作品名は必須入力です。',
            'workname.exists' => '入力したレビュー作品名が存在しません。',
            'poststar.required' => '評価は必須入力です。',
            'postbody.required' => 'レビュー内容は必須入力です。',
        ]);

        return view('post.postconfirmation',compact('postconf'));
    }

    public function postcomplete(Request $request, User $user, Work $work, Post $post) {
        $postconf['nickname'] = $request->nickname;
        $postconf['workname'] = $request->workname;
        $postconf['poststar'] = $request->poststar;
        $postconf['postbody'] = $request->postbody;

        $loginid = 'Guest';
        if ($postconf['nickname'] !== 'Guest') $loginid = $user->userModelSearch('nickname',$postconf['nickname'],'loginid'); //ログインしていれば、そのユーザーのユーザーIDを取得。まだテストしてない
        $worksdata = $work->workidModelGet('works','title',$postconf['workname']); //投稿した作品のIDを取得
        foreach ($worksdata as $workd) {
            $workssubdata = $work->workidModelGet('worksubs','workid',$workd->workid); //投稿した作品のsubIDを取得
            foreach ($workssubdata as $worksd) {
                $post->postModelInsert($loginid,$worksd->id,$postconf['poststar'],$postconf['postbody']); //ユーザーIDと作品IDとレビュー内容を登録
            }
        }

        return view('post.postcomplete');
    }

    public function postworktitle() {
        return view('post.postworktitle');
    }
}
