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
use App\Models\Post;
use App\Models\Printorderjsid;
use App\Models\Rankingtitlesetting;
use App\Models\Record;
use App\Models\Worktype;
use DateTime;
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
            $birthday = $request->birthday;
            $gender = $request->gender;
            $nickname = $request->nickname;
            $password = $request->password;

            $request->validate([
                'loginid' => 'required|unique:users',
                'email' => 'required|unique:users',
                'birthday' => 'required',
                'nickname' => 'required',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ],
            [
                'loginid.required' => 'ログインIDは必須入力です。',
                'loginid.unique' => '入力されたログインIDはすでに登録されています。',
                'email.required' => 'Eメールアドレスは必須入力です。',
                'birthday.required' => '誕生日は必須入力です。',
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
            $date = new DateTime($birthday);
            $now = new DateTime();
            $interval = $now->diff($date);
            $user->userModelInsert($loginid,$nickname,$password,$email,$birthday,$interval->y,$gender,1);
            
            $needDB = [];
            $where = NULL;
            $select = [
                'id',
            ];
            $groupby = NULL;
            $orderby = NULL;
            $orderbyascdesc = NULL;
            $limit = NULL;
            $workdigitcounts = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
            $digit = '';
            for ($i = 0;$i < count($workdigitcounts);$i++) {
                $digit = $digit.'1';
            }
            $rankingtablesetting->rankingtablesettingModelInsert($loginid,$digit);

            /**
             * 作品IDとユーザーIDをrecordsテーブルに初期化して登録
             */
            //新規ページから遷移できないので確認
            $workid = $work->workModelGet('select',NULL,'workid',NULL,NULL,NULL,NULL);

            $needDB = [
                'worksubs',
                'worktypes',
                'worktransinfos',
            ];
            $where = NULL;
            $select = [
                'workid'
            ];
            $groupby = NULL;
            $orderby = NULL;
            $orderbyascdesc = NULL;
            $limit = NULL;
            $workids = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
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

    public function contentstop(Request $request, Work $work, Worktype $worktype, User $user, Post $post, Attribute $attribute, Printorderjsid $printorderjsid, Rankingtitlesetting $rankingtitlesetting, Rankingtablesetting $rankingtablesetting, Browsehistory $browsehistory, Notification $notification) {
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
            $where = [['loginid','=',$loginid]];
            $select = [
                'onetime_pass_flag',
            ];
            $users = $user->userModelGet($where,$select);
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
            $where = [['loginid','=',session('loginid')]];
            $select = [
                'login_number_of_times',
                'next_display_login_time',
            ];
            $users = $user->userModelGet($where,$select);
            foreach ($users as $ur) {
                $user->userModelUpdate('loginid',session('loginid'),'login_number_of_times',$ur->login_number_of_times + 1);
                $user->userModelUpdate('loginid',session('loginid'),'last_display_login_time',$ur->next_display_login_time);
                $user->userModelUpdate('loginid',session('loginid'),'next_display_login_time',date('Y-m-d H:i:s'));
                $user->userModelUpdate('loginid',session('loginid'),'updated_at',now());
            }
        /**
         * トップページ画面のヘッダーから遷移
         */
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
        $needDB = [
            'rankingtablesettings',
        ];
        $select = [
            'table_title',
            'button_name',
        ];
        if (!session('loginid')) {
            $where = [['loginid','=','Guest']];
            $rankingtitlesettings = $rankingtitlesetting->rankingtitlesettingModelGet($needDB,$where,$select);
        } else {
            $where = [['loginid','=',session('loginid')]];
            $rankingtitlesettings = $rankingtitlesetting->rankingtitlesettingModelGet($needDB,$where,$select);
        }
        foreach ($rankingtitlesettings as $rankingtitle) {
            $contentstop['table_title'] = $rankingtitle->table_title;
            $contentstop['button_name'] = $rankingtitle->button_name;
        }

        /**
         * おすすめのランキング用作品を取得
         * ユーザーにより表示する作品ジャンルとその内容が変化
         */
        $contentstop['recentcheck_img'] = FALSE;
        if (session('loginid')) {
            $genre_list = [];
            $tab_list = [];
            $id_list = [];
            $active_list = [];
            $show_list = [];
            $tf_list = [];

            /**
             * ユーザーがなんのジャンルを設定しているかを取得、(0 未設定ジャンル、1 設定ジャンル)
             * 文字列で連結されているため、str_splitで分割
             */
            $where = [['loginid','=',session('loginid')]];
            $select = [
                'genresumnum',
            ];
            $rankingtablesettings = $rankingtablesetting->rankingtablesettingModelGet($where,$select);
            foreach ($rankingtablesettings as $rankingtable) {
                $genresumnum = $rankingtable->genresumnum;
            }
            $genrenum = str_split($genresumnum);

            $worktype_list = [];
            $icon_list = [];
            for ($i = 0;$i < count($genrenum);$i++) {
                if ($genresumnum[$i] == 1) {
                    array_push($worktype_list,'0'.$i+1);
                }
            }

            for ($i = 0;$i < count($worktype_list);$i++) {
                $needDB = [];
                $where = [['worktypeid','=',$worktype_list[$i]]];
                $select = [
                    'worktype_icon',
                ];
                $groupby = NULL;
                $orderby = NULL;
                $orderbyascdesc = NULL;
                $limit = NULL;
                $worktypes = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                foreach ($worktypes as $workt) {
                    array_push($icon_list,$workt->worktype_icon);
                }
            }

            for ($i = 0;$i < count($worktype_list);$i++) {
                $needDB = [];
                $where = [['worktypeid','=',$worktype_list[$i]]];
                $select = [
                    'worktype_name',
                    'worktype_eng',
                ];
                $groupby = NULL;
                $orderby = NULL;
                $orderbyascdesc = NULL;
                $limit = NULL;
                $worktypes = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                foreach ($worktypes as $workt) {
                    array_push($genre_list,$workt->worktype_eng);
                    array_push($tab_list,$workt->worktype_name);
                    array_push($id_list,'recommend'.$workt->worktype_eng.'table');
                }
            }
            $contentstop['genre_list'] = $genre_list;
            $contentstop['tab_list'] = $tab_list;
            $contentstop['id_list'] = $id_list;
            $contentstop['icon_list'] = $icon_list;

            for ($i = 0;$i < count($worktype_list);$i++) {
                if (!in_array('active',$active_list)) {
                    array_push($active_list,'active');
                    array_push($show_list,'show');
                    array_push($tf_list,'true');
                } else {
                    array_push($active_list,'');
                    array_push($show_list,'');
                    array_push($tf_list,'false');
                }
            }
            $contentstop['worktype_list'] = $worktype_list;
            $contentstop['active_list'] = $active_list;
            $contentstop['show_list'] = $show_list;
            $contentstop['tf_list'] = $tf_list;



            for ($i = 0;$i < count($worktype_list);$i++) {
                $needDB = [
                    'worksubs',
                    'worktypes',
                ];
                $where = [['works.work_type','=',$worktype_list[$i]]];
                $select = [
                    'title',
                    'img',
                    'url',
                ];
                $groupby = NULL;
                $orderby = NULL;
                $orderbyascdesc = NULL;
                $limit = NULL;
                $workdatas = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                $j = 0;
                foreach ($workdatas as $workd) {
                    $contentstop['work_title'][$i][$j] = $work->worktitleConvert($workd->title,5);
                    $contentstop['work_img'][$i][$j] = asset($workd->img);
                    $contentstop['work_url'][$i][$j] = $workd->url;
                    $j++;
                }
            }

            /**
             * 最近チェックした作品
             */
            $needDB = [
                'works',
                'worksubs',
                'worktypes',
            ];
            $where = [['loginid','=',session('loginid')]];
            $select = [
                'history_time',
                'title',
                'img',
                'url',
                'worktype_name',
            ];
            $groupby = NULL;
            $orderby = NULL;
            $orderbyascdesc = NULL;
            $limit = 5;
            $browsehistories = $browsehistory->browsehistoryModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
            if (count($browsehistories) != 0) {
                $i = 0;
                foreach ($browsehistories as $browsehist) {
                    $contentstop['recentcheck_title'][$i] = $work->worktitleConvert($browsehist->title,5);
                    $contentstop['recentcheck_tag'][$i] = $browsehist->worktype_name;
                    $contentstop['recentcheck_url'][$i] = $browsehist->url;
                    $contentstop['recentcheck_img'][$i] = asset($browsehist->img);
                    $contentstop['recentcheck_historydate'][$i] = $browsehist->history_time;
                    $i++;
                }
            }
        } 
    
        /**
         * 全ユーザーランキング表示用、全ユーザーで表示される作品は同じ、ただし1日ごとに表示される作品は変わる
         */
        $needDB = [
            'worksubs',
        ];
        $where = NULL;
        $select = [
            'title',
            'img',
            'url',
            DB::raw('worksubs.browse_record * worksubs.notificate_record  AS record_times'),
        ];
        $groupby = NULL;
        $orderby = NULL;
        $orderbyascdesc = NULL;
        $limit = NULL;
        $workdatas = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
        $i = 0;
        foreach ($workdatas as $workd) {
            $contentstop['workall_title'][$i] = $work->worktitleConvert($workd->title,5);
            $contentstop['workall_img'][$i] = asset($workd->img);
            $contentstop['workall_url'][$i] = $workd->url;
            $i++;
        }

        /**
         * 年代別注目作品($i...年代,$j...性別,$k...該当作品)
         */
        for ($i = 1;$i <= 5;$i++) {
            for ($j = 1;$j <= 2;$j++) {
                $agegenders[$i][$j] = FALSE;
                $contentstop['genderattention_title'][$i][$j] = FALSE;
                $contentstop['genderattention_tag'][$i][$j] = FALSE;
                $contentstop['genderattention_img'][$i][$j] = FALSE;
                $contentstop['genderattention_url'][$i][$j] = FALSE;
            }
        }

        $where = NULL;
        $select = [
            'loginid',
            'age',
            'gender',
        ];
        $users = $user->userModelGet($where,$select);
        foreach ($users as $user) {
            if ($browsehistory->browsehistoryModelExist($user->loginid,NULL)) {
                $age = (int) (($user->age) / 10); 
                if ($age >= 5) $age = 5;
                $agegenders[$age][$user->gender][] = $user->loginid;
            }
        }
        
        for ($i = 1;$i <= count($agegenders);$i++) {
            for ($j = 1;$j <= 2;$j++) {
                if ($j == 1) {
                    if ($i == 5) {
                        $contentstop['genderattention_button'][$i][$j] = $i.'0代以上男性';
                    } else {
                        $contentstop['genderattention_button'][$i][$j] = $i.'0代男性';
                    }
                } else {
                    if ($i == 5) {
                        $contentstop['genderattention_button'][$i][$j] = $i.'0代以上女性';
                    } else {
                        $contentstop['genderattention_button'][$i][$j] = $i.'0代女性';
                    }
                }
                if ($agegenders[$i][$j]) {
                    $needDB = [
                        'works',
                        'worksubs',
                        'worktypes',
                    ];
                    $where = [['loginid','=',$agegenders[$i][$j]]];
                    $select = [
                        'worksubid',
                        'title',
                        'img',
                        'url',
                        'worktype_name',
                        DB::raw('count(worksubid) AS loginidOfsameworksubid_count'),
                    ];
                    $groupby = [
                        'worksubid',
                        'worktype_name',
                    ];
                    $orderby = 'loginidOfsameworksubid_count';
                    $orderbyascdesc = 'DESC';
                    $limit = 5;
                    $browsehistorydatas = $browsehistory->browsehistoryModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                    $k = 0;
                    foreach ($browsehistorydatas as $get) {
                        $contentstop['genderattention_title'][$i][$j][$k] = $work->worktitleConvert($get->title,5);
                        $contentstop['genderattention_tag'][$i][$j][$k] = $get->worktype_name;
                        $contentstop['genderattention_img'][$i][$j][$k] = $get->img;
                        $contentstop['genderattention_url'][$i][$j][$k] = $get->url;
                        $k++;
                    }
                } 
            }
        }

        /**
         * 人気急上昇(本日、今日と昨日の増加率取得、今週、週の初めと終わりの増加率取得、今月、月の初めと終わりの増加率)
         */
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

            $worksubids = [];

            $needDB = [
                'orwhere',
                'works',
                'worksubs',
                'worktypes',
            ];
            $where = 'history_time_date+'.$findate.'+'.$startdate;
            $select = [
                'worksubid',
                'history_time_date',
                DB::raw('count(worksubid) AS sameworksubid_count'),
            ];
            $groupby = [
                'worksubid',
                'history_time_date',
            ];
            $orderby = 'history_time_date';
            $orderbyascdesc = 'ASC';
            $limit = 4;
            $ninkistodayyesterdays = $browsehistory->browsehistoryModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);

            $contentstop['ninkitodayyesterday']['title'][$date] = FALSE;
            $contentstop['ninkitodayyesterday']['tag'][$date] = FALSE;
            $contentstop['ninkitodayyesterday']['img'][$date] = FALSE;
            $contentstop['ninkitodayyesterday']['url'][$date] = FALSE;
            if (count($ninkistodayyesterdays) != 0) {
                foreach ($ninkistodayyesterdays as $ninkity) {
                    $ninki1[$ninkity->worksubid][0] = 0; //昨日の作品閲覧数
                    $ninki1[$ninkity->worksubid][1] = 0; //今日の作品閲覧数
                }

                foreach ($ninkistodayyesterdays as $ninkity) {
                    if ($ninki1[$ninkity->worksubid][0] == 0) {
                        $ninki1[$ninkity->worksubid][0] = $ninkity->sameworksubid_count;
                    } else {
                        $ninki1[$ninkity->worksubid][1] = $ninkity->sameworksubid_count;
                    }
                }

                arsort($ninki1);

                foreach ($ninkistodayyesterdays as $ninkity) {
                    $contentstop['ninkitodayyesterday_wariai'][$date][$ninkity->worksubid] = ($ninki1[$ninkity->worksubid][1] / $ninki1[$ninkity->worksubid][0]) * 100;

                    $needDB = [
                        'worksubs',
                        'worktypes',
                    ];
                    $where = [['worksubs.id','=',$ninkity->worksubid]];
                    $select = [
                        'title',
                        'img',
                        'url',
                        'worktype_name',
                    ];
                    $groupby = NULL;
                    $orderby = NULL;
                    $orderbyascdesc = NULL;
                    $limit = NULL;
                    $ninkidatas = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                    foreach ($ninkidatas as $ninki) {
                        $tmp['title'][$ninkity->worksubid] = $work->worktitleConvert($ninki->title,5);
                        $tmp['tag'][$ninkity->worksubid] = $ninki->worktype_name;
                        $tmp['img'][$ninkity->worksubid] = $ninki->img;
                        $tmp['url'][$ninkity->worksubid] = $ninki->url;
                    }
                }

                $i = 0;
                foreach ($tmp['title'] as $data) {
                    $contentstop['ninkitodayyesterday']['title'][$date][$i] = $data;
                    $i++;
                }
                $j = 0;
                foreach ($tmp['tag'] as $data) {
                    $contentstop['ninkitodayyesterday']['tag'][$date][$j] = $data;
                    $j++;
                }
                $k = 0;
                foreach ($tmp['img'] as $data) {
                    $contentstop['ninkitodayyesterday']['img'][$date][$k] = $data;
                    $k++;
                }
                $l = 0;
                foreach ($tmp['url'] as $data) {
                    $contentstop['ninkitodayyesterday']['url'][$date][$l] = $data;
                    $l++;
                }
            }
        }

        /**
         * 新着作品 ジャンルごとに上映前、発売前の作品を取得
         */
        $contentstop['worknew_genre'] = FALSE;
        $contentstop['worknew_title'] = FALSE;
        $contentstop['worknew_img'] = FALSE;
        $contentstop['worknew_url'] = FALSE;
        $contentstop['worknew_date'] = FALSE;

        $needDB = [
            'worksubs',
            'worktransinfos',
        ];
        $where = [['worktransinfoid','=',1]];
        $select = [
            'work_type',
            'title',
            'img',
            'url',
            'siteviewday_1',
        ];
        $groupby = NULL;
        $orderby = 'siteviewday_1';
        $orderbyascdesc = 'ASC';
        $limit = NULL;
        $workdatas = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
        if (count($workdatas) != 0) {
            $needDB = [];
            $where = NULL;
            $select = [
                'worktypeid',
            ];
            $groupby = NULL;
            $orderby = NULL;
            $orderbyascdesc = NULL;
            $limit = NULL;
            $worktypes = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);

            for ($i = 1;$i <= count($worktypes);$i++) {
                $needDB = [];
                $where = [['worktypeid','=','0'.$i]];
                $select = [
                    'worktype_name',
                ];
                $groupby = NULL;
                $orderby = NULL;
                $orderbyascdesc = NULL;
                $limit = NULL;
                $worktypescount = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                foreach ($worktypescount as $workt) {
                    $contentstop['worknew_genre'][$i] = $workt->worktype_name.'新着作品';
                }
            }
            foreach ($workdatas as $workd) {
                $num = str_split($workd->work_type);
                $contentstop['worknew_title'][$num[1]][] = $work->worktitleConvert($workd->title,5);
                $contentstop['worknew_img'][$num[1]][] = asset($workd->img);
                $contentstop['worknew_url'][$num[1]][] = $workd->url;
                $contentstop['worknew_date'][$num[1]][] = $workd->siteviewday_1.'発売';
            }
        }

        /**
         * 新着作品 本日のNEW作品を取得
         */
        $needDB = [
            'worksubs',
        ];
        $where = [['siteviewday_1','=',date('Y-m-d')]];
        $select = [
            'work_type',
            'title',
            'img',
            'url',
        ];
        $groupby = NULL;
        $orderby = NULL;
        $orderbyascdesc = NULL;
        $limit = NULL;
        $workdatas = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
        if (count($workdatas) != 0) {
            $k = 0;
            foreach ($workdatas as $workd) {
                $needDB = [];
                $where = NULL;
                $select = [
                    'worktypeid',
                ];
                $groupby = NULL;
                $orderby = NULL;
                $orderbyascdesc = NULL;
                $limit = NULL;
                $worktypes = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
                $contentstop['worknew_genre'][count($worktypes)+1] = '本日の新着作品';
                $contentstop['worknew_title'][count($worktypes)+1][$k] = $work->worktitleConvert($workd->title,5);
                $contentstop['worknew_img'][count($worktypes)+1][$k] = asset($workd->img);
                $contentstop['worknew_url'][count($worktypes)+1][$k] = $workd->url;
                $contentstop['worknew_date'][count($worktypes)+1][$k] = '';
                $k++;
            }
        }

        /**
         * 今日のレビューレポート(トップページには星評価7以上を1件表示)
         */
        $contentstop['recommendpostreport_img'] = FALSE;

        $where = [['created_at','=',date('Y-m-d')]];
        $select = [
            'created_at'
        ];
        $posts = $post->postModelGet($where,$select);
        if (count($posts) != 0) {
            $needDB = [
                'worksubs',
                'posts',
            ];
            $where = [
                ['created_at','=',date('Y-m-d')],
                ['poststar','>=',7],
            ];
            $select = [
                'title',
                'furigana',
                'img',
                'url',
                'poststar',
                'postbody',
            ];
            $groupby = NULL;
            $orderby = 'poststar';
            $orderbyascdesc = 'DESC';
            $limit = 1;
            $workreviewreports = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
            foreach ($workreviewreports as $workreview) {
                $contentstop['recommendpostreport_title'] = $workreview->title;
                $contentstop['recommendpostreport_furigana'] = $workreview->furigana;
                $contentstop['recommendpostreport_url'] = $workreview->url;
                $contentstop['recommendpostreport_img'] = asset($workreview->img);
                $contentstop['recommendpostreport_poststar'] = $workreview->poststar;
                $contentstop['recommendpostreport_postbody'] = $workreview->postbody;
            }
        }

        return view('contentstop',compact('contentstop'));
    }
}