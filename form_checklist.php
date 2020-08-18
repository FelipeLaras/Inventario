<?php
//chamando sessão
session_start();

//chasmando o banco de dados
include 'conexao.php';

//data de hoje

$data = date('d/m/Y G:i:s');

/*------------------------ LIBERANDO OS EQUIPAMENTOS PARA DISVINCULAR DE UM FUNCIONÁRIO ------------------------*/

//montando a query para liberar
$liberar_equip = "UPDATE manager_inventario_equipamento SET liberado_rh = 1 WHERE ";

if($_POST['id_equip'] != NULL){

    $liberar_equip .= "id_equipamento IN (";

    foreach ($_POST['id_equip'] as $equipamento) {

		$liberar_equip .= "'".$equipamento."',"; 

		//montando o log de alteração		
		$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$equipamento."',
						'".$data."',
						'".$_SESSION["id"]."',
						'1')";
		$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));
	}
	
	$liberar_equip .= "'')";
	
}else{
	$liberar_equip .= "id_funcionario = ".$_POST['id_fun']."";

	//Preparando para montar o log de todos os equipamentos
	$show = "SELECT id_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = ".$_POST['id_fun']."";
	$result_show = mysqli_query($conn, $show);

	while($row_show = mysqli_fetch_assoc($result_show)){

		$log_query = "INSERT manager_log (id_equipamento, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$row_show['id_equipamento']."',
						'".$data."',
						'".$_SESSION["id"]."',
						'1')";
		$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));
	}

}

$result_liberado = mysqli_query($conn, $liberar_equip) or die(mysqli_error($conn));
//Fim query

/*-------------------------------------------- MONTANDO O CHEC-LIST ------------------------------------------*/

//1º pegando a informação do funcionario

$fun = "SELECT 
            MIF.nome,
            MIF.cpf,
            MDD.nome AS departamento,
            MDF.nome AS funcao,
            MDE.nome AS filial
        FROM 
            manager_inventario_funcionario MIF
        LEFT JOIN
            manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
        LEFT JOIN
            manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
        LEFT JOIN
            manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa
        WHERE
            MIF.id_funcionario = ".$_POST['id_fun']."";

$result_fun = mysqli_query($conn, $fun);

$row_fun = mysqli_fetch_assoc($result_fun);


//2º pegando a informação do equipamento

$equip = "SELECT 
            MIE.id_equipamento,
            MIE.tipo_equipamento,
            MIE.patrimonio,
            MIE.modelo,
            MIE.imei_chip,
            MIE.valor,
            MDSO.nome AS so,
            MDOFF.nome AS office,
            MDO.nome AS operadora,
            MIE.numero,
            MDST.nome AS situacao
        FROM
            manager_inventario_equipamento MIE
        LEFT JOIN
            manager_dropoperadora MDO ON MIE.operadora = MDO.id_operadora
        LEFT JOIN
            manager_dropsituacao MDST ON MDST.id_situacao = MIE.situacao
        LEFT JOIN
            manager_sistema_operacional MSO ON MIE.id_equipamento = MSO.id_equipamento
        LEFT JOIN
            manager_dropsistemaoperacional MDSO ON MSO.versao = MDSO.id
        LEFT JOIN
            manager_office MO ON MIE.id_equipamento = MO.id_equipamento
        LEFT JOIN
            manager_dropoffice MDOFF ON MO.id = MDOFF.id
        WHERE ";

        if($_POST['id_equip'] != NULL){
            $equip .= "MIE.id_equipamento IN (";

            foreach ($_POST['id_equip'] as $equipamento) {
				$equip .= "'".$equipamento."',";  	
            }

            $equip .= "'') AND MIE.tipo_equipamento NOT IN (8 , 10) AND MIE.deletar = 0";
        }else{
            $equip .= "MIE.id_funcionario = ".$_POST['id_fun']." AND 
                        MIE.tipo_equipamento NOT IN (8 , 10) AND
                        MIE.deletar = 0";
        }

$result_equip = mysqli_query($conn, $equip);


// 3º montando o corpo do check-list

