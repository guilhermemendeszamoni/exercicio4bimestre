<?php
$host = "localhost:3307";
$user = "root";
$senha = "usbw";
$bd = "ex_4bimestre";

$conexao = mysqli_connect($host, $user, $senha, $bd) 
	or die("erro conexão");
	
mysqli_set_charset($conexao, "utf8");

?>