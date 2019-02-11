<?php
/**
 * Created by PhpStorm.
 * User: kunotota
 * Date: 2019-01-05
 * Time: 14:55
 */
//ログインしてる場合

if(!empty($_SESSION['login_date'])){
    debug('ログイン済ユーザーです');

    //現在時刻が　最終ログイン日時＋有効期限を超えていた場合 セッション＋現在時刻
    if(!empty($_SESSION['login_date'] + $_SESSION['login_limit']) < time()){
        debug('ログイン有効期限オーバーです');

        //セッション削除
        session_destroy();

        //ログイページへ
        header("Location:login.php");
    }else{
        debug('ログイン有効期限内です');
        //最終ログイン日時を現在日時に更新
        $_SESSION['login_date'] = time();

//($_SERVER['PHP_SELF']は現在実行しているスプリクトファイル
        if(basename($_SERVER['PHP_SELF']) === 'login.php'){
            debug('ホーム画面へ遷移します');
            header("Location:index.php");
        }
    }
}else{
    debug('未ログインユーザーです');
    if(basename($_SERVER['PHP_SELF'] !== 'login.php')){
        //未ログインユーザーはログイン画面へ遷移
        header("Location:login.php");
    }
}

