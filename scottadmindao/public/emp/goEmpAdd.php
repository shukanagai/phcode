<?php
/**
 * PH35 課題03
 * 従業員テーブル管理作成DAO版
 *
 * @author Shuka NAGAI
 *
 * ファイル名=empAdd.php
 * フォルダ=/ph35/scottadmin/public/emp/
 */

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Dept.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/DeptDAO.php");

$db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
$deptDAO = new DeptDAO($db);
$deptList = $deptDAO->findAll();

$empDAO = new EmpDAO($db);
$empList = $empDAO->findAll();

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
        <title>課題03 従業員テーブル管理作成DAO版</title>
        <link rel="stylesheet" href="/ph35/scottadmindao/public/css/main.css" type="text/css">
    </head>
    <body>

        <h1>従業員情報追加</h1>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/ph35/scottadmindao/public/">TOP</a></li>
                <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
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
            <form action="/ph35/scottadmindao/public/emp/empAdd.php" method="post" class="box">
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
                <label for="addEmSal">
                    給与&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="0"  name="addEmSal" id="addEmSal" value="<?= $emp->getEmSal() ?>" required>
                </label><br>
                <label for="addEmMgr">
                    上司番号&nbsp;<span class="required">必須</span><br>
                    <select name="addEmMgr" id="addEmMgr" required>
                        <option value="">選択してください</option>
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
                        <option id="addMgr" value="<?=$empInfo->getEmNo(); ?>" selected>氏名：<?=$empInfo->getEmName(); ?>　社員番号:<?=$empInfo->getEmNo(); ?></option>
<?php
    }else{
?>
                        <option id="addMgr" value="<?=$empInfo->getEmNo(); ?>">氏名：<?=$empInfo->getEmName(); ?>　社員番号:<?=$empInfo->getEmNo(); ?></option>
<?php
    }
}
?>
                    </select>
                </label><br>
                <label for="addEmHiredate">
                    雇用日&nbsp;<span class="required">必須</span><br>
                    <select name="addEmHiredateYear" id="addEmHiredateYear" required>
                        <option value="">--</option>
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
                    <select name="addEmHiredateMonth" id="addEmHiredateMonth" required>
                        <option value="">--</option>
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
                    <select name="addEmHiredateDay" id="addEmHiredateDay" required>
                        <option value="">--</option>
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

                <label for="addDeptId">
                    部門ID&nbsp;<span class="required">必須</span><br>
                    <select name="addDeptId" id="addDeptId" required>
                        <option value="">選択してください</option>
<?php
foreach($deptList as $dept) {
    if($emp->getDeptId() == $dept->getId()){
?>
                        <option id="addDeptId" value="<?=$dept->getId(); ?>" selected><?=$dept->getDpNo(); ?>:<?=$dept->getDpName(); ?></option>
<?php
    }else{
?>
                        <option id="addDeptId" value="<?=$dept->getId(); ?>"><?=$dept->getDpNo(); ?>:<?=$dept->getDpName(); ?></option>
<?php
    }
}
?>
                    </select>
                </label><br>
                <button type="submit">登録</button>
            </form>
        </section>
    </body>
</html>