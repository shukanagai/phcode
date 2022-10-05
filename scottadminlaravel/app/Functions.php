<?php
/**
 * PH35 Sample12 マスタテーブル管理Laravel版 Src03/17
 *
 * @author Shinzo SAITO
 *
 * ファイル名=Functions.php
 * フォルダ=/scottadminlaravel/app/
 */
namespace App;

use Illuminate\Http\Request;

/**
 * 共通処理が書かれたクラス。
 */
class Functions {
    /**
     * ログイン済かどうかをチェックする関数。
     * セッションからログイン情報が見つからない場合はログアウト状態と判定する。
     *
     * @param Request $request リクエストオブジェクト。
     * @return boolean ログアウト状態の場合はtrue、ログイン状態の場合はfalse。
     */
    public static function loginCheck(Request $request): bool {
        $result = false;
        $session = $request->session();
        if(!$session->has("loginFlg") || $session->get("loginFlg") == false || !$session->has("id") || !$session->has("name") || !$session->has("auth")) {
            $result =  true;
        }
        return $result;
    }
}