<?php

//chamar o banco
require_once('../conexao/conexao.php');

/*PEGANDO DADOS DO FUNCIONARIO*/
$query_funcionario =  "SELECT  MIF.cpf, MIF.nome, MDF.nome AS funcao, MDD.nome AS departamento, MDE.nome AS empresa
						FROM manager_inventario_funcionario MIF
						LEFT JOIN manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
						LEFT JOIN manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
						LEFT JOIN manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
						WHERE MIF.id_funcionario = '".$_GET['id']."'";

$resultado_funcionarios = $conn->query($query_funcionario);

$row_fun = mysqli_fetch_assoc($resultado_funcionarios);	
/*CORPO DO PDF*/
$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous'>
	</head>
	<style type='text/css'>
		table{
			font-size: 10px;
		}
		.logo{
			margin_left: 80%;
			margin-bottom: 2%;
		}
		.logo2{
			position: absolute;
			top: -20px;
			bottom: 100px;
		}
		.linha_table{
			background-color: #bfbfbf;
		}
		td {
   			border: 1px solid #dee2e6;
		}
		.info_user {
    		background-color: #f9f3f3a1;
		}
		td.marcador {
		    font-size: 20px;
		}
		p{
			font-size: 13px;
		}
		#up_linha {
		    position: absolute;
		    top: -2%;
		}
		p#up {
		    position: absolute;
		    top: 6%;
		}
		img.celular {
		    width: 115%;
		}
		
		th{
			font-weight: bold;
		}
		</style>
	<body>

		<div id='logo2'>
			<img class='logo2' src='./img/logo2.png' width='130' alt='Logo'>
		</div>

		<div id='logo'>
			<img class='logo' src='./img/logo.png' width='150' alt='Logo'>
		</div>

		<div id='tabela'>
			<table class='table table-sm'>
				<thead>
					<tr>
						<th colspan='4'>DEVOLUÇÃO RH (Cheklist)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class='linha_table' scope='row'>FUNCIONÁRIO:</td>
						<td class='info_user'>".$row_fun['nome']."</td>
						<td class='linha_table'>CPF:</td>
						<td class='info_user'>".$row_fun['cpf']."</td>
					</tr>
					<tr>
						<td class='linha_table'>DEPARTAMENTO:</td>
						<td class='info_user'>".$row_fun['departamento']."</td>
						<td class='linha_table'>FUNÇÃO:</td>
						<td class='info_user'>".$row_fun['funcao']."</td>
					</tr>
					<tr>
						<td class='linha_table'>FILIAL:</td>
						<td colspan='4' class='info_user'>".$row_fun['empresa']."</td>
					</tr>
				<tbody>
			</table>
		</div>

		<div id='equipamento_title'>
			<p class='text-left'><u>Lista dos Equipamentos:</u></p>
		</div>";

	/*PEGANDO DADOS DO EQUIPAMENTO*/
	$query_equipamento = "SELECT MIE.id_equipamento, MIE.tipo_equipamento, MIE.modelo, MIE.imei_chip, MIE.valor, MIE.numero
							, MDO.nome AS operadora, MDST.nome AS situacao
							FROM manager_inventario_equipamento MIE
							LEFT JOIN manager_dropoperadora MDO ON MIE.operadora = MDO.id_operadora
							LEFT JOIN manager_dropsituacao MDST ON MDST.id_situacao = MIE.situacao
							WHERE MIE.id_equipamento = ".$_GET['id_equip']."";

	$resulado_equipamento = $conn->query($query_equipamento);
	$row_equi = mysqli_fetch_assoc($resulado_equipamento);

	if ($row_equi['tipo_equipamento'] == 1) {// 1 = CELULAR

		$tipo_equip = "CELULAR";
		$modelo = $row_equi['modelo'];
		$rowspan = '6';

		} elseif ($row_equi['tipo_equipamento'] == 2) {// 2 = TABLET
			$tipo_equip = "TABLET";
			$modelo = $row_equi['modelo'];
			$rowspan = '6';
		}elseif ($row_equi['tipo_equipamento'] == 3){// 3 = CHIP
			$tipo_equip = "CHIIP";
			$modelo = 'Chip';
			$rowspan = '2';
		} elseif ($row_equi['tipo_equipamento'] == 4){// 4 = MODEM
			$tipo_equip = "MODEM";
			$modelo = 'Modem';
			$rowspan = '2';
		}
		$html .= "
		<div id='tabela_equipamento'>
			".$tipo_equip." - ".$row_equi['situacao']."
			<table class='table table-sm'>
				<tbody>
					<tr>
						<td rowspan='".$rowspan."' class='marcador' width='30'>(&nbsp; &nbsp;)</td>
						<td colspan=''>";

					$html .= "<b>Modelo:</b> ";	

					$html .= "- ".$modelo."
						</td>
						<td><b>Operadora:</b> ".$row_equi['operadora']."</td>												
						<td rowspan='".$rowspan."' width='200'><u>OBS.:</u></td>
					</tr>
					<tr>
					<td><b>Imei:</b> ".$row_equi['imei_chip']."</td>
					<td><b>Numero:</b> ".$row_equi['numero']."</td>
					</tr>";

					$query_acessorios = "SELECT mda.nome
										FROM manager_inventario_acessorios mia
										LEFT JOIN manager_dropacessorios mda ON mia.tipo_acessorio = mda.id_acessorio
										WHERE mia.id_equipamento = ".$_GET['id_equip']."";					

					$resultado_acessorios = $conn->query($query_acessorios);
					
					while ($row_acessorios = mysqli_fetch_assoc($resultado_acessorios)) {
							$html .="<tr>
									<td colspan='2'>(&nbsp; &nbsp;)".$row_acessorios['nome']."</td>
								</tr>";
							}	

				$html .="</tbody>
			</table>
		</div>

		<p class='text-left'>Na condição de empregado(a) da filial <b>".$row_fun['empresa']."</b>, estou devolvendo neste ato os equipamentos descritos conforme a cima.</p>
		<p class='text-left'><u>CHECAR ITENS NA DEVOLUÇÃO</u></p>
		<div id='tabela_devolucao'>

			<table style='font-size: 12px; border: 1px solid #dee2e6'>
			  <thead>
			    <tr>
			      <th>Checar</th>
			      <th style='padding-right: 6px;border: solid 1px #dee2e6;'>Status</th>
			      <th style='padding-right: 300px;'>Observacao + Valor do Conserto</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <td>Senha de Desbloqueio</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Dados Pessoais</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Carregador</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Fone de Ouvido</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Cabos</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Botões Faltantes</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Tela Trincada</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Tela Trincada</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Danos por Queda</td>
			      <td></td>
			      <td></td>
			    </tr>
			    <tr>
			      <td>Umidade</td>
			      <td></td>
			      <td></td>
			    </tr>
			  </tbody>
			</table>

		</div>
		<div style='margin-top: 20px'>
			<p class='text-left'>Para os fins do par. 1° do Art. 462 a CLT, desde já autorizo o desconto nas minhas verbas rescisórias, afim de ressarcir os danos acima.</p>
		</div>
		<div id='termo_data'>
			<p class='text-center'>____________, ____ de _____________ de ________</p>
		</div>
		<div id='assinatura'>
			<p class='text-left'>______________________________</p>
			<p class='text-left' style='margin-top: -18px;'>".$row_fun['empresa']."</p>
			<p class='text-left'>______________________________</p>
			<p class='text-left' style='margin-top: -18px;'>".$row_fun['nome']."</p>
		</div>
	</body>
</html>";

require_once 'dompdf/autoload.inc.php';
require_once 'dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/src/Autoloader.php';
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
$dompdf->stream('Vigencia_'.$row_fun['nome'].'.pdf',array("Attachment"=>0));//1 - Download 0 - Previa

$conn->close();
?>