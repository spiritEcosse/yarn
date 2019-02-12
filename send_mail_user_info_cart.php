<?php
include('index.php');
include('catalog/controller/account/customer_support.php');

$cls = new ControllerAccountCustomerSupport($registry);
$cls->sendMailCustomersInfoCart();

?>