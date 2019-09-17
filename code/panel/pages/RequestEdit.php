<?php require_once '../../db.php'; ?>
<?php require_once '../../user_limit_session.php'; ?>
<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/27/2018
 * Time: 2:05 PM
 */
?>
<?php
require_once '../../db.php';

$err_msg = [];

if(isset($_GET['edit']) && !empty($_GET['edit']))
{
    $edit = $_GET['edit'];
    if(isset($_POST['car_type']))
    {
        $car_type = $_POST['car_type'];

        $starting_date = $_POST['starting_date'];
        $starting_time = $_POST['starting_time'];

        $starting_time_string = date("Y/m/d", $_POST['starting_date'])." - ". $starting_time;

        $address = $_POST['address'];
        $customer_id = $_SESSION['user_id'];
        if(!empty($car_type) && !empty($starting_time))
        {
            $sql = "UPDATE orders SET car_type='$car_type', starting_time_string='$starting_time_string', address='$address' WHERE customer_id = '{$_SESSION['user_id']}' AND order_id = '$edit'";
            if ($result = sqlsrv_query( $conn, $sql))
            {
                if(sqlsrv_rows_affected($result) == 1)
                {
                    header("Location: RequestsManage.php");
                }
                else
                {
                    die( print_r( sqlsrv_errors(), true) );
                    array_push($err_msg, 'اضافه نکرد.');
                }
            }
            else
            {
                die( print_r( sqlsrv_errors(), true) );
                array_push($err_msg, 'اشکال در درخواست');
            }
        }
        else
        {
            array_push($err_msg, 'ایمیل یا رمز عبور خالی است.');
        }

    }

    $sql = "SELECT * FROM orders WHERE customer_id = '{$_SESSION['user_id']}' AND order_id = '$edit'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    if ($result = sqlsrv_query( $conn, $sql , $params, $options ))
    {
        if (sqlsrv_num_rows($result) == 1)
        {
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        }
    }
    else
    {
        die( print_r( sqlsrv_errors(), true) );
    }
}
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';*/
$starting = $row['starting_time_string'];
$starting_date = substr($starting, 0, strpos($starting, '-')-1);
$starting_time = substr($starting, strpos($starting, '-')+1);
?>


<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <?php include('../blocks/head.php'); ?>
    <title>پنل کاربری</title>
    <script>var total_price=0,total_time=0;</script>
    <style>
        .on1{
            display: flex;flex-direction: row;
        }
        .on1 > p , .on1 > div{
            padding: 10px;
        }
    </style>
</head>


<?php include('../blocks/navbar.php'); ?>
<body>
<div class="container" style="margin-right: 300px; padding-left: 200px; padding-right: 150px;">

    <form enctype="multipart/form-data" action="" method="post" role="form">

        <h1>درخواست کارواش</h1>
        <hr>

        <div class="form-group">
            <label for="address">آدرس:</label>
            <textarea class="form-control" name="address" id="address"
                      rows="3"><?=$row['address']?></textarea>
        </div>

        <div class="form-group">
            <label for="car_type">نوع ماشین:</label>
            <select id="car-type" class="form-control" name="car_type">
                <option value="sedan" <?php if ($row['car_type'] == 'sedan') echo 'selected'; ?>>سدان
                </option>
                <option value="mini_bus" <?php if ($row['car_type'] == 'mini_bus') echo 'selected'; ?>>مینی بوس
                </option>
                <option value="van" <?php if ($row['car_type'] == 'van') echo 'selected' ?>>ون
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="starting_date"> انتخاب روز:</label>
            <select id="starting_date" class="form-control" name="starting_date">
                <?php //date("Y/m/d",time()) ?>
                <?php
                $startdate=strtotime("tomorrow");
                $enddate=strtotime("+1 weeks", $startdate);

                while ($startdate < $enddate) {
                    echo '<option value="'.$startdate.'"';
                    if (date("Y/m/d", $startdate) == $starting_date)
                        echo 'selected';
                    echo '>'.date("Y/m/d", $startdate).'</option>';
                    $startdate = strtotime("+1 day", $startdate);
                }
                ?>
            </select>
        </div>


        <div class="form-group">
            <label for="starting_time">انتخاب ساعت:</label>
            <select id="starting_time" class="form-control" name="starting_time">
                <?php for ($i=9; $i<17; ++$i) { ?>
                    <option <?=$i?> <?php if ($i == $starting_time) echo 'selected' ?>><?=$i?></option>
                <?php } ?>
            </select>
        </div>

        <div class="on1" >
            <p for="sum_price">قیمت نهایی:</p>
            <div id="sum_price"><?=$row['total_cost']?></div>
            <p>تومان</p>
        </div>
        <div class="on1" >
            <p for="sum_time">مجموع زمان:</p>
            <div id="sum_time"><?=$row['total_time']?></div>
            <p>دقیقه</p>
        </div>

        <button type="submit" name="submit" class="btn btn-primary" style="float: left">تایید</button>

    </form>

</div>
</body>

<?php include('../blocks/footer.php'); ?>

</html>

<script>
    var total_price=0
    function doChange(checkboxElem, price, time) {
        if (checkboxElem.checked) {
            total_price += price;
            total_time += time;
        } else {
            total_price -= price;
            total_time -= time;
        }
        document.getElementById('sum_price').innerHTML = total_price;
        document.getElementById('sum_time').innerHTML = total_time;

        document.getElementById('total_cost').value = total_price;
        document.getElementById('total_time').value = total_time;

    };
</script>
