<?php
/**
 * Created by PhpStorm.
 * User: m.sain
 * Date: 5/26/2018
 * Time: 4:39 PM
 */
?>
<?php
session_start();
require_once 'db.php';

$err_msg = [];

if(isset($_POST['email']) && isset($_POST['password']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	$hashed_password = sha1($password);

	if(!empty($email) && !empty($password))
	{
		$sql = "SELECT customer_id, email, password FROM customer WHERE password = '$hashed_password' AND email = '$email'";
        $params = array();
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		if ($result = sqlsrv_query( $conn, $sql , $params, $options ))
		{
			if(sqlsrv_num_rows($result) == 1)
			{
				$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
				$_SESSION['user_id'] = $row['customer_id'];
				$_SESSION['user_time'] = time();

				header("Location: panel/pages/UserPanel.php");
			}
			else
			{
                array_push($err_msg, '.چنین کاربری وجود ندارد');
			}
		}
		else
		{
			array_push($err_msg, 'اشکال در درخواست');
		}
	}
	else
	{
		array_push($err_msg, 'ایمیل یا رمز عبور خالی است.');
	}
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
	<title>Login V16</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter" >
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					صفحه ورود
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">

					<div class="wrap-input100 validate-input">
						<input class="input100" type="email" name="email" placeholder="ایمیل" required>
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="password" placeholder="رمز عبور" required>
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32" style="margin-bottom: -2%">
						<button class="login100-form-btn">
							ثبت نام
						</button>
						&nbsp;
						&nbsp;
						<button class="login100-form-btn" type="submit">
							ورود
						</button>
					</div>
                    <br>
                    <?php if(!empty($err_msg)) { ?>
                        <div class="alert alert-danger" style="text-align: right; margin-left: 5%; margin-right: 5%; margin-bottom: -3%">
                            <?php foreach ($err_msg as $error) echo $error; ?>
                        </div>
                    <?php } ?>
                </form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>