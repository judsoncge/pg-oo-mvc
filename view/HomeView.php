<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/BaseView.php';

class HomeView extends BaseView{
	
	//esta funcao carrega o head da classe mae e adiciona um script que e necessario para execucao da pagina
	public function carregarHead(){
		
		parent::carregarHead(); ?>
		
		<div id='fb-root'></div>
		<script>(function(d, s, id) {
		    var js, fjs = d.getElementsByTagName(s)[0];
		    if (d.getElementById(id)) 
				return;
		    js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.12&appId=2008844572700318&autoLogAppEvents=1';
			fjs.parentNode.insertBefore(js, fjs);
		}	
			(document, 'script', 'facebook-jssdk'));
		</script>
		
	<?php }
	
	//esta funcao carrega o conteudo da pagina, pegando a lista das cinco comunicacoes mais atuais que vem do controller
	public function carregarConteudo($titulo, $lista){ ?>

		<div id='page-content-wrapper'>
			<p><?php echo $titulo ?></p>
			<div class='row linha-grafico'>
				<div class='col-md-6'>
					<div class='grafico' id='processos-ativos' >
						<b>Principais notícias</b>:
						<br>
						<br>
					  <?php foreach($lista as $noticia){ ?>
								
								<font size='2px'>
								    (<?php echo date_format(new DateTime($noticia['DT_PUBLICACAO']) , 'd/m/Y H:i') ?>)
								</font>
								
								<br>
								
								<a href="#">
									<h3><?php echo $noticia['NM_TITULO'] ?></h3>
								</a>
								
								<font size="2px"><?php echo substr($noticia['NM_INTERTITULO'], 0, 79) . "..." ?></font>	
								
								<br>
								<br>
					  <?php } ?>
					</div>
				</div>
				 
				<div class='col-md-6'>
					<center>
						<div class='fb-page' data-href='https://www.facebook.com/ControladoriaGeralAL/' data-tabs='timeline' data-width='600' data-height='685' data-small-header='true' data-adapt-container-width='true' data-hide-cover='false' data-show-facepile='true'>
							<blockquote cite='https://www.facebook.com/ControladoriaGeralAL/' class='fb-xfbml-parse-ignore'>
								<a href='https://www.facebook.com/ControladoriaGeralAL/'>CGE - AL</a>
							</blockquote>
						</div>
					</center>
				</div>
			</div>
		</div>	
	</div><!--essa div e referente ao fechamento do wrapper, do body padrao-->
<?php
    }

}

?>