<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/27/2018
 * Time: 3:04 PM
 */
session_start();

unset($_SESSION['user_id']);
unset($_SESSION['user_time']);

header('Location: ../../login.php');
?>