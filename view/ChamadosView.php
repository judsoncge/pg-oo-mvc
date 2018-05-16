<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ChamadosView extends View{
	
	public function listar(){ ?>
		
		<div class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			<table class="table table-hover tabela-dados">
				<thead>
					<tr>
						<th>Abertura</th>
						<th>Natureza do problema</th>
						<th>Solicitante</th>
						<th>Status</th>
						<th>Avaliação</th>
						<th>Ação</th>
					</tr>	
				</thead>
				<tbody>
					<?php 
					
						$lista = $_REQUEST['LISTA_CHAMADOS'];
						
						foreach($lista as $chamado){ 
							
							$styleTR = ($chamado['DS_STATUS'] == 'RESOLVIDO' && $chamado['DS_AVALIACAO'] != "SEM AVALIAÇÃO") 
								? "style='background-color:#f1c40f'" 
								: "";

					?>
							<tr <?php echo $styleTR ?>>
								<td><?php echo date_format(new DateTime($chamado['DT_ABERTURA']), 'd/m/Y H:i:s') ?></td>
								<td><?php echo $chamado['DS_NATUREZA'] ?></td>
								<td><?php echo $chamado['DS_NOME_REQUISITANTE'] ?></td>
								<td><?php echo $chamado['DS_STATUS'] ?></td>
								<td><?php echo $chamado['DS_AVALIACAO'] ?></td>
								<td>
									<a href="detalhes.php?id=<?php echo $chamado['ID'] ?>">
										<button type='button' class='btn btn-secondary btn-sm' title='Detalhes e operações'>
											<i class='fa fa-eye' aria-hidden='true'></i>
										</button>
									</a>
								</td>
							</tr>
			      <?php 
						} 
				  ?>	
				</tbody>
			</table>
		</div>
<?php 
	
	}
	
	public function cadastrar(){

?>
	
		<form name="cadastro" method="POST" action="cadastrar/chamado/" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					 <div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Natureza do problema:</label>
						<select class="form-control" id="natureza" name="natureza_problema" required/>
							<option value="">Selecione a natureza do problema</option>
							<option value="WORD">WORD</option>
							<option value="EXCEL">EXCEL</option>
							<option value="POWER POINT">POWER POINT</option>
							<option value="TRELLO">TRELLO</option>
							<option value="SIAFEM">SIAFEM</option>
							<option value="SIAPI">SIAPI</option>
							<option value="COMPUTADOR OU PEÇA COM DEFEITO">COMPUTADOR OU PEÇA COM DEFEITO</option>
							<option value="INTERNET">INTERNET</option>
							<option value="COMPARTILHAMENTO DE PASTA">COMPARTILHAMENTO DE PASTA</option>
							<option value="IMPRESSORA">IMPRESSORA</option>
							<option value="PAINEL DE GESTÃO">PAINEL DE GESTÃO</option>
							<option value="OUTRO">OUTRO</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="comment">Problema: (máx 300 carac.)</label>
						<input type='text' class='form-control' rows='1' id='problema' name='problema' maxlength="300" required></input>	
					</div>	
				</div>
			</div>	
			<div class="row" id="cad-button">
				<div class="col-md-12">
					<button type="submit" class="btn btn-default" name="submit" value="Send" id="submit">Abrir chamado</button>
				</div>
			</div>
		</form>
	
<?php	
	
	}
	
	

	

}

?>