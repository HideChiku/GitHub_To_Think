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


$pdo->query('SET NAMES utf8');



//���̓f�[�^�ҏW
$myname = 'chiku';
$comment = 'tennis player';
$id = '11';


$sql = "update NAMAE set name=:name , comment=:comment where ID=:ID";

//�i�G���[�����j���ł��Ȃ��D�K���G���[�ɂȂ��Ă��܂�

//if(!$res = $pdo->query($sql)){

//  echo "SQL���s���G���[";
//  exit;

//}

//////////////

$result = $pdo->prepare($sql);
$result->bindValue(':name',$myname,PDO::PARAM_STR);
$result->bindValue(':comment',$comment,PDO::PARAM_STR);
$result->bindValue(':ID',$id,PDO::PARAM_INT);

$result->execute();




$pdo = null;

?>
