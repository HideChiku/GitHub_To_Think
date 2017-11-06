<?php //編集コード1_mission2-5

$edit = $_POST['edit'];

$PASS2 = $_POST['pass2'];

if(empty($edit)){
}else{

 $filename = 'kadai2-2.txt';

 $F = file($filename);

 //$fp = fopen($filename,'w+');

 foreach( $F as $value){

  $A = explode("<>","$value");

  if($A[0] == $edit){
   if($A[4] != $PASS2){
    echo "パスワードが間違っています";
   }else{
    $T = $A[0];
    $N = $A[1];
    $C = $A[2];
   }
  }
 } //endforeach

 //fclose($fp);

} //endelse


?>


<?php //txtファイル作成コード+編集コード2_mission2-1 and 2-5
$name = $_POST['name'];
//$name = mb_convert_encoding($name, "Shift_JIS", "HTML-ENTITIES");

$comment = $_POST['comment'];
//$comment = mb_convert_encoding($comment, "Shift_JIS", "HTML-ENTITIES");

$check = $_POST['check'];

$PASS = $_POST['password'];

if(empty($check)){  //txtファイル作成コード

 $filename = 'kadai2-2.txt';

 $fp = fopen($filename,'a+');

 for($count = 0; fgets( $fp ); $count++ );

 if(empty($name)){
  fclose($fp);
  echo "名前が未入力です";
 }else{
  if(empty($comment)){
   fclose($fp);
   echo "コメントが未入力です";
  }else{
   if(empty($PASS)){
    fclose($fp);
    echo "パスワードが未設定です";
   }else{
    $i = $count+1;

    $d = date("H時i分s秒");
    fwrite($fp,"{$i}<>{$name}<>{$comment}<>{$d}<>{$PASS}<>"."\n");

    fclose($fp);

    $name = null;
    $comment = null;

   }
  }
 }
//require('mission_2-3.php');

}else{  //編集コード2

 if(empty($name)){
  //fclose($fp);
  echo "名前が未入力です";
  $T = $check;
 }else{
  if(empty($comment)){
   //fclose($fp);
   echo "コメントが未入力です";
   $T = $check;
  }else{
   if(empty($PASS)){
    //fclose($fp);
    echo "パスワードが未設定です";
    $T = $check;
   }else{

 $filename = 'kadai2-2.txt';

 $F = file($filename);

 $fp = fopen($filename,'w+');

 foreach( $F as $value){

  $A = explode("<>","$value");

  if($A[0] != $check){
   fwrite($fp,"$value");
  }else{

   $d = date("H時i分s秒");
   fwrite($fp,"{$check}<>{$name}<>{$comment}<>{$d}<>{$PASS}<>"."\n");
  }

 }

 fclose($fp);

 $name = null;
 $comment = null;

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

 //echo '<script type ="text/javascript">document.write(res);</script>';

 if('<script type ="text/javascript">document.write(res);</script>' == true){

 $filename = 'kadai2-2.txt';

 $F = file($filename);

 $fp = fopen($filename,'w+');

 foreach( $F as $value){

  $A = explode("<>","$value");

  if($A[0] != $delete){
   fwrite($fp,"$value");
  }else{
   if($A[4] != $PASS1){
    fwrite($fp,"$value");
    echo "パスワードが間違っています"."<br>";
    //fwrite($fp,"$delete<> 消去しました"."\n");
   }else{
    //fwrite($fp,"$value");
    //echo "パスワードが間違っています",$PASS1,$A[4]."<br>";
    fwrite($fp,"$delete<>消去しました<>"."\n");
   }
  }

 } //endforeach

 fclose($fp);
} //endif_res
} //endelse


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




<?php //echoコード_mission2-2

//require('mission_2-1.php');


$filename = 'kadai2-2.txt';

//$fp = fopen($filename,'r');

$F = file($filename);

foreach($F as $value){

 $A = explode("<>","$value");

 //echo $A[1]."<br>";

 if($A[1] != "消去しました"){  //ブラウザには削除行を表示させないようにしたいができない
  echo $A[0],"&nbsp",$A[1],"&nbsp",$A[2],"&nbsp",$A[3]."<br>";
 }
}

//fclose($fp);

?>