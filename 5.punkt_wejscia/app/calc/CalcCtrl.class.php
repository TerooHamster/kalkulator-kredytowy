<?php

require_once $conf->root_path.'/libs/Smarty.class.php';
require_once $conf->root_path.'/libs/Messages.class.php';
require_once $conf->root_path.'/app/calc/CalcForm.class.php';
require_once $conf->root_path.'/app/calc/CalcResult.class.php';

class CalcCtrl {
	private $msgs;
	private $form;
	private $result;
	
	public function __construct(){
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	public function getParams(){
		$this->form->kwota =  isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
		$this->form->wybor = isset($_REQUEST['wybor']) ? $_REQUEST['wybor'] : null;
		$this->result->rodzaj = isset($_REQUEST['rodzaj']) ? $_REQUEST['rodzaj'] : null;
		$this->result->oprocentowanie =  isset($_REQUEST['oprocentowanie']) ? $_REQUEST['oprocentowanie'] : null;
		$this->result->odsetki = isset($_REQUEST['odsetki']) ? $_REQUEST['odsetki'] : null;
		$this->result->koszt = isset($_REQUEST['koszt']) ? $_REQUEST['koszt'] : null;
		$this->result->miesiac = isset($_REQUEST['miesiac']) ? $_REQUEST['miesiac'] : null;
		$this->result->calkowita = isset($_REQUEST['calkowita']) ? $_REQUEST['calkowita'] : null; 
	}
	public function validate(){

    if ( ! isset($this->form->kwota) && isset($this->form->wybor) ) {
        $this->msgs->addError('brak przekazanych argumentów podstawowych');		
        return false;
    }
	$this->msgs->addError('parametry zostały przekazane prawidłowo');
	if ($this->form->kwota == "") $this->msgs->addError('Nie podano kwoty');

    else return true;		
	}
	public function process(){
		$this->getparams();
		if ($this->validate()){
			switch ($this->form->wybor){
				case '30d' : 
				$this->result->parametr1 = $this->result->rodzaj = '30 dni';
				$this->result->parametr2 = $this->result->oprocentowanie = 0;	
				$this->result->parametr3 = $this->result->odsetki = 0;	
				$this->result->parametr4 = $this->result->koszt = 0;	
				$this->result->parametr5 = $this->result->miesiac = $this->form->kwota/1;	
				$this->result->parametr6 = $this->result->calkowita = $this->form->kwota + $this->result->koszt;					
				break;
				
				case '60d' :
				$this->result->parametr1 = $this->result->rodzaj = '60 dni';
				$this->result->parametr2 = $this->result->oprocentowanie = 0;	
				$this->result->parametr3 = $this->result->odsetki = 0;	
				$this->result->parametr4 = $this->result->koszt = 0;	
				$this->result->parametr5 = $this->result->miesiac = $this->form->kwota/2;	
				$this->result->parametr6 = $this->result->calkowita = $this->form->kwota + $this->result->koszt;					
				break;
				
				case '3m' :
				$this->result->parametr1 = $this->result->rodzaj = '3 miesiące';
				$this->result->parametr2 = $this->result->oprocentowanie = 0.05*100;	
				$this->result->parametr3 = $this->result->odsetki = ($this->result->oprocentowanie/100*$this->form->kwota)/3;	
				$this->result->parametr4 = $this->result->koszt = $this->result->odsetki*3;	
				$this->result->parametr5 = $this->result->miesiac = $this->form->kwota/3 + $this->result->odsetki;	
				$this->result->parametr6 = $this->result->calkowita = $this->form->kwota + $this->result->koszt;					
				break;
				
				case '6m' :
				$this->result->parametr1 = $this->result->rodzaj = '6 miesiący';
				$this->result->parametr2 = $this->result->oprocentowanie = 0.10*100;	
				$this->result->parametr3 = $this->result->odsetki = ($this->result->oprocentowanie/100*$this->form->kwota)/6;	
				$this->result->parametr4 = $this->result->koszt = $this->result->odsetki*6;	
				$this->result->parametr5 = $this->result->miesiac = $this->form->kwota/6 + $this->result->odsetki;	
				$this->result->parametr6 = $this->result->calkowita = $this->form->kwota + $this->result->koszt;						
				break;
				
				case '12m' : 
				$this->result->parametr1 = $this->result->rodzaj = '12 miesiący';
				$this->result->parametr2 = $this->result->oprocentowanie = 0.20*100;	
				$this->result->parametr3 = $this->result->odsetki = ($this->result->oprocentowanie/100*$this->form->kwota)/12;	
				$this->result->parametr4 = $this->result->koszt = $this->result->odsetki*12;	
				$this->result->parametr5 = $this->result->miesiac = $this->form->kwota/12 + $this->result->odsetki;	
				$this->result->parametr6 = $this->result->calkowita = $this->form->kwota + $this->result->koszt;						
				break;
				
				default : 
				$this->result->parametr1 = $this->result->rodzaj = '30 dni';
				$this->result->parametr2 = $this->result->oprocentowanie = 0;	
				$this->result->parametr3 = $this->result->odsetki = 0;	
				$this->result->parametr4 = $this->result->koszt = 0;	
				$this->result->parametr5 = $this->result->miesiac = $this->form->kwota;	
				$this->result->parametr6 = $this->result->calkowita = $this->form->kwota + $this->result->koszt;						
				break;
			}
			$this->msgs->addInfo('obliczenia ok');
	}
	$this->generateView();
}

public function generateView(){
	global $conf;
	$smarty = new Smarty();
	$smarty->assign('conf',$conf);
	
	$smarty->assign('page_title','');
	$smarty->assign('page_description','');
	$smarty->assign('page_header','');
	
	$smarty->assign('msgs', $this->msgs);
	$smarty->assign('form', $this->form);
	$smarty->assign('res',$this->result);
	$smarty->display($conf->root_path.'/app/calc/CalcView.html');
}

}
?>