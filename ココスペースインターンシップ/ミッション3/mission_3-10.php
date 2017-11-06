<html>

<h1>サークル内掲示板</h1>


<head>
<style>

body{
  background-color: steelblue;
}

label{
  margin-right: 10px;
  width: 140px;
  float: left;
}

.form1{
  background-color: white;
  margin: 0 auto;
  width: 420px;

  padding: 1em;
  border: 1px solid;
  border-radius: 1em;
}

.toko{
  background-color: white;
  margin: 0 auto;
  width: 400px;

  padding: 1em;
  border: 1px solid;
}

div{
  text-align: left;
}

.submit{
  text-align: center;
}

.thread{
  background-color: white;
  margin: 0 auto;
  width: 420px;

  padding: 1em;
  border: 1px solid;
  border-radius: 1em;
}

p{
 font-size: 14px;
}

h1{
text-align:center;
}
h3{
  text-align: center;
}

</style>
</head>


<form method = "post">
  <input type = "hidden" name = "logout" value = "logout">
  <div><input type = "submit" value = "ログアウト"></div>
</form>
<form method = "post">
  <input type = "hidden" name = "threaddef" value = "def">
  <input type = "submit" value = "スレッド選択">
</form>

</html>


<?php


//文字コード指定--------------------------------------------------
header("Content-Type: text/html; charset=UTF-8");



//ログアウトコード--------------------------------------------------
$logout = $_POST['logout'];

if($logout == "logout"){
 session_start();
 unset($_SESSION['username']);
 $logout = null;
 header("location: http://'ユーザー情報'/mission_3-7.php");
}



//sessionが空の場合，ログインページに飛ぶ-------------------------------

session_start();


if(empty($_SESSION['username'])){
 header("location: http://'ユーザー情報'/mission_3-7.php");
}


//編集コード1////////////////////////////////////////////////////////

$edit = $_POST['edit'];

session_start();
$session = $_SESSION['choice'];

$PASS2 = $_POST['pass2'];

if(!empty($edit)){

//mysql接続---------------------------------------------------------
$dbname = 'データベース名';
$host = 'localhost';
$user = 'ユーザー名';
$password = 'パスワード';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
 $pdo = new PDO($dns, $user, $password);
 if ($pdo == null) {print_r('接続失敗').PHP_EOL;}
}catch(PDOException $e){
 echo('Connection failed:'.$e->getMessage());
 die();
}

$pdo->query('SET NAMES utf8');


//データ読み込み-----------------------------------------------------
$sql = "SELECT * FROM `$session`";

$result = $pdo->query($sql);

if(!empty($session)){
 foreach($result as $row){

  if($row['id'] == $edit){
   if($row['pass'] != $PASS2){
    echo "<h3>"."パスワードが間違っています"."</h3>";
   }else{
    $T = $row['id'];
    $N = $row['name'];
    $G = $row['generation'];
    $S = $row['subject'];
    $M = $row['message'];
    $O = $row['opengeneration'];
   }
  }
 }//foreach
}
$pdo = null;

}
////////////////////////////////////////////////////////////////////////



//投稿コード+編集コード2//////////////////////////////////////////////
$name = $_POST['name'];
$gen = $_POST['generation'];
$sub = $_POST['subject'];
$mes = $_POST['message'];
$ogen = $_POST['opengeneration'];

//スレッド選択-------------------------------------------------------
$choice = $_POST['choice'];
$sinnki = $_POST['sinnki'];

session_start();

if(!empty($_POST['threaddef'])){
unset($_SESSION['choice']);
}

if(!empty($choice)){
$_SESSION['choice'] = $choice;
}

if(!empty($sinnki)){
$_SESSION['choice'] = $sinnki;
}

$session = $_SESSION['choice'];


