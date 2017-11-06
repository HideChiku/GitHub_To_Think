<html>

<h1>サークル内掲示板</h1>
<style>
h1{
color:blue;
text-align:center;
}
</style>

</html>

<html>
<form method = "post">
  <input type = "hidden" name = "logout" value = "logout">
  <input type = "submit" value = "ログアウト">
</form>
</html>


<?php //ログアウト用

$logout = $_POST['logout'];

if($logout == "logout"){
session_start();
unset($_SESSION['username']);
$logout = null;
header("location: http://'ユーザー情報'/mission_3-7.php");
}

?>


<?php //sessionが空の場合，ログインページに飛ぶ


session_start();


if(empty($_SESSION['username'])){
  //header("location: http://'ユーザー情報'/mission_3-7.php");
}

?>



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
$sql = "SELECT * FROM KEIJI3";

$result = $pdo->query($sql);

foreach($result as $row){

  if($row['id'] == $edit){
    if($row['pass'] != $PASS2){
      echo "パスワードが間違っています";
    }else{
      $T = $row['id'];
      $N = $row['name'];
      $G = $row['generation'];
      $S = $row['subject'];
      $M = $row['message'];
      $O = $row['opengeneration'];
    }
  }
}

$pdo = null;

}


?>




<?php //mysqlテーブル作成・挿入コード+編集コード2
$name = $_POST['name'];
$gen = $_POST['generation'];
$sub = $_POST['subject'];
$mes = $_POST['message'];
$ogen = $_POST['opengeneration'];

if(!empty($_FILES['upload'])){

//バイナリデータ
$fp = fopen($_FILES['upload']['tmp_name'],'rb');
$filedata = fread($fp,filesize($_FILES['upload']['tmp_name']));
fclose($fp);
//$filedata = addslashes($filedata);

//echo $_FILES['upload']['tmp_name'];
//if(empty($filedata)){echo 'empty';}else{echo 'in';}


//拡張子
$dat = pathinfo($_FILES['upload']['name']);
$extension = $dat['extension'];

//MIMEタイプ
if($extension == "jpg" || $extension == "jpeg" ){
  $mime = "image/jpeg";
}else if( $extension == "gif" ){
  $mime = "image/gif";
}else if( $extension == "png" || $extension == "PNG"){
  $mime = "image/png";
}else if( $extension == "mp4" ){
  $mime = "video/mp4";
}else if( $extension == "mpg" || $extension == "mpeg"){
  $mime = "video/mpeg";
}

}


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
$sql_c = "CREATE TABLE IF NOT EXISTS `KEIJI11`"
."("
."`id` INT auto_increment primary key,"
."`name` VARCHAR(100),"
."`generation` VARCHAR(200),"
."`subject` VARCHAR(200),"
."`message` TEXT,"
."`opengeneration` VARCHAR(200),"
."`filedata` MEDIUMBLOB,"
."`mime` VARCHAR(64),"
."`date` VARCHAR(30),"
."`pass` VARCHAR(200)"
.") DEFAULT CHARSET=utf8 ;";


$stmt = $pdo -> prepare($sql_c);
$stmt -> execute();



 if(empty($sub)){
  echo "件名が未入力です";
 }else{
  if(empty($mes)){
   echo "本文が未入力です";
  }else{
   if(empty($PASS)){
    echo "パスワードが未設定です";
   }else{

  //データ挿入

    $sql_i = "INSERT INTO KEIJI11 (id,name,generation,subject,message,opengeneration,filedata,mime,date,pass) VALUE ('',:name,:generation,:subject,:message,:opengeneration,:filedata,:mime,now(),:pass)";

    $result = $pdo->prepare($sql_i);
    $result -> bindValue(':name',$name,PDO::PARAM_STR);
    $result -> bindValue(':generation',$gen,PDO::PARAM_STR);
    $result -> bindValue(':subject',$sub,PDO::PARAM_STR);
    $result -> bindValue(':message',$mes,PDO::PARAM_STR);
    $result -> bindValue(':opengeneration',$ogen,PDO::PARAM_STR);
    $result -> bindValue(':filedata',$filedata,PDO::PARAM_LOB);
    $result -> bindValue(':mime',$mime,PDO::PARAM_STR);
    $result -> bindValue(':pass',$PASS,PDO::PARAM_STR);

    $result -> execute();

    $name = null;
    $gen = null;
    $sub = null;
    $mes = null;
    $ogen = null;

   }
  }
 }

