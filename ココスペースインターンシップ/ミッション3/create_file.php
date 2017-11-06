<?php
//接続
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

session_start();
$session = $_SESSION['choice'];

$id = $_GET['id'];
$sql = "SELECT * FROM `$session`";

$result = $pdo->query($sql);




foreach($result as $row){

  if($id == $row['id']){
    header("Content-Type: ".$row['mime']);
    echo $row['filedata'];
  }
}


?>
