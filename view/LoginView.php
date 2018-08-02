<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class LoginView extends View{
	
	
	public function carregarBody(){ 
		$this->carregarMensagem(); 
?>
		<body style='background-color:#3498db;'>
			<div class='container' id='container-index' style='max-width: 1400px;'>
				<div id='sub-container-index'>
					
					<div class='logo' >
						<center>
							<!--<div class='row'>
								<img src='/view/_libs/img/logo-governo.png' id='logo-governo'>
							</div>-->
							<div class='row'>
								<p id='nome-sistema'>Painel de Gestão</p>	
							</div>
						</center>
					</div>
					<div class='login'>
						<div class='row'>
							<form  name='form-login' method='POST' action='login'>
								
								<div class='col-md-5' id='campo-login'>
									<input type='text' class='form-control' placeholder='CPF' name='CPF' id='CPF' required>
								</div>
								
								<div class='col-md-5' id='campo-senha'>
									<input type='password' class='form-control' placeholder='Senha' aria-describedby='sizing-addon3' name='senha' required>
								</div>
								<div class='col-md-2'>
									<center><button type='submit' class='btn btn-large' id='botao-entrar'>ENTRAR</button></center>
								</div>
							</form>
						</div>						
					</div>
				</div>
			</div>
		</body>	
		
<?php 
	
	}
	
}

?>