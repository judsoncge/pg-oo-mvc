<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class HomeView extends View{

	public function home(){ ?>
	
		<div class='grafico' id='processos-ativos'>
			
			<b>Principais notícias</b><br><br>
				
				
				<?php $lista = $_REQUEST['LISTA_NOTICIAS'];
				
				foreach($lista as $noticia){ ?>

					<font size='2px'><?php echo $noticia['DT_NOTICIA']?></font>
					
					
					<a href='/comunicacao/visualizar/<?php echo $noticia['ID'] ?>'><h3><?php echo $noticia['DS_TITULO'] ?></h3></a>
					
					<font size='2px'><?php echo $noticia['DS_INTERTITULO'] ?></font><br><br>					

		<?php	} ?>
		</div>

<?php 
	
	}

}

?>