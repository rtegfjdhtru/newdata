<?php

require('function.php');
debug('>>>>>>>>>>>>>>>>>>>>>>>>>');
debug('パスワード変更ページ');
debug('>>>>>>>>>>>>>>>>>>>>>>>>>');


require('auth.php');

//画面処理
$userData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報:'.print_r($userData, true));


//postしたら
if (!empty($_POST)) {

    $pass_old = $_POST['old_pass'];
    $pass_new = $_POST['new_pass'];
    $pass_new_re = $_POST['re_new_pass'];

    //未入力チェック
    inputchech($pass_old, 'old_pass');
    inputchech($pass_new, 'new_pass');
    inputchech($pass_new_re, 're_new_pass');

    if (empty($err_msg)) {
        debug('バリデーションOK');

        //古いパスワードと認証
        if (!password_verify($pass_old, $userData['password'])) {
            $err_msg['old_pass'] = MSG11;
        }

        //古いパスワードと一緒か
        if ($pass_old === $pass_new) {
            $err_msg['new_pass'] = MSG12;
        }
        //新しいパスと再入力が一緒か

        if ($pass_new !== $pass_new_re) {
            $err_msg['re_new_pass'] = MSG13;
        }
        if (empty($err_msg)) {
            debug('バリデーションOK');

            //db接続

            try {
                $dbh = dbconnect();
                $sql = 'UPDATE user SET password = :pass WHERE id = :id';
                $data = array(':id' => $_SESSION['user_id'], ':pass' => password_hash($pass_new, PASSWORD_DEFAULT));
                $stmt = querypost($dbh, $sql, $data);

                //メーるを送信 変数に　名前　メアド　件名　本文を　変数に入れる
                $username = ($userData['username'] ? $userData['username'] : '名無しのごんべえ');
                $from = 'tamura6830@gmail.com';
                $to = $userData['email'];
                $subject = 'パスワード変更通知|MEMO!';
                $comment = <<<EOT

{$username}様
パスパードが変更されました
//////////////////////
MEMO！
//////////////////////
EOT;
sendMail($from,$to,$subject, $comment);
header("Location:index.php");


            }catch (Exception $e){
                error_log('エラー発生:'.$e->getMessage());
                $err_msg['common'] = MSG07;
            }
        }
    }
}


?>




<?php
$title_name = 'パスワード変更';
require('head.php')
?>
<body>

<?php require('header.php'); ?>

<div id="form" class="text-center container-fluid c-form-container">
    <form class="form-signin" action="" method="post">
        <img class="mb-4" src="" alt="">
        <div class="<?php if(!empty($err_msg['common'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
        </div>
        <h1 class="h3 mb-3 font-weight-normal">パスワード変更</h1>
        <label for="inputEmail" class="sr-only">古いパスワード</label>
        <input type="password" id="inputEmail" class="form-control" placeholder="古いパスワード" name="old_pass">
        <div class="<?php if(!empty($err_msg['old_pass'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php echo getErrMsg('old_pass')?> </div>

        <input type="password" class="form-control" placeholder="新しいパスワード" name="new_pass">
        <div class="<?php if(!empty($err_msg['new_pass'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php echo getErrMsg('new_pass'); ?> </div>

        <input type="password" class="form-control" placeholder="新しいパスワード(再入力）" name="re_new_pass">
        <div class="<?php if(!empty($err_msg['re_new_pass'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php echo getErrMsg('re_new_pass'); ?> </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">変更</button>


    </form>
</div>
<!--メイン-->


<!--フッター-->
<?php
require('footer.php');
?>