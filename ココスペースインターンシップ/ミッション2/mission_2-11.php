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

//文字コード指定
$moji = $pdo->query('SET NAMES utf8');



//データ入力
$myname = '秀康';
$comment = 'tennis';

$sql = "INSERT INTO NAMAE (ID,name,comment) VALUE ('',:name,:comment)";

$result = $pdo->prepare($sql);
$result -> bindValue(':name',$myname,PDO::PARAM_STR);
$result -> bindValue(':comment',$comment,PDO::PARAM_STR);

$result -> execute();




$pdo = null;

?>
