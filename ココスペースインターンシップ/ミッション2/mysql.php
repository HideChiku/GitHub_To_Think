<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$link = mysql_connect('localhost', '�f�[�^�x�[�X��', '�p�X���[�h');
if (!$link) {
    die('�ڑ����s�ł��B'.mysql_error());
}

print('<p>�ڑ��ɐ������܂����B</p>');

// MySQL�ɑ΂��鏈��

$close_flag = mysql_close($link);

if ($close_flag){
    print('<p>�ؒf�ɐ������܂����B</p>');
}

?>
</body>
</html>