$(document).ready(function(){
	$(".servidores-subitem").hide(500);
	
	$(".processos-subitem").hide(500);
	
	$(".arquivos-subitem").hide(500);
	
	$(".chamados-subitem").hide(500);
	
	$(".comunicacao-subitem").hide(500);
		
		
		
	$("#servidores").click(function(){
		$(".servidores-subitem").slideToggle();
	});
	
	$("#processos").click(function(){
		$(".processos-subitem").slideToggle();
	});
	
	$("#arquivos").click(function(){
		$(".arquivos-subitem").slideToggle();
	});
	
	$("#chamados").click(function(){
		$(".chamados-subitem").slideToggle();
	});
	
	$("#comunicacao").click(function(){
		$(".comunicacao-subitem").slideToggle();
	});
	
	
});