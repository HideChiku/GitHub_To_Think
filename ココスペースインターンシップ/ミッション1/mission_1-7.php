<?php

//�e�L�X�g�t�@�C����ǂݍ���ŕ\��������;

$fp = fopen("kadai6.txt",'r');  //txt�t�@�C����ǂݍ��ݗp�ɊJ��

while ($line = fgets($fp)){
   echo "$line<br/>";
}

fclose($fp);

?>