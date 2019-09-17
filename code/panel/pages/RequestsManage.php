<?php require_once '../../db.php'; ?>
<?php require_once '../../user_limit_session.php'; ?>

<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('../blocks/head.php'); ?>
    <title>مشاهده سفارشات</title>
</head>
<?php include('../blocks/navbar.php'); ?>
<body>

    <div class="container" style="margin-right: 300px; padding-left: 200px; padding-right: 150px;">
        <h1>مشاهده سفارشات</h1>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>نوع ماشین</th>
                    <th>زمان رزرو</th>
                    <th>زمان درخواست</th>
                    <th>قیمت کل</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    $sql = "SELECT * FROM orders WHERE customer_id = '{$_SESSION['user_id']}'";
                    $params = array();
                    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                    if ($result = sqlsrv_query( $conn, $sql , $params, $options ))
                    {
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                    {
                    ?>
                    <tr>

                    <td><?=$row['car_type']?></td>
                    <td><?=$row['starting_time_string']?></td>
                    <td><?=$row['date']?></td>
                    <td><?=$row['total_cost']?></td>
                    <td><a href='RequestEdit.php?edit=<?=$row['order_id']?>'><button class="btn btn-primary">ویرایش</button></a></td>
                    <td><a href='RequestDelete.php?id=<?=$row['order_id']?>'><button class="btn btn-danger">حذف</button></a></td>
                    <?php } ?>
                    </tr>
                    <?php }?>

            </tbody>
        </table>

    </div>

</body>
<?php include('../blocks/footer.php'); ?>
</html>