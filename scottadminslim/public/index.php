<?php
/**
 * PH35 Sample14 マスタテーブル管理Slim版 Src05
 * 実行ファイル。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=index.php
 * フォルダ=/ph35/scottadminslim/public/
 */
use Slim\Factory\AppFactory;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminslim/vendor/autoload.php");

$app = AppFactory::create();

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminslim/bootstrappers.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminslim/routes.php");

$app->run();