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

class Controller{
	
	protected $loginModel;
	protected $loginView;
	protected $arquivosModel;
	protected $arquivosView;
	protected $servidoresModel;
	protected $servidoresView;
	protected $setoresModel; 
	
	public function editarStatus($tabela, $status, $id){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"UPDATE ".$tabela."
		
		SET DS_STATUS='".$status."'
		
		WHERE ID='".$id."'
		
		") or die(mysqli_error($this->conexao));
		
		$resultado = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		return $resultado;

	}

}













?>