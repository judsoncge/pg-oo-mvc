
/*var soma = 0;
var contador = 0;
var nota_tecnico;
*/


function assiduidade(){
    var n1 = parseInt(document.getElementById('ass1').value, 10);
    var n2 = parseInt(document.getElementById('ass2').value, 10);
    if (Number.isNaN(n1)){
        n1=0;
    }
    if (Number.isNaN(n2)){
        n2=0;
    }
    var result = document.getElementById('ass_result').value = ((n2 / n1) * 10).toFixed(1);;
    if(result > 10){
        result = document.getElementById('ass_result').value = 10;
    }
    /*contador ++;
    soma += parseFloat(result);
    nota_tecnico = document.getElementById('nota-final').innerHTML = soma/contador;
    alert(soma);
    */

}

function cumprimentoDePrazo(){
    var n1 = parseInt(document.getElementById('cum1').value, 10);
    var n2 = parseInt(document.getElementById('cum2').value, 10);
    if (Number.isNaN(n1)){
        n1=0;
    }
    if (Number.isNaN(n2)){
        n2=0;
    }
    var result = document.getElementById('cum_result').value = ((n1 / (n1 + n2)) * 10).toFixed(1);;
    if(result > 10){
        result = document.getElementById('cum_result').value = 10;
    }

}

function legislacao(){
    var n1 = parseInt(document.getElementById('leg1').value, 10);
    var n2 = parseInt(document.getElementById('leg2').value, 10);
    if (Number.isNaN(n1)){
        n1=0;
    }
    if (Number.isNaN(n2)){
        n2=0;
    }
    var result = document.getElementById('leg_result').value = ((n1 / (n1 + n2)) * 10).toFixed(1);;
    if(result > 10){
        result = document.getElementById('leg_result').value = 10;
    }

}


function softwareEscritorio(){
    var n1 = parseInt(document.getElementById('word1').value, 10);
    var n2 = parseInt(document.getElementById('word2').value, 10);
    
    var n3 = parseInt(document.getElementById('excel1').value, 10);
    var n4 = parseInt(document.getElementById('excel2').value, 10);
    
    var n5 = parseInt(document.getElementById('power1').value, 10);
    var n6 = parseInt(document.getElementById('power2').value, 10);
    
    if (Number.isNaN(n1)){
        n1=0;
    }
    if (Number.isNaN(n2)){
        n2=0;
    }
    if (Number.isNaN(n3)){
        n3=0;
    }
    if (Number.isNaN(n4)){
        n4=0;
    }
    if (Number.isNaN(n5)){
        n5=0;
    }
    if (Number.isNaN(n6)){
        n6=0;
    }




   


    var result_word = document.getElementById('word_result').value = ((n1 / (n1 + n2)) * 10).toFixed(1);
    if(result_word > 10){
        result_word = document.getElementById('word_result').value = 10;
    }
  


    var result_excel = document.getElementById('excel_result').value = ((n3 / (n3 + n4)) * 10).toFixed(1);
    if(result_excel > 10){
        result_excel = document.getElementById('excel_result').value = 10;
    }

 


    var result_power = document.getElementById('power_result').value = ((n5 / (n5 + n6)) * 10).toFixed(1);
    if(result_power > 10){
        result_power = document.getElementById('power_result').value = 10;
    }

    var result_soft = document.getElementById('soft_result').value = ((((n1 / (n1 + n2)) * 10) + ((n3 / (n3 + n4)) * 10) + ((n5 / (n5 + n6)) * 10)) / 3).toFixed(1);

}


function softwareCGE(){
    var n1 = parseInt(document.getElementById('soft_cge1').value, 10);
    var n2 = parseInt(document.getElementById('soft_cge2').value, 10);
    if (Number.isNaN(n1)){
        n1=0;
    }
    if (Number.isNaN(n2)){
        n2=0;
    }
    var result = document.getElementById('soft_cge_result').value = ((n1 / (n1 + n2)) * 10).toFixed(1);
    if(result > 10){
        result = document.getElementById('soft_cge_result').value = 10;
    }

}


function proatividade(){
    var n1 = parseInt(document.getElementById('pro1').value, 10);
    var n2 = parseInt(document.getElementById('pro2').value, 10);
    if (Number.isNaN(n1)){
        n1=0;
    }
    if (Number.isNaN(n2)){
        n2=0;
    }
    var result = document.getElementById('pro_result').value = (((n2 / n1) * 10) + 5).toFixed(1);
    if(result > 10){
        result = document.getElementById('pro_result').value = 10;
    }

}
