<?php

$dbname = '�f�[�^�x�[�X��';
$host = 'localhost';
$user = '���[�U�[��';
$password = '�p�X���[�h';

$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $dbh = new PDO($dns, $user, $password);
    if ($dbh == null) {
        print_r('�ڑ����s').PHP_EOL;
    } else {
        print_r('�ڑ�����').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}


?>
