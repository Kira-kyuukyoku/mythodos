<?php
// include captcha class
require('php-captcha.inc.php');

// define fonts
$aFonts = array('VeraMoBd.ttf', 'akbar.ttf');

// create new image
$oPhpCaptcha = new PhpCaptcha($aFonts, 150, 50);

$oPhpCaptcha->UseColour(true);

$oPhpCaptcha->Create();
?>