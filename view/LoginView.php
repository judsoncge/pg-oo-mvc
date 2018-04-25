<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/BaseView.php';

class LoginView extends BaseView{
	
	//primeira pagina do sistema, caso o usuario nao tenha efetuado login, é a "index"
	public function login(){
		
		$this->carregarHead();
		$this->carregarBody();
		$this->carregarFooter();
	}
	
	public function carregarHead(){ 
	
		parent::carregarHead(); ?>
		
		<script type='text/javascript' src='/view/libs/js/jquery.maskedinput.js'></script>
		<script type='text/javascript' src='/view/libs/js/util.js'></script>
		
	<?php }
	
	//o body desta pagina nao e padrao, pois e a que tem a caixa de login e senha. assim, sobrescreve o metodo da classe-mae
	public function carregarBody(){ ?>
		
		<body style='background-color:#3498db;'>
			<div class='container' id='container-index' style='max-width: 1400px;'>
				<div id='sub-container-index'>
					<!-- imagens e titulo antes dos campos de login -->
					<div class='logo' >
						<center>
							<div class='row'>
								<img src='/view/libs/img/logo-governo.png' id='logo-governo'>
							</div>
							<div class='row'>
								<p id='nome-sistema'>Painel de Gestão</p>	
							</div>
						</center>
					</div>
					<div class='login'>
						<div class='row'>
							<form  name='form-login' method='POST' action='home'>
								<!-- campo usuario, que é o cpf da pessoa -->
								<div class='col-md-5' id='campo-login'>
									<input type='text' class='form-control' placeholder='CPF' name='CPF' id='CPF' required>
								</div>
								<!-- campo senha -->
								<div class='col-md-5' id='campo-senha'>
									<input type='password' class='form-control' placeholder='Senha' aria-describedby='sizing-addon3' name='senha' required>
								</div>
								<!-- botao para enviar os dados -->
								<div class='col-md-2'>
									<center><button type='submit' class='btn btn-large' id='botao-entrar'>ENTRAR</button></center>
								</div>
							</form>
						</div>						
					</div>
				</div>
			</div>
		</body>		
	<?php }

}

?>