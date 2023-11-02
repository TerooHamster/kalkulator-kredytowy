<?php
require_once 'init.php';
getConf()->login_action='login';
switch($action) {
	default :
	control('app\\controllers','CalcCtrl','generateView',['user','admin']);
	break;
	case 'login' :
	control('app\\controllers','LoginCtrl','doLogin');
	break;
	case 'calcCompute' :
	control(null,'CalcCtrl','process',['user','admin']);
	break;
	case 'logout' :
	control(null,'LoginCtrl','doLogout',['user','admin']);
	break;
}
?>