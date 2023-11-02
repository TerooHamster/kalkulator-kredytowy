<?php
require_once dirname(__FILE__).'/../config.php';

include _ROOT_PATH.'/app/security/check.php';
?>
<!DOCTYPE HTML>
<html xml:lang="pl" lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Chroniona strona</title>
	<link rel="stylesheet" href="">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/calc.php" class="pure-button">Powrót do kalkulatora</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button">Wyloguj</a>
</div>

<div style="width:90%; margin: 2em auto;">
	<p>To jest inna chroniona strona aplikacji internetowej</p>
</div>	

</body>
</html>