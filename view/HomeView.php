<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class HomeView extends View{
	
	//esta funcao carrega o conteudo da pagina, pegando a lista das cinco comunicacoes mais atuais que vem do controller
	public function carregarConteudo(){ ?>

		<div id='page-content-wrapper'>
			<p><?php echo $this->titulo ?></p>
			<div class='row linha-grafico'>
				<div class='col-md-12'>
					<div class='grafico' id='processos-ativos' >
						<b>Principais notícias</b>:
						<br>
						<?php foreach($this->lista as $noticia){ ?>
								
								<font size='2px'>
								    (<?php echo date_format(new DateTime($noticia['DT_PUBLICACAO']) , 'd/m/Y H:i') ?>)
								</font>
								
								<br>
								
								<a href="#">
									<h3><?php echo $noticia['DS_INTERTITULO'] ?></h3>
								</a>
								
								<font size="2px">
									<?php echo $noticia['DS_TITULO'] ?>
								</font>	
								
								<br>
								<br>
								
					<?php 	} ?>
					</div>
				</div>
			</div>
		</div>	
	</div><!--essa div e referente ao fechamento do wrapper, do body padrao-->
<?php
    }

}

?>