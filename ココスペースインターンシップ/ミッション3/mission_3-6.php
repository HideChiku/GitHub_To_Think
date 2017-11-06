<html>

<h1>サークル内掲示板</h1>
<h3>ユーザー登録</h3>

<style>
h1{
 text-align:center;
}
h3{
 text-align:center;
 font-size:22px;
}
</style>

</html>


<?php //テーブルを作成し，登録情報を保存
$name = $_POST['name'];
$gen = $_POST['generation'];
$pass = $_POST['password'];
$mail = $_POST['address'];
$check = $_POST['okuttayo'];

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
$sql_c = "CREATE TABLE IF NOT EXISTS `userinfo`"
."("
."`id` INT auto_increment primary key,"
."`name` VARCHAR(100),"
."`generation` VARCHAR(200),"
."`pass` VARCHAR(200),"
."`mail` VARCHAR(200),"
."`flag` VARCHAR(200),"
."`date` VARCHAR(30),"
."`autoID` VARCHAR(200)"
.");";


$stmt = $pdo -> prepare($sql_c);
$stmt -> execute();

if(!empty($check)){

if(empty($name)){
  echo "<h2>"."名前が未入力です"."</h2>";
}else{
if(empty($gen)){
  echo "<h2>"."代が未入力です"."</h2>";
}else{
if(empty($pass)){
  echo "<h2>"."パスワードが未入力です"."</h2>";
}else{
if(empty($mail)){
  echo "<h2>"."メールアドレスが未入力です"."</h2>";
}else{


//データ挿入
$sql_i = "INSERT INTO userinfo (id,name,generation,pass,mail,flag,date,autoID) VALUE ('',:name,:generation,:pass,:mail,:flag,now(),:autoID)";

$flag = "kari";
$autoID = date("Ymd").md5(uniqid(microtime(),1)).getmypid().".gif";

$result = $pdo->prepare($sql_i);
$result -> bindValue(':name',$name,PDO::PARAM_STR);
$result -> bindValue(':generation',$gen,PDO::PARAM_STR);
$result -> bindValue(':pass',$pass,PDO::PARAM_STR);
$result -> bindValue(':mail',$mail,PDO::PARAM_STR);
$result -> bindValue(':flag',$flag,PDO::PARAM_STR);
$result -> bindValue(':autoID',$autoID,PDO::PARAM_STR);

$result -> execute();


//メール送信
$to = $mail;
$subject = "メール認証";
$message = "管理人：知久秀康"."\n"."掲示板のユーザー登録確認です"."\n"."正しければ下記のURLをクリックしてください"."\n"."http://co-714.it.99sv-coco.com/mission_3-9.php?id=$autoID";
$headers = "From: chikuhideyasudayo@example.com";

mail($to,$subject,$message,$headers);

echo "$mail".'宛に確認メールを送信しました．';




$name = null;
$gen = null;
$pass = null;
$mail = null;

}//入力確認
}//入力確認
}//入力確認
}//入力確認
}

?>


<html>

<form method = "post">
  <div>
    <label for="name">名前:</label>
    <input type = "text" name = "name">
  </div></p>
  <div>
    <label for="generation">代:</label>
    <input type = "text" name = "generation" placeholder = "半角数字入力">代
  </div></p>
  <div>
    <label for="password">パスワード:</label>
    <input type = "text" name = "password">
  </div></p>
  <div>
    <label for="address">メールアドレス:</label>
    <input type = "text" name = "address">
  </div></p>
    <input type = "hidden" name = "okuttayo" value = "ok">
    <input type = "submit">
</form>

<style>
body{
  background-color: steelblue;
}

h2{
  text-align: center;
  font-size: 18px;
}

form{
  text-align: center;
  margin: 0 auto;
  width: 400px;

}

label{
  margin-right: 10px;
  width: 120px;
  float: left;

}

div{
  text-align: left;
}

</style>


</html>


<?php //登録情報エコー

$sql = "SELECT * FROM userinfo";

$result = $pdo->query($sql);

foreach($result as $row){

if($autoID == $row['autoID']){
  echo "登録情報(仮登録)".'<br>';
  echo "名前:".$row['name'].'<br>';
  echo "代:".$row['generation'].'<br>';
  echo "メールアドレス:".$row['mail'].'<br>';
  echo "ID:".$row['autoID'].'<br>';
}

}


$pdo = null;

?>

