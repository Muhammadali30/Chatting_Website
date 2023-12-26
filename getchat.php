<?php
require 'CLASSES/user.php';
session_start();
if(isset($_SESSION['chatroom'])){
    if(isset($_GET['lid'])){
        $user=new user();
        $cht= $user->getchat($_SESSION['chatroom'],$_GET['lid']);
        while ($c=mysqli_fetch_assoc($cht)) {
            $data[]=$c;
        }
    }
    if(!empty($data)){
        echo json_encode($data);
    }
    else{
        echo "hello";

    }
}
?>