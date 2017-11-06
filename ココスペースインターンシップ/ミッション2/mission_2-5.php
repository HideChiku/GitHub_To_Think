<?php //編集コード1_mission2-5

$edit = $_POST['edit'];


if(empty($edit)){
}else{

 $filename = 'kadai2-2.txt';

 $F = file($filename);

 //$fp = fopen($filename,'w+');

 foreach( $F as $value){

  $A = explode("<>","$value");

  if($A[0] == $edit){
    $T = $A[0];
    $N = $A[1];
    $C = $A[2];
  }
 } //endforeach

 //fclose($fp);

} //endelse


?>


<?php //txtファイル作成コード+編集コード2_mission2-1 and 2-5
$name = $_POST['name'];

$comment = $_POST['comment'];

$check = $_POST['check'];

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
    $i = $count+1;

    $d = date("H時i分s秒");
    fwrite($fp,"{$i}<>{$name}<>{$comment}<>{$d}<>{$PASS}<>"."\n");

    fclose($fp);

    $name = null;
    $comment = null;
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
}//endelse

?>


<html>
<form method = "post">
  <input type = "hidden" name = "check" value = "<?php echo $T; ?>">
  <p>名前:<input type = "text" name = "name" value = "<?php echo $N; ?><?php echo $name ?>"></p>
  <p>コメント:<input type = "text" name = "comment" value = "<?php echo $C; ?><?php echo $comment ?>"></p>
  <input type = "submit">
</form>

<form method = "post">
  <p>編集対象番号:<input type = "text" name = "edit"></p>
  <input type = "submit" value = "編集">
</form>
</html>

