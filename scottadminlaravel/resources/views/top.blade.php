{{--
/**
 * PH35 Sample12 マスタテーブル管理Larvel版 Src13/17
 * TOP画面
 *
 * @author Shinzo SAITO
 *
 * ファイル名=top.blade.php
 * フォルダ=/scottadminlaravel/resources/views/
 */
--}}
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>TOP | ScottAdminLaravel Sample</title>
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