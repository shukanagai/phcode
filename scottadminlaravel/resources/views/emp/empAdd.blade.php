{{--
/**
 * 従業員情報登録画面。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=empAdd.blade.php
 * フォルダ=/scottadminlaravel/resources/views/emp/
 */
--}}
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>部門情報追加 | ScottAdminLaravel Sample</title>
        <link rel="stylesheet" href="/css/main.css" type="text/css">
    </head>
    <body>
        <header>
            <h1>従業員情報追加</h1>
            <p><a href="/logout">ログアウト</a></p>
        </header>
        <nav id="breadcrumbs">
            <ul>
                <li><a href="/goTop">TOP</a></li>
                <li><a href="/emp/showEmpList">従業員リスト</a></li>
                <li>従業員情報追加</li>
            </ul>
        </nav>
        @isset($validationMsgs)
        <section id="errorMsg">
            <p>以下のメッセージをご確認ください。</p>
            <ul>
                @foreach($validationMsgs as $msg)
                <li>{{$msg}}</li>
                @endforeach
            </ul>
        </section>
        @endisset
        <section>
            <p>
                情報を入力し、登録ボタンをクリックしてください。
            </p>
            
            <form action="/emp/empAdd" method="post" class="box">
                @csrf
                <label for="addEmNo">
                    従業員番号&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="1000" max="9999" step="1" name="addEmNo" id="addEmNo" value="{{$emp->getEmNo()}}" required>
                </label><br>
                <label for="addEmName">
                    従業員名&nbsp;<span class="required">必須</span><br>
                    <input type="text" name="addEmName" id="addEmName" value="{{$emp->getEmName()}}" required>
                </label><br>
                <label for="addEmJob">
                    役職&nbsp;<span class="required">必須</span><br>
                    <input type="input" id="addEmJob"  name="addEmJob" value="{{$emp->getEmJob()}}" required>
                </label><br>
                <label for="addEmSal">
                    給与&nbsp;<span class="required">必須</span><br>
                    <input type="number" min="0"  name="addEmSal" id="addEmSal" value="{{$emp->getEmSal()}}" required>
                </label><br>
                <label for="addEmMgr">
                上司番号&nbsp;<span class="required">必須</span><br>
                <select name="addEmMgr" id="addEmMgr" required>
                    <option value="">選択してください</option>
                    @if($emp->getEmMgr() === 0)
                    <option value="0" selected>上司なし</option>
                    @else
                    <option value="0">上司なし</option>
                    @endif
                    @foreach($empList as $emId => $list)
                    @if($emp->getEmMgr() == $list->getEmNo())
                    <option value="{{$list->getEmNo()}}" selected>氏名:{{$list->getEmName()}}  社員番号:{{$list->getEmNo()}}</option>
                    @else
                    <option value="{{$list->getEmNo()}}">氏名:{{$list->getEmName()}}  社員番号:{{$list->getEmNo()}}</option>
                    @endif
                    @endforeach
                </select>
                </label><br>
                <label for="addEmHiredate">
                    雇用日&nbsp;<span class="required">必須</span><br>
                    <select name="addEmHiredateYear" id="addEmHiredateYear" required>
                        <option value="">--</option>
                        @for($year=date('Y'); $year>1979; $year--)
                        @if($emp->getEmHiredateYear() == $year)
                        <option value="{{$year}}" selected>{{$year}}</option>
                        @else
                        <option value="{{$year}}">{{$year}}</option>
                        @endif
                        @endfor
                    </select>
                    年
                    <select name="addEmHiredateMonth" id="addEmHiredateMonth" required>
                        <option value="">--</option>
                        @for($month=1; $month<13; $month++)
                        @if($emp->getEmHiredateMonth() == $month)
                        <option value="{{$month}}" selected>{{$month}}</option>
                        @else
                        <option value="{{$month}}">{{$month}}</option>
                        @endif
                        @endfor
                    </select>
                    月
                    <select name="addEmHiredateDay" id="addEmHiredateDay" required>
                        <option value="">--</option>
                        @for($day=1; $day<32; $day++)
                        @if($emp->getEmHiredateDay() == $day)
                        <option value="{{$day}}" selected>{{$day}}</option>
                        @else
                        <option value="{{$day}}">{{$day}}</option>
                        @endif
                        @endfor
                    </select>
                    日
                </label><br>
                <label for="addDeptId">
                    部門ID&nbsp;<span class="required">必須</span><br>
                    <select name="addDpId" id="addDpId" required>
                        <option value="">選択してください</option>
                        @foreach($deptList as $dpId => $dept)
                        @if($dpId == $emp->getDeptId())
                        <option value="{{$dpId}}" selected>{{$dept->getDpNo()}}:{{$dept->getDpName()}}</option>
                        @else
                        <option value="{{$dpId}}">{{$dept->getDpNo()}}:{{$dept->getDpName()}}</option>
                        @endif
                        @endforeach
                    </select>
                </label><br>
                <button type="submit">登録</button>
            </form>
        </section>
    </body>
</html>