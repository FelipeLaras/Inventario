<?php

//chamar o banco
include 'conexao.php';

/*PEGANDO DADOS DO FUNCIONARIO*/
$query_funcionario =  "SELECT 
MIF.cpf,
MIF.nome,
MDF.nome AS funcao,
MDD.nome AS departamento,
MDE.nome AS empresa
FROM
manager_inventario_funcionario MIF
	INNER JOIN
manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
	INNER JOIN
manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
	INNER JOIN
manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
WHERE
MIF.id_funcionario = '".$_GET['id_fun']."'";

$resultado_funcionarios = mysqli_query($conn, $query_funcionario);

$row_fun = mysqli_fetch_assoc($resultado_funcionarios);	
/*CORPO DO PDF*/
$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous'>		
	</head>
	<style type='text/css'>
		font-weight-light{
			font-size: 9px;
		}
		table{
			font-size: 8px;
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
   			padding: 3px;
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
		    top: 18%;
		}
		img.celular {
		    width: 115%;
		}
		
		th{
			font-weight: bold;
		}

		#alerta{
			margin-bottom: -12px;
			margin-top: 5px;
		}
		#titulo_alerta{
			font-size: 14px;
			margin-bottom: -2px;
			color: red;
			font-weight: bold;
		}
		#sub_alerta{
			font-size: 7px;
		}
		</style>
	<body>

		<div id='logo2'>
			<img class='logo2' src='./img/logo2.png' width='130' alt='Logo'>
		</div>

		<div id='logo'>
			<img class='logo' src='./img/logo.png' width='150' alt='Logo'>
		</div>
		
		<div id='alerta'>
			<p id='titulo_alerta'>&ldquo; É OBRIGATÓRIO A DEVOLUÇÃO DESTE DOCUMENTO ASSINADO PARA O DEPARTAMENTO DO T.I &rdquo;</p>
			<p id='sub_alerta'>Caso não consiga entregar o documento fisicamente pode ser escaneado e enviado por e-mail.</p>
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
	$query_equipamento = "SELECT 
    MIE.id_equipamento,
    MIE.tipo_equipamento AS id_tipo_equipamento,
    MDE.nome AS tipo_equipamento,
    MIE.patrimonio,
    MIE.serialnumber,
    MIE.processador,
    MIE.modelo,
    MIE.hd,
    MIE.memoria,
    MIE.numero,
    MDST.nome AS situacao,
	MDSO.nome AS nome_so,
    MDOF.nome AS nome_office
FROM
    manager_inventario_equipamento MIE
		LEFT JOIN
	manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
        LEFT JOIN
    manager_dropsituacao MDST ON MDST.id_situacao = MIE.situacao
		LEFT JOIN
	manager_sistema_operacional MSO ON MIE.id_equipamento = MSO.id_equipamento
		LEFT JOIN
	manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
		LEFT JOIN
	manager_office MO ON MIE.id_equipamento = MO.id_equipamento
		LEFT JOIN
	manager_dropoffice MDOF ON MO.versao = MDOF.id
WHERE
    MIE.id_funcionario = ".$_GET['id_fun']." AND MIE.deletar = 0";

	$resulado_equipamento = mysqli_query($conn, $query_equipamento);
		while ($row_equi = mysqli_fetch_assoc($resulado_equipamento)) {

			if($row_equi['id_tipo_equipamento'] == 9){
				$html .= "
				<div class='row'>
					<div class='col-sm'>
						<p class='font-weight-light'>
							Equipamento:...... ".$row_equi['tipo_equipamento']." <span style='font-size: 8px;'>(".$row_equi['situacao'].")</span><br />
							Modelo:...... ".$row_equi['modelo']."<br />
							Patrimônio:...... ".$row_equi['patrimonio']."<br />
							N. Série:...... ".$row_equi['serialnumber']."<br />
							Hard Disk:...... ".$row_equi['hd']."<br />
							Processador:...... ".$row_equi['processador']."<br />
							Memoria:...... ".$row_equi['memoria']."<br />
							Sistema Operacional:...... ".$row_equi['nome_so']."<br />";

							if($row_equi['nome_office'] == NULL){
								$html .= "Office:...... Não possui";
							}else{
								$html .= "Office:...... ".$row_equi['nome_office']."<br />";
							}//end IF office						
						
						$html .="
						</p>
					</div>
				</div>
				";
			}else{
				$html .= "
				<div class='row'>
					<div class='col-sm'>
						<p class='font-weight-light'>
							Equipamento:...... ".$row_equi['tipo_equipamento']."<br />
							Número:...... ".$row_equi['numero']."<br />
						</p>
					</div>
				</div>
				";
			}//end IF notebook
		}//end While



				$html .= "		
		<p class='text-left'>Na condição de empregado(a) da filial <b>".$row_fun['empresa']."</b>, estou devolvendo neste ato os equipamentos descritos conforme a cima.</p>
		<p class='text-left'><u>CHECAR ITENS NA DEVOLUÇÃO</u></p>
		<div id='tabela_devolucao'>

			<table style='font-size: 8px; border: 1px solid #dee2e6'>
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
		<br>
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
$dompdf->stream('termo_'.$row_fun['nome'].'.pdf',array("Attachment"=>0));//1 - Download 0 - Previa

mysqli_close($conn);
?>