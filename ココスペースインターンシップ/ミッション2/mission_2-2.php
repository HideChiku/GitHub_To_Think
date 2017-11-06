<?php //txtファイル作成コード
$name = $_POST['name'];

$comment = $_POST['comment'];

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

?>


<html>

<form method = "post">
  <p>名前:<input type = "text" name = "name"></p>
  <p>コメント:<input type = "text" name = "comment"></p>
  <input type = "submit">
</form>

</html>


