<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/BaseView.php';

class ArquivosView extends BaseView{
	
	public function carregarConteudo($titulo, $lista){ ?>

		<div id="page-content-wrapper">
			<div class="container titulo-pagina">
				<p><?php echo $titulo ?></p>
			</div>
			<div class="container caixa-conteudo">
				<div class="row">
					<div class="col-lg-12">
						<div class="container">
							<div class="well">	
								<div class="row">
									<div class="col-sm-10">
										<div class="input-group margin-bottom-sm">
											<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span> <input type="text" class="input-search form-control" alt="tabela-dados" placeholder="Busque por qualquer termo da tabela" id="search" autofocus="autofocus" />
										</div>
									</div>
									<div class="col-sm-2 pull-right">
										<a href="cadastrar.php" id="botao-cadastrar">
										<i class="fa fa-plus-circle"></i> Novo arquivo</a>
									</div>
								</div>
							</div>
							<div class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
								<table class="table table-hover tabela-dados">
									<thead>
										<tr>
											<th><center>Tipo</center></th>
											<th><center>Criado por</center></th>
											<th><center>Enviado para</center></th>
											<th><center>Data de criação</center></th>
											<th><center>Baixar</center></th>
											<th><center>Ação</center></th>
										</tr>	
									</thead>
									<tbody>
										<?php foreach($lista as $arquivo){ ?>
										
											<tr>
												<td>
													<center>
														<?php echo $arquivo['NM_TIPO'] ?>
													</center>
												</td>
												<td>
													<center>
														<?php echo $arquivo['CRIACAO'] ?>
													</center>
												</td>
												<td>
													<center>
														<?php echo $arquivo['ENVIADO'] ?>
													</center>
												</td>
												<td>
													<center>
														<?php 
															echo date_format(new DateTime($arquivo['DT_CRIACAO']), 'd/m/Y');
														?>
													</center>
												</td>
												<td>
													<center>
														<a href='<?php echo "/registros/anexos/". $arquivo['NM_ANEXO'] ?>' title='<?php echo $arquivo['NM_ANEXO'] ?>' download>
															<?php echo substr($arquivo['NM_ANEXO'], 0, 20) . "..." ?>
														</a>
													</center> 
												</td>
												<td>
													<?php 
														//so quem pode editar ou excluir é quem criou o arquivo
														if($_SESSION['ID'] == $arquivo['ID_SERVIDOR_CRIACAO']){ ?> 
															<center> 
																<a href='/controller/arquivos/editar.php?operacao=inativar&id=$r->ID'>
																	Inativar
																</a> 
																
																ou 			
																
																<a href='/controller/arquivos/excluir.php?id=$r->ID&anexo=$r->NM_ANEXO'>
																	Excluir
																</a>
															</center>
												  <?php } ?>
												</td>									
											</tr>
									 <?php } ?>		
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div><!--essa div e referente ao fechamento do wrapper, do body padrao-->
<?php 
	
	}

}

?>