<?php


require('function.php');
//postされたら
if(!empty($_POST)){


    $email = $_POST['email'];
    $pass = $_POST['pass'];

    //未入力チェック
    inputchech($email,'email');
    inputchech($pass,'pass');

    if(empty($err_msg)) {
        //emailの形式か
        validemail($email, 'email');
        //255文字以上か
        inputMaxlan_email($email, 'email');
        //半角英数字か
        validhalf($pass, 'pass');

        //パスワードは６文字以上か
        inputMinlan_pass($pass, 'pass');

        //email重複チェック
        emailDup($email);

        if(empty($err_msg)){

            //DB接続
            try{
                $dbh= dbconnect();
                $sql = 'INSERT INTO user(email,password,login_time,create_data)
                        VALUES (:email,:password,:login_time,:create_data)';
                $data= array(':email'=>$email,':password'=>password_hash($pass,PASSWORD_DEFAULT),
                             ':login_time'=>date('Y-m-d H:i:s'),':create_data'=>date('Y-m-d H:i:s'));
                //クエリ実行
               $stmt = querypost($dbh,$sql,$data);

                //クエリが成功したら

                if($stmt){
                    $sesLimit = 24*30;
                    //現在日時を取得
                    $_SESSION['login_date'] = time();
                    $_SESSION['login_limit'] = $sesLimit;
                    //ユーザーIDを格納
                    $_SESSION['user_id'] = $dbh->lastInsertId();
//PDOオブジェクト　lastInsertId();でインサートしたレコードのIDがとれる
                    debug('セッション変数の中身:'.print_r($_SESSION,true));
                   header("Location:index.php");
                }else{
                    debug('クエリが失敗しました');
                    $err_msg['common'] = MSG07;

                }

            }catch (Exception $e){
                error_log('エラー発生:'.$e->getMessage());
                $err_msg['common']=MSG08;
            }

        }
    }
}

?>


<?php
$title_name='新規登録';
require ('head.php');
?>

<body>

<?php require ('header.php'); ?>

<div id="form" class="text-center container-fluid c-form-container">
    <form class="form-signin" action="" method="post">
        <h1 class="h3 mb-3 font-weight-normal">新規登録</h1>

<!--        エラーメッセージ-->
        <div class="<?php if(!empty($err_msg['common'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
        </div>


        <input type="email" id="inputEmail" class="form-control" placeholder="Email" name="email">

        <div class="<?php if(!empty($err_msg['email'])) echo 'alert alert-danger' ;?>" role="alert">
            <?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?> </div>

        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass">

            <div class="<?php if(!empty($err_msg['pass'])) echo 'alert alert-danger' ;?>" role="alert">
                <?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?></div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">登録</button>
    </form>
</div>
<!--メイン-->


<!--フッター-->
<div id="footer" class="footer bgcolor-footer">

    <div class="footer--title">©️kunotota</div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>