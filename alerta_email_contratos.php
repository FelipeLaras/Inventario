<?php 
//chamando o banco
require 'conexao.php';

/*VALORES PADRÕES*/
$dias = "20"; //dias antes da data da carencia para o envio do e-mail
$data_hoje =  date('Y-m-d');//Data atual

/*VERIFICANDO SE A DATA DE ENVIO É HOJE*/
//pegando as datas dos contratos
$query_datas = "SELECT id_son, data_due AS data, temp_lack AS carencia, number_contract AS numero, cnpj, data_due AS vencer, contracts_father AS pai FROM manager_contracts_son where deleted = 0";
$resultado_datas = mysqli_query($conn, $query_datas);

while ($row_data = mysqli_fetch_assoc($resultado_datas)) {//salvando as datas em uma variavel

	 //PEGANDO A DATA NO BANCO E TIRANDO O TEMPO DE CARENCIA INFORMADO TBM NO BANCO	
	 $date_carencia = date('d-m-Y', strtotime("-".$row_data['carencia']." days",strtotime(''.$row_data['data'].'')));
	 //PEGANDO A DATA DA CARENCIA E TIRANDO O TEMPO QUE A CELINA INFORMOU QUE É 20 DIAS.
	 $date_total = date('d/m/Y', strtotime("-".$dias." days",strtotime(''.$date_carencia.'')));

	if ($data_hoje >= $date_total) {//se for menor ou igual a data de hoje envia!
		
		/*Antes de enviar teremos que verificar se já não foi enviado*/
		$query_check = "SELECT * FROM manager_contracts_check WHERE id_son = ".$row_data['id_son']." AND send = 1";
		$resultado_check = mysqli_query($conn, $query_check);
		$row_check = mysqli_fetch_assoc($resultado_check);

		if ($row_check['id_son'] != NULL) {
			echo "não foi enviado o id: ".$row_check['id_son']." pois já foi enviado dia = ".$row_check['date_send']."<br>";
		}else{
		//insere na tabela check
		$insert_check = "INSERT INTO manager_contracts_check (id_son, date_send, send) VALUES ('".$row_data['id_son']."', '".$data_hoje."', '1')";
		$resultado_insert_check = mysqli_query($conn, $insert_check) or die(mysqli_error($conn));
		
		/*PEGANDO O E_MAIL DO RESPONSAVEL PELO CONTRATO*/
		$query_mail_responsavel = "SELECT MCF.id AS id_pai,MCF.mail_responsible AS mail, MCS.id_son AS id_filho, MCF.contracts_responsible AS nome 
									FROM manager_contracts MCF
									INNER JOIN manager_contracts_son MCS on MCF.id = MCS.contracts_father 
									WHERE MCF.id = ".$row_data['pai']."";
		$resultado_mail = mysqli_query($conn, $query_mail_responsavel);
		$row_mail = mysqli_fetch_assoc($resultado_mail);

	#ENVIO DE EMAIL
			require 'PHPMailer/PHPMailerAutoload.php';
			
			//variaveis de conf. envio
			$smtp = "smtp.gmail.com";//servidor usado para envio
			$porta = "465"; //porta padrão SSL
			$login_email = "glpi@servopa.com.br"; //usuario para o login do SMTP
			$senha_email = "cpdtec05"; //senha para o login ao SMTP
			$destinatario = $$row_mail['mail'];//O mail que receberá as msn
			$titulo_email = "Alerta Vencimento Contrato";
			//Criando o corpo da mensagem.

			$corpo = '<head>
						<style type="text/css">
							#titulo {
					    margin-left: 40%;
						}
						#segundario {
					    margin-left: 4%;
					    font-size: 14px;
					    font-weight: bold;
						}
						#linha {
					    margin-left: 16%;
						}
						table.table.table-sm {
						    margin-left: 28%;
						}
						</style>
					</head>';
			$corpo .= '<div id="container">
						<div id="titulo">
							<div id="segundario"><p>CONTRATOS</p></div>
						</div>
						<div id="body">
							<div id="linha"><p>olá '.$row_mail['nome'].'Este e-mail e para apenas alertar que um contrato está para vencer. Segue abaixo ás informações do contrato em questão</p></div>
						</div>
						<div id="tabela">
							<table class="table table-sm" border="1">
							  <thead>
							    <tr>
							      <th scope="col">Numero do Contrato</th>
							      <th scope="col">Cnpj</th>
							      <th scope="col">Data Vencimento</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <td>'.$row_data['numero'].'</td>
							      <td>'.$row_data['cnpj'].'</td>
							      <td>'.$row_data['vencer'].'</td>
							    </tr>
							  </tbody>
							</table>
						</div>
					</div>';
			
			#Configurando o e-mail

			//Definando o PHPMailer
			$Mailer = new PHPMailer();
			
			//Define que será usado SMTP
			$Mailer->IsSMTP();
			
			//Enviar e-mail em HTML
			$Mailer->isHTML(true);
			
			//Aceitar carasteres especiais
			$Mailer->Charset = 'UTF-8';
			
			//Configurações
			$Mailer->SMTPAuth = true;
			$Mailer->SMTPSecure = 'ssl';
			
			//nome do servidor
			$Mailer->Host = $smtp;
			//Porta de saida de e-mail 
			$Mailer->Port = $porta;
			

			#Montando o e-mail

			//Dados do e-mail de saida - autenticação
			$Mailer->Username = $login_email;
			$Mailer->Password = $senha_email;
			
			//E-mail remetente (deve ser o mesmo de quem fez a autenticação)
			$Mailer->From = $login_email;
			
			//Nome do Remetente
			$Mailer->FromName = $nome;
			
			//Assunto da mensagem
			$Mailer->Subject = $titulo_email;
			
			//Corpo da Mensagem
			$Mailer->Body = $corpo;
			
			//Corpo da mensagem em texto
			$Mailer->AltBody = '';
			
			//Destinatario 
			$Mailer->AddAddress($destinatario);
			
			if($Mailer->Send()){
				echo "Email enviado para: ".$row_mail['mail']."<br>";
			}else{
				echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
			}
	}
		
	}
}

mysqli_close($conn);
?>