<?php //���o�^�폜

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



$flag = "kari";

$delete = "DELETE FROM userinfo2 WHERE flag=$flag";

$result = $pdo->query($delete);


$pdo = null;

?>
