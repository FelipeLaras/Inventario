<?php
session_start();
//chamar o banco
require_once('../conexao/conexao.php');

//aplicando a query
$resultado_relatorios = $conn->query($_SESSION['query_relatorios']);

/*
* Criando e exportando planilhas do Excel
* /
*/
// Definimos o nome do arquivo que será exportado
$arquivo = 'relatorio_equipamentos.xls';
// Criamos uma tabela HTML com o formato da planilha
$html = "
<html>
	<style>
		td{
			border: solid 1px;
		}
	</style>
	<body>
		<table class='table table-sm' style='font-size:12px;'>
		  <thead>
		    <tr>
				<th scope='col'>ID</th>
				<th scope='col'>MODELO</th>
				<th scope='col'>EQUIPAMENTO</th>
				<th scope='col'>PATRIMONIO</th>
				<th scope='col'>NUMERO</th>
				<th scope='col'>IMEI-CHIP</th>
				<th scope='col'>STATUS</th>
				<th scope='col'>DEPARTAMENTO</th>
				<th scope='col'>EMPRESA</th>
				<th scope='col'>FUNCIONARIO</th>
		    </tr>
		  </thead>
		  <tbody>";

		  while ($row_relatorio = mysqli_fetch_assoc($resultado_relatorios)) {
$html .="
			<tr><td>".$row_relatorio['id_equipamento']."</td>";
				//modelo
				if($row_relatorio['modelo'] != NULL){
	$html .= "<td>".$row_relatorio['modelo']."</td>";         
			}else{
	$html .=  "<td>---</td>";         
			}
			//cpf
			if($row_relatorio['equipamento'] != NULL){
	$html .= "<td>".$row_relatorio['equipamento']."</td>";         
			}else{
	$html .=  "<td>---</td>";         
			}
			//funcao
			if($row_relatorio['patrimonio'] != NULL){
	$html .= "<td>".$row_relatorio['patrimonio']."</td>";         
			}else{
	$html .=  "<td>---</td>";         
			}
			//departamento
			if($row_relatorio['numero'] != NULL){
	$html .= "<td>".$row_relatorio['numero']."</td>";         
			}else{
	$html .=  "<td>---</td>";         
			}
			//filial
			if($row_relatorio['imei_chip'] != NULL){
	$html .= "<td>".$row_relatorio['imei_chip']."</td>";         
			}else{
	$html .=  "<td>---</td>";         
			}
			//tipo_equipamento
			if($row_relatorio['status'] != NULL){
	$html .= "<td>".$row_relatorio['status']."</td>";         
			}else{
	$html .=  "<td>---</td>";         
			}
               //patrimonio
               if($row_relatorio['departamento'] != NULL){
	$html .= "<td>".$row_relatorio['departamento']."</td>";         
               }else{
	$html .=  "<td>---</td>";         
               }
               //modelo
               if($row_relatorio['filial'] != NULL){
	$html .=  "<td>".$row_relatorio['filial']."</td>";         
               }else{
	$html .= "<td>---</td>";         
               }
               //imei
               if($row_relatorio['nome'] != NULL){
	$html .= "<td>".$row_relatorio['nome']."</td>";         
               }else{
	$html .= "<td>---</td>";         
               }
	$html .= "
		    </tr>";
		    }
	$html .= "</tbody>
		</table>
	</body>
</html>";

// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Envia o conteúdo do arquivo
echo $html;
exit;