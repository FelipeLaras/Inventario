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
						   if($row_relatorio['empresa'] != NULL){
				$html .=  "<td>".$row_relatorio['empresa']."</td>";         
						   }else{
				$html .= "<td>---</td>";         
						   }
						   //imei
						   if($row_relatorio['funcionario'] != NULL){
				$html .= "<td>".$row_relatorio['funcionario']."</td>";         
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

?>