<?php
/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); */
//sessão da merda toda
session_start(); 

//chamar o banco
require_once('../conexao/conexao.php');

/*PEGANDO DADOS DO FUNCIONARIO*/
$query_funcionario =  "SELECT  
							MIF.cpf, 
							MIF.nome, 
							MDF.nome AS funcao, 
							MDD.nome AS departamento, 
							MDE.nome AS empresa,
							MIOB.obs
						FROM 
							manager_inventario_funcionario MIF
						LEFT JOIN 
							manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
						LEFT JOIN 
							manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
						LEFT JOIN 
							manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
						LEFT JOIN
							manager_inventario_obs MIOB ON MIF.id_funcionario = MIOB.id_funcionario
						WHERE 
							MIF.id_funcionario = ".$_GET['id_fun']."";

$resultado_funcionarios = $conn->query($query_funcionario);

$row_fun = $resultado_funcionarios->fetch_assoc();

/*PEGANDO DADOS DO EQUIPAMENTO*/

$queryEquipamento = "SELECT 
						MIE.id_equipamento,
						MDE.nome AS tipo_equipamento,
						MIE.modelo,
						MIE.patrimonio,
						MIE.imei_chip,
						MIE.valor,
						MIE.numero,
						MIE.planos_dados,
						MDST.nome AS situacao,
						MDET.nome as estado
					FROM
						manager_inventario_equipamento MIE
					LEFT JOIN
						manager_dropequipamentos MDE ON (MIE.tipo_equipamento = MDE.id_equip)
					LEFT JOIN
						manager_dropsituacao MDST ON (MIE.situacao = MDST.id_situacao)
					LEFT JOIN
						manager_dropestado MDET ON (MIE.estado = MDET.id)
					WHERE
						MIE.id_funcionario = ".$_GET['id_fun']." AND MIE.deletar = 0";

$resultEquipamento = $conn->query($queryEquipamento);


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
			<img id='logo' src='../img/logo.png' width='150' alt='Logo'>
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
					<table class='table table-sm'>
					  <tr>
					  	<th>EQUIP.</th>
						<th>MODELO</th>
						<th>PATRIMÔNIO</th>
					    <th>IMEI</th> 
					    <th>VALOR</th>
					    <th>NÚMERO</th>
					    <th>PLANOS</th>
					    <th>ACESSÓRIOS</th>
						<th>SITUAÇÃO</th>						
					    <th>ESTADO</th>	    
					  </tr>";

						while ($equip = $resultEquipamento->fetch_assoc()) {
							$html .=  "<tr> <td>".$equip['tipo_equipamento']."</td> <td>".$equip['modelo']."</td>";

							$html .= (empty($equip['patrimonio'])) ? "<td>---</td>" : "<td>".$equip['patrimonio']."</td>";
							
							$html .= (empty($equip['imei_chip'])) ? "<td>---</td>" : "<td>".$equip['imei_chip']."</td>";

							$html .= (empty($equip['valor'])) ? "<td>---</td>" : "<td>".$equip['valor']."</td>";

							$html .= (empty($equip['numero'])) ? "<td>---</td>" : "<td>".$equip['numero']."</td>";

							$html .= (empty($equip['planos_dados'])) ? "<td>---</td>" : "<td>".$equip['planos_dados']."</td>";

							/*PEGANDO DADOS DOS ACESSORIOS*/
							$queryAcessorios = "SELECT 
													MDA.nome
												FROM
													manager_inventario_acessorios MIA
												LEFT JOIN
													manager_dropacessorios MDA ON (MIA.tipo_acessorio = MDA.id_acessorio)
												WHERE
													id_equipamento = ".$equip['id_equipamento']."";

							$resultAcessorios = $conn->query($queryAcessorios);

							$html .= "<td>";

							while($acessorios = $resultAcessorios->fetch_assoc()){

								if(!empty($acessorios['nome'])){
									$html .= $acessorios['nome'].",";
								}else{
									$html .= "<td>---</td>";
								}
							}

							$html .= "</td>";

							$html .= (empty($equip['situacao'])) ? "<td>---</td>" : "<td>".$equip['situacao']."</td>";

							$html .= (empty($equip['estado'])) ? "<td>---</td>" : "<td>".$equip['estado']."</td>";
							
							$html .= "</tr>";
						}

		$html .=	"</table>
				</div>
			</div>
			<br>
			<br>
			<div id='termo_texto'>
				<p class='text-sm-left texto'>Comprometendo-me a devolvê-lo, em perfeito estado de conservação, mediante simples solicitação da empresa ou no caso de rescisão contratual, independente do motivo. Declaro que a utilização do referido equipamento <span class='font-weight-bold'><u> será exclusivamente em minha atividade profissional</u></span>,(não esta autorizado fotos particulares, telefones particulares, redes sociais, facebook, instagram, tinder, badoo, happn) estou ciente, da minha responsabilidade por danificar culposamente(pelo extravio, queda, danos por contato com umidade, extravio de componentes(carregador), estando isento de responsabilidade por danos advindos de desgates natural por uso cotidiano). Ciente que em caso de mau funcionamento (bateria não carrega) ou defeito do aparelho devo notificar no prazo máximo de 3 dias, após a retirada.</p>
				<p class='text-sm-left texto'>Caso haja nessecidade de portar portar, levar para casa este eletrônico, que devo notificar qualquer estrago ou avaria imediatamente a para área de T.I, que caso se faça necessários consertos, estes deverão preferencialmente ser realizados via T.I, só em caso de impossibilidade incompatibilidade (devido a distância) o conserto será feito de forma particular.

					Para os fins do par. 1º do Art. 462 da CLT, desde já autorizo o desconto salarial à conta de eventuais danos
					causados ao equipamento,(descritos acima) reembolsando a minha empregadora pelos reparos necessários ou até mesmo a substituição de um novo aparelho. Lembrando que o valor para ressarcimento será o vigente da data da ocorrência.<p>
			</div>
			<div id='tabela_titulo_principal'>
				<p class='titulo_segundario'><u>Observações:</u></p>
			</div>
			<div id='termo_texto'>";
			if($row_fun['obs'] != NULL){

				$html .= "<p class='text-sm-left texto'>&raquo; ".$row_fun['obs']."</p>";

			}else{
				$html .= "<br /><br />";				
			}	  
				
	$html .=   "</div>
			<br>
			<div id='termo_data'>
				<p class='text-center'>____________, ____ de _____________ de ________</p>
			</div>
			<br>
			<br>
			<br>
			<br>
			<div id='termo_footer'>
				<p class='font-weight-light'>Colaborador(A): ".$row_fun['nome']."</p>
				<p class='font-weight-light'>CPF: ".$row_fun['cpf']."</p>
				<p class='font-weight-light'>Assinatura:_______________________________________________________________ </p>
			</div>
		</div>
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
$dompdf->stream('termo_new_'.$row_fun['nome'].'.pdf',array("Attachment"=>0));//1 - Download 0 - Previa

$conn->close();
?>