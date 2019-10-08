<?php 
/**
 * get-captcha.php
 *
 * Captcha invocation 
 *
 * @package    Captcha
 * @author     Avinash Dalvi(aviboy2006)
 * @copyright  2019 aviboy2006   
 */
session_start();
include("includes/captcha-engine.php");

$captchaObj = new captchaClass();
$captchaObj->create('#162453','#fff',120,40,10,25);
 ?>