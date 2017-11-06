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



//入力データ確認
$sql = "SELECT * FROM NAMAE";

$result = $pdo->query($sql);

foreach($result as $row){

  echo $row['ID'].','.$row['name'].','.$row['comment'].'<br>';

}


$pdo = null;

?>
