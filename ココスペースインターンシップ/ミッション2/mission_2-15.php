<?php //編集コード1_mission2-5

$edit = $_POST['edit'];

$PASS2 = $_POST['pass2'];

if(empty($edit)){
}else{

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


//データ読み込み
$sql = "SELECT * FROM KEIJI";

$result = $pdo->query($sql);

foreach($result as $row){

  if($row['id'] == $edit){
    if($row['pass'] != $PASS2){
      echo "パスワードが間違っています";
    }else{
      $T = $row['id'];
      $N = $row['name'];
      $C = $row['comment'];
    }
  }
}

$pdo = null;

}


?>




<?php //mysqlテーブル作成・挿入コード+編集コード2
$name = $_POST['name'];

$comment = $_POST['comment'];

$check = $_POST['check'];

$PASS = $_POST['password'];

if(empty($check)){  //mysqlテーブル作成・挿入コード

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

//テーブル作成
$sql_c = "CREATE TABLE IF NOT EXISTS `KEIJI`"
."("
."`id` INT auto_increment primary key,"
."`name` VARCHAR(100),"
."`comment` VARCHAR(200),"
."`date` VARCHAR(30),"
."`pass` VARCHAR(200)"
.");";


$stmt = $pdo -> prepare($sql_c);
$stmt -> execute();



 if(empty($name)){
  echo "名前が未入力です";
 }else{
  if(empty($comment)){
   echo "コメントが未入力です";
  }else{
   if(empty($PASS)){
    echo "パスワードが未設定です";
   }else{

  //データ挿入

    $sql_i = "INSERT INTO KEIJI (id,name,comment,date,pass) VALUE ('',:name,:comment,now(),:pass)";

    $result = $pdo->prepare($sql_i);
    $result -> bindValue(':name',$name,PDO::PARAM_STR);
    $result -> bindValue(':comment',$comment,PDO::PARAM_STR);
    $result -> bindValue(':pass',$PASS,PDO::PARAM_STR);

    $result -> execute();

    $name = null;
    $comment = null;

   }
  }
 }

$pdo = null;












}else{  //編集コード2

 if(empty($name)){
  echo "名前が未入力です";
  $T = $check;
 }else{
  if(empty($comment)){
   echo "コメントが未入力です";
   $T = $check;
  }else{
   if(empty($PASS)){
    echo "パスワードが未設定です";
    $T = $check;
   }else{



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
$sql = "update KEIJI set name=:name , comment=:comment where id=:id";

//（エラー処理）ができない．必ずエラーになってしまう

//if(!$res = $pdo->query($sql)){

//  echo "SQL実行時エラー";
//  exit;

//}

//////////////

$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':comment',$comment,PDO::PARAM_STR);
$result->bindValue(':id',$check,PDO::PARAM_INT);

$result->execute();



$name = null;
$comment = null;

$pdo = null;


   }
  }
 }
}//endelse

?>



<?php //削除コード_mission2-4

$delete = $_POST['delete'];

$PASS1 = $_POST['pass1'];

if(empty($delete)){
}else{

?>

<script type = "text/javascript">
 var res = confirm("本当に削除しますか？");
</script>

<?php

 if('<script type ="text/javascript">document.write(res);</script>' == true){



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

//データ読み込み
$sql = "SELECT * FROM KEIJI";

$result = $pdo->query($sql);

foreach($result as $row){
  if($row['id'] == $delete){
    if($row['pass'] != $PASS1){
      echo "パスワードが間違っています"."<br>";
    }else{

//データ削除(編集)
$sql = "update KEIJI set name=:name where id=:id";

//（エラー処理）ができない．必ずエラーになってしまう

//if(!$res = $pdo->query($sql)){

//  echo "SQL実行時エラー";
//  exit;

//}

//////////////

$name = 'deleted';

$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':id',$delete,PDO::PARAM_INT);

$result->execute();

$name = null;

    }
  }

}


}

$pdo = null;

}




?>


<html>
<form method = "post">
  <input type = "hidden" name = "check" value = "<?php echo $T; ?>">
  <p>名前:<input type = "text" name = "name" value = "<?php echo $N; ?><?php echo $name ?>"></p>
  <p>コメント:<input type = "text" name = "comment" value = "<?php echo $C; ?><?php echo $comment ?>"></p>
  <p>パスワード設定:<input type = "text" name = "password"></p>
  <input type = "submit">
</form>

<form method = "post">
  <p>削除対象番号:<input type = "text" name = "delete"></p>
  <p>パスワード:<input type = "text" name = "pass1"></p>
  <input type = "submit" value = "削除">
</form>

<form method = "post">
  <p>編集対象番号:<input type = "text" name = "edit"></p>
  <p>パスワード:<input type = "text" name = "pass2"></p>
  <input type = "submit" value = "編集">
</form>
</html>



<?php //エコーコード

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


//SELECT文

$sql = "SELECT * FROM KEIJI";

$result = $pdo->query($sql);

foreach($result as $row){

  if($row['name'] != 'deleted'){
    echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].'<br>';
  }
}


$pdo = null;

?>



