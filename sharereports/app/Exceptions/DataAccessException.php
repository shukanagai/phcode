<?php
/**
 *
 * @author Shuka Nagai
 *
 * ファイル名=DataAccessException.php
 * フォルダ=/sharereports/app/Exceptions/
 */
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

/**
 * データ処理中に想定外の事態を検知した時に発生させる例外クラス。
 */
class DataAccessException extends Exception {
    /**
     * 例外発生時に行う画面表示処理。
     *
     * @param Request $request リクエストオブジェクト。
     * @return レスポンスオブジェクト。
     */
    public function render(Request $request) {
        $errorMsg = $this->getMessage();
        $assign["errorMsg"] = $errorMsg;
        return view("error", $assign);
    }
}
