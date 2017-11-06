<?php

$dbname = 'データベース名';
$host = 'localhost';
$user = 'ユーザー名';
$password = 'パスワード';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $pdo = new PDO($dns, $user, $password);
    if ($pdo == null) {
        print_r('接続失敗').PHP_EOL;
    } else {
        print_r('接続成功').PHP_EOL;
    }


} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}


//テーブル作成
$sql_c = "CREATE TABLE IF NOT EXISTS `NAMAE`"
."("
."`ID` INT auto_increment primary key,"
."`name` VARCHAR(100),"
."`comment` VARCHAR(200)"
.");";


$stmt = $pdo -> prepare($sql_c);
$stmt -> execute();



$pdo = null;

?>
