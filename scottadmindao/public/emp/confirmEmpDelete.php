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

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");

$deleteEmpId = $_POST["deleteEmpId"];

try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $empDAO = new EmpDAO($db);
    $emp = $empDAO->findByPK($deleteEmpId);
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
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shuka NAGAI" >
        <title>課題02 従業員テーブル管理作成</title>
        <link rel="stylesheet" href="/ph35/scottadmindao/public/css/main.css" type="text/css">
    </head>
    <body>
        <h1>従業員情報削除</h1>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/ph35/scottadmindao/public/">TOP</a></li>
                <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
                <li>従業員情報削除確認</li>
            </ul>
        </nav>
        <section>
            <p>
                以下の部門情報を削除します。<br>
                よろしければ、削除ボタンをクリックしてください。
            </p>
            <dl>
                <dt>ID</dt>
                <dd><?= $emp->getId() ?></dd>
                <dt>従業員番号</dt>
                <dd><?= $emp->getEmNo() ?></dd>
                <dt>従業員名</dt>
                <dd><?= $emp->getEmName() ?></dd>
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
            <form action="/ph35/scottadmindao/public/emp/empDelete.php" method="post">
                <input type="hidden" id="deleteEmpId" name="deleteEmpId" value="<?= $emp->getId() ?>">
                <button type="submit">削除</button>
            </form>
        </section>
    </body>
</html>