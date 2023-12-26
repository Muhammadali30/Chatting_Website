<?php
require 'CLASSES/user.php';
session_start();
if(isset($_GET['msg'])){
	$user=new user();
   $user->chatting($_GET['msg'],$_SESSION['USER_ID'],$_SESSION['chatroom']);
}
?>