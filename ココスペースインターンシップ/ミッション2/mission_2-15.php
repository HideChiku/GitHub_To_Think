<?php //�ҏW�R�[�h1_mission2-5

$edit = $_POST['edit'];

$PASS2 = $_POST['pass2'];

if(empty($edit)){
}else{

//mysql�ڑ�
$dbname = '�f�[�^�x�[�X��';
$host = 'localhost';
$user = '���[�U�[��';
$password = '�p�X���[�h';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $pdo = new PDO($dns, $user, $password);
    if ($pdo == null) {
        print_r('�ڑ����s').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}

$pdo->query('SET NAMES utf8');


//�f�[�^�ǂݍ���
$sql = "SELECT * FROM KEIJI";

$result = $pdo->query($sql);

foreach($result as $row){

  if($row['id'] == $edit){
    if($row['pass'] != $PASS2){
      echo "�p�X���[�h���Ԉ���Ă��܂�";
    }else{
      $T = $row['id'];
      $N = $row['name'];
      $C = $row['comment'];
    }
  }
}

$pdo = null;

}


?>




<?php //mysql�e�[�u���쐬�E�}���R�[�h+�ҏW�R�[�h2
$name = $_POST['name'];

$comment = $_POST['comment'];

$check = $_POST['check'];

$PASS = $_POST['password'];

if(empty($check)){  //mysql�e�[�u���쐬�E�}���R�[�h

//mysql�ڑ�
$dbname = '�f�[�^�x�[�X��';
$host = 'localhost';
$user = '���[�U�[��';
$password = '�p�X���[�h';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $pdo = new PDO($dns, $user, $password);
    if ($pdo == null) {
        print_r('�ڑ����s').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}

$pdo->query('SET NAMES utf8');

//�e�[�u���쐬
$sql_c = "CREATE TABLE IF NOT EXISTS `KEIJI`"
."("
."`id` INT auto_increment primary key,"
."`name` VARCHAR(100),"
."`comment` VARCHAR(200),"
."`date` VARCHAR(30),"
."`pass` VARCHAR(200)"
.");";


$stmt = $pdo -> prepare($sql_c);
$stmt -> execute();



 if(empty($name)){
  echo "���O�������͂ł�";
 }else{
  if(empty($comment)){
   echo "�R�����g�������͂ł�";
  }else{
   if(empty($PASS)){
    echo "�p�X���[�h�����ݒ�ł�";
   }else{

  //�f�[�^�}��

    $sql_i = "INSERT INTO KEIJI (id,name,comment,date,pass) VALUE ('',:name,:comment,now(),:pass)";

    $result = $pdo->prepare($sql_i);
    $result -> bindValue(':name',$name,PDO::PARAM_STR);
    $result -> bindValue(':comment',$comment,PDO::PARAM_STR);
    $result -> bindValue(':pass',$PASS,PDO::PARAM_STR);

    $result -> execute();

    $name = null;
    $comment = null;

   }
  }
 }

$pdo = null;












}else{  //�ҏW�R�[�h2

 if(empty($name)){
  echo "���O�������͂ł�";
  $T = $check;
 }else{
  if(empty($comment)){
   echo "�R�����g�������͂ł�";
   $T = $check;
  }else{
   if(empty($PASS)){
    echo "�p�X���[�h�����ݒ�ł�";
    $T = $check;
   }else{



//mysql�ڑ�
$dbname = '�f�[�^�x�[�X��';
$host = 'localhost';
$user = '���[�U�[��';
$password = '�p�X���[�h';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $pdo = new PDO($dns, $user, $password);
    if ($pdo == null) {
        print_r('�ڑ����s').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}

$pdo->query('SET NAMES utf8');


//�f�[�^�ҏW
$sql = "update KEIJI set name=:name , comment=:comment where id=:id";

//�i�G���[�����j���ł��Ȃ��D�K���G���[�ɂȂ��Ă��܂�

//if(!$res = $pdo->query($sql)){

//  echo "SQL���s���G���[";
//  exit;

//}

//////////////

$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':comment',$comment,PDO::PARAM_STR);
$result->bindValue(':id',$check,PDO::PARAM_INT);

$result->execute();



$name = null;
$comment = null;

$pdo = null;


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

 if('<script type ="text/javascript">document.write(res);</script>' == true){



//mysql�ڑ�
$dbname = '�f�[�^�x�[�X��';
$host = 'localhost';
$user = '���[�U�[��';
$password = '�p�X���[�h';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $pdo = new PDO($dns, $user, $password);
    if ($pdo == null) {
        print_r('�ڑ����s').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}

$pdo->query('SET NAMES utf8');

//�f�[�^�ǂݍ���
$sql = "SELECT * FROM KEIJI";

$result = $pdo->query($sql);

foreach($result as $row){
  if($row['id'] == $delete){
    if($row['pass'] != $PASS1){
      echo "�p�X���[�h���Ԉ���Ă��܂�"."<br>";
    }else{

//�f�[�^�폜(�ҏW)
$sql = "update KEIJI set name=:name where id=:id";

//�i�G���[�����j���ł��Ȃ��D�K���G���[�ɂȂ��Ă��܂�

//if(!$res = $pdo->query($sql)){

//  echo "SQL���s���G���[";
//  exit;

//}

//////////////

$name = 'deleted';

$result = $pdo->prepare($sql);
$result->bindValue(':name',$name,PDO::PARAM_STR);
$result->bindValue(':id',$delete,PDO::PARAM_INT);

$result->execute();

$name = null;

    }
  }

}


}

$pdo = null;

}




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



<?php //�G�R�[�R�[�h

//�ڑ�
$dbname = '�f�[�^�x�[�X��';
$host = 'localhost';
$user = '���[�U�[��';
$password = '�p�X���[�h';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $pdo = new PDO($dns, $user, $password);
    if ($pdo == null) {
        print_r('�ڑ����s').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}


$pdo->query('SET NAMES utf8');


//SELECT��

$sql = "SELECT * FROM KEIJI";

$result = $pdo->query($sql);

foreach($result as $row){

  if($row['name'] != 'deleted'){
    echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].'<br>';
  }
}


$pdo = null;

?>



