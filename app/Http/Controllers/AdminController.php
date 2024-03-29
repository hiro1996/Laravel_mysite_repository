<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\AdminAuthPageSendMail;
use App\Models\Attribute;
use App\Models\Printorderjsid;
use App\Models\Rankingtitlesetting;
use App\Models\Work;
use Exception;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FA\Support\QRCode;

class AdminController extends Controller
{
    use QRCode;

    public function adminregister(Request $request, User $user) {
        // URLの有効期限が切れた場合と不正なURLの場合
        if (!$request->hasValidSignature()) {
            return redirect()->route('invalidlink');
        }
        $userdata['loginid'] = $user->userModelSearch('user_value_id',2,'loginid');
        $userdata['nickname'] = $user->userModelSearch('user_value_id',2,'nickname');
        $userdata['email'] = $user->userModelSearch('user_value_id',2,'email');
        return view('admin.adminregister',compact('userdata'));
    }

    public function adminpage() {
        return view('admin.adminpage');
    }

    public function adminlink() {
        return view('admin.adminlink');
    }

    //管理者権限付与ページにモーダルで送信完了文言を表示
    public function adminlinkcomplete(Request $request) {
        $email = $request->email;

        $request->validate([
            'email' => 'required',
        ],
        [
            'email.required' => 'Eメールアドレスは必須入力です。',
            //'email.unique' => '入力されたEメールアドレスはすでに登録されています。',
        ]);

        /**
         * 管理者パスワード設定用画面のURL生成
         */
        $urls = [
            'valid' => URL::temporarySignedRoute(
                'admin_authpage.valid',
                now()->addMinutes(1),
            )
        ];
        //dd($urls);

        $mail = new AdminAuthPageSendMail($request,$urls);
        Mail::to($email)->send($mail);

        $setmsg = "管理者用アカウントメールを送信しました。確認ボタンを押下すると、モーダルを閉じます。";
        return response()->json(
            [
                "msg" => $setmsg
            ],
        );
    }