$pdo = null;












}else{  //編集コード2

 if(empty($sub)){
  echo "件名が未入力です";
  $T = $check;
 }else{
  if(empty($mes)){
   echo "本文が未入力です";
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
$sql = "update KEIJI3 set name=:name,generation=:generation,subject=:subject,message=:message,opengeneration=:opengeneration,pass=:pass where id=:id";

//（エラー処理）ができない．必ずエラーになってしまう

//if(!$res = $pdo->query($sql)){

//  echo "SQL実行時エラー";
//  exit;

//}

//////////////

$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':generation',$gen,PDO::PARAM_STR);
$result->bindValue(':subject',$sub,PDO::PARAM_STR);
$result->bindValue(':message',$mes,PDO::PARAM_STR);
$result->bindValue(':opengeneration',$ogen,PDO::PARAM_STR);
$result->bindValue(':pass',$PASS,PDO::PARAM_STR);
$result->bindValue(':id',$check,PDO::PARAM_INT);

$result->execute();



$name = null;
$gen = null;
$sub = null;
$mes = null;
$ogen = null;

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
$sql = "SELECT * FROM KEIJI3";

$result = $pdo->query($sql);

foreach($result as $row){
  if($row['id'] == $delete){
    if($row['pass'] != $PASS1){
      echo "パスワードが間違っています"."<br>";
    }else{

//データ削除(編集)
$sql = "update KEIJI3 set name=:name where id=:id";

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
<form method = "post" enctype = "multipart/form-data">

<style>
form{
  margin: 0 auto;
  width: 400px;

  padding: 1em;
  border: 1px solid;
  border-radius: 1em;
}
</style>

  <input type = "hidden" name = "check" value = "<?php echo $T; ?>">
  <div>
    <label for="name">名前:</label>
    <input type = "text" name = "name" value = "<?php echo $N; if(empty($N)){echo $_SESSION['username'];} ?>">
  </div>
  <div>
    <label for="generation">代:</label>
    <input type = "text" name = "generation" value = "<?php echo $G; if(empty($N)){echo $_SESSION['generation'];} ?>">
  </div>
  <div>
    <label for="subject">件名:</label>
    <input type = "text" name = "subject" value = "<?php echo $S; ?>">
  </div>
  <div>
    <label for="message">本文:</label>
    <textarea name = "message" rows = "7"><?php echo $M; ?></textarea>
  </div>
  <div>
    <label for="upload">画像・動画</label>
    <input type = "file" name = "upload">
  </div>
  <div>
    <label for="opengeneration">公開する代:</label>
    <input type = "text" name = "opengeneration" value = "<?php echo $O; ?>">
  </div>
  <div>
    <label for="password">パスワード設定:</label>
    <input type = "text" name = "password"></p>
  </div>
  <input type = "submit">

</form>

<form method = "post">
  <div>
    <label for="delete">削除対象番号:</label>
    <input type = "text" name = "delete">
  </div>
  <div>
    <label for="pass1">パスワード:</label>
    <input type = "text" name = "pass1">
  </div>
  <input type = "submit" value = "削除">
</form>

<form method = "post">
  <div>
    <label for="edit">編集対象番号:</label>
    <input type = "text" name = "edit">
  </div>
  <div>
    <label for="pass2">パスワード:</label>
    <input type = "text" name = "pass2">
  </div>
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

$sql = "SELECT * FROM KEIJI11";

$result = $pdo->query($sql);

foreach($result as $row){

  if($row['name'] != 'deleted'){
    echo $row['id'].','.$row['name'].','.$row['generation'].','.$row['subject'].','.$row['message'].','.$row['opengeneration'].','.$row['mime'].','.$row['date'].'<br>';
    if(!empty($row['mime'])){
      $id = $row['id'];
      $mime = substr($row['mime'],0,1);
      if($mime == "i"){
        echo '<img src="http://'ユーザー情報'/create_file.php?id='.$id.'"width="300" />';
      }else if($mime == "v"){
        echo '<video src="http://'ユーザー情報'/create_file.php?id='.$id.'"width="300" controls preload></video>';
      }
    }
  }
}



$pdo = null;

?>



