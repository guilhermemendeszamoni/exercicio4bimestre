<?php
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	
	$p = $_POST["pg"];
		
	$sql = "SELECT * FROM estado LIMIT $p,5";
	
	$resultado = mysqli_query($conexao,$sql) or die ("Erro." . mysqli_query($conexao));
	
	while ($linha = mysqli_fetch_assoc($resultado)){
		$matriz[] = $linha;
	}
	
	echo json_encode($matriz);
	
?>