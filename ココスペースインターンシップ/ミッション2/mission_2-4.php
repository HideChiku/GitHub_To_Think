<?php //削除コード_mission2-4

$delete = $_POST['delete'];


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
    fwrite($fp,"$delete<>消去しました<>"."\n");
  }

 } //endforeach

 fclose($fp);
} //endif_res
} //endelse


?>


<html>
<form method = "post">
  <p>削除対象番号:<input type = "text" name = "delete"></p>
  <input type = "submit" value = "削除">
</form>
</html>