//ファイルデータ変換-----------------------------------------------------
if(!empty($_FILES['upload']['name'])){


//バイナリデータ
$fp = fopen($_FILES['upload']['tmp_name'],'rb');
$filedata = fread($fp,filesize($_FILES['upload']['tmp_name']));
fclose($fp);


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

if(empty($check)){  //投稿コード//////////////////////////

//mysql接続------------------------------------------------
$dbname = 'データベース名';
$host = 'localhost';
$user = 'ユーザー名';
$password = 'パスワード';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
 $pdo = new PDO($dns, $user, $password);
 if ($pdo == null) {print_r('接続失敗').PHP_EOL;}
}catch(PDOException $e){
 echo('Connection failed:'.$e->getMessage());
 die();
}

$pdo->query('SET NAMES utf8');

//テーブル作成-----------------------------------------------
$sql_c = "CREATE TABLE IF NOT EXISTS `$session`"
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



 if(empty($sub) and !empty($name)){
  echo '<h3>'."件名が未入力です".'</h3>';
 }else if(empty($mes) and !empty($name)){
  echo '<h3>'."本文が未入力です".'</h3>';
 }else if(empty($PASS) and !empty($name)){
  echo '<h3>'."パスワードが未設定です".'</h3>';
 }else if(!empty($name)){

  //データ挿入-----------------------------------------------------------

    $sql_i = "INSERT INTO `$session` (id,name,generation,subject,message,opengeneration,filedata,mime,date,pass) VALUE ('',:name,:generation,:subject,:message,:opengeneration,:filedata,:mime,now(),:pass)";

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

$pdo = null;



}else{  //編集コード2//////////////////////////////////////////

 if(empty($sub) and !empty($name)){
  echo '<h3>'."件名が未入力です".'</h3>';
  $T = $check;
 }else if(empty($mes) and !empty($name)){
  echo '<h3>'."本文が未入力です".'</h3>';
  $T = $check;
 }else if(empty($PASS) and !empty($name)){
  echo '<h3>'."パスワードが未設定です".'</h3>';
  $T = $check;
 }else if(!empty($name)){


//mysql接続----------------------------------------------------
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


if(!empty($mime)){ //ファイルも編集する場合----------------------------
$sql = "update `$session` set name=:name,generation=:generation,subject=:subject,message=:message,opengeneration=:opengeneration,filedata=:filedata,mime=:mime,pass=:pass where id=:id";


$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':generation',$gen,PDO::PARAM_STR);
$result->bindValue(':subject',$sub,PDO::PARAM_STR);
$result->bindValue(':message',$mes,PDO::PARAM_STR);
$result->bindValue(':opengeneration',$ogen,PDO::PARAM_STR);
$result->bindValue(':pass',$PASS,PDO::PARAM_STR);
$result->bindValue(':id',$check,PDO::PARAM_INT);
$result -> bindValue(':filedata',$filedata,PDO::PARAM_LOB);
$result -> bindValue(':mime',$mime,PDO::PARAM_STR);

$result->execute();

}else{ //ファイルは維持する場合------------------------------------------
$sql = "update `$session` set name=:name,generation=:generation,subject=:subject,message=:message,opengeneration=:opengeneration,pass=:pass where id=:id";

$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':generation',$gen,PDO::PARAM_STR);
$result->bindValue(':subject',$sub,PDO::PARAM_STR);
$result->bindValue(':message',$mes,PDO::PARAM_STR);
$result->bindValue(':opengeneration',$ogen,PDO::PARAM_STR);
$result->bindValue(':pass',$PASS,PDO::PARAM_STR);
$result->bindValue(':id',$check,PDO::PARAM_INT);


$result->execute();
}


$name = null;
$gen = null;
$sub = null;
$mes = null;
$ogen = null;

$pdo = null;

 }
}//endelse
////////////////////////////////////////////////////////////////////////////////




//削除コード/////////////////////////////////////////////////////////////////////

$delete = $_POST['delete'];
$box = $_POST['filedel'];

session_start();
$session = $_SESSION['choice'];

$PASS1 = $_POST['pass1'];

if(!empty($delete)){

//mysql接続-------------------------------------------------
$dbname = 'データベース名';
$host = 'localhost';
$user = 'ユーザー名';
$password = 'パスワード';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
 $pdo = new PDO($dns, $user, $password);
 if ($pdo == null) {print_r('接続失敗').PHP_EOL;}
}catch(PDOException $e){
 echo('Connection failed:'.$e->getMessage());
 die();
}

$pdo->query('SET NAMES utf8');

//データ読み込み-----------------------------------------------
$sql = "SELECT * FROM `$session`";

$result = $pdo->query($sql);

if(!empty($session)){
 foreach($result as $row){
  if($row['id'] == $delete){
    if($row['pass'] != $PASS1){
      echo '<h3>'."パスワードが間違っています".'</h3>'."<br>";
    }else{

if(!empty($box)){ //ファイルのみ削除--------------------------

$sql = "update `$session` set mime=:mime where id=:id";

$mime = null;

$result = $pdo->prepare($sql);
$result->bindValue(':mime',$mime,PDO::PARAM_STR);
$result->bindValue(':id',$delete,PDO::PARAM_INT);

$result->execute();


}else{ //全て削除------------------------------------------------

$sql = "update `$session` set name=:name where id=:id";

$name = 'deleted';

$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':id',$delete,PDO::PARAM_INT);

$result->execute();

$name = null;

} //ファイル削除かどうかの分岐

    } //パスワード分岐
  } //id分岐

 } //foreach文

} //$session

