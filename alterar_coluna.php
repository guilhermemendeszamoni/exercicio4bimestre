<?php
	include("conexao.php");
	$coluna = $_POST["coluna"];
	$valor = $_POST["valor"];
	$id = $_POST["id"];
	$tabela = $_POST["tabela"];
	
	$update = "UPDATE $tabela SET $coluna='$valor' WHERE id_$tabela='$id'";
	
	mysqli_query($conexao,$update) or die(mysqli_error($conexao));
?>