<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/27/2018
 * Time: 1:29 PM
 */
?>
<?php require_once '../../db.php'; ?>
<?php require_once '../../user_limit_session.php'; ?>

<?php
if(isset($_GET['id']))
{
    $order_id = $_GET['id'];

    if(!empty($order_id))
    {
        $sql = "DELETE FROM orders WHERE customer_id = '{$_SESSION['user_id']}' AND order_id = '$order_id'";
        if ( sqlsrv_query( $conn, $sql))
        {
            header('Location: RequestsManage.php');
        }
        else
        {
            die( print_r( sqlsrv_errors(), true) );
        }
    }
}
?>