$pdo = null;

}
//////////////////////////////////////////////////////////////////////////////////

?>

<html>

<form class="form1" method = "post">
  <h2>スレッド検索</h2>
  <div>
    <label for="thread">スレッド名</label>
    <input type = "text" name = "thread">
  </div></p>
  <div class="submit"><input type = "submit" value = "検索"></div>
</form>
</html>

<?php

//スレッド検索///////////////////////////////////////////////////////////////////////////////

$thread = $_POST['thread'];
$count = strlen($thread);

//mysql接続-------------------------------------------------------------------
$dbname = 'データベース名';
$host = 'localhost';
$user = 'ユーザー名';
$password = 'パスワード';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
 $pdo = new PDO($dns, $user, $password);
 if($pdo == null){print_r('接続失敗').PHP_EOL;}
}catch(PDOException $e){
 echo('Connection failed:'.$e->getMessage());
 die();
}

$pdo->query('SET NAMES utf8');

//テーブル一覧表示-------------------------------------------------------------
$sql_s = "SHOW TABLES";

$result = $pdo->query($sql_s);

if(empty($session)){

?>

<html>
<div class="thread">
<h2>表示スレッド選択</h2>
</html>

<?php
//スレッドボタン表示---------------------------------------------------------
foreach($result as $row){
  if($row[0] != "userinfo"){
    $refer = substr($row[0],0,$count);
    if($thread == $refer){

?>

<html>

<form class="form2" method = "post">
  <input type = "hidden" name = "choice" value = "<?php echo $row[0]; ?>">
  <input type = "submit" value = "<?php echo $row[0]; ?>">
</form>

</html>


<?php
    }
  }
}

?>

<html>
</div>
</html>

<?php

}

echo '<br><br>';


$pdo = null;

//////////////////////////////////////////////////////////////////////////////////////////////

?>


<html>
<form class="form1" method = "post" enctype = "multipart/form-data">
<h2>投稿フォーム</h2>
  <input type = "hidden" name = "check" value = "<?php echo $T; ?>">
  <div>
    <label for="sinnki">スレッド新規作成:</label>
    <input type = "text" name = "sinnki">
  </div></p>
  <div>
    <label for="name">名前:</label>
    <input type = "text" name = "name" value = "<?php echo $N; if(empty($N)){echo $_SESSION['username'];} ?>">
  </div></p>
  <div>
    <label for="generation">代:</label>
    <input type = "text" name = "generation" value = "<?php echo $G; if(empty($N)){echo $_SESSION['generation'];} ?>" placeholder = "半角数字入力">
  </div></p>
  <div>
    <label for="subject">件名:</label>
    <input type = "text" name = "subject" value = "<?php echo $S; ?>">
  </div></p>
  <div>
    <label for="message">本文:</label>
    <textarea name = "message" rows = "7"><?php echo $M; ?></textarea>
  </div></p>
  <div>
    <label for="upload">画像・動画:</label>
    <input type = "file" name = "upload">
  </div>
  <p>*編集時，ファイルを送信すると上書き保存します</p>
  <div>
    <label for="opengeneration">公開する代:</label>
    <input type = "text" name = "opengeneration" value = "<?php echo $O; ?>" placeholder = "半角数字入力">
  </div>
  <p>*空欄の場合，全ての代に公表します</p>
  <div>
    <label for="password">パスワード設定:</label>
    <input type = "text" name = "password">
  </div></p>
  <div class="submit"><input type = "submit"></div>
</form>



<form class="form1" method = "post">
  <div>
    <label for="delete">削除対象番号:</label>
    <input type = "text" name = "delete" placeholder = "半角数字入力">
  </div></p>
  <div>
    <label for="pass1">パスワード:</label>
    <input type = "text" name = "pass1">
  </div></p>
  <div>
    <input type = "checkbox" name = "filedel" value ="delete">
  </div>
  <p>*ファイルのみ削除</p>
  <div class="submit"><input type = "submit" value = "削除" onclick="return RunConfirm();"></div>
</form>



