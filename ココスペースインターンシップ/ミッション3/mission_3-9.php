<?php //本登録

$id = $_GET['id'];


//mysql接続
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



//データ編集
$sql = "update userinfo set flag=:flag where autoID=:autoID";

//（エラー処理）ができない．必ずエラーになってしまう

//if(!$res = $pdo->query($sql)){

//  echo "SQL実行時エラー";
//  exit;

//}

//////////////

$flag = "honto";

$result = $pdo->prepare($sql);
$result->bindValue(':flag',$flag,PDO::PARAM_STR);
$result->bindValue(':autoID',$id,PDO::PARAM_STR);

$result->execute();



//本登録確認
$sql = "SELECT * FROM userinfo";

$result = $pdo->query($sql);

foreach($result as $row){

if($id == $row['autoID']){

  if($row['flag'] == "honto"){
    echo 'サークル掲示板'.'<br>';
    echo '本登録が完了しました．';
  }
}
}

$pdo = null;

?>
