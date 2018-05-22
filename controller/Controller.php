<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/model/LoginModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/LoginView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/HomeView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/ArquivosModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/ArquivosView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/ServidoresModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/ServidoresView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/SetoresModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/ComunicacaoModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/ChamadosView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/ChamadosModel.php';

class Controller{
	
	protected $loginModel;
	protected $loginView;
	protected $arquivosModel;
	protected $arquivosView;
	protected $servidoresModel;
	protected $servidoresView;
	protected $setoresModel; 
	
	public function enviarMensagem($modulo, $id){	
			
		$model = new $moduloModel();
		
		$model->setModulo($modulo);
		
		$model->setID($id);
		
		$model->enviarMensagem();
		
		
		
		
	}

}













?>