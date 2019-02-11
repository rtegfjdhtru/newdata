<?php

require('function.php');

debug('>>>>>>>>>>>>>>>>>>>');
debug('ホーム(index.php)ページ');
debug('>>>>>>>>>>>>>>>>>>>');

require('auth.php');

//GETパラメータを取得
$c_text = (!empty($_GET['c_text'])) ? $_GET['c_text'] : '';
//サニタイズ
$c_text = sanitize($c_text);
//
//$getContentDBdate = (!empty($c_id)) ? getcontentsA($_SESSION['user_id'],$p_id) : '';

//$currentPage = (!empty($_GET['p']))? $_GET['p'] : 1;
////検索のGETパラメータ
//$Search = (!empty($_GET['s_id']))? $_GET['s_id'] : '';
////パラメーターに不正な値が入って_いるかの確認
//if(!is_int($currentPage)){
//    error_log('エラー発生:指定ページに不正な値が入りました');
//    hedaer("Location:index.php");
//}
//ユーザ情報を取得
$dbUserData = getUser($_SESSION['user_id']);
//掲示板のデーターを取得
//$dbContentsData = getContents();
$dbContentsData = getContents($_SESSION['user_id']);

$dbGetContentSearchDate = getContentSearch($c_text,$_SESSION['user_id']);


debug('掲示板情報:' . print_r($dbContentsData, true));


?>


    <!--html-->
<?php
$title_name = 'ホーム';
require('head.php');

?>
    <!--ヘッダー-->
<?php
require('header.php');
?>
    <!--メイン  パス変成功した時の画面-->
    <p id="js-show-msg" style="display: none;" class="p-msg-slide">
        <?php echo getSesstionFlash('msg_success'); ?>
    </p>
    <!--ユーザーバー-->
    <div id="main">
    <div class="container c-main">
        <div class="row">
            <div class="col-10 bg-color-u">
                <div class="u-main-img">
                    <img class="rounded-circle" src="<?php echo $dbUserData['img']; ?>" alt="image">
                </div>
                <div class="u-user-text">
                    <h2><?php echo sanitize($dbUserData['username']); ?></h2>
                    <p><?php echo sanitize($dbUserData['text']); ?></p>
                </div>
            </div>
        </div>

        <!--コンテンツ画面-->
        <!--    検索結果の表示-->

        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-10">
                    <?php if (!empty($_GET)) { ?>
                        <?php foreach ($dbGetContentSearchDate as $key => $val) { ?>



                            <div class="c-main--card">
                                <div class="card">
                                    <!--                        画像投稿がなければ-->
                                    <?php if (!empty($val['img'])) { ?>
                                        <img class="card-img-top" src="<?php echo $val['img']; ?>" alt="画像">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo sanitize($val['title']); ?></h5>
                                        <p class="card-text"><?php echo sanitize($val['text']); ?></p>
                                        <p class="card-text">
                                            <small class="text-muted"><?php echo sanitize($val['create_date']); ?></small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }else{ //検索しない場合
                        foreach ($dbContentsData as $key => $val) { ?>
                    <div class="c-main--card">
                        <div class="card">

                            <?php if (!empty($val['img'])) {

                                ?>
                                <img class="card-img-top" src="<?php echo $val['img']; ?>" alt="画像">
                            <?php } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo sanitize($val['title']); ?></h5>
                                <p class="card-text"><?php echo sanitize($val['text']); ?></p>
                                <p class="card-text">
                                    <small class="text-muted"><?php echo sanitize($val['create_date']); ?></small>
                                </p>
                            </div>
                        </div>


                        <?php }
                    } ?>
                </div>

            </div>
        </div>
    </div>



        </div>


    </div>


    <!--フッター-->
<?php

$index = 1;
require('footer.php');
?>