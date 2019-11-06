<?php

	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$sexo = $_POST["sexo"];
	$salario = $_POST["salario"];

	include("conexao.php");
	$insert = "INSERT into cadastro (nome, email, sexo, salario)
	VALUES ('$nome', '$email', '$sexo', '$salario')";
		mysqli_query($conexao, $insert)or die(mysqli_error($conexao));
	echo "1";
?>