<?php

require('function.php');

debug('>>>>>>>>>>>>>>>>>>>>>>>');
debug('退会ページ');
debug('>>>>>>>>>>>>>>>>>>>>>>>');
debugLogStart();

//ログイン認証
require('auth.php');

if (!empty($_POST)) {
    debug('POST送信があります');

    //db接続
    try {
        $dbh = dbconnect();
        $sql1 = 'UPDATE user SET delete_flg = 1 WHERE id = :us_id';
        $sql2 = 'UPDATE contents SET delete_flg= 1 WHERE user_id = :us_id';
        $data = array(':us_id' => $_SESSION['user_id']);

        $stmt1 = querypost($dbh,$sql1,$data);
        $stmt2 =querypost($dbh,$sql2,$data);

        if($stmt1){
            session_destroy();
            debug('セッション変数の中身:',print_r($_SESSION,true));
            debug('新規登録画面へ遷移します');
            header("Location:signup.php");
        }else{
            debug('クエリは失敗しました');
            $err_msg['common'] = MSG07;
        }

    }catch (Exception $e){
        error_log('エラー発生:'.$e->getMessage());
        $err_msg['common'] = MSG07;
    }
}
debug('画面遷移終了>>>>>>>>>>>>>>>>>>>>');

?>


<?php

$title_name = '退会';
require('head.php');

?>

    <body>
<?php
require('header.php');

?>

    <div id="form" class="text-center container-fluid c-form-container">
        <form class="form-signin" action="" method="post">

            <h1 class="h3 mb-3 font-weight-normal">退会</h1>

            <input class="btn btn-lg btn-primary btn-block" name="submit" type="submit" value="退会">
        </form>
    </div>
    <!--メイン-->


    <!--フッター-->
<?php
require('footer.php');
?>