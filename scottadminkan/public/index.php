<?php
/**
 * PH35 Sample10 マスタテーブル管理完版 Src09/20
 * ログイン画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=index.php
 * フォルダ=/ph35/scottadminkan/public/
 */
namespace LocalHalPH35\ScottAdminKan\exec;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$html = $twig->render("login.html");
print($html);