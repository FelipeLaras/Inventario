<?php
session_start();
//chamar o banco
include 'conexao.php';

//aplicando a query
$resultado_relatorios = mysqli_query($conn, $_SESSION['query_relatorios']);

/*
* Criando e exportando planilhas do Excel
* /
*/
// Definimos o nome do arquivo que será exportado
$arquivo = 'relatorio_equipamentos.xls';
// Criamos uma tabela HTML com o formato da planilha
$html = "
<html>
	<body>
		<table class='table table-sm' style='font-size:12px;'>
			<thead>
				<tr>
					<th scope='col'>T.EQUIPAMENTO</th>
					<th scope='col'>COLABORADOR</th>
					<th scope='col'>USUARIO</th>
					<th scope='col'>DATA VIGENCIA</th>
				</tr>
			</thead>
		<tbody>";

		  while ($row_relatorio = mysqli_fetch_assoc($resultado_relatorios)) {
			$html .= "<tr>";               
			//CÓDIGO DO EQUIPAMENTO 
			if($row_relatorio['tipo_equipamento'] != NULL){
				$html .= "<td>".$row_relatorio['tipo_equipamento']."</td>";         
			}else{
				$html .= "<td>---</td>";         
			}
			//COLABORADOR
			if($row_relatorio['colaborador'] != NULL){
				$html .= "<td>".$row_relatorio['colaborador']."</td>";         
			}else{
				$html .= "<td>---</td>";         
			}
			//USUÁRIO
			if($row_relatorio['id_usuario'] != NULL){
				$html .= "<td>".$row_relatorio['id_usuario']."</td>";         
			}else{
				$html .= "<td>---</td>";         
			}
			//DATA DA VIGENCIA
			if($row_relatorio['data_vigencia'] != NULL){
				$html .= "<td>".$row_relatorio['data_vigencia']."</td>";         
			}else{
				$html .= "<td>---</td>";         
			}
			$html .= "</tr>";
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