<?php
/**
 * PH35 課題02
 * 従業員テーブル管理作成
 *
 * @author Shuka NAGAI
 *
 * ファイル名=prepareEmpEdit.php
 * フォルダ=/ph35/scottadmin/public/emp/
 */

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/entity/Emp.php");

$emp = new Emp();
$validationMsgs = null;

if(isset($_POST["editEmpId"])) {
    $editEmpId = $_POST["editEmpId"];
    try {
        $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql = "SELECT * FROM emps WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(":id", $editEmpId, PDO::PARAM_INT);
        $result = $stmt->execute();
        if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $emNo = $row["em_no"];
            $emName = $row["em_name"];
            $emJob = $row["em_job"];
            $emMgr = $row["em_mgr"];
            $emHiredate = $row["em_hiredate"];
            $emSal = $row["em_sal"];
            $deptId = $row["dept_id"];
    
            $emp = new Emp();
            $emp->setId($id);
            $emp->setEmNo($emNo);
            $emp->setEmName($emName);
            $emp->setEmJob($emJob);
            $emp->setEmMgr($emMgr);
            $emp->setEmHiredate($emHiredate);
            $emp->setEmSal($emSal);
            $emp->setDeptId($deptId);
            
        }
        else {
            $_SESSION["errorMsg"] = "従業員情報の取得に失敗しました。";
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
}
else {
    if(isset($_SESSION["emp"])) {
        $emp = $_SESSION["emp"];
        $emp = unserialize($emp);
        unset($_SESSION["emp"]);
    }
    if(isset($_SESSION["validationMsgs"])) {
        $validationMsgs = $_SESSION["validationMsgs"];
        unset($_SESSION["validationMsgs"]);
    }
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
        <h1>従業員情報編集</h1>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/ph35/scottadmin/public/">TOP</a></li>
                <li><a href="/ph35/scottadmin/public/emp/showEmpList.php">従業員リスト</a></li>
                <li>従業員情報編集</li>
            </ul>
        </nav>
<?php
if(!is_null($validationMsgs)) {
?>
        <section id="errorMsg">
            <p>以下のメッセージをご確認ください。</p>
            <ul>
<?php
foreach($validationMsgs as $msg) {
?>
                <li><?= $msg ?></li>
<?php
}
?>
            </ul>
        </section>
<?php
}
?>
        <section>
            <p>
                情報を入力し、更新ボタンをクリックしてください。
            </p>
            <form action="/ph35/scottadmin/public/emp/empEdit.php" method="post" class="box">
                部門ID:&nbsp;<?= $emp->getId() ?>
                <input type="hidden" name="editEmId" value="<?= $emp->getId() ?>"><br>
                <label for="editEmNo">
                    従業員番号&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="1000" max="9999" step="1" name="editEmNo" value="<?= $emp->getEmNo() ?>">
                </label><br>
                <label for="editEmName">
                    従業員名&nbsp;<span class="required">必須</span><br>
                    <input type="text" id="editEmName" name="editEmName" value="<?= $emp->getEmName() ?>" required>
                </label><br>
                <label for="editEmJob">
                    役職&nbsp;<span class="required">必須</span><br>
                    <input type="text" id="editEmJob" name="editEmJob" value="<?= $emp->getEmJob() ?>" required>
                </label><br>
                <label for="editEmMgr">
                    上司番号&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="0" id="editEmMgr" name="editEmMgr" value="<?= $emp->getEmMgr() ?>" required>
                </label><br>
                <label for="editEmHiredate">
                    雇用日&nbsp;<span class="required">必須</span><br>
                    <input type="text" id="editEmHiredate" name="editEmHiredate" value="<?= $emp->getEmHiredate() ?>" required>
                </label><br>
                <label for="editEmSal">
                    給与&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="0" id="editEmSal" name="editEmSal" value="<?= $emp->getEmSal() ?>" required>
                </label><br>
                <label for="editDpId">
                    部門ID&nbsp;<span class="required">必須</span><br>
                    <input type="number"  id="editDpId" name="editDpId" value="<?= $emp->getDeptId() ?>" required>
                </label><br>

                <button type="submit">更新</button>
            </form>
        </section>
    </body>
</html>