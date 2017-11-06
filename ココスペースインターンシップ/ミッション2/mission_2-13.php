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



//入力データ編集
$myname = 'chiku';
$comment = 'tennis player';
$id = '11';


$sql = "update NAMAE set name=:name , comment=:comment where ID=:ID";

//（エラー処理）ができない．必ずエラーになってしまう

//if(!$res = $pdo->query($sql)){

//  echo "SQL実行時エラー";
//  exit;

//}

//////////////

$result = $pdo->prepare($sql);
$result->bindValue(':name',$myname,PDO::PARAM_STR);
$result->bindValue(':comment',$comment,PDO::PARAM_STR);
$result->bindValue(':ID',$id,PDO::PARAM_INT);

$result->execute();




$pdo = null;

?>
