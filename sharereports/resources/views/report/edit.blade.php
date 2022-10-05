<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>レポート編集</h1>
        <p class="logout"><a href="/logout">ログアウト</a></p>
        <p class="name">{{$session['name']}}</p>
        <nav id="editpan">
            <ul>
                <li><a href="/report/showList">レポート一覧</a></li>
                <li>></li>
                <li><a href="/report/showDetail/{{$report->getId()}}">レポート詳細</a></li>
                <li>></li>
                <link rel="stylesheet" href="/css/main.css" type="text/css">
                <li>レポート編集</li>
            </ul>
        </nav>
    </header>
    <article>
        <h2>以下の内容を入力し、登録してください</h2>
        <section id="editForm">
            <h3 class="d_none">レポート登録フォーム</h3>
            <form action="/report/edit" method="post">
            @csrf
                <div class="form">
                    <div class="title">
                        <h4>レポートID</h4>    
                    </div>
                    <p>{{$report->getId()}}</p>
                    <input type="hidden" name="editId" value="{{$report->getId()}}">
                </div>
                <div class="form">
                    <div class="title">
                        <h4>作業日</h4>
                        @isset($validationMsgs['date'])
                        <p>{{$validationMsgs['date']}}</p>
                        @endisset
                    </div>
                    <div class="select">
                        <select name="editDateYear" id="editDateYear" required>
                            <option value="">--</option>
                            @for($year=date('Y'); $year>1979; $year--)
                            @if($report->getRpDateYear() == $year)
                            <option value="{{$year}}" selected>{{$year}}</option>
                            @else
                            <option value="{{$year}}">{{$year}}</option>
                            @endif
                            @endfor
                        </select>
                        年
                        <select name="editDateMonth" id="editDateMonth" required>
                            <option value="">--</option>
                            @for($month=1; $month<13; $month++)
                            @if($report->getRpDateMonth() == $month)
                            <option value="{{$month}}" selected>{{$month}}</option>
                            @else
                            <option value="{{$month}}">{{$month}}</option>
                            @endif
                            @endfor
                        </select>
                        月
                        <select name="editDateDay" id="editDateDay" required>
                            <option value="">--</option>
                            @for($day=1; $day<32; $day++)
                            @if($report->getRPDateDay() == $day)
                            <option value="{{$day}}" selected>{{$day}}</option>
                            @else
                            <option value="{{$day}}">{{$day}}</option>
                            @endif
                            @endfor
                        </select>
                        日
                    </div>
                </div>
                <div class="form">
                    <div class="title">
                        <h4>作業開始時刻</h4>
                        @isset($validationMsgs['timeFrom'])
                        <p class="red">{{$validationMsgs['timeFrom']}}</p>
                        @endisset
                    </div>
                    <input type="time"  id="editTimeFrom" name="editTimeFrom" value="{{$report->getRpTimeFrom()}}" required>
                </div>
                <div class="form">
                    <div class="title">
                        <h4>作業終了時刻</h4>
                        @isset($validationMsgs['timeTo'])
                        <p class="red">{{$validationMsgs['timeTo']}}</p>
                        @endisset
                    </div>
                    <input type="time"  id="editTimeTo" name="editTimeTo" value="{{$report->getRpTimeTo()}}" required>
                </div>
                <div class="form">
                    <div class="title">
                        <h4>作業内容</h4>
                        @isset($validationMsgs['reportContent'])
                        <p class="red">{{$validationMsgs['reportContent']}}</p>
                        @endisset
                    </div>
                    <textarea id="reportContent" name="reportContent" value="{{$report->getRpContent()}}" required>{{$report->getRpContent()}}</textarea>
                </div>
                <div class="form">
                    <div class="title">
                        <h4>作業種類</h4>
                        @isset($validationMsgs['reportcateId'])
                        <p>{{$validationMsgs['reportcateId']}}</p>
                        @endisset
                    </div>
                    <div class="select">
                        <select  id="editReportcateId" name="editReportcateId" required>
                        <option value="">--</option>
                        @foreach($reportcateList as $rcId => $reportcate)
                        @if($rcId == $report->getReportCateId())
                        <option value="{{$rcId}}" selected>{{$rcId}}:{{$reportcate->getRcName()}}</option>
                        @else
                        <option value="{{$rcId}}">{{$rcId}}:{{$reportcate->getRcName()}}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit">編集</button>
            </form>
        </section>
    </article>
</body>
</html>