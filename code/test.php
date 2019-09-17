<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/26/2018
 * Time: 5:35 PM
 */

echo sha1('qwerty123');
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php

/*$sql = "SELECT * FROM customer";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    echo $row['first_name'].", ".$row['last_name']."<br />";
}

sqlsrv_free_stmt($stmt);

$sql = "INSERT INTO customer VALUES ('yasin','esi','yasin.esi@gmail.com','".sha1('qwerty123')."', '09121234567')";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
sqlsrv_free_stmt($stmt);

sqlsrv_close($conn);*/

?>

</body>
</html>

<script>
    document.getElementById('car-type').addEventListener("change", function() {
        type = document.getElementById('car-type').value
        <?php
        $sql = "SELECT * FROM services";
        $params = array();
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        if ($result = sqlsrv_query( $conn, $sql , $params, $options ))
        {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
        ?>
        if (type == 'sedan' && type == <?=$row['service_name']?>)
            document.getElementById('s<?=$row['service_id']?>').value = <?=$row['price']?>*1;
        if (type == 'mini_bus' && type == <?=$row['service_name']?>)
            document.getElementById('s<?=$row['service_id']?>').value = <?=$row['price']?>*1;
        if (type == 'van' && type == <?=$row['service_name']?>)
            document.getElementById('s<?=$row['service_id']?>').value = <?=$row['price']?>*1;
        <?php
        }
        }
        ?>
        if (type == 'sedan')
            document.getElementById('s1').value = <?=$row['price']?>*1;
        else if (type == 'mini_bus')
            document.getElementById('s2').value = <?=$row['price']?>*2;
        else if (type == 'van')
            document.getElementById('s3').value = <?=$row['price']?>*1.5;
    });
</script>
