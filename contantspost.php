<?php

require('function.php');
debug('>>>>>>>>>>>>>>>>>>>>>>>>>');
debug('投稿画面ページ');
debug('>>>>>>>>>>>>>>>>>>>>>>>>>');
debugLogStart();

require('auth.php');



//dbから掲示板データを取得
$dbFormData =  getproduct($_SESSION['user_id']);





//post 送信
if (!empty($_POST)) {
    debug('POST送信があります');
    debug('POST情報:' . print_r($_POST, true));
    debug('FILE情報:' . print_r($_FILES, true));
//変数にぶっこむ
    $title = $_POST['title'];
    $text = $_POST['text'];
    $pic = (!empty($_FILES['pic']['name']) ? uploadImg($_FILES['pic'], 'pic') : '');


    //未入力チェック
    inputchech($title, 'title');
    inputchech($text, 'text');

    //タイトルは３０文字いないか
    inputMaxlan_text30($title, 'title');

    if (empty($err_msg)) {
        debug('バリデーションOK');

        try {

            $dbh = dbconnect();
            $sql = 'INSERT INTO contents(title,text,img,user_id,create_date)
                     VALUE (:title,:text,:img,:user_id,:create_date)';
            $data = array(':title' => $title, ':text' => $text, ':img' => $pic, ':user_id' => $_SESSION['user_id'],
                ':create_date' => date('Y-m-d H:i:s'));
            $stmt = querypost($dbh, $sql, $data);
            if ($stmt) {
                debug('ホーム画面へ遷移します');
                header("Location:index.php");
            }


        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG07;
        }
    }
}
debug('画面処理終了>>>>>>>>>>>>>>>>>>>');

?>


    <!--html-->
<?php

$title_name = '投稿画面';
require('head.php');

?>
    <!--ヘッダー-->

<?php require('header.php');
?>
    <!--メイン-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm">
                <form action="" method="post" class="c-form-container u-form-margin" enctype="multipart/form-data">
                    <div class="form-group">

                        <div class="col-sm-12">
                        <div class="<?php if (!empty($err_msg['common'])) echo 'alert alert-danger'; ?>" role="alert">
                            <?php if (!empty($err_msg['common'])) echo $err_msg['common']; ?>
                        </div>

                            <div class="<?php if (!empty($err_msg['pic'])) echo 'alert alert-danger'; ?>" role="alert">
                                <?php if (!empty($err_msg['pic'])) echo $err_msg['pic']; ?></div>

                        <label class="p-FormFile p-FormFile-area-drop">

                            <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                            <input type="file" class="form-control-file p-FormFile-input-file" name="pic">
                            <img src="" alt="" class="p-FormFile-prev-img">

                        </label>
                    </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">タイトル</label>
                            <input type="text" class="form-control" id="js-form-text" name="title" placeholder="">
                            <span id="js-text-count">0</span>/30
                        </div>

                        <div class="<?php if (!empty($err_msg['title'])) echo 'alert alert-danger'; ?>" role="alert">
                            <?php if (!empty($err_msg['title'])) echo $err_msg['title']; ?> </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">テキスト</label>
                            <textarea name="text" class="form-control"
                                      rows="3"></textarea>
                        </div>

                        <div class="<?php if (!empty($err_msg['text'])) echo 'alert alert-danger'; ?>" role="alert">
                            <?php if (!empty($err_msg['text'])) echo $err_msg['text']; ?> </div>


                        <input type="submit" value="投稿" class="btn btn-primary mb-2">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--フッター-->
<?php require('footer.php'); ?>