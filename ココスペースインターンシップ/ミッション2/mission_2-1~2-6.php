<?php //�ҏW�R�[�h1_mission2-5

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
    echo "�p�X���[�h���Ԉ���Ă��܂�";
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


<?php //txt�t�@�C���쐬�R�[�h+�ҏW�R�[�h2_mission2-1 and 2-5
$name = $_POST['name'];
//$name = mb_convert_encoding($name, "Shift_JIS", "HTML-ENTITIES");

$comment = $_POST['comment'];
//$comment = mb_convert_encoding($comment, "Shift_JIS", "HTML-ENTITIES");

$check = $_POST['check'];

$PASS = $_POST['password'];

if(empty($check)){  //txt�t�@�C���쐬�R�[�h

 $filename = 'kadai2-2.txt';

 $fp = fopen($filename,'a+');

 for($count = 0; fgets( $fp ); $count++ );

 if(empty($name)){
  fclose($fp);
  echo "���O�������͂ł�";
 }else{
  if(empty($comment)){
   fclose($fp);
   echo "�R�����g�������͂ł�";
  }else{
   if(empty($PASS)){
    fclose($fp);
    echo "�p�X���[�h�����ݒ�ł�";
   }else{
    $i = $count+1;

    $d = date("H��i��s�b");
    fwrite($fp,"{$i}<>{$name}<>{$comment}<>{$d}<>{$PASS}<>"."\n");

    fclose($fp);

    $name = null;
    $comment = null;

   }
  }
 }
//require('mission_2-3.php');

}else{  //�ҏW�R�[�h2

 if(empty($name)){
  //fclose($fp);
  echo "���O�������͂ł�";
  $T = $check;
 }else{
  if(empty($comment)){
   //fclose($fp);
   echo "�R�����g�������͂ł�";
   $T = $check;
  }else{
   if(empty($PASS)){
    //fclose($fp);
    echo "�p�X���[�h�����ݒ�ł�";
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

   $d = date("H��i��s�b");
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


<?php //�폜�R�[�h_mission2-4

$delete = $_POST['delete'];

$PASS1 = $_POST['pass1'];

if(empty($delete)){
}else{

?>

<script type = "text/javascript">
 var res = confirm("�{���ɍ폜���܂����H");
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
    echo "�p�X���[�h���Ԉ���Ă��܂�"."<br>";
    //fwrite($fp,"$delete<> �������܂���"."\n");
   }else{
    //fwrite($fp,"$value");
    //echo "�p�X���[�h���Ԉ���Ă��܂�",$PASS1,$A[4]."<br>";
    fwrite($fp,"$delete<>�������܂���<>"."\n");
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
  <p>���O:<input type = "text" name = "name" value = "<?php echo $N; ?><?php echo $name ?>"></p>
  <p>�R�����g:<input type = "text" name = "comment" value = "<?php echo $C; ?><?php echo $comment ?>"></p>
  <p>�p�X���[�h�ݒ�:<input type = "text" name = "password"></p>
  <input type = "submit">
</form>

<form method = "post">
  <p>�폜�Ώ۔ԍ�:<input type = "text" name = "delete"></p>
  <p>�p�X���[�h:<input type = "text" name = "pass1"></p>
  <input type = "submit" value = "�폜">
</form>

<form method = "post">
  <p>�ҏW�Ώ۔ԍ�:<input type = "text" name = "edit"></p>
  <p>�p�X���[�h:<input type = "text" name = "pass2"></p>
  <input type = "submit" value = "�ҏW">
</form>
</html>




<?php //echo�R�[�h_mission2-2

//require('mission_2-1.php');


$filename = 'kadai2-2.txt';

//$fp = fopen($filename,'r');

$F = file($filename);

foreach($F as $value){

 $A = explode("<>","$value");

 //echo $A[1]."<br>";

 if($A[1] != "�������܂���"){  //�u���E�U�ɂ͍폜�s��\�������Ȃ��悤�ɂ��������ł��Ȃ�
  echo $A[0],"&nbsp",$A[1],"&nbsp",$A[2],"&nbsp",$A[3]."<br>";
 }
}

//fclose($fp);

?>