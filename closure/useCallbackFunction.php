<?php
/**
 * PH35 サンプル4 無名関数 Src06/09
 * コールバック関数。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=useCallbackFunction.php
 * フォルダ=/ph35/closure/
 */
function hello(string $name): string {
    return $name."さん、こんにちは！";
}

function goodMorning(string $name): string {
    return $name."さん、おはよう！";
}

function hello(callable $funcName): void {
    $result = $funcName("しんちゃん");
    print($result."<br>");
}

useGreetings("hello");
useGeetings("goodMorning");