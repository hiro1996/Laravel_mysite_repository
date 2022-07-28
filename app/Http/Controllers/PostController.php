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

        if (session('loginid')) { //ログインしている時
            $users = $user->userModelGet(session('loginid'));
            foreach ($users as $ur) {
                $posts['nickname'] = $ur->nickname;
            };
        } else { //ログインしていない時
            $posts['nickname'] = 'Guest';
        }
        $worktitle = $work->workModelGet('select',NULL,'title',NULL,NULL,NULL,NULL);
        $i = 0;
        foreach ($worktitle as $title) {
            $posts['wotkalltitle'][$i] = $title->title;
            $i++;
        }


        $favoritetmps = $favorite->favoriteAllModelGet();

        $posts['favoritetitle'] = FALSE;
        if (count($favoritetmps) > 0) {
            $i = 0;
            foreach ($favoritetmps as $favotmp) {
                $favoritetmp2 = $favorite->favoriteModelGet($favotmp->workid);

                foreach ($favoritetmp2 as $favo) {
                    $posts['favoritetitle'][$i] = $favo->title;
                }
                $i++;
            }
        } 

        $browseworks = $browsehistory->browsehistoryModelGet('normal','loginid',session('loginid'),NULL,NULL,10);
        $posts['browsehistorytime'] = FALSE;
        $posts['browsehistorytitle'] = FALSE;
        if (count($browseworks) > 0) {
            $i = 0;
            foreach ($browseworks as $browse) {
                $browsehistoriesworks = $work->workModelGet('where','worksubs','workid',$browse->workid,NULL,NULL,NULL);
                $posts['browsehistorytime'][$i] = $browse->history_time;

                foreach ($browsehistoriesworks as $history) {
                    $posts['browsehistorytitle'][$i] = $history->title;
                }
                $i++;
            }
        }

        $posts['worktitle'] = NULL;
        if ($request->worktitle) $postdisplaydata['worktitle'] = $request->worktitle;
        return view('post.post',compact('posts'));

    }

    public function postconf(Request $request) {
        $nickname = $request->nickname;
        $workname = $request->workname;
        $poststar = $request->poststar;
        $postbody = $request->postbody;

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

        return view('post.postconfirmation',compact('nickname','workname','poststar','postbody'));
    }

    public function postcomplete(Request $request, User $user, Work $work, Post $post) {
        $name = $request->name;
        $workname = $request->workname;
        $poststar = $request->poststar;
        $postbody = $request->postbody;

        $loginid = 'Guest';
        if ($name !== 'Guest') $loginid = $user->userModelSearch('nickname',$name,'loginid'); //ログインしていれば、そのユーザーのユーザーIDを取得。まだテストしてない
        $workid = $work->workModelSearch('works',$workname,'workid'); //投稿した作品のIDを取得

        $post->postModelInsert($loginid,$workid,$poststar,$postbody); //ユーザーIDと作品IDとレビュー内容を登録
        return view('post.postcomplete');
    }

    public function postworktitle() {
        return view('post.postworktitle');
    }
}
