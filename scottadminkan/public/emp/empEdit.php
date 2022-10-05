<?php
/**
 * PH35 課題03
 * 従業員テーブル管理作成DAO版
 *
 * @author Shuka NAGAI
 *
 * ファイル名=prepareEmpEdit.php
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
$templatePath = "emp/empEdit.html";
$assign = [];
$validationMsgs = [];
$isRedirect = false;

$editEmId = $_POST['editEmId'];
$editEmNo = $_POST['editEmNo'];
$editEmName = trim(str_replace("　" , " " , $_POST['editEmName']));
$editEmJob = trim(str_replace("　" , " " , $_POST['editEmJob']));
$editEmSal = trim(str_replace("　" , " " , $_POST['editEmSal']));
$editEmMgr = $_POST['editEmMgr'];
$editEmHiredateYear = $_POST['editEmHiredateYear'];
$editEmiredateMonth = $_POST['editEmHiredateMonth'];
$editEmiredateDay = $_POST['editEmHiredateDay'];
$editDpId = $_POST['editDeptId'];

$emp = new Emp();
$emp->setId($editEmId);
$emp->setEmNo($editEmNo);
$emp->setEmName($editEmName);
$emp->setEmJob($editEmJob);
$emp->setEmSal($editEmSal);
$emp->setEmMgr($editEmMgr);
$emp->setEmHiredate($editEmHiredateYear.'-'.$editEmiredateMonth.'-'.$editEmiredateDay);
$emp->setDeptId($editDpId);

$validationMsgs = [];

if(empty($editEmName)) {
    $validationMsgs[] = "従業員名の入力は必須です。";
}

if(empty($editEmJob)) {
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
        if(!empty($empDB)  && $empDB->getId() != $editEmId) {
            $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
        }

        if(empty($validationMsgs)) {
            $result = $empDAO->update($emp);
            if(!$result) {
                $assign["errorMsg"] = "情報の更新に失敗しました。もう一度はじめからやり直してください。";
                $templatePath = "error.html";
            }else {
                $isRedirect = true;
                $_SESSION["flashMsg"] = "従業員ID".$emp->getId()."の従業員情報を更新しました。";
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