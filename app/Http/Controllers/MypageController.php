<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attributeanswer;
use App\Models\Attributetextanswer;
use App\Models\Point;
use App\Models\Rankingtitlesetting;
use App\Models\Rankingtablesetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MypageController extends Controller
{
    public function mypage() {
        return view('mypage.mypage');
    }

    /**
     * ニックネーム変更画面、デフォルトで現在のニックネームを表示し、現在のニックネームは変更不可
     */
    public function nicknamechange(User $user) {
        $nownickname = $user->userModelSearch('loginid',session('loginid'),'nickname');
        return view('mypage.nicknamechange',compact('nownickname'));
    }

    /**
     * ニックネーム変更完了、usersテーブルへ入力したニックネームを更新
     */
    public function nicknamechangecomplete(Request $request, User $user) {
        $newnickname = $request->newnickname;

        $request->validate([
            'newnickname' => 'required',
        ],
        [
            'newnickname.required' => '新しいニックネームは必須入力です。',
        ]);

        $user->userModelUpdate('loginid',session('loginid'),'nickname',$newnickname);
        return view('mypage.nicknamechangecomplete');
    }

    /**
     * パスワード変更画面
     */
    public function passwordchange() {
        return view('mypage.passwordchange');
    }

    /**
     * パスワード変更完了、usersテーブルへ入力したパスワードをハッシュ化して更新
     */
    public function passwordchangecomplete(Request $request, User $user) {
        $nowpassword = $request->nowpassword;
        $nowpassword = Hash::make($nowpassword);
        $newpassword = $request->newpassword;

        $request->validate([
            'nowpassword' => 'required|exists',
            'newpassword' => 'required|confirmed',
            'password_confirmation' => 'required',
        ],
        [
            'nowpassword.required' => '現在のパスワードは必須入力です。',
            'nowpassword.exists' => '現在のパスワードが一致しません。',
            'newpassword.required' => '新しいパスワードは必須入力です。',
            'newpassword.confirmed' => '新しいパスワードと新しいパスワード確認が一致しません。',
            'password_confirmation.required' => '新しいパスワード確認は必須入力です。',
        ]);

        $user->userModelUpdate('loginid',session('loginid'),'password',Hash::make($newpassword));
        return view('mypage.passwordchangecomplete');
    }

    /**
     * 個人属性情報の内容とコンテンツトップのモーダル内で回答した答えを表示
     * attributedata['attributes'] 個人属性情報の質問
     * attributedata['attrid'] コンテンツトップでユーザーが回答した質問id
     */
    public function attribute(Attribute $attribute, Attributeanswer $attributeanswer, Attributetextanswer $attributetextanswer) {
        $attributedata['attributes'] = $attribute->attributeModelGet('attrpage');
        $needDB = [
            'attributes'
        ];
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'attr_id',
        ];
        $attributeanswers = $attributeanswer->attributeanswerModelGet($needDB,$where,$select);
        $i = 0;
        foreach ($attributeanswers as $attrans) {
            $attributedata['attrid'][$i] = $attrans->attr_id;
            $i++;
        }
        /**
         * attributetextanswerテーブルに登録しているテキスト値をどのインデックス番号に入れて表示させるかを決定する箇所
         * $column_num どの質問番号がテキスト型か(type_idがどのインデックス番号を示すか)を絞り、一時的にリストに入れたもの
         */
        $column_num = [];
        foreach ($attributedata['attributes']['type_id'] as $key => $value) {
            if ($value == 'text') {
                array_push($column_num,$key);
            }
        }


        /**
         * attributeテーブルでは、type_idが2番目にテキストになるよう設定しているので、attributetextanswerテーブルに登録しているテキスト値
         * のインデックス番号を同じ2に対応させてあげれば良い。
         */
        $needDB = [
            'attributes'
        ];
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'text',
        ];
        $attributetextanswers = $attributetextanswer->attributetextanswerModelGet($needDB,$where,$select);
        $i = 0;
        foreach ($attributetextanswers as $attrtext) {
            $attributedata['attrtext'][$column_num[$i]] = $attrtext->text;
            $i++;
        }
        return view('mypage.attribute',compact('attributedata'));
    }

    public function attributecomplete(Request $request, Attribute $attribute, Attributeanswer $attributeanswer, Attributetextanswer $attributetextanswer) {
        /**
         * attributeテーブルからname_idを取得し、個人属性変更画面からリクエストを受ける値を決定
         * name_idに[]が含まれる(例えばcheckboxタイプ)場合は、[]を削除し、配列に格納
         * その後、onlyメソッドでリクエストされた値を取得
         */
        $attributes = $attribute->attributeModelGet('get');
        $onlydata = [];
        $i = 0;
        foreach ($attributes as $at) {
            $name_id[$i] = $at->name_id;
            if (strpos($name_id[$i],'[]') !== false) {
                $name_id[$i] = str_replace('[]','',$name_id[$i]);
            }
            array_push($onlydata,$name_id[$i]);
            $attributedatas = $request->only($onlydata);
            $i++;
        }

        /**
         * 個人属性変更画面で、radioタイプで答えた値とtextタイプで答えた値のリクエストデータの配列への変換。
         * 配列のキーがそのままname_idと一致しているため、対応するtype_idが3かつ配列になっていない場合、
         * リクエストを受けた値とキーを配列に、
         * 対応するtype_idが3ではないかつ配列になっていない場合別配列にリクエストを受けた値を格納。
         */
        $value = [];
        $i = 1;
        foreach ($attributedatas as $key => $is_array) {
            $type_id = $attribute->attributeModelExist('name_id',$key,'type_id');
            if (!is_array($is_array)) {
                if ($type_id == 3) {
                    $attributedatas[$key] = [$key];
                    $value[$key] = [$is_array];
                } else {
                    $attributedatas[$key] = [$is_array];
                }
            } 
        }

        /**
         * ログインしているユーザーのattributeanswersテーブル、attributetextanswersテーブルにある情報を削除
         * onlyメソッドでリクエストされた値から、チェックされた各個人属性の回答を1つの配列にし、
         * attributesテーブルからattr_idを取得、attributeanswerテーブルに登録
         * type_idが3の時、対応したキーのvalue変数内の値をattributetextanswerテーブルに格納
         */
        $attributeanswer->attributeanswerModelDelete();
        $attributetextanswer->attributetextanswerModelDelete();
        
        foreach ($attributedatas as $key => $attr) {
            for ($i = 0;$i < count($attr);$i++) {
                $type_id = $attribute->attributeModelExist('attr_id',$attr[$i],'type_id');
                $ans_id = $attribute->attributeModelExist('attr_id',$attr[$i],'answer_id');

                if ($type_id == 3) {
                    $attributetextanswer->attributetextanswerModelInsert($ans_id,$value[$key][$i]);
                } 
                $attributeanswer->attributeanswerModelInsert($ans_id);
            }
        }
        return redirect('/mypage');
    }

    public function statistics() {
        return view('mypage.statistics');
    }

    public function setting(Attribute $attribute, Rankingtitlesetting $rankingtitlesetting, Rankingtablesetting $rankingtablesetting) {
        $attributessetting = $attribute->attributeSettingModelGet();
        $needDB = [
            'rankingtablesettings',
        ];
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'table_title',
        ];
        $rankingdefaultsetting = $rankingtitlesetting->rankingtitlesettingModelGet($needDB,$where,$select);
        $needDB = [
            'rankingtablesettings',
        ];
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'table_title',
            'button_name',
        ];
        $rankingtitlesetting = $rankingtitlesetting->rankingtitlesettingModelGet($needDB,$where,$select);
        $where = [['loginid','=',session('loginid')]];
        $select = [
            'genresumnum',
        ];
        $rankingtablesetting = $rankingtablesetting->rankingtablesettingModelGet($where,$select);

        $i = 0;
        foreach ($attributessetting as $setting) {
            $attributeq[$i] = $setting->q_attribute;
            $attributeattrid[$i] = $setting->attr_id;
            $i++; 
        }

        $i = 0;
        foreach ($rankingdefaultsetting as $defaultsetting) {
            $defaulttablesetting = $defaultsetting->table_title;
            $i++;
        }

        $i = 0;
        foreach ($rankingtitlesetting as $defaultsetting) {
            $tablesetting[$i] = $defaultsetting->table_title;
            $firstdisplayflag[$i] = $defaultsetting->first_display_flag;
            $i++;
        }

        $rankingtablist = []; 
        foreach ($rankingtablesetting as $table) {
            $tmp = str_split($table->genresumnum);
        }
        for ($i = 0;$i < count($tmp);$i++) {
            array_push($rankingtablist,$tmp[$i]);
        }

        return view('mypage.setting',compact('attributeq','attributeattrid','defaulttablesetting','tablesetting','firstdisplayflag','rankingtablist'));
    }

    public function mypagesetting(Request $request, Rankingtablesetting $rankingtablesetting) {
        $mypagesetting = $request->only('tab','tabid','table');

        $rankingtablesetting->rankingtablesettingModelUpdate('rankingtablesettingdefaultflag',NULL,$mypagesetting["table"]);
        for ($i = 0;$i < count($mypagesetting["tab"]);$i++) {
            $rankingtablesetting->rankingtablesettingModelUpdate('work',$mypagesetting["tabid"][$i],$mypagesetting["tab"][$i]);
        }

        $setmsg = "設定変更しました。";
        return response()->json(
            [
                "msg" => $setmsg,
            ],
        );
    }

    public function information(User $user, Point $point) {
        $points = $point->pointModelGet();

        $where = [['loginid','=',session('loginid')]];
        $select = [
            'loginid',
            'nickname',
            'email',
            'age',
            'login_number_of_times',
            'last_display_login_time',
        ];
        $users = $user->userModelGet($where,$select);
        $users = $users[0];
        return view('mypage.information',compact('users','points'));
    }
}
