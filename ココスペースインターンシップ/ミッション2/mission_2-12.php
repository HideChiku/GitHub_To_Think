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



//���̓f�[�^�m�F
$sql = "SELECT * FROM NAMAE";

$result = $pdo->query($sql);

foreach($result as $row){

  echo $row['ID'].','.$row['name'].','.$row['comment'].'<br>';

}


$pdo = null;

?>
