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

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");

$editEmId = $_POST["editEmId"];
$editEmNo = $_POST["editEmNo"];
$editEmName = $_POST["editEmName"];
$editEmJob = $_POST["editEmJob"];
$editEmMgr = $_POST["editEmMgr"];
$editEmHiredate = $_POST["editEmHiredateYear"].'-'.$_POST["editEmHiredateMonth"].'-'.$_POST["editEmHiredateDay"];
$editEmSal = $_POST["editEmSal"];
$editDpId = $_POST["editDeptId"];


$editEmName = str_replace("　" , " " , $editEmName);
$editEmJob = str_replace("　" , " " , $editEmJob);
$editEmHiredate = str_replace("　" , " " , $editEmHiredate);
$editEmName = trim($editEmName);
$editEmJob = trim($editEmJob);
$editEmHiredate = trim($editEmHiredate);

$emp = new Emp();
$emp->setId($editEmId);
$emp->setEmNo($editEmNo);
$emp->setEmName($editEmName);
$emp->setEmJob($editEmJob);
$emp->setEmMgr($editEmMgr);
$emp->setEmHiredate($editEmHiredate);
$emp->setEmSal($editEmSal);
$emp->setDeptId($editDpId);

$validationMsgs = [];

if(empty($editEmName)) {
    $validationMsgs[] = "従業員名の入力は必須です。";
}

if(empty($editEmJob)) {
    $validationMsgs[] = "役職の入力は必須です。";
}


try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $empDAO = new EmpDAO($db);
    $empDB = $empDAO->findByEmNo($emp->getEmNo());
    

    if(!empty($empDB) && $empDB->getId() != $editEmId) {
        $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
    }

    if(empty($validationMsgs)) {
        $result = $empDAO->update($emp);
        if(!$result) {
            $_SESSION["errorMsg"] = "情報更新に失敗しました。もう一度はじめからやり直してください。";
        }
    }
    else {
        $_SESSION["emp"] = serialize($emp);
        $_SESSION["validationMsgs"] = $validationMsgs;
    }
}
catch(PDOException $ex) {
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
}
finally {
    $db = null;
}

if(isset($_SESSION["errorMsg"])) {
    header("Location: /ph35/scottadmindao/public/error.php");
    exit;
}
elseif(!empty($validationMsgs)) {
    header("Location: /ph35/scottadmindao/public/emp/prepareEmpEdit.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shuka NAGAI">
        <title>課題03 従業員テーブル管理作成DAO版</title>
        <link rel="stylesheet" href="/ph35/scottadmindao/public/css/main.css" type="text/css">
    </head>
    <body>
        <h1>部門情報追加完了</h1>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/ph35/scottadmindao/">TOP</a></li>
                <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
                <li>従業員情報編集</li>
                <li>従業員情報編集完了</li>
            </ul>
        </nav>
        <section>
            <p>
                以下の従業員情報を更新しました。
            </p>
            <dl>
                <dt>ID(自動生成)</dt>
                <dd><?= $emp->getId() ?></dd>
                <dt>従業員名</dt>
                <dd><?= $emp->getEmName() ?></dd>
                <dt>従業員番号</dt>
                <dd><?= $emp->getEmNo() ?></dd>
                <dt>役職</dt>
                <dd><?= $emp->getEmJob() ?></dd>
                <dt>上司番号</dt>
                <dd><?= $emp->getEmMgr() ?></dd>
                <dt>雇用日</dt>
                <dd><?= $emp->getEmHiredate() ?></dd>
                <dt>給与</dt>
                <dd><?= $emp->getEmSal() ?></dd>
                <dt>部門ID</dt>
                <dd><?= $emp->getDeptId() ?></dd>
            </dl>
            <p>
                従業員リストに<a href="/ph35/scottadmindao/public/emp/showEmpList.php">戻る</a>
            </p>
        </section>
    </body>
</html>