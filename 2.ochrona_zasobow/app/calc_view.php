<?php require_once dirname(__FILE__).'/../config.php';?>
<!DOCTYPE HTML>
<head>
	<html lang="pl">
		<meta charset="UTF-8" />
		<meta name="description" content="kalkulator kredytowy" />
		<meta name="keywords" content="loan, credit, loan calc, money, kredyt, kalkulator kredytowy, pieniądze" />
		<meta name="author" content="Krystian Górski" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>credit calc</title>
</head>

<body>

<div style="width:90%; margin: 2em auto;">

	<a href="<?php echo _APP_URL; ?>/app/security/logout.php" class="">Wyloguj</a>
</div>

    <form action="<?php echo _APP_URL; ?>/app/calc.php" method="post">
	
        <label for="id_kwota">Kwota kredytu</label>
        <input id="id_kwota" type="text" name="kwota" value="<?php out($kwota); ?>"/>
        </br>

        <label for="id_splata">Okres kredytu</label>
        <button name="splata" value="30d">30 dni</button>
        <button name="splata" value="60d">60 dni</button>
        <button name="splata" value="3m">3 miesiące</button>
        <button name="splata" value="6m">6 miesięcy</button>
        <button name="splata" value="12m">12 miesięcy</button>
        </br>
    </form>

    <?php if (isset($messages) && count($messages) > 0): ?>
        <ol style="color: red;">
        <?php foreach ($messages as $message): ?>
            <li><?php echo $message; ?></li>
        <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <?php if (isset($result)): ?>
        <div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #2DDAB1; width:300px;">
            <?php echo 'Czas spłaty wynosi ' . $rodzaj; ?> </br>
            <?php echo 'Oprocentowanie wynosi ' . $oprocentowanie . ' %'; ?> </br>
            <?php echo 'Miesięczne odsetki wynoszą ' . round($odsetki, 1) . ' zł'; ?> </br>
            <?php echo 'Miesięczna rata wynosi ' . round($result, 1) . ' zł'; ?> </br>
            <?php echo 'Całkowity koszt pożyczki wynosi ' . round($koszt, 1) . ' zł'; ?> </br>
            <?php echo 'Całkowita kwota do oddania ' . round($calkowita, 1) . ' zł'; ?> </br>
        </div>
    <?php endif; ?>

</body>
</html>