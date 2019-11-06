<?php
header("content-type: application/json");
include("conexao.php");

$id = $_POST["id"];

$sql = "SELECT * FROM cadastro WHERE id_cadastro='$id'";

$resultado = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));

$linha = mysqli_fetch_assoc($resultado);

echo json_encode($linha);
?>