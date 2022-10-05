<?php
/**
    *PH35 課題01
    *エンティティの確認
    *@author Shuka NAGAI
    *ファイル名=execSQL1.php
    *フォルダ=/ph35/asgmt01/q2/
*/

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/asgmt01/Conf.php");
require_once("Department.php");


$departmentList = [];
try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT * FROM departments WHERE department_name LIKE :department_name;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":department_name", "%Sales%", PDO::PARAM_STR);
    $result = $stmt->execute();

    while($row = $stmt->fetch()) {
        $departmentId = $row["department_id"];
        $departmentName = $row["department_name"];
        $managerId = $row["manager_id"];
        $locationId = $row["location_id"];

        $department = new Department();
        $department->setDepartmentId($departmentId);
        $department->setDepartmentName($departmentName);
        $department->setManagerId($managerId);
        $department->setLocationId($locationId);

        $departmentList[$departmentId] = $department;
    }
}
catch(PDOException $ex) {
    print("DB接続に失敗しました。");
}
finally {
    $db = null;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shuka NAGAI">
        <title>課題01 | エンティティの確認</title>
        <style type="text/css">
            table {
                border-collapse: collapse;
            }
            th, td {
                border: solid 1px black;
            }
        </style>
    </head>
    <body>
        <h1>課題01 | エンティティの確認</h1>
        <h2>セレクト文:SELECT * FROM departments WHERE department_name LIKE '%Sales%';</h2>
<?php
if(empty($departmentList)) {
?>
        <P>
            該当データはありません。
        </P>
<?php
}
else {
?>
        <table>
            <thead>
                <tr>
                    <th>department_id</th>
                    <th>department_name</th>
                    <th>manager_id</th>
                    <th>location_id</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach($departmentList as $departmentId=>$department) {
?>
                <tr>
                    <td><?= $departmentId ?></td>
                    <td><?= $department->getDepartmentName() ?></td>
                    <td><?= $department->getManagerId() ?></td>
                    <td><?= $department->getLocationId() ?></td>
                </tr>
<?php
}
?>
            </tbody>
        </table>
<?php
}
?>
        <p>
            <a href="/ph35/asgmt01/index.php">戻る</a>
        </p>
    </body>
</html>
