<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class HomeView extends View{
	
	//esta funcao carrega o conteudo da pagina, pegando a lista das cinco comunicacoes mais atuais que vem do controller
	public function listar(){ 
	
?>
	
		<div class='grafico' id='processos-ativos' >
			<b>Principais notícias</b><br>
<?php 
				$lista = $_REQUEST['LISTA_NOTICIAS'];
				foreach($lista as $noticia){ 
?>
					<font size='2px'>(<?php echo date_format(new DateTime($noticia['DT_PUBLICACAO']) , 'd/m/Y H:i') ?>)</font>
					<a href='/comunicacao/visualizar/<?php echo $noticia['ID'] ?>'><h3><?php echo $noticia['DS_INTERTITULO'] ?></h3></a>
					<font size='2px'><?php echo $noticia['DS_TITULO'] ?></font><br><br>					

<?php			} 
				
?>
		</div>

<?php
    
	}

}

?>