<?php require_once '../../db.php'; ?>
<?php require_once '../../user_limit_session.php'; ?>
<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/26/2018
 * Time: 6:31 PM
 */
$services=[
    'rushuyi' => 'روشویی',
    'tushuyi' => 'توشویی',
    'vaxdashboard' => 'واکس داشبورد'
];
?>

<?php
/**
 * Created by PhpStorm.
 * User: m.sain
 * Date: 5/26/2018
 * Time: 6:58 PM
 */
?>
<?php
require_once '../../db.php';

$err_msg = [];

if(isset($_POST['car_type']))
{
    $car_type = $_POST['car_type'];
    $date = date('Y/m/d - h:i', time());
    $total_time = $_POST['total_time'];

    $starting_date = $_POST['starting_date'];
    $starting_time = $_POST['starting_time'];

    $starting_time_string = date("Y/m/d", $_POST['starting_date'])." - ". $starting_time;

    $total_cost = $_POST['total_cost'];
    $address = $_POST['address'];
    $customer_id = $_SESSION['user_id'];

    if(!empty($car_type) && !empty($starting_time) && !empty($total_cost) && !empty($customer_id))
    {
        $sql = "INSERT INTO orders VALUES ('$car_type', '$date', '$total_time',  '$starting_time_string', '$total_cost', '', '', '$address', '$customer_id', '1')";
        if ($result = sqlsrv_query( $conn, $sql))
        {
            if(sqlsrv_rows_affected($result) == 1)
            {
                header("Location: RequestsManage.php");
            }
            else
            {
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
/*foreach ($err_msg as $error)
    echo $error."<br>";*/

echo '<pre>';
print_r($_POST);
echo '</pre>';
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
                  rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="car_type">نوع ماشین:</label>
            <select id="car-type" class="form-control" name="car_type">
                <option value="sedan">سدان
                </option>
                <option value="mini_bus">مینی بوس
                </option>
                <option value="van">ون
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
                    echo '<option value="'.$startdate.'">'.date("Y/m/d", $startdate).'</option>';
                    $startdate = strtotime("+1 day", $startdate);
                }
                ?>
            </select>
        </div>


        <div class="form-group">
            <label for="starting_time">انتخاب ساعت:</label>
            <select id="starting_time" class="form-control" name="starting_time">
                <?php for ($i=9; $i<17; ++$i) { ?>
                    <option <?=$i?>><?=$i?></option>
                <?php } ?>
            </select>
        </div>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th>خدمات</th>
                <th>قیمت</th>
            </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM services";
                $params = array();
                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                if ($result = sqlsrv_query( $conn, $sql , $params, $options ))
                {
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                    {
                    ?>
                <tr>
                    <th><input name="s_<?=$row['service_name']?>" type="checkbox" value="<?=$row['service_name']?>" onchange="doChange(this, <?=$row['price']?>, <?=$row['total_time']?>)"><?=$services[$row['service_name']]?></th>
                    <th id="s_<?=$row['service_name']?>"><?=$row['price']?></th>
                </tr>
                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
        <div class="on1" >
            <p for="sum_price">قیمت نهایی:</p>
            <div id="sum_price">0</div>
            <input name="total_cost" id="total_cost" type="hidden">
            <p>تومان</p>
        </div>
        <div class="on1" >
            <p for="sum_time">مجموع زمان:</p>
            <div id="sum_time">0</div>
            <input name="total_time" id="total_time" type="hidden">
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