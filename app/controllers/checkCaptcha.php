<?php
$captchaOK = false;

if(isset($_SESSION) && isset($_SESSION['firstCaptchaItem']) && isset($_SESSION['secondCaptchaItem'])) {
	$captchaAnswer = $_SESSION['firstCaptchaItem'] + $_SESSION['secondCaptchaItem'];
	if(isset($_POST) && isset($_POST['additionAnswer']) && $_POST['additionAnswer'] == $captchaAnswer) {
		$captchaOK = true;
	}
}