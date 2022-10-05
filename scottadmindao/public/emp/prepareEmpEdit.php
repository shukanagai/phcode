<?php
/**
 * PH35 課題03
 * 従業員テーブル管理作成課題03 従業員テーブル管理作成DAO版
 *
 * @author Shuka NAGAI
 *
 * ファイル名=prepareEmpEdit.php
 * フォルダ=/ph35/scottadmindao/public/emp/
 */

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Dept.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/DeptDAO.php");
$emp = new Emp();
$validationMsgs = null;

if(isset($_POST["editEmpId"])) {
    $editEmId = $_POST["editEmpId"];
    try {
        $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $empDAO = new EmpDAO($db);
        $emp = $empDAO->findByPK($editEmId);
        $empList = $empDAO->findAll();
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
        if(empty($emp)) {
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
        header("Location: /ph35/scottadmindao/public/error.php");
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
        $dbReturn = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $empDAO = new EmpDAO($dbReturn);
        $empList = $empDAO->findAll();
        $deptDAO = new DeptDAO($dbReturn);
        $deptList = $deptDAO->findAll();
    }
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
        <h1>従業員情報編集</h1>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/ph35/scottadmindao/public/">TOP</a></li>
                <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
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
            <form action="/ph35/scottadmindao/public/emp/empEdit.php" method="post" class="box">
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
                    <select name="editEmMgr" id="editEmMgr" required>
                        
<?php
if($emp->getEmMgr() === 0){
?>
                        <option value="0" selected>上司なし</option>
<?php 
}else{
?>
                        <option value="0">上司なし</option>
<?php
}
foreach($empList as $empInfo) {
    if($emp->getEmMgr() == $empInfo->getEmNo()){
?>
                        <option id="editMgr" value="<?=$empInfo->getEmNo(); ?>" selected>氏名：<?=$empInfo->getEmName(); ?>　社員番号:<?=$empInfo->getEmNo(); ?></option>
<?php
    }else{
?>
                        <option id="editMgr" value="<?=$empInfo->getEmNo(); ?>">氏名：<?=$empInfo->getEmName(); ?>　社員番号:<?=$empInfo->getEmNo(); ?></option>
<?php
    }
}
?>
                    </select>
                </label><br>
                <label for="editEmSal">
                    給与&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="0" id="editEmSal" name="editEmSal" value="<?= $emp->getEmSal() ?>" required>
                </label><br>
                <label for="editEmHiredate">
                    雇用日&nbsp;<span class="required">必須</span><br>
                    <select name="editEmHiredateYear" id="editEmHiredateYear" required>
                        
<?php
for($i=date('Y'); $i>1979; $i--){
    if(explode('-' , $emp->getEmHiredate())[0] == $i){
?>
                        <option value="<?= $i; ?>" selected><?= $i; ?></option>
<?php
    }else{
?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
<?php
    }
}
?>
                    </select> 
                    年
                    <select name="editEmHiredateMonth" id="editEmHiredateMonth" required>
                        
<?php
for($i=1; $i<13; $i++){
    if(explode('-' , $emp->getEmHiredate())[1] == $i){
?>
                        <option value="<?= $i; ?>" selected><?= $i; ?></option>
<?php
    }else{
?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
<?php
    }
}
?>
                    </select>  
                    月
                    <select name="editEmHiredateDay" id="editEmHiredateDay" required>
                        
<?php
for($i=1; $i<32; $i++){
    if(explode('-' , $emp->getEmHiredate())[2] == $i){
?>
                        <option value="<?= $i; ?>" selected><?= $i; ?></option>
<?php
    }else{
?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
<?php
    }
}
?>
                    </select> 
                    日            
                </label><br>
                <label for="editDpId">
                    部門ID&nbsp;<span class="required">必須</span><br>
                    <select name="editDeptId" id="editDeptId" required>
                        
<?php
foreach($deptList as $dept) {
    if($emp->getDeptId() == $dept->getId()){
?>
                        <option id="editDeptId" value="<?=$dept->getId(); ?>" selected><?=$dept->getDpNo(); ?>:<?=$dept->getDpName(); ?></option>
<?php
    }else{
?>
                        <option id="editDeptId" value="<?=$dept->getId(); ?>"><?=$dept->getDpNo(); ?>:<?=$dept->getDpName(); ?></option>
<?php
    }
}
?>
                    </select>
                </label><br>

                <button type="submit">更新</button>
            </form>
        </section>
    </body>
</html>