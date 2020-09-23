<?php
	require_once('../conexao/conexao.php');

	//Recebendo as Variais
	$mail = $_POST['username'];

	#ENVIO DE EMAIL
	require_once('../PHPMailer/PHPMailerAutoload.php');
	
	//variaveis de conf. envio
	$smtp = "smtp.gmail.com";//servidor usado para envio
	$porta = "465"; //porta padrão SSL
	$login_email = "glpi@servopa.com.br"; //usuario para o login do SMTP
	$senha_email = "cpdtec05"; //senha para o login ao SMTP
	$destinatario = "felipe.lara@servopa.com.br";//O mail que receberá as msn
	$titulo_email = "Esqueci a Senha";

	//Criando o corpo da mensagem.

	$corpo = '<head>
				<style type="text/css">
					#tabela{width: 70%}
					h1 {margin-left: 27%;}
					th{padding: 2px 7px 1px 7px;}
				</style>
			</head>';
	$corpo .= '<div id="tabela">
				<h1>Esqueci a Senha</h1>';
	$corpo .='<table border="1">
				<tr>
					<th>E-mail</th>
				</tr>
				<tr>
					<th>'.$mail.'</th>
				</tr>
			</table></div>';

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
		header('location: ../front/alert_forget_envio.html');
	}else{
		echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
	}
//Fechando a conexão com o banco
$conn->close();
?>