<?php
//chamando a sessão
session_start();

//por via das duvidas

if($_SESSION['patrimonio_termo'] != NULL){
	$patrimonio = $_SESSION['patrimonio_termo'];
}else{
	$patrimonio = $_GET['patrimonio'];
}

//chamar o banco
require_once('../conexao/conexao.php');

/*PEGANDO DADOS DO FUNCIONARIO*/
$query_funcionario =  "SELECT  
MIF.cpf, 
MIF.nome, 
MDF.nome AS funcao,
MDD.nome AS departamento, 
MDE.nome AS empresa
FROM manager_inventario_funcionario MIF
LEFT JOIN manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
LEFT JOIN manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
LEFT JOIN manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
WHERE MIF.id_funcionario = ".$_GET['id_funcionario']."";

$resultado_funcionarios = mysqli_query($conn, $query_funcionario);

$row_fun = mysqli_fetch_assoc($resultado_funcionarios);

/*PEGANDO DADOS DO EQUIPAMENTO*/
$query_equipamento = "SELECT 
MIE.id_equipamento,
MIE.tipo_equipamento AS idTipo_equipamento,
MDE.nome AS tipo_equipamento,
MIE.modelo,
MDEM.nome AS empresa,
MDEM.nome AS filial,
MIE.numero,
MIE.patrimonio,
MIE.serialnumber,
MIE.hd,
MIE.processador,
MIE.memoria,
MIE.observacao,
MDF.nome AS office,
MDSO.nome AS windows
FROM
    manager_inventario_equipamento MIE
        LEFT JOIN
    (manager_dropequipamentos MDE) ON (MIE.tipo_equipamento = MDE.id_equip)
        LEFT JOIN
    (manager_sistema_operacional SO) ON (MIE.id_equipamento = SO.id_equipamento)
        LEFT JOIN
    (manager_office OFFI) ON (MIE.id_equipamento = OFFI.id_equipamento)
        LEFT JOIN
    (manager_dropoffice MDF) ON (OFFI.versao = MDF.id)
        LEFT JOIN
    (manager_dropsistemaoperacional MDSO) ON (SO.versao = MDSO.id)
        LEFT JOIN
    (manager_dropempresa MDEM) ON (MIE.filial = MDEM.id_empresa)
WHERE
MIE.id_funcionario = ".$_GET['id_funcionario']." AND 
MIE.patrimonio = '".$patrimonio."' AND 
MIE.deletar = 0 AND 
MIE.tipo_equipamento IN (9 , 5)";

$resulado_equipamento = mysqli_query($conn, $query_equipamento);
$row_equip = mysqli_fetch_assoc($resulado_equipamento);


if(empty($row_fun['funcao'])){
	header('location: equip_edit.php?id_equip='.$row_equip['id_equipamento'].'&id_fun='.$_GET['id_funcionario'].'&tipo='.$_GET['tipo'].'&erro=1');
}

