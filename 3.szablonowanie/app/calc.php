<?php
require_once dirname(__FILE__) . '/../config.php'; // implementacja wstępna 
require_once _ROOT_PATH.'/libs/Smarty.class.php';

function getParams(&$form) { // pobranie parametrów
    $form['kwota'] = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
    $form['wybor'] = isset($_REQUEST['wybor']) ? $_REQUEST['wybor'] : null;
	$form['rodzaj'] = isset($_REQUEST['rodzaj']) ? $_REQUEST['rodzaj'] : null;
	$form['oprocentowanie'] = isset($_REQUEST['oprocentowanie']) ? $_REQUEST['oprocentowanie'] : null;
	$form['odsetki'] = isset($_REQUEST['odsetki']) ? $_REQUEST['odsetki'] : null;
	$form['koszt'] = isset($_REQUEST['koszt']) ? $_REQUEST['koszt'] : null;
	$form['miesiac'] = isset($_REQUEST['miesiac']) ? $_REQUEST['miesiac'] : null;
	$form['calkowita'] = isset($_REQUEST['calkowita']) ? $_REQUEST['calkowita'] : null;
}

function validate(&$form, &$infos, &$msgs, &$hide_intro) { // prosta walidacja 

    if ( ! isset($form['kwota']) && isset($form['wybor']) ) {
        $infos[] = 'brak przekazanych argumentów podstawowych';
		$hide_intro = false;		
        return false;
    }
	
	$hide_intro = true;
	$infos[] = 'parametry zostały przekazane prawidłowo';
	if ($form['kwota'] == "") $msgs[] = 'Nie podano kwoty';
	if (count($msgs)==0){
		;
	}
	if (count($msgs)>0) return false;
    else return true;
}

function process(&$form, &$infos, &$msgs, &$parametr1, &$parametr2, &$parametr3, &$parametr4, &$parametr5, &$parametr6) { // funkcja na obliczenia
	
	$infos[] = 'parametry ok, wykonywanie obliczen';
	
	switch ($form['wybor']) {
		
		case '30d':
		
			$parametr1 = $form['rodzaj'] = '30 dni';
			$parametr2 = $form['oprocentowanie'] = 0;
			$parametr3 = $form['odsetki'] = 0;
			$parametr4 = $form['koszt'] = 0;
			round($form['kwota']);
			$parametr5 = $form['miesiac'] = $form['kwota']/1;
			$parametr6 = $form['calkowita'] = $form['kwota'] + $form['koszt'];			
			break;
			
		case '60d' :
		
			$parametr1 = $form['rodzaj'] = '60 dni';
			$parametr2 = $form['oprocentowanie'] = 0;
			$parametr3 = $form['odsetki'] = 0;
			$parametr4 = $form['koszt'] = 0;			
			$parametr5 = $form['miesiac'] = $form['kwota']/2;
			$parametr6 = $form['calkowita'] = $form['kwota'] + $form['koszt'];
			break;
			
		case '3m' :
		
			$parametr1 = $form['rodzaj'] = '3 miesiące';
			$parametr2 = $form['oprocentowanie'] = 0.05*100;
			$parametr3 = $form['odsetki'] = ($form['oprocentowanie']/100*$form['kwota'])/3;
			$parametr4 = $form['koszt'] = $form['odsetki']*3;			
			$parametr5 = $form['miesiac'] = $form['kwota']/3 + $form['odsetki'];
			$parametr6 = $form['calkowita'] = $form['kwota'] + $form['koszt'];
			break;
			
		case '6m':
	
			$parametr1 = $form['rodzaj'] = '6 miesiący';
			$parametr2 = $form['oprocentowanie'] = 0.10*100;
			$parametr3 = $form['odsetki'] = ($form['oprocentowanie']/100*$form['kwota'])/6;
			$parametr4 = $form['koszt'] = $form['odsetki']*6;			
			$parametr5 = $form['miesiac'] = $form['kwota']/6 + $form['odsetki'];
			$parametr6 = $form['calkowita'] = $form['kwota'] + $form['koszt'];
			break;
			
		case '12m':
		
			$parametr1 = $form['rodzaj'] = '12 miesiący';
			$parametr2 = $form['oprocentowanie'] = 0.20*100;
			$parametr3 = $form['odsetki'] = ($form['oprocentowanie']/100*$form['kwota'])/12;
			$parametr4 = $form['koszt'] = $form['odsetki']*12;			
			$parametr5 = $form['miesiac'] = $form['kwota']/12 + $form['odsetki'];
			$parametr6 = $form['calkowita'] = $form['kwota'] + $form['koszt'];		
			break;		
			
		default :
			$form['kwota'] = 0;
			$parametr1 = $form['rodzaj'] = '30 dni';
			$parametr2 = $form['oprocentowanie'] = 0;
			$parametr3 = $form['odsetki'] = 0;	
			$parametr4 = $form['koszt'] = 0;			
			$parametr5 = $form['miesiac'] = $form['kwota'];
			$parametr6 = $form['calkowita'] = $form['kwota'] + $form['koszt'];			
			break;
	}
}

$form = null;
$infos = array();
$messages = array();
$hide_intro = false;

$parametr1 = null;
$parametr2 = null;
$parametr3 = null;
$parametr4 = null;
$parametr5 = null;
$parametr6 = null;



getParams($form);

if (validate($form,$infos, $messages, $hide_intro)) {
    process($form, $infos, $messages, $parametr1, $parametr2, $parametr3, $parametr4, $parametr5, $parametr6);
}

// przekazywanie do biblioteki smarty

$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','');
$smarty->assign('page_description','');
$smarty->assign('page_header','');
$smarty->assign('hide_intro',$hide_intro);
$smarty->assign('form',$form);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

$smarty->assign('parametr1',$parametr1);
$smarty->assign('parametr2',$parametr2);
$smarty->assign('parametr3',$parametr3);
$smarty->assign('parametr4',$parametr4);
$smarty->assign('parametr5',$parametr5);
$smarty->assign('parametr6',$parametr6);

$smarty->display(_ROOT_PATH.'/app/calc.html');
?>