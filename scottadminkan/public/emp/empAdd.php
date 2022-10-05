<?php
/**
 * PH35 課題04
 * PH35 Sample10 マスタテーブル管理完版
 *
 * @author Shuka NAGAI
 *
 * ファイル名=empAdd.php
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
$templatePath = "emp/empAdd.html";
$assign = [];
$validationMsgs = [];
$isRedirect = false;

$addEmNo = $_POST['addEmNo'];
$addEmName = trim(str_replace("　" , " " , $_POST['addEmName']));
$addEmJob = trim(str_replace("　" , " " , $_POST['addEmJob']));
$addEmSal = trim(str_replace("　" , " " , $_POST['addEmSal']));
$addEmMgr = $_POST['addEmMgr'];
$addEmHiredateYear = $_POST['addEmHiredateYear'];
$addEmiredateMonth = $_POST['addEmHiredateMonth'];
$addEmiredateDay = $_POST['addEmHiredateDay'];
$addDpId = $_POST['addDeptId'];

$emp = new Emp();
$emp->setEmNo($addEmNo);
$emp->setEmName($addEmName);
$emp->setEmJob($addEmJob);
$emp->setEmSal($addEmSal);
$emp->setEmMgr($addEmMgr);
$emp->setEmHiredate($addEmHiredateYear.'-'.$addEmiredateMonth.'-'.$addEmiredateDay);
$emp->setDeptId($addDpId);


if(empty($addEmName)) {
    $validationMsgs[] = "従業員名の入力は必須です。";
}

if(empty($addEmJob)) {
    $validationMsgs[] = "役職の入力は必須です。";
}

if(Functions::loginCheck()) {
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath = "login.html";
}else{
    if(isset($_SESSION["flashMsg"])) {
        $assign["flashMsg"] = $_SESSION["flashMsg"];
        unset($_SESSION["flashMsg"]);
    }

    try {
        $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $empDAO = new EmpDAO($db);
        $empList = $empDAO->findAll();
        $assign["empList"] = $empList;
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
        $assign["deptList"] = $deptList;

        $empDB = $empDAO->findByEmNo($emp->getEmNo());
        if(!empty($empDB)) {
            $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
        }

        if(empty($validationMsgs)) {
            $emId = $empDAO->insert($emp);
            if($emId === -1) {
                $assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
                $templatePath = "error.html";
            }else {
                $isRedirect = true;
                $_SESSION["flashMsg"] = "従業員ID".$emId."で従業員情報を登録しました。";
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
}
if($isRedirect) {
    header("Location: /ph35/scottadminkan/public/emp/showEmpList.php");
}
else {
    $html = $twig->render($templatePath, $assign);
    print($html);
}