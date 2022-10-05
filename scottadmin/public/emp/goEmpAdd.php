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

$emp = new Emp();
if(isset($_SESSION["emp"])) {
    $emp = $_SESSION["emp"];
    $emp = unserialize($emp);
    unset($_SESSION["emp"]);
}
$validationMsgs = null;
if(isset($_SESSION["validationMsgs"])) {
    $validationMsgs = $_SESSION["validationMsgs"];
    unset($_SESSION["validationMsgs"]);
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>課題02 従業員テーブル管理作成</title>
        <link rel="stylesheet" href="/ph35/scottadmin/public/css/main.css" type="text/css">
    </head>
    <body>
        <h1>従業員情報追加</h1>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/ph35/scottadmin/public/">TOP</a></li>
                <li><a href="/ph35/scottadmin/public/emp/showEmpList.php">従業員リスト</a></li>
                <li>従業員情報追加</li>
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
                <li><?= $msg?></li>
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
                情報を入力し、登録ボタンをクリックしてください。
            </p>
            <form action="/ph35/scottadmin/public/emp/empAdd.php" method="post" class="box">
                <label for="addEmNo">
                    従業員番号&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="1000" max="9999" step="1" name="addEmNo" id="addEmNo" value="<?= $emp->getEmNo() ?>" required>
                </label><br>
                <label for="addEmName">
                    従業員名&nbsp;<span class="required">必須</span><br>
                    <input type="text" name="addEmName" id="addEmName" value="<?= $emp->getEmName() ?>" required>
                </label><br>
                <label for="addEmJob">
                    役職&nbsp;<span class="required">必須</span><br>
                    <input type="input" id="addEmJob"  name="addEmJob" value="<?= $emp->getEmJob() ?>" required>
                </label><br>
                <label for="addEmMgr">
                    上司番号&nbsp;<span class="required">必須</span><br>
                    <input type="number"  name="addEmMgr" id="addEmMgr" value="<?= $emp->getEmMgr() ?>" required>
                </label><br>
                <label for="addEmHiredate">
                    雇用日&nbsp;<span class="required">必須</span><br>
                    <input type="text"  name="addEmHiredate" id="addEmHiredate" value="<?= $emp->getEmHiredate() ?>" required>
                </label><br>
                <label for="addEmSal">
                    給与&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="0"  name="addEmSal" id="addEmSal" value="<?= $emp->getEmSal() ?>" required>
                </label><br>
                <label for="addDeptId">
                    部門ID&nbsp;<span class="required">必須</span><br>
                    <input type="number"  name="addDeptId" id="addDeptId" value="<?= $emp->getDeptId() ?>" required>
                </label><br>
                <button type="submit">登録</button>
            </form>
        </section>
    </body>
</html>