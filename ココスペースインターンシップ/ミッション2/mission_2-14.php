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



//入力データ削除
$id = '10';

$sql = "DELETE FROM NAMAE where ID=:delete_id";


//（エラー処理）ができない．必ずエラーになってしまう

//if(!$res = $pdo->query($sql)){

//  echo "SQL実行時エラー";
//  exit;

//}

//////////////

$result = $pdo->prepare($sql);
$result->bindValue(':delete_id',$id,PDO::PARAM_INT);

$result->execute();



$pdo = null;

?>
