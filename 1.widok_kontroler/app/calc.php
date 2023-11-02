<?php

require_once dirname(__FILE__).'/../config.php';

$kwota = $_REQUEST ['kwota'];
$wybor = $_REQUEST ['splata'];
$oprocentowanie;
$odsetki;
$koszt;
$calkowita=$kwota;
$rodzaj;

if ( ! (isset($kwota))) {
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}
if ($kwota == ""){
	$messages [] = 'Nie podano kwoty';
}
if (empty( $messages )) {
	if (! is_numeric( $kwota )) {
		$messages [] = 'Prosze podać kwote całkowitą';
	}
}
if (empty ( $messages )) { 
	
	$kwota = intval($kwota);
	
	switch ($wybor) {
		case '30d':
			$rodzaj = '30 dni';
			$oprocentowanie = 0;
			$odsetki = 0;
			$koszt = 0;
			$result = $kwota/1;
			round($result);
			$calkowita = $kwota + $koszt;	
			round($calkowita);
			break;
		case '60d' :
			$rodzaj = '60 dni';
			$oprocentowanie = 0;
			$odsetki = 0;
			$koszt = 0;			
			$result = $kwota/2;
			round($result);
			$calkowita = $kwota + $koszt;
			round($calkowita);			
			break;
		case '3m' :
			$rodzaj = '3 miesiące';
			$oprocentowanie = 0.05*100;
			$odsetki = ($oprocentowanie/100*$kwota)/3;
			$koszt = $odsetki*3;			
			$result = $kwota/3 + $odsetki;
			round($result);
			$calkowita = $kwota + $koszt;
			round($calkowita);	
			break;
		case '6m':
			$rodzaj = '6 miesiący';
			$oprocentowanie = 0.10*100;
			$odsetki = ($oprocentowanie/100*$kwota)/6;
			$koszt = $odsetki*6;			
			$result = $kwota/6 + $odsetki;
			round($result);
			$calkowita = $kwota + $koszt;	
			round($calkowita);	
			break;
		case '12m':
			$rodzaj = '12 miesiący';
			$oprocentowanie = 0.20*100;
			$odsetki = ($oprocentowanie/100*$kwota)/12;
			$koszt = $odsetki*12;			
			$result = $kwota/12 + $odsetki;
			$calkowita = $kwota + $koszt;			
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
	
	
include 'view.php';
?>