/*CORPO DO PDF*/
$html = "
<html>
	<head>
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous'>		
	</head>
	<style type='text/css'>
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
						<td colspan='4' class='info_user'>".$row_fun['filial']."</td>
					</tr>
				<tbody>
			</table>
		</div>

		<div id='equipamento_title'>
			<p class='text-left'><u>Lista dos Equipamentos:</u></p>
        </div>";

        $number = '1';
		while ($row_equi = mysqli_fetch_assoc($result_equip)) {

				

				switch ($row_equi['tipo_equipamento']) {
					case 1:
						$tipo_equip = "CELULAR";
						$modelo = $row_equi['modelo'];
						$rowspan = '6';
					break;

					case 2:// 2 = TABLET
						$tipo_equip = "TABLET";
						$modelo = $row_equi['modelo'];
						$rowspan = '6';
					break;				

					case 3:
						$tipo_equip = "CHIP";
						$modelo = 'Chip';
						$rowspan = '2';
					break;

					case 4:
						$tipo_equip = "MODEM";
						$modelo = 'Modem';
						$rowspan = '2';
					break;

					case 9:
						$tipo_equip = "NOTEBOOK";
						$modelo = 'Notebook';
						$rowspan = '2';
					break;

					case 5:
						$tipo_equip = "RAMAL";
						$modelo = 'Ramal';
						$rowspan = '2';
					break;
				}

					$html .= "
					<div id='tabela_equipamento'>
						<div style='font-size: 9px;'>
							".$number." - ".$tipo_equip.": ".$row_equi['situacao']."
						</div>	
						<table class='table table-sm' style='font-size: 10px'>
							<tbody>
								<tr>
									<td rowspan='".$rowspan."' class='marcador'>(&nbsp; &nbsp; &nbsp;)</td>
									<td>
										<b>Modelo: </b>".$row_equi['modelo']."
									</td>
									<td>";
									if(($row_equi['tipo_equipamento'] == 9) || ($row_equi['tipo_equipamento'] == 5)){
										$html .= "<b>Patrimônio: </b>".$row_equi['patrimonio']."";										
									}else{
										$html .= "<b>Operadora: </b>".$row_equi['operadora']."";
									}//end IF patrimonio / Operadora										

					$html .=   "</td>
									<td rowspan='".$rowspan."' width='200'><u>OBS.:</u></td>
								</tr>
								<tr>
									<td>";
									if(($row_equi['tipo_equipamento'] == 9) || ($row_equi['tipo_equipamento'] == 5)){
										$html .= "<b>S.O: </b>".$row_equi['so']."";										
									}else{
										$html .= "<b>Imei:</b> ".$row_equi['imei_chip']."";
									}//end IF S.O / Imei										
					$html .="		</td>
									<td>";
									if(($row_equi['tipo_equipamento'] == 9) || ($row_equi['tipo_equipamento'] == 5)){
										if($row_equi['office'] != NULL){
											$html .= "<b>Office: </b>".$row_equi['office']."";
										}else{
											$html .= "<b>Office: </b>Não Possui";
										}//end IF caso não tenha OFFICE										
									}else{
										$html .= "<b>Numero:</b> ".$row_equi['numero']."";
									}//end IF office / numero	
					$html .="		</td>
								</tr>";

								$query_acessorios = "SELECT 
														mda.nome
													FROM
														manager_inventario_acessorios mia
															LEFT JOIN
														manager_dropacessorios mda ON mia.tipo_acessorio = mda.id_acessorio
													WHERE
														mia.id_equipamento = ".$row_equi['id_equipamento']."";					

								$resultado_acessorios = mysqli_query($conn, $query_acessorios);
								
								while ($row_acessorios = mysqli_fetch_assoc($resultado_acessorios)) {
										$html .="<tr>
												<td colspan='2'>(&nbsp; &nbsp;)".$row_acessorios['nome']."</td>
											</tr>";
										}//end WHILE buscando acessórios	

							$html .="</tbody>
						</table>";
						$number++;
					}// end WHILE do equipamento
				$html .= "</div>
		
		<div style='margin-top: -12px'>			
			<p class='text-left'>Na condição de empregado(a) da filial <b>".$row_fun['filial']."</b>, estou devolvendo neste ato os equipamentos descritos conforme a cima.</p>
			<p class='text-left'><u>CHECAR ITENS NA DEVOLUÇÃO</u></p>
		</div>
		<div id='tabela_devolucao'>

			<table style='font-size: 8px; border: 1px solid #dee2e6'>
			  <thead>
			    <tr>
			      <th>Checar</th>
				  <th style='padding-right: 6px;border: solid 1px #dee2e6;'>Status</th>
				  <th>Checar</th>
				  <th style='padding-right: 6px;border: solid 1px #dee2e6;'>Status</th>
				  <th>Checar</th>
				  <th style='padding-right: 6px;border: solid 1px #dee2e6;'>Status</th>
				  <th>Checar</th>
				  <th style='padding-right: 6px;border: solid 1px #dee2e6;'>Status</th>
				  <th>Checar</th>
			      <th style='padding-right: 6px;border: solid 1px #dee2e6;'>Status</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <td>Senha de Desbloqueio</td>
			      <td><!--STATUS--></td>
				  <td>Dados Pessoais</td>
				  <td><!--STATUS--></td>
				  <td>Carregador</td>
				  <td><!--STATUS--></td>
				  <td>Fone de Ouvido</td>
				  <td><!--STATUS--></td>
				  <td>Cabos</td>
				  <td><!--STATUS--></td>
			    </tr>
			    <tr>
			      <td>Botões Faltantes</td>
				  <td><!--STATUS--></td>
				  <td>Tela Trincada</td>
				  <td><!--STATUS--></td>
				  <td>Danos por Queda</td>
				  <td><!--STATUS--></td>
				  <td>Umidade</td>
				  <td><!--STATUS--></td>
				  <td>-*-</td>
				  <td>-*-</td>
			    </tr>
			  </tbody>
			</table>

		</div>
		<div style='margin-top: 5px'>
			<p class='text-left'>Para os fins do par. 1° do Art. 462 a CLT, desde já autorizo o desconto nas minhas verbas rescisórias, afim de ressarcir os danos acima.</p>
		</div>
		<div id='termo_data'>
			<p class='text-center'>____________, ____ de _____________ de ________</p>
		</div>
		<div id='assinatura'>
			<p class='text-left'>______________________________</p>
			<p class='text-left' style='margin-top: -5px;'>".$row_fun['filial']."</p>
			<p class='text-left'>______________________________</p>
			<p class='text-left' style='margin-top: -5px;'>".$row_fun['nome']."</p>
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