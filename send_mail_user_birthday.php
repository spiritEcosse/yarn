<?php
include('index.php');
include('catalog/controller/account/birthday.php');

$cls = new ControllerAccountBirthday($registry);
$cls->sendMailCustomersBirthday();

?>