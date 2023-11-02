<?php
require_once dirname(__FILE__) . '/../config.php';

session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

if (empty($role)) {
    include _ROOT_PATH . '/app/security/login.php';
    exit();
}

function getParams(&$kwota, &$wybor) {
    $kwota = isset($_POST['kwota']) ? floatval($_POST['kwota']) : null;
    $wybor = isset($_POST['splata']) ? $_POST['splata'] : null;
}

function validate($kwota, $wybor, &$messages) {
    if (!isset($kwota) || !isset($wybor)) {
        $messages[] = 'Wypełnij formularz i wybierz okres kredytu.';
        return false;
    }
    return true;
}
function process($kwota, $wybor, &$oprocentowanie, &$odsetki, &$koszt, &$result, &$calkowita) {
	global $role;
	
	
	switch ($wybor) {
		
		case '30d':
		if ($role == 'user' || $role == 'admin'){
			$rodzaj = '30 dni';
			$oprocentowanie = 0;
			$odsetki = 0;
			$koszt = 0;
			$result = $kwota/1;
			$calkowita = $kwota + $koszt;			
		}
			break;
		case '60d' :
		if ($role == 'user' || $role == 'admin'){
			$rodzaj = '60 dni';
			$oprocentowanie = 0;
			$odsetki = 0;
			$koszt = 0;			
			$result = $kwota/2;
			$calkowita = $kwota + $koszt;
		}			
			break;
			
		case '3m' :
		if ($role == 'user' || $role == 'admin'){
			$rodzaj = '3 miesiące';
			$oprocentowanie = 0.05*100;
			$odsetki = ($oprocentowanie/100*$kwota)/3;
			$koszt = $odsetki*3;			
			$result = $kwota/3 + $odsetki;
			$calkowita = $kwota + $koszt;
		}
			break;
		case '6m':
		if ($role == 'user' || $role == 'admin'){
			$rodzaj = '6 miesiący';
			$oprocentowanie = 0.10*100;
			$odsetki = ($oprocentowanie/100*$kwota)/6;
			$koszt = $odsetki*6;			
			$result = $kwota/6 + $odsetki;
			$calkowita = $kwota + $koszt;
		}			
			break;
		case '12m':
		if ($role == 'user' || $role == 'admin'){
			$rodzaj = '12 miesiący';
			$oprocentowanie = 0.20*100;
			$odsetki = ($oprocentowanie/100*$kwota)/12;
			$koszt = $odsetki*12;			
			$result = $kwota/12 + $odsetki;
			$calkowita = $kwota + $koszt;	
		}			
			break;					
		default :
			$oprocentowanie = 0;
			$odsetki = 0;	
			$koszt = 0;			
			$result = $kwota;
			$calkowita = $kwota + $koszt;			
			;
			break;
	}
}
$kwota = null;
$wybor = null;
$oprocentowanie = null;
$odsetki = null;
$koszt = null;
$result = null;
$calkowita = null;
$rodzaj = null;
$messages = array();

getParams($kwota, $wybor);
if (validate($kwota, $wybor, $messages)) {
    process($kwota, $wybor, $oprocentowanie, $odsetki, $koszt, $result, $calkowita);
}

include _ROOT_PATH . '/app/calc_view.php';
?>