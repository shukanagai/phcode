{{--
/**
 * PH35 Sample13 マスタテーブル管理ミドルウェア版 Src15/19
 * TOP画面
 *
 * @author Shinzo SAITO
 *
 * ファイル名=top.blade.php
 * フォルダ=/scottadminmiddle/resources/views/
 */
--}}
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>TOP | ScottAdminMiddle Sample</title>
    </head>
    <body>
        <header>
            <h1>TOP</h1>
            <p><a href="/logout">ログアウト</a></p>
        </header>
        <nav>
            <ul>
                <li><a href="/dept/showDeptList">部門リスト</a></li>
                <li><a href="/emp/showEmpList">従業員リスト</a></li>
            </ul>
        </nav>
    </body>
</html>