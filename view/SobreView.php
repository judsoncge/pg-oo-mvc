<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class SobreView extends View{
	
	
	public function visualizar(){

?>	
		
	<div class="container caixa-conteudo">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-12">
					<p class="text-justify">O Sistema Painel de Gestão CGE foi criado com o objetivo auxiliar no gerenciamento de processos, pessoas e tecnologias dentro do órgão Controladoria Geral do Estado, Governo de Alagoas.</p>
					<p class="text-justify">O Sistema foi idealizado e criado pelo setor de Assessoria de Governança e Transparência da Controladoria Geral do Estado de Alagoas, sob o apoio da atual gestora Controladora Geral Dra. Maria Clara Cavalcante Bugarim.</p>
					<hr>
				</div>
			</div>
			<center><p style="font-size: 20pt;">Equipe</p>	
				<div class="row">
					<div class='col-md-3'>
						<div class='box-equipe'>
							<img src='/_registros/fotos-equipe/clara.png' class='equipe-img'>
						</div>
						<div class='equipe_servidor'><b>Maria Clara Bugarim</b><br>Apoio</div>
					</div>
					<div class='col-md-3'>
						<div class='box-equipe'>
							<img src='/_registros/fotos-equipe/thiago.png' class='equipe-img'>
						</div>
						<div class='equipe_servidor'><b>Thiago Paiva</b><br>Coordenador</div>
					</div>
					<div class='col-md-3'>
						<div class='box-equipe'>
							<img src='/_registros/fotos-equipe/judson.jpg' class='equipe-img'>
						</div>
						<div class='equipe_servidor'><b>Judson Bandeira</b><br>Analista de TI</div>
					</div>
					<div class='col-md-3'>
						<div class='box-equipe'>
							<img src='/_registros/fotos-equipe/vilker.jpg' class='equipe-img'>
						</div>
						<div class='equipe_servidor'><b>Vilker Tenório</b><br>Analista de TI</div>
					</div>	
				</div>
				<div class='row'>
					<div class='col-md-3'>
						<div class='equipe_servidor'><b>Anterior: Denys Rocha</b><br>Analista de TI</div>
					</div>
					<div class='col-md-3'>
						<div class='equipe_servidor'><b>Anterior: Romero Malaquias</b><br>Analista de TI</div>
					</div>
				</div>
			</center>				
		</div>
	</div>
		
<?php		
		
	}

}

?>