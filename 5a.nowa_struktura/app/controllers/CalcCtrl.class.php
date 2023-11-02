<?php

require_once 'CalcForm.class.php';
require_once 'CalcResult.class.php';

class CalcCtrl {

	private $form;
	private $result;
	
	public function __construct(){

		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	public function getParams(){
		$this->form->kwota =  getFromRequest('kwota');
		$this->form->wybor =  getFromRequest('wybor');
		$this->result->rodzaj =  getFromRequest('rodzaj');
		$this->result->oprocentowanie =  getFromRequest('oprocentowanie');
		$this->result->odsetki =  getFromRequest('odsetki');
		$this->result->koszt =  getFromRequest('koszt');
		$this->result->miesiac =  getFromRequest('miesiac');
		$this->result->calkowita =  getFromRequest('calkowita');
	}
	public function validate(){

    if ( ! isset($this->form->kwota) && isset($this->form->wybor) ) {
        getMessages()->addError('brak przekazanych argumentów podstawowych');		
        return false;
    }
		getMessages()->addError('parametry zostały przekazane prawidłowo');
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
	}
	$this->generateView();
}

public function generateView(){
	
	getSmarty()->assign('page_title','');
	getSmarty()->assign('page_description','');
	getSmarty()->assign('page_header','');
	
	getSmarty()->assign('form', $this->form);
	getSmarty()->assign('res',$this->result);
	
	getSmarty()->display('CalcView.html');
}

}
?>