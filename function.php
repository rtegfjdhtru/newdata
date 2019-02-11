<?php
/**
 * Created by PhpStorm.
 * User: kunotota
 * Date: 2019-01-03
 * Time: 14:36
 */
//ログ設定

ini_set('log_errors', 'on');
//php_iniファイルのデフォルトのディレクトリに出力
ini_set('error_log', 0);

//======================
//デバック trueの時のみ発動
//======================
$debug_flg = true;

function debug($str)
{
    global $debug_flg;
    if (!empty($debug_flg)) {
        error_log('デバック:' . $str);
    }
}


//エラーメッセージ定数
define('MSG01', '入力が空です');
define('MSG02', 'Emailの形式で入力してください');
define('MSG03', 'パスワードは6文字以上で入力してくだい');
define('MSG04', 'emailは255以下で入力してください');
define('MSG05', '半角英数字の形式で入力してください');
define('MSG06', '同じEmailが使われています');
define('MSG07', ' エラーが発生しました');
define('MSG08', 'メールアドレスまたはパスワードが間違っています');
define('MSG09', '30文字以内で入力してください');
define('MSG10', '10文字以内で入力してください');
define('MSG11', '古いパスワードが違います');
define('MSG12', '古いパスワードと一緒です');
define('MSG13', '再入力が違います');


//セッション関係　ファイル置き場所 アクセス制限をかけたディレクトリ
session_save_path("./var/tmp");
//ガーベージコレクションが削除する確率　1/100 30日以降
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
//ブラウザが閉じても保存できるようにする　クッキーの有効期限を伸ばす
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
//セッション開始
session_start();
//なりすまし防止 新しいID発行
session_regenerate_id();

//ログ吐き出し関数
function debugLogStart()
{
    debug('>>>>>>>>>>>>>>>>>>>>>>>>画面表示開始');
    debug('セッションID:' . session_id());
    debug('セッション変数の中身:' . print_r($_SESSION, true));
    debug('現在日時タイムスタンプ' . time());
    if (!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])) {
        debug('ログイン期限日時タイムスタンプ:' . ($_SESSION['login_date'] + $_SESSION['login_limit']));
    }
}


$err_msg = array();
//バリデーション
//未入力チェック
function inputchech($str, $key)
{
    if ($str === '') { //数字の０は空ではない判定
        global $err_msg;
        $err_msg[$key] = MSG01;
    }
}

//email形式か
function validemail($str, $key)
{
    if (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $str)) {
        global $err_msg;
        $err_msg[$key] = MSG02;
    }
}

//最小文字数
function inputMinlan_pass($str, $key, $min = 6)
{
    if (mb_strlen($str) < $min) {
        global $err_msg;
        $err_msg[$key] = MSG03;
    }
}

//最大文字数
function inputMaxlan_email($str, $key, $max = 255)
{
    if (mb_strlen($str) > $max) {
        global $err_msg;
        $err_msg[$key] = MSG04;
    }
}

//３０文字以上
function inputMaxlan_text30($str, $key, $max = 30)
{
    if (mb_strlen($str) > $max) {
        global $err_msg;
        $err_msg[$key] = MSG09;
    }
}

//1０文字以上
function inputMaxlan_text10($str, $key, $max = 10)
{
    if (mb_strlen($str) > $max) {
        global $err_msg;
        $err_msg[$key] = MSG10;
    }
}

//半角チェック
function validhalf($str, $key)
{
    if (!preg_match("/^[a-zA-Z0-9]+$/", $str)) {
        global $err_msg;
        $err_msg[$key] = MSG05;
    }
}

//DB接続 ローカル環境
function dbconnect()
{
    $dsn = 'mysql:dbname=newdata;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';

    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );

    $dbh = new PDO($dsn, $user, $password, $options);
    return $dbh;
}

//sql流し込み
function querypost($dbh, $sql, $data)
{
    global $err_msg;
    $stmt = $dbh->prepare($sql);
    if (!$stmt->execute($data)) {
        debug('クエリ失敗');
        debug('失敗したsql:'.print_r($stmt,true));
        $err_msg['common'] = MSG07;
        return 0;
    }
    debug('クエリ成功');
    return $stmt;
}

//email重複チェック
function emailDup($email)
{
    global $err_msg;
    try {
        $dbh = dbconnect();
        $sql = 'SELECT count(*) FROM user WHERE email =:email AND delete_flg=0';
        $data = array(':email' => $email);
        $stmt = querypost($dbh, $sql, $data);
        //データを返す
        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!empty($result['count(*)'])) {
            $err_msg['email'] = MSG06;
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = MSG07;
    }
}

