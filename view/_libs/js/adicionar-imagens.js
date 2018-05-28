var id_row = 1;
var id = 1;

function adicionarImagem(){
	
	var newdiv = document.createElement('div');
	
	newdiv.setAttribute("name", "campos"+id);
	
	newdiv.setAttribute("id", id);
	
	newdiv.innerHTML = 
	"<div class='row'>"+
		"<div class='col-md-4'>"+
			"Selecione a imagem:<br>"+
				"<input type='file' id='selecao-arquivo' name='imagens[]' accept='.jpg, .jpeg, .pjpeg, .gif, .png' id='imagem' required />"+	
		"</div>"+
		"<div class='col-md-3'>"+
			"Legenda:<br>"+
			"<input class='form-control' id='legenda' name='legendas[]' placeholder='Máximo de 100 caracteres' type='text' maxlength='100' required />"+	
		"</div>"+
		"<div class='col-md-2' >"+
			"Créditos:<br>"+
			"<input class='form-control' id='creditos' name='creditos[]' placeholder='Máx. de 30 caracteres' type='text' maxlength='30' required />"+
		"</div>"+
		"<div class='col-md-2' >"+
			"É pequena?<br>"+
			"<select class='form-control' id='pequenas' name='pequenas[]' placeholder='Máximo de 30 caracteres' type='text' maxlength='30' required />"+
				"<option value='0'>Não</option>"+
				"<option value='1'>Sim</option>"+
			"</select>"+
		"</div>"+
		"<div class='col-md-1' >"+
			"Remover:<br>"+
			"<center><a href='javascript:void(0)' title='remover' onclick='removerImagem("+id+");'><i class='fa fa-times' aria-hidden='true'></i></a></center>"+
		"</div>"+
	"</div>";
	
	var nova_imagem = document.getElementById("adicionarImagem");

	nova_imagem.appendChild(newdiv);
	
	id++;
	
}

function removerImagem(id){
	
	document.getElementById(id).innerHTML=""; 
	
}

function aparecerSubmit(){
	
	document.getElementById("submitImagens").style.display="block";
	
}
