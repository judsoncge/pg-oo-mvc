jQuery(function($){ 
	$("#processo").mask("99999 999999/9999"); 
	$("#CPF").mask("999.999.999-99");				
	$("#CNPJ").mask("99.999.999/9999-99");				
	$("#telefone").mask("99999-9999");								
	$("#numero_contrato").mask("999999999/9999");				
	$("#numero_contrato_siafi").mask("999999999/9999");
	$("#placa").mask("aaa-9999");
	$("#ano_veiculo").mask("9999/9999");	
	$("#numero_portaria").mask("9999/9999");
	$("#numero_protocolo").mask("9999/9999");	
});



function cadastrar_marcar(){
	boxes = document.getElementsByClassName('cadastra');
	for(var i = 0; i < boxes.length; i++)
	boxes[i].checked = true;
}

function cadastrar_desmarcar(){
	boxes = document.getElementsByClassName('cadastra');
	for(var i = 0; i < boxes.length; i++)
	boxes[i].checked = false;
}

function mascara(o,f){
	v_obj=o
	v_fun=f
	setTimeout("execmascara()",1)
}

function execmascara(){
	v_obj.value=v_fun(v_obj.value)
}
	
function mreais(v){
	v=v.replace(/\D/g,"")		
	v=v.replace(/(\d{2})$/,",$1") 
	return v
}

function pegar_parametro_query(nome, url){
	if (!url) url = window.location.href;
	nome = nome.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + nome + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function formatar_data(date) {
	var nomes_mes = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
	var dia = date.getDate();
	var indice_mes = date.getMonth();
	var ano = date.getFullYear();

	return dia + ' de ' + nomes_mes[indice_mes] + ' de ' + ano;
}

function formatar_data2(data) {
	data = new Date(data);
	var dia = data.getDate() > 9 ? data.getDate(): '0' + data.getDate(),
	month = data.getMonth() + 1;
	month = month > 9 ? month: '0' + month;
	return dia + '/' + month + '/' + data.getFullYear();
}

window.onload = function() {
	
	$('.toggle').click(function(){
		$('#' + $(this).attr("data-target")).toggle();
	})
	
}
