<?php

$dbname = 'データベース名';
$host = 'localhost';
$user = 'ユーザー名';
$password = 'パスワード';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $dbh = new PDO($dns, $user, $password);
    if ($dbh == null) {
        print_r('接続失敗').PHP_EOL;
    } else {
        print_r('接続成功').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}


?>
