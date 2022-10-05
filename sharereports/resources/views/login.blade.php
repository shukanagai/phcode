{{--
/**
 * ログイン画面
 *
 * @author shuka Nagai
 *
 * ファイル名=login.blade.php
 * フォルダ=/sharereports/resources/views
 */
--}}
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shuka NAGAI">
        <title>ログイン</title>
        <link rel="stylesheet" href="/css/main.css" type="text/css">
    </head>
    <body>
        <header>
            <h1>sharereports login</h1>
        </header>

        <main>
            <article>
                <h2>以下の内容を入力し、ログインしてください</h2>
                @isset($validationMsgs['msg'])
                <p class="redlogin">{{$validationMsgs['msg']}}</p>
                @endisset
                <section id="login">
                    <h3 class="d_none">ログインフォーム</h3>
                    <form action="/login" method="post">
                    @csrf
                        <div class="form">
                            <div class="title">
                                <h4>メールアドレス</h4>
                                @isset($validationMsgs['mail'])
                                <p class="red">{{$validationMsgs['mail']}}</p>
                                @endisset
                            </div>
                            <input type="email" id="loginMail" name="loginMail" value="{{$loginMail?? ""}}">
                        </div>

                        <div class="form">
                            <div class="title">
                                <h4>パスワード</h4>
                                @isset($validationMsgs['pass'])
                                <p class="red">{{$validationMsgs['pass']}}</p>
                                @endisset
                            </div>
                            <input type="password" id="loginPw" name="loginPw">
                        </div>
                        <button type="submit" id="loginbtn">ログイン</button>
                    </form>
                </section>
            </article>
        </main>
    </body>
</html>