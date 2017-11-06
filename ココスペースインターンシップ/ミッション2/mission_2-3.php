<html>

<form method = "post">
  <p>名前:<input type = "text" name = "name"></p>
  <p>コメント:<input type = "text" name = "comment"></p>
  <input type = "submit">
</form>

</html>


<?php //echoコード

$filename = 'kadai2-2.txt';

$F = file($filename);

foreach($F as $value){

  $A = explode("<>","$value");

  if($A[1] != "消去しました"){
    echo $A[0],"&nbsp",$A[1],"&nbsp",$A[2],"&nbsp",$A[3]."<br>";
  }
}

?>



