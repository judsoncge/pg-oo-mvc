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
							
							$styleTR = ($chamado['DS_STATUS'] == 'FECHADO' && $chamado['DS_AVALIACAO'] != "SEM AVALIAÇÃO") 
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
									<a href="/detalhar/chamado/<?php echo $chamado['ID'] ?>">
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
	
		<form name="cadastro" method="POST" action="/cadastrar/chamado/" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					 <div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Natureza do problema:</label>
						<select class="form-control" id="natureza" name="natureza" required />
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
	
	public function detalhar(){
		
		$lista = $_REQUEST['DADOS_CHAMADO'];
		
?>		
	
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12">
				<div class="row linha-modal-processo">
					
					<?php if($lista['DS_STATUS'] =='ABERTO' and $_SESSION['FUNCAO']=='TI'){ ?>
					
							<a href="logica/editar.php?operacao=resolver&id=<?php echo $id ?>"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Resolver chamado&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden="true"></i></button></a>
					
					<?php } 	
					
					if($lista['DS_STATUS']=='FECHADO' and $_SESSION['FUNCAO']=='TI' and $lista['DS_AVALIACAO'] != "SEM AVALIAÇÃO"){ ?>
					
							<a href="logica/editar.php?operacao=encerrar&id=<?php echo $id ?>"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Encerrar chamado&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden="true"></i></button></a>
					<?php } 
					
					if($_SESSION['FUNCAO'] == 'TI' and $lista['DS_STATUS']=='ABERTO'){ ?>
							
							<a href="logica/excluir.php?id=<?php echo $id ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este processo?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true"></i></button></a>
						
					<?php } ?>
				</div> 
			</div>
		</div>

<?php		
	}

	

}

?>