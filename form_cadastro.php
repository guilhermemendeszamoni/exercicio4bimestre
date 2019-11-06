<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
</head>
<body>
	<script src="jquery-3.4.1.min.js"></script>
	<script>
		var id = null;

		
		$(document).ready(function()
		{
			
			$("filtro").click(function(){
				$.ajax({
					url:"paginação_cadastro.php",
					type:"post",
					data:{
							nome_filtro: $("input[name='nome_filtro']")
						},
					success: function(d){
						$("#paginação").html(d);
					}
				})
			});
			
			paginacao(0);
			
			$(document).on("click", ".alterar",function(){
				id = $(this).attr("value");
				
				$.ajax({
					url: "carrega_cadastro_alterar.php",
					type: "post",
					data: {id: id},
					success: function(vetor){
						$("input[name='nome']").val(vetor.nome);
						$("input[name='email']").val(vetor.email);
						if(vetor.sexo=="m"){
							$("input[name='sexo'][value='f']").attr(
							"checked",false);
							$("input[name='sexo'][value='m']").attr(
							"checked",true);
						}
						else{
							$("input[name='sexo'][value='m']").attr(
							"checked",false);
							$("input[name='sexo'][value='f']").attr(
							"checked",true);
						}
						$(".cadastrar").attr("class","alteracao");
						$(".alteracao").val("Alterar cadastro");
					}
				});
				
			});
			
			function paginacao(p){
				
				$.ajax({
					url: "carrega_cadastro.php",
					type:"post",
					data:{pg: p},
					success: function(matriz){
						console.log(matriz);
						$("#tb").html("");
						for(i=0;i<matriz.length;i++){
							linha = "<tr>";
							linha += "<td class='nome'>" + matriz[i].nome + "</td>";
							linha += "<td>" + matriz[i].email + "</td>";
							linha += "<td>" + matriz[i].sexo + "</td>";
							linha += "<td>" + matriz[i].salario + "</td>";
							linha += "<td><button type='button' class='alterar' value='" + matriz[i].id_cadastro + "'>alterar</button> <button type='button' class='remover' value='" + matriz[i].id_cadastro + "'>remover</button> </td>";
							linha += "</tr>";
							$("#tb").append(linha);
						}
					}
					
				});
				
			}
			
			$(document).on("click",".pg",function(){
				p = $(this).val();
				p = (p-1)*5;
				paginacao(p);
			});
			
			
			
			
			$(document).on("click",".cadastrar",function()
			{
					nome = $("input[name='nome']").val();
					email = $("input[name='email']").val();
					sexo = $("input[name='sexo']:checked").val();
					salario = $("input[name='salario']").val();

					
					$.ajax(
					{
						url: "insere_cadastro.php",
						type: "post",
						data: {nome: nome, email: email, sexo: sexo,salario:salario},
						success: function(d)
						{	
						if(d=='1'){
							$("#mensagens").html("pessoa cadastrada com sucesso");
							$("input[name='nome']").val("");
							$("input[name='email']").val("");
							$("input[name='sexo']").prop("checked",false);
							paginacao(0);
							}else{
								console.log(d);
							}
						}
					});
			});
			
			$(document).on("click",".alteracao",function(){
				
				nome = $("input[name='nome']").val();
					email = $("input[name='email']").val();
					sexo = $("input[name='sexo']:checked").val();

					
					$.ajax(
					{
						url: "alteracao_cadastro.php",
						type: "post",
						data: {
							id: id,nome: nome, email: email, sexo: sexo},
						success: function(d)
						{	
							if(d=='1'){
								$("#mensagens").html("cadastro alterado com sucesso");
								$("input[name='nome']").val("");
								$("input[name='email']").val("");
								$("input[name='sexo']").prop("checked",false);
								paginacao(0);
								$("input[name='nome']").val("");
								$("input[name='email']").val("");
								$(".alteracao").attr("class","cadastrar");
								$(".cadastrar").val("cadastrar");
								
								}else{
									console.log(d);
								}
						}
					});
				
			});
			
			$(document).on("click",".nome",function(){
				td = $(this);
				nome = td.html();
				td.html("<input type='text' name='nome' value='" + nome + "' />");
				td.attr("class","nome_alterar");
			});
			
			$(document).on("blur",".nome_alterar",function(){
				
				id_linha = $(this).closest("tr").find("button").val();
				$.ajax({
					url:"alterar_coluna.php",
					type:"post",
					data:{coluna:'nome', valor:$("#nome_alterar").val(),
					id: id_linha
					},
					success: function(){
						nome = $("nome_alterar").val();
						td.html(nome);
						td.attr("class","nome");
					}
				});
			});
		});
	</script>
	<div id="mensagens"></div>
	
<?php

	include("conexao.php");

?>	
	
nome:<input type="text" name="nome" /><br /><br />
email:<input type="text" name="email" /><br /><br />
salario:<input type="text" name="salario" /><br /><br />
sexo:<br /><br />
masculino<input type="radio" name="sexo" value="m">
feminino<input type="radio" name="sexo" value="f">
<br /><br />

<input type="button" class="cadastrar" value="cadastrar" />

<h3>cadastros</h3>

<form name="filtro">
	<input type="text" name="nome_filtro" placeholder="filtrar por nome...">
	<button type="button" id="filtrar">filtrar</button>
</form>

<table border='1'>

	<thead>
		<tr>
			<th>nome</th><th>email</th><th>sexo</th><th>salario</th><th>ação</th>
		</tr>
	</thead>
	<tbody id="tb">
	</tbody>
</table>
<br /><br />

<div id="paginação">
<?php 
		include("conexao.php");
		include("paginacao_cadastro.php");
?>
</div>
</body>
</html>