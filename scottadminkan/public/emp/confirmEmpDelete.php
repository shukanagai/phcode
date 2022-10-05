<?php
/**
 * PH35 課題03
 * 従業員テーブル管理作成DAO版
 *
 * @author Shuka NAGAI
 *
 * ファイル名=confirmEmpDelete.php
 * フォルダ=/ph35/scottadmin/public/emp/
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


if(Functions::loginCheck()) {
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath = "login.html";
}
else {
    $deleteEmpId = $_POST["deleteEmpId"];
    try {
        $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $empDAO = new EmpDAO($db);
        $emp = $empDAO->findByPK($deleteEmpId);
        $empList = $empDAO->findAll();
        $assign["empList"] = $empList;
        if(empty($emp)) {
            $assign["errorMsg"] = "従業員情報の取得に失敗しました。";
            $templatePath = "error.html";
        }
        else {
            $assign["emp"] = $emp;
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
}

$html = $twig->render($templatePath, $assign);
print($html);