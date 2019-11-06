<?php

header("Content-Type: application/json");

	include("conexao.php");
	
	$posicao = $_POST["posicao"];
	
	$consulta = "SELECT * FROM cadastro";
	$resultado = mysqli_query($conexao, $consulta)
		or die("erro. não foi possivel consultar a lista no sistema");
		
	while($linha=mysqli_fetch_assoc($resultado)){
		
		$matriz[] = $linha;

	}
	
	echo json_encode($matriz);
?>