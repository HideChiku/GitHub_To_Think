<?php


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

//�����R�[�h�w��
$moji = $pdo->query('SET NAMES utf8');



//�f�[�^����
$myname = '�G�N';
$comment = 'tennis';

$sql = "INSERT INTO NAMAE (ID,name,comment) VALUE ('',:name,:comment)";

$result = $pdo->prepare($sql);
$result -> bindValue(':name',$myname,PDO::PARAM_STR);
$result -> bindValue(':comment',$comment,PDO::PARAM_STR);

$result -> execute();




$pdo = null;

?>
