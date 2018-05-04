<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class LoginView extends View{
	
	public function adicionarScripts(){ 
	
		parent::adicionarScripts(); ?>
		
			<script type='text/javascript' src='/view/libs/js/jquery.maskedinput.js'></script>
			<script type='text/javascript' src='/view/libs/js/util.js'></script>
		
	<?php }
	
	public function carregarBody(){ ?>
		
		<body style='background-color:#3498db;'>
			<?php $this->carregarConteudo(); ?>
		</body>		
<?php 
	}
	
	public function carregarConteudo(){ ?>
		<div class='container' id='container-index' style='max-width: 1400px;'>
			<div id='sub-container-index'>
				<div class='logo' >
					<center>
						<div class='row'>
							<img src='/view/libs/img/logo-governo.png' id='logo-governo'>
						</div>
						<div class='row'>
							<p id='nome-sistema'><?php echo $this->titulo ?></p>	
						</div>
					</center>
				</div>
				<div class='login'>
					<div class='row'>
						<form  name='form-login' method='POST' action='home'>
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
<?php 	
	}

}

?>