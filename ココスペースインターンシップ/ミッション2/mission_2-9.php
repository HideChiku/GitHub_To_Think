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
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}


$pdo->query('SET NAMES utf8');


//テーブル一覧表示
$sql_s = "SHOW TABLES";

$result = $pdo->query($sql_s);

foreach($result as $row){

echo $row[0].'<br>';

}


?>
