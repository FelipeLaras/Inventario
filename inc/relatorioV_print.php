<?php
session_start();
//chamar o banco
require_once('../conexao/conexao.php');

//aplicando a query
$resultado_relatorios = $conn->query($_SESSION['query_relatorios']);

//corpo da msn
$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<style type='text/css'>
			td{
				border: 2px solid #dee2e6;
				font-size: 8px
			}
			th{
				border: 2px solid #dee2e6;
				font-size: 12px;
			}
		</style>
	</head>
	<body>		
		<header>
			<img id='logo' src='../img/logo.png' width='150' alt='Logo'>
		</header>
		<div class='container-fluid'>
 			<p class='text-center'><b>RELATÓRIO DE EQUIPAMENTOS CORPORATIVOS</b></p>
		</div>
		<br>
		<br>
		<br>
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

		  while ($row_relatorio = $resultado_relatorios->fetch_assoc()) {
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

require_once '../dompdf/autoload.inc.php';
require_once '../dompdf/lib/html5lib/Parser.php';
require_once '../dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once '../dompdf/lib/php-svg-lib/src/autoload.php';
require_once '../dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation, landscape = paisagem; portrait = retrato
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('termo_'.$row_fun['nome'].'.pdf',array("Attachment"=>0));//1 - Downlaod,  0 - Prévia

$conn->close();
?>