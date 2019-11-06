<?php

	include("conexao.php");
	
	$sql = "SELECT COUNT(*) as qtd FROM estado";
	
	if(!empty($_POST)){
		$nome = $_POST["nome_filtro"];
		$sql .= " WHERE nome LIKE '%$nome%'";
	}
	
	$resultado = mysqli_query($conexao,$sql) or die ("ERRO." .mysqli_query);
	
	$linha = mysqli_fetch_assoc($resultado);
	
	$qtd_tupla = $linha["qtd"];
	
	$qtd_botoes = (int)($qtd_tupla/5);
	
	if($qtd_tupla%5!=0){
		$qtd_botoes++;
	}
	
	for($i=1;$i<$qtd_botoes;$i++){
		echo "<button type='button' value='$i' class='pg'>$i</button> ";
	}
?>