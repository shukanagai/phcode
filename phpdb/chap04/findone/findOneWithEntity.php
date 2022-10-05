<?php
/**
    *PH35 サンプル2 PHP DB Access Src12/14
    *Chap4-1 エンティティクラスを使って一行のデータ取得
    *@author Shinzo SAITO
    *ファイル名=findOneWithEntity.php
    *フォルダ=/ph35/phpdb/findone/
*/

require_once("Order.php");

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";

$orderIdInput = 2380;
// $orderIdInput = 10000;

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT * FROM orders WHERE order_id=:order_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":order_id", $orderIdInput, PDO::PARAM_INT);
    $result = $stmt->execute();

    if($row = $stmt->fetch()) {
        $orderId = $row["order_id"];
        $orderDate = $row["order_date"];
        $orderMode = $row["order_mode"];
        $customerId = $row["customer_id"];
        $orderStatus = $row["order_status"];
        $orderTotal = $row["order_total"];

        $order = new Order();
        $order->setOrderId($orderId);
        $order->setOrderDate($orderDate);
        $order->setOrderMode($orderMode);
        $order->setCustomerId($customerId);
        $order->setOrderStatus($orderStatus);
        $order->setOrderTotal($orderTotal);
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
        <meta name="author" content="Shinzo SAITO">
        <title>PH35 サンプル2 | PHP DB Access | Ch4-1
エンティティを使って一行のデータ取得</title>
    </head>
    <body>
        <h1>PHP DB Access: Chap4-1 エンティティを使って一行のデータ取得</h1>
<?php
if(isset($order)) {
    $orderDateStr = date("Y年n月j日 H時i分s秒", strtotime($order->getOrderDate()));
    $orderTotalStr = number_format($order->getOrderTotal(), 2);
?>
        <ul>
            <li>注文ID: <?= $order->getOrderId() ?></li>
            <li>注文日時: <?= $orderDateStr ?></li>
            <li>注文種類: <?= $order->getOrderMode() ?></li>
            <li>顧客ID: <?= $order->getCustomerId() ?></li>
            <li>注文状況: <?= $order->getOrderStatus() ?></li>
            <li>注文合計: $<?= $orderTotalStr ?></li>
        </ul>
<?php
}
else {
?>
        <p>該当データは存在しません。別の注文IDを指定してください。</p>
<?php
}
?>
        <p>
            <a href="/ph35/phpdb/index.html">戻る</a>
        </p>
    </body>
</html>