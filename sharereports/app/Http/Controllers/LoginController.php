<?php
/**
 * PH35 Sample13 マスタテーブル管理ミドルウェア版 Src10/19
 *
 * @author Shinzo SAITO
 *
 * ファイル名=LoginController.php
 * フォルダ=/scottadminmiddle/app/Http/Controllers/
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DAO\UserDAO;
use App\Http\Controllers\Controller;

/**
 * ログイン・ログアウトに関するコントローラクラス。
 */
class LoginController extends Controller {
    /**
     * ログイン画面表示処理。
     */
    public function goLogin() {
        return view("login");
    }
    
    /**
     * ログイン処理。
     */
    public function login(Request $request) {
        $isRedirect = false;
        $templatePath = "login";
        $assign = [];

        $loginMail = $request->input("loginMail");
        $loginPw = $request->input("loginPw");

        $validationMsgs = [];
        if(empty($loginMail)){
            $validationMsgs['mail'] = "未入力です。";
        }

        if(empty($loginPw)){
            $validationMsgs['pass'] = "未入力です。";
        }

        if(empty($validationMsgs)) {
            $db = DB::connection()->getPdo();
            $userDAO = new UserDAO($db);

            $user = $userDAO->findByLoginMail($loginMail);
            if($user == null) {
                $validationMsgs['mail'] = "存在しないメールアドレスです。正しいアドレスを入力してください。";
            }
            else {
                $userPw = $user->getUsPasswd();
                if(password_verify($loginPw, $userPw)) {
                    $id = $user->getId();
                    $name = $user->getUsName();
                    $auth = $user->getUsAuth();
                    $session = $request->session();
                    $session->put("loginFlg", true);
                    $session->put("id", $id);
                    $session->put("name", $name);
                    $session->put("auth", $auth);
                    $isRedirect = true;
                }
                else {
                    $validationMsgs['pass'] = "パスワードが違います。正しいパスワードを入力してください。";
                }
            }
        }

        if($isRedirect) {
            $response = redirect("/report/showList");
        }
        else {
            if(!empty($validationMsgs)) {
                $assign["validationMsgs"] = $validationMsgs;
                $assign["loginMail"] = $loginMail;
            }
            $response = view("login", $assign);
        }
        return $response;
    }

    /**
     * ログアウト処理。
     */
    public function logout(Request $request) {
        $session = $request->session();
        $session->flush();
        $session->regenerate();
        return redirect("/");
    }
}