/*CORPO DO PDF*/
$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<style type='text/css'>
		p.termo_titulo{
			 font-size: 10px; 
			 font-weight: bold;
		}
		p.texto{
			font-size:12px;
		}
		.titulo_segundario{
			font-weight: bold;
			font-size: 12px;
			text-decaration: sublime
		}
		table{
			font-size: 8px;
		}
		
		th{
			font-weight: bold;
		}
		</style>
	</head>
	<body>
		<header>
			<img id='logo' src='./img/logo.png' width='150' alt='Logo'>
		</header>
		<div id='termo_header'>
			<p class='text-center'>&ldquo;TERMO DE ENTREGA E DECLARAÇÃO&rdquo;</p>
		</div>
		<div id='termo_body'>
			<div id='termo_equipamento'>
				<p class='text-center termo_titulo'>EQUIPAMENTOS CORPORATIVOS</p>
			</div>
			<div id='text_departamento'>
				<span id='empresa_departamento'>
					<p class='texto'>Na condição de empregado(a) da filial <span class='titulo_segundario'>".$row_fun['empresa']." - ".$row_fun['departamento']." / ".$row_fun['funcao']."</span>, estou recebendo neste ato equipamento conforme abaixo:
				</span>
			</div>
			<div id='tabela_equipamento'>
				<div id='tabela_titulo_principal'>
					<p class='titulo_segundario'><u>Descrição dos Produtos:</u></p>
				</div>
				<div id='termo_tabela'>
					<table class='table table-sm'>";
		if ($_GET['tipo'] == 9){//notebook

			$html .= "<tr>
						<th>EQUIP.</th>
						<th>MODELO</th>						
						<th>PATRIMÔNIO</th>											
						<th>N. SÉRIE</th>
						<th>HARD DISK(HD)</th> 
						<th>PROCESSADOR</th>						
						<th>MEMORIA</th>
						<th>SISTEMA OPERACIONAL</th>
						<th>OFFICE</th>			    
					</tr>";
				$html .= "<tr>";
					$html .= "<td>".$row_equip['tipo_equipamento']."</td>";
					$html .= "<td>".$row_equip['modelo']."</td>";						  
					$html .= "<td>".$row_equip['patrimonio']."</td>";
					$html .= "<td>".$row_equip['serialnumber']."</td>";
					$html .= "<td>".$row_equip['hd']."</td>";
					$html .= "<td>".$row_equip['processador']."</td>";
					$html .= "<td>".$row_equip['memoria']."</td>";
					$html .= "<td>".$row_equip['windows']."</td>";
					$html .= "<td>".$row_equip['office']."</td>";
				$html .= "</tr>";
		}else{//ramal
			$html .= "<tr>
						<th>EQUIP.</th>
						<th>NÚMERO</th>		
						<th>LOCAÇÃO</th>
						<th>EMPRESA</th>    
					</tr>";

			$query_ramal = "SELECT 
			MDE.nome AS tipo_equipamento,
			MIE.numero,
			MIE.modelo,
			MDL.nome AS locacao,
			MDEM.nome AS filial
		FROM
			manager_inventario_equipamento MIE
				LEFT JOIN
			manager_dropequipamentos MDE ON MIE.tipo_equipamento = MDE.id_equip
				LEFT JOIN
			manager_dropempresa MDEM ON MIE.filial = MDEM.id_empresa
				LEFT JOIN
			manager_droplocacao MDL ON MIE.locacao = MDL.id_empresa
		WHERE
			MIE.id_funcionario = ".$_GET['id_funcionario']."
				AND MIE.tipo_equipamento = 5";

			$resultado_ramal = mysqli_query($conn, $query_ramal);
			while ($row_ramal = mysqli_fetch_assoc($resultado_ramal)){
				$html .= "<tr>";
					$html .= "<td>".$row_ramal['modelo']."</td>";					  
					$html .= "<td>".$row_ramal['numero']."</td>";
					$html .= "<td>".$row_ramal['locacao']."</td>";
					$html .= "<td>".$row_ramal['filial']."</td>";
				$html .= "</tr>";
			}//end WHILE ramal
		}//end IF do ramal		  

$html .=		"</table>
				</div>
			</div>";

			if($row_equip['observacao'] != 0){

				$html .= "
				<div id='tabela_titulo_principal'>
					<p class='titulo_segundario'><u>Observações:</u></p>
				</div>
				<div id='termo_texto'>
					<p class='text-sm-left texto'>&raquo; ".$row_equip['observacao']."</p>
				</div>";
			}

$html .="
			<div id='tabela_titulo_principal'>
				<p class='titulo_segundario'><u>Termo:</u></p>
			</div>
			<div id='termo_texto'>
				<p class='text-sm-left texto'>Comprometendo-me a devolvê-lo, em perfeito estado de conservação, mediante simples solicitação da empresa ou no caso de rescisão contratual, independente do motivo. Declaro que a utilização do referido equipamento <span class='font-weight-bold'><u> será exclusivamente em minha atividade profissional</u></span>,(não esta autorizado fotos particulares, redes sociais, facebook, instagram, tinder, badoo, happn) estou ciente, da minha responsabilidade por danificar culposamente(pelo extravio, queda, danos por contato com umidade, extravio de componentes(carregador), estando isento de responsabilidade por danos advindos de desgates natural por uso cotidiano). Ciente que em caso de mau funcionamento (bateria não carrega) ou defeito do aparelho devo notificar no prazo máximo de 3 dias, após a retirada.</p>
				<p class='text-sm-left texto'>Caso haja necessidade de portar, levar para casa este eletrônico, que devo notificar qualquer estrago ou avaria imediatamente para área de T.I, que caso se faça necessários consertos, estes deverão preferencialmente ser realizados via T.I, só em caso de impossibilidade incompatibilidade (devido a distância) o conserto será feito de forma particular.

					Para os fins do par. 1º do Art. 462 da CLT, desde já autorizo o desconto salarial à conta de eventuais danos
					causados ao equipamento,(descritos acima) reembolsando a minha empregadora pelos reparos necessários ou até mesmo a substituição de um novo aparelho. Lembrando que o valor para ressarcimento será o vigente da data da ocorrência.<p>
			</div>
			<br>
			<div id='termo_data'>
				<p class='text-center'>____________, ____ de _____________ de ________</p>
			</div>
			<div id='termo_footer'>
				<p class='font-weight-light'>Colaborador(A): ".$row_fun['nome']."</p>
				<p class='font-weight-light'>CPF: ".$row_fun['cpf']."</p>
				<p class='font-weight-light'>Assinatura:_______________________________________________________________ </p>
			</div>
		</div>
	</body>
</html>";


//limpando a sessão
unset($_SESSION['patrimonio_termo']);

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

$conn->close();
?>