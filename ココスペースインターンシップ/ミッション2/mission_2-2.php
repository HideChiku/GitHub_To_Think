<?php //txt�t�@�C���쐬�R�[�h
$name = $_POST['name'];

$comment = $_POST['comment'];

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
    $i = $count+1;

    $d = date("H��i��s�b");
    fwrite($fp,"{$i}<>{$name}<>{$comment}<>{$d}<>{$PASS}<>"."\n");

    fclose($fp);

    $name = null;
    $comment = null;

  }
}

?>


<html>

<form method = "post">
  <p>���O:<input type = "text" name = "name"></p>
  <p>�R�����g:<input type = "text" name = "comment"></p>
  <input type = "submit">
</form>

</html>