//user_id取得
function getUser($u_id)
{
    debug('ユーザー情報を取得します');

    try {
        $dbh = dbconnect();
        $sql = 'SELECT * FROM user WHERE id = :u_id';
        $data = array(':u_id' => $u_id);
        $stmt = querypost($dbh, $sql, $data);

//        //クエリ成功したら
//        if ($stmt) {
//            debug('クエリ成功です');
//        } else {
//            debug('クエリ失敗です');
//        }

    } catch (Exception $e) {
        error_log('エラー発生' . $e->getMessage());
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//入力保持関数
function getformDate($str)
{
    global $dbFormData;
    //ユーザデータがある場合
    if (!empty($dbFormData)) {
        //フォームのデータがある場合
        if (!empty($err_msg[$str])) {
            //postにデータがある場合
            if (!isset($_POST)) {
                return sanitize(_POST[$str]);
            } else {
                //基本あり得ないが
                return sanitize($dbFormData[$str]);
            }
        } else {
            //他のフォームでチェックに引っかかっている場合があるので
            if (isset($_POST[$str]) && $_POST[$str] !== $dbFormData[$str]) {
                return $_POST[$str];
            } else {
                //そもそもっ変更していない
                return sanitize($dbFormData[$str]);
            }
        }
    } else {
        if (isset($_POST[$str])) {
            return $_POST[$str];
        }
    }
}

//メール送信
function sendMail($from, $to, $subject, $comment)
{
    if (!empty($to) && !empty($subject) && !empty($comment)) {
        //文字化けしないようにおきまりのパターン
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $result = mb_send_mail($to, $subject, $comment, "From " . $from);
        if ($result) {
            debug('メール送信成功');
        } else {
            debug('メール送信失敗');
        }
    }
}

//エラーメッセージ表示
function getErrMsg($key)
{
    global $err_msg;
    if (!empty($err_msg[$key])) {
        return $err_msg[$key];
    }
}

//セッションを１度だけ取得
function getSesstionFlash($key)
{
    if (!empty($_SESSION[$key])) {
        $data = $_SESSION[$key];
        $_SESSION[$key] = '';
        return $data;
    }

}

function getproduct($u_id)
{
    debug('掲示板情報を取得します');
    debug('ユーザーID:' . $u_id);

    try {
        $dbh = dbconnect();
        $sql = 'SELECT * FROM contents WHERE user_id = :u_id AND delete_flg=0';
        $data = array(':u_id' => $u_id);
        $stmt = querypost($dbh, $sql, $data);
        if ($stmt) {
            return   $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
    }
}

function uploadImg($file,$key) //fileには$FLIES['pic'] keyにはpicがはいる
{
    debug('アップロード開始');
    debug('FILE情報:' . print_r($file, true));


    if (isset($file['error']) && is_int($file['error'])) {

        try {

            switch ($file['error']) {
                case UPLOAD_ERR_OK; //okなら
                    break;
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズが超過した場合
                case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過した場合
                    throw new RuntimeException('ファイルサイズが大きすぎます');
                default: // その他の場合
                    throw new RuntimeException('その他のエラーが発生しました');
            }
//MIMEタイプを取ってくる
                    $type = @exif_imagetype($file['tmp_name']);
                    if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_PNG, IMAGETYPE_JPEG], true)) {
                        throw new RuntimeException('画像形式が未対応です');
                    }
                    $path = 'uploads/' . sha1_file($file['tmp_name']) . image_type_to_extension($type);

                    if (!move_uploaded_file($file['tmp_name'], $path)) {
                        throw new RuntimeException('ファイル保存時にエラーが発生しました');
                    }
                    //保存したファイルのパスのパーミッションを変更する　権限
                    chmod($path, 0644);
                    debug('ファイルは正常にアップロードされました');
                    debug('ファイルパス:' . $path);
                    return $path;

        } catch (RuntimeException $e) {
            debug($e->getMessage());
            global $err_msg;
            $err_msg[$key] = $e->getMessage();
        }
    }
}

//
//function getContents()
//{
//    debug('掲示板情報を取得します');
//
//
//    try {
//        $dbh = dbconnect();
//        $sql = 'SELECT * FROM contents ORDER BY id DESC';
//        $data = array();
//        $stmt = querypost($dbh, $sql, $data);
//        if ($stmt) {
//            return $stmt;
//        } else {
//            return false;
//        }
//    } catch (Exception $e) {
//        error_log('エラー発生:' . $e->getMessage());
//    }
//}
function sanitize($str){
    return htmlspecialchars($str,ENT_QUOTES);
}

function getContentSearch($str,$u_id){

debug:('GET情報:'.print_r($_GET,true));
    debug('検索結果を取得します');
    try{
        $text = $str;
        $text = '%'.$text.'%';
        $dbh = dbconnect();
        $sql = 'SELECT * FROM contents WHERE (text LIKE :text) OR (title LIKE :text) AND (user_id = :u_id)';
        $data = array(':text' => $text,':u_id'=> $u_id);
        $stmt = querypost($dbh,$sql,$data);


        if($stmt){
            $rst = $stmt->fetchAll();
            debug(print_r($rst,true));
            return $rst;
        }


    }catch (Exception $e){
        error_log('エラー発生:'.$e->getMessage());
    }
}



function getcontents($u_id)
{
    debug('掲示板情報を取得します');
    debug('ユーザーID:' . $u_id);
//ORDER BY は最後
    try {
        $dbh = dbconnect();
        $sql = 'SELECT * FROM contents WHERE user_id = :u_id AND delete_flg=0 ORDER BY id DESC';
        $data = array(':u_id' => $u_id);
        $stmt = querypost($dbh, $sql, $data);
        if ($stmt) {
            return   $stmt;
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
    }
}
