<?php
session_start();

//chamar o banco
require_once('../conexao/pesquisa_condb.php');

//pesquisa

$query_pesquisa = "SELECT * FROM google WHERE cod_tabela = '".$_GET['id_pesquisa']."'";
$resultadoPesquisa = $conn_db -> query($query_pesquisa);
$pesquisa = $resultadoPesquisa->fetch_assoc();

/*CORPO DO PDF*/
$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
	</head>
	<style>
	div{
		font-size:10px;
	}
	</style>
	<body>		
		<div><h1>".$pesquisa['titulo']."</h1><p class='text-left'>".$pesquisa['body']."<p></div>
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

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser

$dompdf->stream('termo_'.$row_fun['nome'].'.pdf',array("Attachment"=>0));//1 - Download 0 - Previa

?>