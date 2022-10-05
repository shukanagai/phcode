<?php
/**
 * PH35 課題02
 * 従業員テーブル管理作成
 *
 * @author Shuka NAGAI
 *
 * ファイル名=empAdd.php
 * フォルダ=/ph35/scottadmin/public/emp/
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/entity/Emp.php");

$empList = [
    "addEmNo" => "",
    "addEmName" => "",
    "addEmNo" =>  "",
    "addEmJob" =>  "",
    "addEmMgr" =>  "",
    "addEmHiredate" => "",
    "addEmSal" =>  "",
    "addDeptId" =>  ""
];

foreach($empList as $key => $empValue){
    $empList[$key] = $_POST[$key];
    $empList[$key] = str_replace("　" , " " , $empList[$key]);
    $empList[$key] = trim($empList[$key]);
}

$emp = new Emp();
$emp->setEmNo($empList['addEmNo']);
$emp->setEmName($empList['addEmName']);
$emp->setEmJob($empList['addEmJob']);
$emp->setEmMgr($empList['addEmMgr']);
$emp->setEmHiredate($empList['addEmHiredate']);
$emp->setEmSal($empList['addEmSal']);
$emp->setDeptId($empList['addDeptId']);


$validationMsgs = [];

if(empty($empList['addEmName'])) {
    $validationMsgs[] = "従業員名の入力は必須です。";
}

if(empty($empList['addEmJob'])) {
    $validationMsgs[] = "役職の入力は必須です。";
}

if(empty($empList['addEmHiredate'])) {
    $validationMsgs[] = "雇用日の入力は必須です。";
}



try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sqlSelect = "SELECT COUNT(*) count FROM emps WHERE em_no = :em_no";
    $sqlInsert = "INSERT INTO emps (em_no, em_name, em_job, em_mgr, em_hiredate, em_sal, dept_id) VALUES (:em_no, :em_name, :em_job, :em_mgr, :em_hiredate, :em_sal, :dept_id)";

    $stmt = $db->prepare($sqlSelect);
    $stmt->bindValue(":em_no", $emp->getEmNo(), PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = 1;
    if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $count = $row["count"];
    }
    if($count > 0) {
        $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
    }

    if(empty($validationMsgs)) {
        $stmt = $db->prepare($sqlInsert);
        $stmt->bindValue(":em_no", $emp->getEmNo(), PDO::PARAM_INT);
        $stmt->bindValue(":em_name", $emp->getEmName(), PDO::PARAM_STR);
        $stmt->bindValue(":em_job", $emp->getEmJob(), PDO::PARAM_STR);
        $stmt->bindValue(":em_mgr", $emp->getEmMgr(), PDO::PARAM_INT);
        $stmt->bindValue(":em_hiredate", $emp->getEmHiredate(), PDO::PARAM_STR);
        $stmt->bindValue(":em_sal", $emp->getEmSal(), PDO::PARAM_INT);
        $stmt->bindValue(":dept_id", $emp->getDeptId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        if($result) {
            $EmpId = $db->lastInsertId();
        }
        else {
            $_SESSION["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
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
    header("Location: /ph35/scottadmin/public/error.php");
    exit;
}
elseif(!empty($validationMsgs)) {
    header("Location: /ph35/scottadmin/public/emp/goEmpAdd.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shuka NAGAI">
        <title>課題02 従業員テーブル管理作成</title>
        <link rel="stylesheet" href="/ph35/scottadmin/public/css/main.css" type="text/css">
    </head>
    <body>
        <h1>部門情報追加完了</h1>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/ph35/scottadmin/">TOP</a></li>
                <li><a href="/ph35/scottadmin/public/emp/showEmpList.php">従業員リスト</a></li>
                <li>従業員情報追加</li>
                <li>従業員情報追加完了</li>
            </ul>
        </nav>
        <section>
            <p>
                以下の従業員情報を登録しました。
            </p>
            <dl>
                <dt>ID(自動生成)</dt>
                <dd><?= $EmpId ?></dd>
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
                従業員リストに<a href="/ph35/scottadmin/public/emp/showEmpList.php">戻る</a>
            </p>
        </section>
    </body>
</html>