<?php //�폜�R�[�h_mission2-4

$delete = $_POST['delete'];


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
    fwrite($fp,"$delete<>�������܂���<>"."\n");
  }

 } //endforeach

 fclose($fp);
} //endif_res
} //endelse


?>


<html>
<form method = "post">
  <p>�폜�Ώ۔ԍ�:<input type = "text" name = "delete"></p>
  <input type = "submit" value = "�폜">
</form>
</html>





