<?php
/**
    *PH35 課題01
    *PH-DBの復習
    *@author Shuka NAGAI
    *ファイル名=execSQL1.php
    *フォルダ=/ph35/asgmt01/q1/
*/
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/asgmt01/Conf.php");
?>

<!DOCTYPE html>
 <html lang="ja">
    <head>
       <meta charset="UTF-8">
       <meta name="author" content="Shuka NAGAI">
       <title>課題01 | PHP-DBの復習</title>
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
        <h1>課題01 | PHP-DBの復習</h1>
        <h2>セレクト文:SELECT employee_id , first_name , last_name , salary FROM employees WHERE salary >= :10000;</h2>
        <table>
            <thead>
                <tr>
                    <th>employee_id</th>
                    <th>first_name</th>
                    <th>last_name</th>
                    <th>salary</th>
                </tr>
            </thead>
            <tbody>
<?php
try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                
                
    $sql = "SELECT employee_id , first_name , last_name , salary FROM employees WHERE salary >= :salary";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":salary", 10000, PDO::PARAM_INT);
    $result = $stmt->execute();

    while($row = $stmt->fetch()) {
        $employeeId = $row["employee_id"];
        $firstName = $row["first_name"];
        $lastName = $row["last_name"];
        $salary = $row["salary"];
?>
                <tr>
                    <td><?= $employeeId ?></td>
                    <td><?= $firstName ?></td>
                    <td><?= $lastName ?></td>
                    <td><?= $salary ?></td>
                </tr>
<?php
    }
}
catch(PDOException $ex) {
    print("DB接続に失敗しました。");
}
finally {
    $db = null;
}
?>
            </tbody>
        </table>
       <p>
           <a href="/ph35/asgmt01/index.php">戻る</a>
       </p>
    </body>
 </html>