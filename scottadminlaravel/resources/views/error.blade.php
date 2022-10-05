{{--
/**
 * PH35 Sample12 マスタテーブル管理Laravel版 Src12/17
 * エラー画面
 *
 * @author Shinzo SAITO
 *
 * ファイル名=error.blade.php
 * フォルダ=/scottadminlaravel/resources/views/
 */
--}}
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>Error | ScottAdminLaravel Sample</title>
    </head>
    <body>
        <h1>Error</h1>
        <section>
            <h2>申し訳ございません。障害が発生しました。</h2>
            <p>
                以下のメッセージご確認ください。<br>
                {{$errorMsg}}
            </p>
        </section>
        <p><a href="/goTop">TOPへ戻る</a></p>
    </body>
</html>