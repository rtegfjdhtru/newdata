<?php
/**
 * Created by PhpStorm.
 * User: kunotota
 * Date: 2019-01-05
 * Time: 21:55
 */
require ('function.php');
debug('===========================');
debug('ログアウトページ');
debug('===========================');

debug('ログアウトします');

//セッション削除
session_destroy();
debug('ログイン画面へ遷移します');
header("Location:login.php");

