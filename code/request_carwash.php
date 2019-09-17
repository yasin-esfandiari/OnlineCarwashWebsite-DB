<?php require_once 'db.php'; ?>

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