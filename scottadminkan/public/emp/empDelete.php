<?php
/**
 * PH35 課題03
 * 課題03 従業員テーブル管理作成DAO版
 *
 * @author Shuka NAGAI
 *
 * ファイル名=empDelete.php
 * フォルダ=/ph35/scottadmindao/public/emp/
 */

namespace LocalHalPH35\ScottAdminKan\exec\emp;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminKan\Classes\Conf;
use LocalHalPH35\ScottAdminKan\Classes\Functions;
use LocalHalPH35\ScottAdminKan\Classes\dao\EmpDAO;
use LocalHalPH35\ScottAdminKan\Classes\entity\Emp;
use LocalHalPH35\ScottAdminKan\Classes\dao\DeptDAO;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);
$templatePath = "emp/empDelete.html";
$assign = [];
$validationMsgs = [];
$isRedirect = false;

if(Functions::loginCheck()) {
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath = "login.html";
}
else {
    $deleteEmpId = $_POST["deleteEmpId"];
    if(isset($_SESSION["flashMsg"])) {
        $assign["flashMsg"] = $_SESSION["flashMsg"];
        unset($_SESSION["flashMsg"]);
    }

    try {
        $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $empDAO = new EmpDAO($db);
        $empList = $empDAO->findAll();
        $assign["empList"] = $empList;

        if(empty($validationMsgs)) {
            $result = $empDAO->delete($deleteEmpId);
            if(!$result) {
                $assign["errorMsg"] = "情報の削除に失敗しました。もう一度はじめからやり直してください。";
                $templatePath = "error.html";
            }else {
                $isRedirect = true;
                $_SESSION["flashMsg"] = "従業員ID".$deleteEmpId."の従業員情報を削削除しました。";
            }
        }else {
            $assign["emp"] = $emp;
            $assign["validationMsgs"] = $validationMsgs;
        }


    }
    catch(PDOException $ex) {
        var_dump($ex);
        $assign["errorMsg"] = "DB接続に失敗しました。";
        $templatePath = "error.html";
    }
    finally {
        $db = null;
    }
}if($isRedirect) {
    
    header("Location: /ph35/scottadminkan/public/emp/showEmpList.php");
}else{
    $html = $twig->render($templatePath, $assign);
    print($html);
}

