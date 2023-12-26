<?php
require 'database.php';
class user 
{
    // SIGN UP
    public function signup($f,$l,$un,$em,$pw)
    {
        $db=new db();
   mysqli_query($db->db_connect(),"insert into users(First,Last,username,email,password,u_pic,active)values('$f','$l','$un','$em','$pw','null','0')");
   
}
// SIGN IN
public function signin($f,$l)
{
    $db=new db();
$login= mysqli_query($db->db_connect(),"select * from users where username='$f' AND password='$l'");
$row=mysqli_fetch_assoc($login);
if($row>0){
return $row['u_id'];
}
else{
return 0;
}
}
// GET
public function getdata($id)
{
    $db=new db();
$login= mysqli_query($db->db_connect(),"select * from users where u_id='$id'");
$row=mysqli_fetch_assoc($login);
return $row;
}
// public function getdata($id)
// {
//     $db=new db();
// $login= mysqli_query($db->db_connect(),"select u.u_id,u.First,u.Last,u.username,u.u_pic,s.id,s.file,s.time from users as u join status as s on u.u_id=s.id where u_id='$id'");
// $row=mysqli_fetch_assoc($login);
// return $row;
// }
// UPDATE
public function updatedp($pic,$id)
{
    $db=new db();
 mysqli_query($db->db_connect(),"update users set u_pic='$pic' where u_id='$id'");
}
// get contacts
public function getcon($id)
{
    $db=new db();
 return mysqli_query($db->db_connect(),"select * from users where u_id !='$id'");
}
// get status
public function loadstatus()
{
    $db=new db();
    return mysqli_query($db->db_connect(),"select s.file,s.time,u.username,s.userid from status as s join users as u on s.userid=u.u_id");
}
// get Chatroom
public function chatroom($s,$r)
{
    $db=new db();
 $cr= mysqli_query($db->db_connect(),"select * from chat_room where sender='$r' and receiver='$s'");
 $c=mysqli_fetch_assoc($cr);
 if($c>0){
   return $c['room_id'];
 }
 else{
     $db=new db();
 $c1= mysqli_query($db->db_connect(),"select * from chat_room where sender='$s' and receiver='$r'");
 $c0=mysqli_fetch_assoc($c1); 
 if($c0>0){
    return $c0['room_id'];
 //   return  mysqli_query($db->db_connect(),"select * from chat_romm where sender='$s' and receiver='$r' order by");
  }else{
      mysqli_query($db->db_connect(),"insert into chat_room (sender,receiver) values('$s','$r')");
  }
 }
}
// start Chat
public function chatting($msg,$sender,$room)
{
    $db=new db();
mysqli_query($db->db_connect(),"insert into chat(message,sender,room_id,seen)values('$msg','$sender','$room','0')");
 
 
}
// Get chat
public function getchat($room,$lid)
{
    $db=new db();
return mysqli_query($db->db_connect(),"select  * from chat where room_id='$room' and chat_id>$lid");
}
// Upload status
public function status($f,$id)
{
    $db=new db();
    $t=time();
    $ex=$t+60;
    mysqli_query($db->db_connect(),"delete from status where userid='$id'");
 mysqli_query($db->db_connect(),"insert into status(file,userid,time,expire)values('$f','$id','$t','$ex')");
}
public function delete($id)
{
    $db=new db();
    $t=time();
 mysqli_query($db->db_connect(),"delete from status where userid='$id'");

}
//SEEN MSGS
public function seen($s,$r)
{
    $db=new db();
 mysqli_query($db->db_connect(),"update chat set seen='1' where room_id='$r' AND sender='$s'");
}
//STAR MSGS
public function star($id)
{
    $db=new db();
 $msg=mysqli_query($db->db_connect(),"select * from chat where chat_id='$id'");
 $m=mysqli_fetch_assoc($msg);
 if ($m['star']==0) {
    mysqli_query($db->db_connect(),"update chat set star='1' where chat_id='$id'");
 }
 else{
    mysqli_query($db->db_connect(),"update chat set star='0' where chat_id='$id'");


 }
}
//DEL MSG
public function delmsg($id)
{
    $db=new db();
 mysqli_query($db->db_connect(),"delete from chat where chat_id='$id'");
}
//UPDATE PROFILE
public function updateprofile($f,$l,$p,$id)
{
    $db=new db();
 mysqli_query($db->db_connect(),"update users set First='$f',Last='$l',password='$p' where u_id='$id'");
}

public function getstatus()
{
    $db=new db();
 $return= mysqli_query($db->db_connect(),"select * from status");
 
    while ($rr=mysqli_fetch_assoc($return)) {
        if ($rr['userid']==$_SESSION['USER_ID']) {
            return $rr;
        }
    }

}
public function deletestatus()
{
    $db=new db();
    $t=time();
   $list= mysqli_query($db->db_connect(),"select * from status where expire<='$t'");
   while ($l=mysqli_fetch_assoc($list)) {
    if(file_exists($l['file'])){
        $deletefile= unlink($l['file']);  
    }
   }
    mysqli_query($db->db_connect(),"delete from status where expire<'$t'");
}
public function active($a,$id)
{
    $db=new db();
    mysqli_query($db->db_connect(),"update users set active='$a' where u_id='$id'");
   
}
public function checkactive($id)
{
    $db=new db();
   $list= mysqli_query($db->db_connect(),"select * from users where u_id='$id'");
   $active=mysqli_fetch_assoc($list);
   if($active['active']==1){
return "ONLINE";
   }
   else{
    return "OFFLINE";
   }
}

}
?>