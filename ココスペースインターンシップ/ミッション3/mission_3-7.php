<html>

<h1>サークル内掲示板</h1>
<h3>ログインフォーム</h3>

<style>
h1{
 text-align:center;
}
h3{
 text-align:center;
 font-size: 22px;
}

</style>

</html>

<?php //ログイン後，掲示板のphpへ飛ぶ

$id = $_POST['id'];
$pass = $_POST['pass'];


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


//参照
$sql = "SELECT * FROM userinfo";

$result = $pdo->query($sql);

if(!empty($id)){

foreach($result as $row){

if($id == $row['autoID']){
  if($pass == $row['pass']){
    if($row['flag'] == "honto"){

    session_start();
    $_SESSION['username'] = $row['name'];
    $_SESSION['generation'] = $row['generation'];
    header("location: http://'ユーザー情報'/mission_4-1(3-10).php");
    //echo $row['generation'];

    }else{
    echo "<h2>"."仮登録状態です"."</h2>";
    }
  }else{
    echo "<h2>"."パスワードが間違っています"."</h2>";
  }
}else{
  echo "<h2>"."IDが間違っています"."</h2>";
}
}
}
?>




<html>

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
  width: 100px;
  float: left;

}

div{
  text-align: left;
}

</style>


<form method = "post">
  <div>
    <label for="id">ID:</label>
    <input type = "text" name = "id"></p>
  </div>
  <div>
    <label for="pass">パスワード:</label>
    <input type = "text" name = "pass"></p>
  </div>
  <input type = "submit" value = "ログイン">
</form>

</html>


