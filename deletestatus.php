<?php
session_start();
require 'CLASSES/user.php';
if (isset($_GET['active'])) {
    $user=new user();
    $user->active($_GET['active'],$_SESSION['USER_ID']);
  return;
}
if (isset($_GET['check'])) {
    $user=new user();
  echo  $user->checkactive($_GET['check']);
  return;
}
    $user=new user();
    $user->deletestatus();
?>