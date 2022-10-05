<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <title>削除</title>
</head>
<body>
    <header>
        <h1>削除確認</h1>
        <p class="logout"><a href="/logout">ログアウト</a></p>
        <p class="name">{{$session['name']}}</p>
        <nav class="deletepan">
            <ul>
                <li><a href="/report/showList">レポート一覧</a></li>
                <li>></li>
                <li><a href="/report/showDetail/{{$report->getId()}}">レポート詳細</a></li>
                <li>></li>
                <li>削除確認</li>
            </ul>
        </nav>
    </header>
    <main>
        <article id="deleteform">
            <h2>以下の内容を削除しますよろしいですか</h2>
            <section>
                <h3 class="d_none">詳細一覧</h3>
                @if(session("flashMsg"))
                <p>{{session("flashMsg")}}</p>
                @endif
                <div class="data">
                    <p>レポートID</p>
                    <p>{{$report->getId()}}</p>
                </div>
                <div class="data">
                    <p>報告者名</p>
                    <p>{{$user->getUsName()}}</p>
                </div>
                <div class="data">
                    <p>メールアドレス</p>
                    <p>{{$user->getUsMail()}}</p>
                </div>
                <div class="data">
                    <p>作業日</p>
                    <p>{{$report->getRpDate()}}</p>
                </div>
                <div class="data">
                    <p>作業開始時刻</p>
                    <p>{{$report->getRpTimeFrom()}}</p>
                </div>
                <div class="data">
                    <p>作業終了時刻</p>
                    <p>{{$report->getRpTimeTo()}}</p>
                </div>
                <div class="data">
                    <p>作業種類名</p>
                    @foreach($reportcate as $reId => $reportcate)
                    @if($reId == $report->getReportCateId())
                    <td>{{$reportcate->getRcName()}}</td>
                    @endif
                    @endforeach
                </div>
                <div class="data">
                    <p>作業内容</p>
                    <p>{!!nl2br(e($report->getRpContent()))!!}</p>
                </div>
                <div class="data">
                    <p>レポート登録日時</p>
                    <p>{{$report->getRpCreatedAt()}}</p>
                </div>
            </section>
        </article>
        <article>
            <h2 class="d_none">削除フォーム</h2>
            <section>
                <form action="/report/delete" method="post">
                @csrf
                    <input type="hidden" value="{{$report->getId()}}" name="deletId">
                    <button>削除</button>
                </form>
            </section>
        </article>
    </main>
</body>
</html>