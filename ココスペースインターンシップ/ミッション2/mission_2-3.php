<html>

<form method = "post">
  <p>���O:<input type = "text" name = "name"></p>
  <p>�R�����g:<input type = "text" name = "comment"></p>
  <input type = "submit">
</form>

</html>


<?php //echo�R�[�h

$filename = 'kadai2-2.txt';

$F = file($filename);

foreach($F as $value){

  $A = explode("<>","$value");

  if($A[1] != "�������܂���"){
    echo $A[0],"&nbsp",$A[1],"&nbsp",$A[2],"&nbsp",$A[3]."<br>";
  }
}

?>



