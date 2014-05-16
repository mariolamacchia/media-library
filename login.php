<?php
include "lib.php";
public_zone();
if (isset($_POST['username'])) {
    if ($_POST['username'] == $username and
        md5($_POST['password']) == $password) {
            $_SESSION['username'] = $_POST['username'];
            header('location: index.php');
        }
    else $loginfailed='';
}
?>
<!DOCTYPE html>
<h2>Login</h2>
<form action="#" method="POST">
    Username<br>
    <input name='username' type='text' /><br>
    Password<br>
    <input name='password' type='password' /><br>
<?php 
if (isset($loginfailed))  
    echo "<span style='color:red'>Login failed</span><br>"; 
?>
    <input type='submit' value="Ok"/>
</form>
