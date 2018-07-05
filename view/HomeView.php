<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class HomeView extends View{
	
	//esta funcao carrega o conteudo da pagina, pegando a lista das cinco comunicacoes mais atuais que vem do home controller
	public function listar(){ ?>
	
		<div class='grafico' id='processos-ativos'>
			
			<b>Principais notícias</b><br><br>
				
				<!-- a lista é solicitada ao home controller -->
				<?php $lista = $_REQUEST['LISTA_NOTICIAS'];
				
				foreach($lista as $noticia){ ?>

					<font size='2px'><?php echo $noticia['DT_PUBLICACAO']?></font>
					
					<!-- quando o usuário clica no título, leva para a página da notícia completa -->
					<a href='/comunicacao/visualizar/<?php echo $noticia['ID'] ?>'><h3><?php echo $noticia['DS_TITULO'] ?></h3></a>
					
					<font size='2px'><?php echo $noticia['DS_INTERTITULO'] ?></font><br><br>					

		<?php	} ?>
		</div>

<?php 
	
	}

}

?>