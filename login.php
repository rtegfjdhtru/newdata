<?php

require('function.php');

debug('==========================');
debug('ログインページです');
debug('==========================');

debugLogStart();
//ログイン認証

if (!empty($_POST)) {

    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_save = (!empty($_POST['pass_save'])) ? true : false;

    //バリデーション　空かどうか
    inputchech($email, 'email');
    inputchech($pass, 'pass');

    if(empty($err_msg)){
    //半角英数字か
    validhalf($pass, 'pass');

    //emailの形式か
    validemail($email, 'email');

    if (empty($err_msg)) {
        debug('バリデーションOK');

        //DB接続
        try {
            $dbh = dbconnect();
            $sql = 'SELECT password,id FROM user WHERE email=:email';
            $data = array(':email' => $email);
            $stmt = querypost($dbh, $sql, $data);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($result) && password_verify($pass,array_shift($result))) {
                debug('パスワードがマッチしました');

                //マッチしたらログイン有効期限を発行　デフォは１時間
                $sesLimit = 60 * 60;
                //最終ログイン日時$_SESSION['']に格納 現在時刻で
                $_SESSION['login_date'] = time();
                //ログイン保持にチェックがある場合

                if ($pass_save) {
                    debug('ログイン保持にチェックあり');
                    //ログイン有効期限を３０に変更 デフォルトに２４＊３０
                    $_SESSION['login_limit'] = $sesLimit * 24 * 30;

                } else {
                    debug('ログイン保持にチェックなし');
                    //次回からもデフォルトの１時間のままにする
                    $_SESSION['login_limit'] = $sesLimit;
                }
                //DBのIDを格納
                $_SESSION['user_id'] = $result['id'];
                debug('セッション変数の中身:' . print_r($_SESSION, true));
                debug('ホーム画面へ遷移します');
                header("Location:index.php");
            } else {
                debug('パスワードが間違っています');
                $err_msg['common'] = MSG08;
            }
        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common']=MSG07;
        }
    }
}
}
debug('画面遷移終了>>>>>>>>>>>>>>>>>>>>>');



?>
<?php
//head読み込み
$title_name = 'ログイン';
require ('head.php');

?>



<body>

<?php
//ヘッダー読み込み
require ('header.php');

?>



<div id="form" class="text-center container-fluid c-form-container">
    <form class="form-signin" action="" method="post">
        <img class="mb-4" src="" alt="">

        <div class="<?php if(!empty($err_msg['common'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
        </div>

        <h1 class="h3 mb-3 font-weight-normal">ログイン</h1>

        <input type="email" id="inputEmail" class="form-control" placeholder="Email" name="email">
        <div class="<?php if(!empty($err_msg['email'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?> </div>

        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass">
        <div class="<?php if(!empty($err_msg['pass'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?></div>
        <div class="checkbox mb-3">
            <!--            pass_save ログイン保持　-->
            <label>
                <input type="checkbox" value="remember-me" name="pass_save"> 次回自動でログイン
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
    </form>
</div>
<!--メイン-->


<!--フッター-->

<?php
require ('footer.php');
?>
