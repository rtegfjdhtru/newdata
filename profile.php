<?php

require('function.php');

debug('>>>>>>>>>>>>>>>>');
debug('プロフィール編集画面です');
debug('>>>>>>>>>>>>>>>>');
debugLogStart();

//認証
require('auth.php');

//画面処理 idを取得
$dbFormData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報:' . print_r($dbFormData, true));


if (!empty($_POST)) {
    debug('POST送信があります');
    debug('POST情報:' . print_r($_POST, true));


//フォームで入力したデータを変数にれる

    $prpflieName = $_POST['username'];
    $proflieText = $_POST['text'];
    $pic = (!empty($_FILES['pic']['name']) ? uploadImg($_FILES['pic'], 'pic') : '');

    //DBとの情報に違いがあればバリデーション 30文字いない
    if ($dbFormData['text'] !== $proflieText) {
        inputMaxlan_text30($proflieText, 'text');
    }

    //10文字いない
    if ($dbFormData['username'] !== $prpflieName) {
        inputMaxlan_text10($prpflieName, 'username');
    }
    if (empty($err_msg)) {
        debug('バリデーションOK');

        try {

            $dbh = dbconnect();
            $sql = 'UPDATE user SET username = :u_name, text = :u_text, img = :img WHERE id = :u_id';
            $data = array(':u_name' => $prpflieName, ':u_text' => $proflieText,
                          ':img'=>$pic,':u_id' => $dbFormData['id']);
            $stmt = querypost($dbh, $sql, $data);

            if ($stmt) {
                debug('クエリ成功です');
                debug('ホーム画面へ遷移します');
                header("Location:index.php");
            } else {
                debug('クエリ失敗です');
                $err_msg['common'] = MSG07;
            }
        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG07;
        }

    }

}


?>

    <!--html-->
<?php


$title_name = 'プロフィール';
require('head.php'); ?>





    <body>

<?php
require('header.php');

?>


    <!--メイン-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 u-form-user-post-margin">
                <form action="" method="post" enctype="multipart/form-data">
                    <!--                エラーメッセージ-->
                    <div class="<?php if (!empty($err_msg['common'])) echo 'alert alert-danger'; ?>" role="alert">
                        <?php if (!empty($err_msg['common'])) echo $err_msg['common']; ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">名前</label>
                        <input type="text" name="username" class="form-control" placeholder="実名じゃなくてもいいよ"
                               value="<?php echo getformDate('username'); ?>">
                    </div>
                    <!--                エラーメッセージ-->
                    <div class="<?php if (!empty($err_msg['username'])) echo 'alert alert-danger'; ?>" role="alert">
                        <?php if (!empty($err_msg['username'])) echo $err_msg['username']; ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">ひとこと</label>
                        <input type="text" name="text" class="form-control" placeholder="なんでもいいよ"
                               value="<?php echo getformDate('text'); ?>">
                    </div>
                    <!--                エラーメッセージ-->
                    <div class="<?php if (!empty($err_msg['text'])) echo 'alert alert-danger'; ?>" role="alert">
                        <?php if (!empty($err_msg['text'])) echo $err_msg['text']; ?>
                    </div>
                    <!--                画像選択-->

                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label class="p-FormFile p-FormFile-area-drop">

                                    <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                                    <input type="file" class="form-control-file p-FormFile-input-file" name="pic">
                                    <img src="<?php echo getformDate('img'); ?>" alt="" class="p-FormFile-prev-img">

                                    <div class="<?php if (!empty($err_msg['pic'])) echo 'alert alert-danger'; ?>"
                                         role="alert">
                                        <?php if (!empty($err_msg['pic'])) echo $err_msg['pic']; ?>

                                </label>
                                <input type="submit" class="btn btn-primary u-btn-pro-margin" value="変更">
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <!--フッター-->
<?php
require('footer.php');
?>