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
    } else {
        print_r('�ڑ�����').PHP_EOL;
    }


} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}


//�e�[�u���쐬
$sql_c = "CREATE TABLE IF NOT EXISTS `NAMAE`"
."("
."`ID` INT auto_increment primary key,"
."`name` VARCHAR(100),"
."`comment` VARCHAR(200)"
.");";


$stmt = $pdo -> prepare($sql_c);
$stmt -> execute();



$pdo = null;

?>
