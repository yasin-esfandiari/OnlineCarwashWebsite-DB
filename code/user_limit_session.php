<?php
/**
 * Created by PhpStorm.
 * User: m.sain
 * Date: 5/26/2018
 * Time: 4:28 PM
 */
?>
<?php
session_start();
$limit = 600;

if(!isset($_SESSION['user_id']))
{
    print_r($_SESSION);
    header('Location: ../../login.php');
}
elseif(isset($_SESSION['user_id']) && isset($_SESSION['user_time']) && ($_SESSION['user_time'] + $limit < time()))
{
    unset($_SESSION['user_id']);
    unset($_SESSION['user_time']);
    print_r($_SESSION);
    header('Location: ../../login.php');
}
else
{
    $_SESSION['user_time'] = time();
//    header('Location: UserPanel.php');
}

?>