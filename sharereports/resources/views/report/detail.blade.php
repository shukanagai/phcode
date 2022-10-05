<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <title>詳細</title>
</head>
<body>
    <header>
        <h1>レポート詳細</h1>
        <p class="logout"><a href="/logout">ログアウト</a></p>
        <p class="name">{{$session['name']}}</p>
        <nav>
            <ul>
                <li><a href="/report/showList">レポート一覧</a></li>
                <li>></li>
                <li>レポート詳細</li>
            </ul>
        </nav>
    </header>
    <main>
        <article id="display">
            <h2 class="d_none">画面遷移</h2>
            <p><a href="/report/prepareEdit/{{$report->getId()}}">編集</a></p>
            <p><a href="/report/confirmDelete/{{$report->getId()}}">削除</a></p>
        </article>
        <article id="detail">
            <h2 class="d_none">以下の内容が表示されます</h2>
            <section>
                <h3 class="d_none">詳細一覧:</h3>
                @if(session("flashMsg"))
                <p>{{session("flashMsg")}}</p>
                @endif
                <div class="data">
                    <p>レポートID:</p>
                    <p>{{$report->getId()}}</p>
                </div>
                <div class="data">
                    <p>報告者名:</p>
                    <p>{{$user->getUsName()}}</p>
                </div>
                <div class="data">
                    <p>メールアドレス:</p>
                    <p>{{$user->getUsMail()}}</p>
                </div>
                <div class="data">
                    <p>作業日:</p>
                    <p>{{$report->getRpDate()}}</p>
                </div>
                <div class="data">
                    <p>作業開始時刻:</p>
                    <p>{{$report->getRpTimeFrom()}}</p>
                </div>
                <div class="data">
                    <p>作業終了時刻:</p>
                    <p>{{$report->getRpTimeTo()}}</p>
                </div>
                <div class="data">
                    <p>作業種類名:</p>
                    @foreach($reportcate as $reId => $reportcate)
                    @if($reId == $report->getReportCateId())
                    <p>{{$reportcate->getRcName()}}</p>
                    @endif
                    @endforeach
                </div>
                <div class="data">
                    <p>作業内容:</p>
                    <p>{!!nl2br(e($report->getRpContent()))!!}</p>
                </div>
                <div class="data">
                    <p>レポート登録日時:</p>
                    <p>{{$report->getRpCreatedAt()}}</p>
                </div>
            </section>
        </article>
    </main>
</body>
</html>