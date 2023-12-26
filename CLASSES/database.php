<?php
class db{
 public function db_connect()
 {
 return  mysqli_connect("localhost","root","","chat");
 }
}
?>