
{{--
/**
 *
 * @author Shinzo SAITO
 *
 * ファイル名=list.blade.php
 * フォルダ=/sharereports/resources/views/report/
 */
--}}
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>一覧</title>
        <link rel="stylesheet" href="/css/main.css" type="text/css">
    </head>
    <body>
        <header>
            <h1>レポートリスト</h1>
            <p class="logout"><a href="/logout">ログアウト</a></p>
            <p class="name">{{$session['name']}}</p>
        </header>

        <main>
            <article>
                <h2 class="d_none">新規作成</h2>
                <section>
                <p id="goAdd">新規作成は<a href="/report/goAdd">こちら</a>から</p>
                @if(session("flashMsg"))
                <p class="center">{{session("flashMsg")}}</p>
                @endif
                </section>
            </article>
            <article>
                <h2 class="d_none">レポート一覧</h2>
                <section>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>作業日</th>
                                <th>作業内容</th>
                                <th>報告者名</th>
                                <th>詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reportList as $reId => $report)
                            <tr>
                                <td>{{$report->getId()}}</td>
                                <td>{{$report->getRpDate()}}</td>
                                <td>{{Str::limit($report->getRpContent() , 10)}}</td>
                                @foreach($userList as $usId => $user)
                                @if($usId == $report->getUserId())
                                <td>{{$user->getUsName()}}</td>
                                @endif
                                @endforeach
                                <td>
                                    <a href="/report/showDetail/{{$reId}}">詳細</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">該当情報は存在しません。</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </article>
        </main>
    </body>
</html>