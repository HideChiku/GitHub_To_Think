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



//���̓f�[�^�폜
$id = '10';

$sql = "DELETE FROM NAMAE where ID=:delete_id";


//�i�G���[�����j���ł��Ȃ��D�K���G���[�ɂȂ��Ă��܂�

//if(!$res = $pdo->query($sql)){

//  echo "SQL���s���G���[";
//  exit;

//}

//////////////

$result = $pdo->prepare($sql);
$result->bindValue(':delete_id',$id,PDO::PARAM_INT);

$result->execute();



$pdo = null;

?>
