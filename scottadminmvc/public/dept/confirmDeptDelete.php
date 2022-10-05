<?php
/**
 * PH35 Sample9 マスタテーブル管理MVC版 Src13/18
 * 部門情報削除確認画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=confirmDeptDelete.php
 * フォルダ=/ph35/scottadminmvc/public/dept/
 */
namespace LocalHalPH35\ScottAdminMVC\exec\dept;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/vendor/autoload.php");

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminMVC\Classes\Conf;
use LocalHalPH35\ScottAdminMVC\Classes\dao\DeptDAO;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/templates");
$twig = new Environment($loader);

$templatePath = "dept/deptConfirmDelete.html";
$assign = [];

$deleteDeptId = $_POST["deleteDeptId"];

try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $deptDAO = new DeptDAO($db);
    $dept = $deptDAO->findByPK($deleteDeptId);
    if(empty($dept)) {
        $assign["errorMsg"] = "部門情報の取得に失敗しました。";
        $templatePath = "error.html";
    }
    else {
        $assign["dept"] = $dept;
    }
}
catch(PDOException $ex) {
    var_dump($ex);
    $assign["errorMsg"] = "DB接続に失敗しました。";
    $templatePath = "error.html";
}
finally {
    $db = null;
}

$html = $twig->render($templatePath, $assign);
print($html);