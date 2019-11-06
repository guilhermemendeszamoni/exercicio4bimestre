<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
</head>
<body>
	<script src="jquery-3.4.1.min.js"></script>
	<script>
		var id = null;
		var filtro = null;
		
		$(document).ready(function()
		{
			
			$("filtro").click(function(){
				$.ajax({
					url:"paginação_estado.php",
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
					url: "carrega_estado_alterar.php",
					type: "post",
					data: {id: id},
					success: function(vetor){
						$("input[name='nome']").val(vetor.nome);
						$("input[name='uf']").val(vetor.uf);
						$(".cadastrar").attr("class","alteracao");
						$(".alteracao").val("Alterar estado");
					}
				});
				
			});
			
			function paginacao(p){
				
				$.ajax({
					url: "carrega_estado.php",
					type:"post",
					data:{pg: p},
					success: function(matriz){
						console.log(matriz);
						$("#tb").html("");
						for(i=0;i<matriz.length;i++){
							linha = "<tr>";
							linha += "<td class='nome'>" + matriz[i].nome + "</td>";
							linha += "<td>" + matriz[i].uf + "</td>";
							linha += "<td><button type='button' class='alterar' value='" + matriz[i].id_estado + "'>alterar</button> <button type='button' class='remover' value='" + matriz[i].id_estado + "'>remover</button> </td>";
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
					uf = $("input[name='uf']").val(); 
					

					
					$.ajax(
					{
						url: "insere_cadastro.php",
						type: "post",
						data: {nome: nome, uf: uf},
						success: function(d)
						{	
						if(d=='1'){
							$("#mensagens").html("estado cadastrado com sucesso");
							$("input[name='nome']").val("");
							$("input[name='uf']").val("");
							paginacao(0);
							}else{
								console.log(d);
							}
						}
					});
			});
			
			$(document).on("click",".alteracao",function(){
				
				nome = $("input[name='nome']").val();
					uf = $("input[name='uf']").val();
					
					$.ajax(
					{
						url: "alteracao_estado.php",
						type: "post",
						data: {
							id_estado: id_estado ,nome: nome, uf: uf},
						success: function(d)
						{	
							if(d=='1'){
								$("#mensagens").html("cadastro alterado com sucesso");
								$("input[name='nome']").val("");
								$("input[name='uf']").val("");
								
								$("input[name='nome']").val("");
								$("select[name='uf']").val("");
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
				td.html("<input type='text' id='nome_alterar' name='nome' value='" + nome + "' />");
				td.attr("class","nome_alterar");
			});
			
			$(document).on("blur",".nome_alterar",function(){
				
				id_linha = $(this).closest("tr").find("button").val();
				$.ajax({
					url:"alterar_coluna.php",
					type:"post",
					data:{coluna:'nome', valor:$("#nome_alterar").val(),
					id: id_linha, tabela: "estado"
					},
					success: function(r){
						console.log(r);
						nome = $("#nome_alterar").val();
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
uf:<input type="text" name="uf" /><br /><br />

<input type="button" class="cadastrar" value="cadastrar" />



<form name="filtro">
	<input type="text" name="nome_filtro" placeholder="filtrar por nome...">
	<button type="button" id="filtrar">filtrar</button>
</form>

<table border='1'>

	<thead>
		<tr>
			<th>nome</th><th>UF</th><th>ação</th>
		</tr>
	</thead>
	<tbody id="tb">
	</tbody>
</table>
<br /><br />

<div id="paginação">
<?php 
		include("conexao.php");
		include("paginacao_cidade.php");
?>
</div>
</body>
</html>