    public function adminaccount(User $user) {
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'loginid',
            'nickname',
            'email'
        ];
        $users = $user->userModelGet($where,$select);
        foreach ($users as $ur) {
            $nickname = $ur->nickname;
            $loginid = $ur->loginid;
            $email = $ur->email;
        }
        return view('admin.adminaccount',compact('nickname','loginid','email'));
    }

    /**
     * usersテーブルの管理者用アカウントのニックネームとEメールアドレスを更新
     * 更新された後、「設定変更しました。」のメッセージを表示し、更新内容を表示
     */
    public function adminaccountsetting(Request $request, User $user) {
        $adminaccountdata = $request->only('loginid','nickname','email');
        $user->userModelUpdate('loginid',$adminaccountdata["loginid"],'nickname',$adminaccountdata["nickname"]);
        $user->userModelUpdate('loginid',$adminaccountdata["loginid"],'email',$adminaccountdata["email"]);
        $where = [['loginid','=',$adminaccountdata["loginid"]]];
        $select = [
            'loginid',
        ];
        $users = $user->userModelGet($where,$select);
        $setmsg = "設定変更しました。";
        return response()->json(
            [
                "msg" => $setmsg,
                "users" => $users
            ],
        );
    }

    public function usersearch() {
        return view('admin.usersearch');
    }

    public function usersearchajax(Request $request, User $user) {
        $userword = $request->only('logintimes','times');
        $users = $user->userModelWhere($userword['logintimes'],$userword['times']);
        return response()->json(
            [
                "data" => $users
            ],
        );
    }

    public function clickmakingcsv(Request $request) {
        $csvdata = $request->only('nickname','logintimes','previouslogin');

        for ($i = 0;$i < count($csvdata['nickname']);$i++) {
            $array[$i] = [
                'id' => $i,
                'ニックネーム' => $csvdata['nickname'][$i],
                'ログイン回数' => $csvdata['logintimes'][$i],
                '前回のログイン' => $csvdata['previouslogin'][$i]
            ];
        }

        $csvFileName = time() . rand() . '.csv';
        $fp = fopen($csvFileName, 'w');
        if ($fp === FALSE) {
            throw new Exception('ファイルを開けませんでした。');
        }

        $header = ['No','ニックネーム','ログイン回数','直前ログイン'];
        fputcsv($fp,$header);

        for ($j = 0;$j < count($array);$j++) {
            // 文字コード変換。エクセルで開けるようにする
            mb_convert_variables('SJIS', 'UTF-8', $array[$j]);
            fputcsv($fp,$array[$j]);
        }

        fclose($fp);

        // ファイルタイプ（csv）
        header('Content-Type: application/octet-stream');
        // ファイル名
        header('Content-Disposition: attachment; filename='.$csvFileName); 
        // ファイルのサイズ　ダウンロードの進捗状況が表示
        header('Content-Length: ' . filesize($csvFileName)); 
        header('Content-Transfer-Encoding: binary');
        // ファイルを出力する
        readfile($csvFileName);

    }

    public function adminonetimepass(Request $request, User $user) {
        /**
         * 管理者用のログインID取得
         * URLからaccountidクエリ(2)取得
         */
        $accountid = request('accountid');
        $loginid = $user->userModelSearch('user_value_id',2,'loginid');
        $data = $request->all();
        /**
         * シークレットキー作成
         */
        $g2fa = new Google2FA();
        $data["google2fa_secret"] = $g2fa->generateSecretKey();

        /**
         * userテーブルの管理者レコード(secret_keyカラム)にシークレットキー登録
         */
        $user->userModelUpdate('loginid',$loginid,'secret_key',$data["google2fa_secret"]);

        session(['loginid' => $loginid]);

        $where = [['loginid','=',session('loginid')]];
        $select = [
            'email'
        ];
        $users = $user->userModelGet($where,$select);
        foreach ($users as $ur) {
            $email = $ur->email;
        }

        $qr_code = new AdminController();
        $QR_img = $qr_code->getQRCodeUrl(config('app.name'),$email,$data["google2fa_secret"]);
        $QR_img = 'https://chart.apis.google.com/chart?cht=qr&chs=300x300&chld=LI0&chl='.$QR_img;

        //dd($QR_img);

        return view('admin.adminonetimepass',compact('QR_img','accountid','data'));
    }

    public function admincontentstop(Request $request, Work $work, User $user, Attribute $attribute, Printorderjsid $printorderjsid, Rankingtitlesetting $rankingtitlesetting) {
        $accountid = $request->accountid;
        $onepass = $request->onetimepass;

        $request->validate([
            'onetimepass' => 'required',
        ],
        [
            'onetimepass.required' => 'ワンタイムパスワードは必須入力です。',
        ]);

        $g2fa = new Google2FA();
        $key = $user->userModelSearch('user_value_id',$accountid,'secret_key');
        $valid = $g2fa->verifyKey($key,$onepass);


        $user->userModelUpdate('user_value_id',$accountid,'onetime_pass_flag',1);
        $loginid = $user->userModelSearch('user_value_id',$accountid,'loginid');
        session(['loginid' => $loginid]);

        $where = [['loginid','=',session('loginid')]];
        $select = [
            'login_number_of_times',
            'next_display_login_time'
        ];
        $users = $user->userModelGet($where,$select);
        foreach ($users as $ur) {
            $user->userModelUpdate('loginid',session('loginid'),'login_number_of_times',$ur->login_number_of_times + 1);
            $user->userModelUpdate('loginid',session('loginid'),'last_display_login_time',$ur->next_display_login_time);
            $user->userModelUpdate('loginid',session('loginid'),'next_display_login_time',date('Y-m-d H:i:s'));
            $user->userModelUpdate('loginid',session('loginid'),'updated_at',now());
        }

        /**
         * おすすめの映画、アニメのタイトル、画像、URL
         */
        $needDB = [
            'worksubs',
        ];
        $where = NULL;
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

        $i = 1;
        foreach ($workdatas as $workd) {
            $contentstop['work_title'][$i] = $workd->title;
            $contentstop['work_img'][$i] = $workd->img;
            $contentstop['work_url'][$i] = $workd->url;
            $i++;
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
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'table_title',
            'button_name',
        ];
        $rankingtitlesettings = $rankingtitlesetting->rankingtitlesettingModelGet($needDB,$where,$select);

        foreach ($rankingtitlesettings as $rankingtitlesetting) {
            $contentstop['table_title'] = $rankingtitlesetting->table_title;
            $contentstop['button_name'] = $rankingtitlesetting->button_name;
        }

        return view('admin.adminpage',compact('contentstop'));

    }

    
}