<form class="form1" method = "post">
  <div>
    <label for="edit">編集対象番号:</label>
    <input type = "text" name = "edit" placeholder = "半角数字入力">
  </div></p>
  <div>
    <label for="pass2">パスワード:</label>
    <input type = "text" name = "pass2">
  </div></p>
  <div class="submit"><input type = "submit" value = "編集"></div>
</form>
</html>



<?php

//エコーコード///////////////////////////////////////////////////////////////////////////////////

session_start();
$session = $_SESSION['choice'];

//接続----------------------------------------------------------
$dbname = 'データベース名';
$host = 'localhost';
$user = 'ユーザー名';
$password = 'パスワード';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
 $pdo = new PDO($dns, $user, $password);
 if ($pdo == null){print_r('接続失敗').PHP_EOL;}
}catch(PDOException $e){
 echo('Connection failed:'.$e->getMessage());
 die();
}


$pdo->query('SET NAMES utf8');

if(!empty($session)){
//SELECT文 ページ送りのためのページ番号振り--------------------------------------------------
$sql = "SELECT * FROM `$session` ORDER BY id DESC";

$result = $pdo->query($sql);

$cnt = 0;
foreach($result as $row){
$cnt = ++$cnt;
}

$maxPage = ceil($cnt/10);

//--------------------------------------------------------------
//ページング処理
//--------------------------------------------------------------
$page = $_REQUEST['page'];
  //----------指定がなければ$pageは１---------------
if ($page == "" ) {
$page = 1;
}
  //----------$pageが１より小さい場合は１-----------
$page = max($page, 1);

$offset = 10*($page - 1);

//SELECT文--------------------------------------------------------------------------------
$sql = "SELECT * FROM `$session` ORDER BY id DESC LIMIT 10 OFFSET $offset";

$result = $pdo->query($sql);

echo '<br><br><br><br>';

$i = 0;

  echo '<h1>'."$session".'</h1>';

foreach($result as $row){
  if($row['name'] != 'deleted'){
   $checkgen = $_SESSION['generation'];
   $checkogen = $row['opengeneration'];

   if($checkgen == $checkogen or empty($checkogen)){
    echo '<DIV class="toko">'.$row['id'].','.$row['name'].','.$row['generation'].'代'.'<br>'.'</DIV>';
    echo '<DIV class="toko">'.$row['subject'].'<br>'.'</DIV>';
    $content = $row['message'];
    $content = nl2br($content);
    echo '<DIV class="toko">'.$content.'<br>'.'</DIV>';

    if(!empty($row['mime'])){
      $id = $row['id'];
      $mime = substr($row['mime'],0,1);
      if($mime == "i"){
        echo '<DIV class="toko">'.'<img src="http://'ユーザー情報'/create_file.php?id='.$id.'"width="350" />'.'</DIV>';
        echo '<br>';
      }else if($mime == "v"){
        echo '<DIV class="toko">'.'<video src="http://'ユーザー情報'/create_file.php?id='.$id.'"width="350" controls preload></video>'.'</DIV>';
        echo '<br>';
      }
    }else{echo '<br>';}
   }
    $i = ++$i;
  }
} //endforeach

} //emptyセッション
////////////////////////////////////////////////////////////////////////////////////////////////////////


//テーブル削除/////////////////////////////////////////////////////////////////////////////////////////
if($i == 0){

$sql = "DROP TABLE IF EXISTS `$session`";

$tabledelete = $pdo->exec($sql);

}

$pdo = null;
////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<script type = "text/javascript">
function RunConfirm(){
  if(window.confirm("本当に削除しますか？")){
    return true;
  }else{
    window.alert('キャンセルされました');
    return false;
  }
}
</script>

<?php

//ページ送りフォーム////////////////////////////////////////////////////////////////////////////////////////

if($page > 1 ) {
?>
<a href="mission_3-10.php?page=<?php print($page - 1); ?>">前のページ</a>
<?php
}else{
?>
<!-- 前のページ -->
<?php
}
?>
&nbsp&nbsp&nbsp&nbsp

<?php
for($a = 1; $a <= $maxPage ; $a++){
  echo "<a href="."mission_3-10.php?page=".$a.">".$a."</a>"."&nbsp";
}
?>

<?php
if ($page < $maxPage ){
?>　　
<a href="mission_3-10.php?page=<?php print($page + 1); ?>">次のページ</a>
<?php
}else{
?>
<!-- 次のページ -->
<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

