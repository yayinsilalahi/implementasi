<?php

include 'logout2.php';

$logout = new Logout();
$logout->execute();

header($logout->getHeaders()[0]);
exit();
