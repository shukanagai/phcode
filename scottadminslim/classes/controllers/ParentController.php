<?php
/**
 * PH35 Sample14 マスタテーブル管理Slim版 Src15
 *
 * @author Shinzo SAITO
 *
 * ファイル名=ParentController.php
 * フォルダ=/ph35/scottadminslim/classes/controllers/
 */
namespace LocalHalPH35\ScottAdminSlim\Classes\controllers;

use Slim\Views\Twig;
use Slim\Flash\Messages;

/**
 * 各コントローラクラスの親クラス。
 * 共通処理がメソッドとして記述されている。
 */
class ParentController {
    /**
     * テンプレート描画に使用するTwigインスタンス。
     */
    protected Twig $view;
    /**
     * フラッシュメッセージに利用するMessagesインスタンス。
     */
    protected Messages $flash;

    /**
     * コンストラクタ。
     * Twigインスタンスを生成してプロパティに格納する。
     */
    public function __construct() {
        $this->view = Twig::create($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminslim/templates");
        $this->flash = new Messages();
    }

    /**
     * Session情報の掃除関数。
     * ログイン情報以外のセッション中の情報を一度破棄する。
     * 各ユースケース最初の実行メソッド内でこのメソッドを実行する。
     */
    protected function cleanSession(): void {
        $loginFlg = $_SESSION["loginFlg"];
        $id = $_SESSION["id"];
        $name = $_SESSION["name"];
        $auth = $_SESSION["auth"];

        session_unset();

        $_SESSION["loginFlg"] = $loginFlg;
        $_SESSION["id"] = $id;
        $_SESSION["name"] = $name;
        $_SESSION["auth"] = $auth;
    }
}