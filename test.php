<?php

$uname='admin';
$password = password_hash($uname, PASSWORD_DEFAULT);

echo $password;

?>