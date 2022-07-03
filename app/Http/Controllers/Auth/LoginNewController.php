<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Rankingtablesetting;
use App\Models\Work;
use App\Models\Attribute;
use App\Models\Browsehistory;
use App\Models\Notification;
use App\Models\Printorderjsid;
use App\Models\Rankingtitlesetting;
use App\Models\Record;
use App\Models\Worktype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class LoginNewController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/top';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request, User $user, Work $work, Worktype $worktype, Record $record, Rankingtablesetting $rankingtablesetting) {
        /**
         * 新規作成画面から遷移
         * loginid ログインID
         * email Eメールアドレス
         * nickname ニックネーム
         * password パスワード
         */
        if ($request->register) { 
            $loginid = $request->loginid;
            $email = $request->email;
            $nickname = $request->nickname;
            $password = $request->password;

            $request->validate([
                'loginid' => 'required|unique:users',
                'email' => 'required|unique:users',
                'nickname' => 'required',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ],
            [
                'loginid.required' => 'ログインIDは必須入力です。',
                'loginid.unique' => '入力されたログインIDはすでに登録されています。',
                'email.required' => 'Eメールアドレスは必須入力です。',
                'email.unique' => '入力されたEメールアドレスはすでに登録されています。',
                'nickname.required' => 'ニックネームは必須入力です。',
                'password.confirmed' => 'パスワードとパスワード確認が一致しません。',
                'password.required' => 'パスワードは必須入力です。',
                'password_confirmation.required' => 'パスワード確認は必須入力です。',
            ]);

            /**
             * usersテーブル、rankingtitlesettingtableテーブルに登録
             * 一般ユーザーで登録
             */
            $user->userModelInsert($loginid,$nickname,$password,$email,1);
            $workdigitcounts = $worktype->worktypecountModelGet();
            $digit = '';
            for ($i = 0;$i < $workdigitcounts;$i++) {
                $digit = $digit.'1';
            }
            $rankingtablesetting->rankingtablesettingModelInsert($loginid,$digit);

            /**
             * 作品IDとユーザーIDをrecordsテーブルに初期化して登録
             */
            $workids = $work->workModelGet('select',NULL,'workid',NULL);
            foreach ($workids as $id) {
                $record->recordModelInsert($loginid,$id->workid,0);
            }



        /**
         * 管理者用パスワード設定画面から遷移
         */
        } elseif ($request->adminregister) {
            $password = $request->password;

            $request->validate([
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ],
            [
                'password.confirmed' => 'パスワードとパスワード確認が一致しません。',
                'password.required' => 'パスワードは必須入力です。',
                'password_confirmation.required' => 'パスワード確認は必須入力です。',
            ]);

            $user->userModelUpdate('user_value_id',2,'password',Hash::make($password));
        /**
         * トップページのログインリンクから遷移
         * すでにログインしている場合トップページにリダイレクト。URL直打ちでログイン画面行く場合も考慮済み
         */
        } else {  
            if (session('loginid')) return redirect('/top');
        }

        return view('auth.login');

    }

    public function logout(Request $request, User $user) {
        $user->userModelUpdate('loginid',session('loginid'),'secret_key',NULL);
        $user->userModelUpdate('loginid',session('loginid'),'onetime_pass_flag',0);
        $request->session()->flush();
        return redirect('/top');
    }

    public function contentstop(Request $request, Work $work, Worktype $worktype, User $user, Attribute $attribute, Printorderjsid $printorderjsid, Rankingtitlesetting $rankingtitlesetting, Rankingtablesetting $rankingtablesetting, Browsehistory $browsehistory, Notification $notification) {
        /**
         * パスワード設定画面から遷移
         * new_password 新しいパスワード
         */
        if ($request->passreset) { 
            $newpassword = $request->new_password;

            $request->validate([
                'new_password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ],
            [
                'new_password.required' => '新しいパスワードは必須入力です。',
                'new_password.confirmed' => '新しいパスワードと新しいパスワード確認が一致しません。',
                'password_confirmation.required' => '新しいパスワード確認は必須入力です。',
            ]);
        /**
         * ログイン画面から遷移
         */
        } elseif ($request->login) {
            $loginid = $request->loginid;
            $password = $request->password;

            $request->validate([
                'loginid' => 'required|exists:users,loginid',
                'password' => 'required',
            ],
            [
                'loginid.required' => 'ログインIDは必須入力です。',
                'loginid.exists' => '入力されたログインIDとパスワードのアカウントが見つかりません。', //直す
                'password.required' => 'パスワードは必須入力です。',
            ]);

            /**
             * 管理者でログインした場合、ログインした際の各カラムは更新せず、
             * 先に二要素認証画面へ遷移(ログインIDをリクエストパラメータとして渡す)、その後各カラムを更新。
             */
            $accountid = $user->userModelSearch('loginid',$loginid,'user_value_id');
            $users = $user->userModelGet($loginid);
            foreach ($users as $ur) {
                $onepass = $ur->onetime_pass_flag;
            }

            if ($accountid == 2 && $onepass == 0) { 
                return redirect()->route('adminonetimepass',['accountid' => $accountid]);
            }

            session(['loginid' => $loginid]);

            /**
             * ログインした際の各カラムの更新
             * login_number_of_times ログイン回数 1増やす
             * last_display_login_time 最終ログイン日時 現在ログイン日時に更新
             * next_display_login_time 現在ログイン日時 現在の日時をセット
             * updated_at 更新日
             */
            $users = $user->userModelGet(session('loginid'));
            foreach ($users as $ur) {
                $user->userModelUpdate('loginid',session('loginid'),'login_number_of_times',$ur->login_number_of_times + 1);
                $user->userModelUpdate('loginid',session('loginid'),'last_display_login_time',$ur->next_display_login_time);
                $user->userModelUpdate('loginid',session('loginid'),'next_display_login_time',date('Y-m-d H:i:s'));
                $user->userModelUpdate('loginid',session('loginid'),'updated_at',now());
            }
        /**
         * トップページ画面のヘッダーから遷移
         */
        } else {
            
        }

        /**
         * モーダル内の質問
         */
        $contentstop['attributes'] = $attribute->attributeModelGet('attrpage');
        /**
         * ランキングタイトル、ランキング切り替えの表示
         * ログインしているユーザーが設定しているデフォルト表示を取得
         * 未ログインユーザーは「全ユーザーのおすすめランキング」をデフォルト表示にする
         */
        if (!session('loginid')) {
            $rankingtitlesettings = $rankingtitlesetting->rankingtitlesettingFlagModelGet('Guest');
        } else {
            $rankingtitlesettings = $rankingtitlesetting->rankingtitlesettingFlagModelGet(session('loginid'));
        }
        foreach ($rankingtitlesettings as $rankingtitle) {
            $contentstop['table_title'] = $rankingtitle->table_title;
            $contentstop['button_name'] = $rankingtitle->button_name;
        }

        /**
         * おすすめのランキング
         * ユーザーが表示したい作品ジャンルのみ表示するよう取得
         */
        $genre_list = [];
        $tab_list = [];
        $id_list = [];
        $active_list = [];
        $worktypes = $worktype->worktypeModelGet();
        foreach ($worktypes as $worktype) {
            array_push($genre_list,$worktype->worktype_eng);
            array_push($tab_list,$worktype->worktype_name);
            array_push($id_list,'recommend'.$worktype->worktype_eng.'table');
        }
        $contentstop['genre_list'] = $genre_list;
        $contentstop['tab_list'] = $tab_list;
        $contentstop['id_list'] = $id_list;

        $rankingtablesettings = $rankingtablesetting->rankingtablesettingModelGet();
        //$worktypecount = $worktype->worktypecountModelGet();
        foreach ($rankingtablesettings as $rankingtable) {
            $genresumnum = $rankingtable->genresumnum;
        }
        $genrenum = str_split($genresumnum);

        $worktype_list = [];
        for ($i = 0;$i < count($genrenum);$i++) {
            if ($genresumnum[$i] == 1) {
                array_push($worktype_list,'0'.$i+1);
            }
        }

        for ($i = 0;$i < count($worktype_list);$i++) {
            if (!in_array('active',$active_list)) {
                array_push($active_list,'active');
            } else {
                array_push($active_list,'');
            }
        }
        $contentstop['worktype_list'] = $worktype_list;
        $contentstop['active_list'] = $active_list;


        for ($i = 0;$i < count($worktype_list);$i++) {
            $workdatas = $work->workModelGet('where','works','work_type',$worktype_list[$i]);
            $j = 0;
            foreach ($workdatas as $workd) {
                $contentstop['work_title'][$i][$j] = $workd->title;
                $contentstop['work_img'][$i][$j] = asset($workd->img);
                $contentstop['work_url'][$i][$j] = $workd->url;
                $j++;
            }
        }

        /**
         * 最近チェックした作品
         */
        $contentstop['recentcheck_img'] = FALSE;
        $browsehistories = $browsehistory->browsehistoryModelGet(5);
        $i = 0;
        foreach ($browsehistories as $browsehist) {
            $contentstop['recentcheck_title'][$i] = $browsehist->title;
            $contentstop['recentcheck_img'][$i] = asset($browsehist->img);
            $contentstop['recentcheck_historydate'][$i] = $browsehist->history_time;
            $i++;
        }
        

        return view('contentstop',compact('contentstop'));
    }
}