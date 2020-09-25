<?php
    //iniciando a sessão
    session_start();
    #ENVIO DE EMAIL
    require_once('../PHPMailer/PHPMailerAutoload.php');
    
    //variaveis de conf. envio
    $nome = "felipe";
	$smtp = "smtp.gmail.com";//servidor usado para envio
	$porta = "587"; //porta padrão SSL
	$login_email = "glpi@servopa.com.br"; //usuario para o login do SMTP
	$senha_email = "cpdtec05"; //senha para o login ao SMTP
    $titulo_email = "Funcionarios Pendentes"; 

/*--------------corpo da mensagem quando for 5 dias----------------*/ 
$body_5 = '
    <html>
    <body>
        <div style="color: #fff!important;margin-bottom: .5rem!important;padding: 1rem!important;background-color: #007bff;">
            <p class="text-center" style="text-align: center!important;">INVENTARIO - T.I</p>
        </div>
        <div style="margin-bottom: .5rem!important;color: #343a40!important; background-color: #f8f9fa;padding: 1rem!important;">
            <p class="text-left" style="text-align: left!important;">&raquo; Lista de funcionários que estão a '.$_SESSION['dias_5'].' dias <b style="color: brown;">sem o termo assinado!</b></p>
        </div>
        <table class="table table-sm" style="padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;width: 100%;margin-bottom: 1rem;color: #212529;">
                <caption style="padding-top: .75rem;padding-bottom: .75rem;color: #6c757d;text-align: left;caption-side: bottom;">Lista enviada pelo sistema - Grupo Servopa T.I</caption>
                <thead>
                  <tr>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Nome</th>                
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Filial</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Departamento</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Modelo</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Imei</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Número</th>
                  </tr>
                </thead>
                <tbody>';

                  $cont = 0;  
                  while ($_SESSION['id_equipamento_5'.$cont.''] != NULL) {
   $body_5 .=          '<tr>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;";">'.$_SESSION['funcionario_5'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['filial_5'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['departamento_5'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['modelo_5'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['imei_chip_5'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['numero_5'.$cont.''].'</td>
                      </tr>';
                      $cont++;
                  }

                    
$body_5 .=         '
                </tbody>
              </table>
    </body>
    </html>';

/*--------------corpo da mensagem quando for 10 dias----------------*/ 
$body_10 = '
    <html>
    <body>
        <div style="color: #fff!important;margin-bottom: .5rem!important;padding: 1rem!important;background-color: #007bff;">
            <p class="text-center" style="text-align: center!important;">INVENTARIO - T.I</p>
        </div>
        <div style="margin-bottom: .5rem!important;color: #343a40!important; background-color: #f8f9fa;padding: 1rem!important;">
            <p class="text-left" style="text-align: left!important;">&raquo; Lista de funcionários que estão a '.$_SESSION['dias_10'].' dias <b style="color: brown;">sem o termo assinado!</b></p>
        </div>
        <table class="table table-sm" style="padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;width: 100%;margin-bottom: 1rem;color: #212529;">
                <caption style="padding-top: .75rem;padding-bottom: .75rem;color: #6c757d;text-align: left;caption-side: bottom;">Lista enviada pelo sistema - Grupo Servopa T.I</caption>
                <thead>
                  <tr>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Nome</th>                
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Filial</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Departamento</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Modelo</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Imei</th>
                    <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Número</th>
                  </tr>
                </thead>
                <tbody>';

                  $cont = 0;  
                  while ($_SESSION['id_equipamento_10'.$cont.''] != NULL) {
   $body_10 .=          '<tr>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;";">'.$_SESSION['funcionario_10'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['filial_10'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['departamento_10'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['modelo_10'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['imei_chip_10'.$cont.''].'</td>
                      <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['numero_10'.$cont.''].'</td>
                      </tr>';
                      $cont++;
                  }

                    
$body_10 .=         '
                </tbody>
              </table>
    </body>
    </html>';
/*--------------corpo da mensagem quando for 15 dias----------------*/ 
$body_15 = '
<html>
<body>
    <div style="color: #fff!important;margin-bottom: .5rem!important;padding: 1rem!important;background-color: #007bff;">
        <p class="text-center" style="text-align: center!important;">INVENTARIO - T.I</p>
    </div>
    <div style="margin-bottom: .5rem!important;color: #343a40!important; background-color: #f8f9fa;padding: 1rem!important;">
        <p class="text-left" style="text-align: left!important;">&raquo; Lista de funcionários que estão a '.$_SESSION['dias_15'].' dias <b style="color: brown;">sem o termo assinado!</b></p>
    </div>
    <table class="table table-sm" style="padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;width: 100%;margin-bottom: 1rem;color: #212529;">
            <caption style="padding-top: .75rem;padding-bottom: .75rem;color: #6c757d;text-align: left;caption-side: bottom;">Lista enviada pelo sistema - Grupo Servopa T.I</caption>
            <thead>
              <tr>
                <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Nome</th>                
                <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Filial</th>
                <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Departamento</th>
                <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Modelo</th>
                <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Imei</th>
                <th style="border-color: inherit;padding: .75rem;vertical-align: top;border: 1px solid #dee2e6;padding: $table-cell-padding-sm;">Número</th>
              </tr>
            </thead>
            <tbody>';

              $cont = 0;  
              while ($_SESSION['id_equipamento_10'.$cont.''] != NULL) {
$body_15 .=          '<tr>
                  <td style="padding: .75rem;border: 1px solid #dee2e6;";">'.$_SESSION['funcionario_15'.$cont.''].'</td>
                  <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['filial_15'.$cont.''].'</td>
                  <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['departamento_15'.$cont.''].'</td>
                  <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['modelo_15'.$cont.''].'</td>
                  <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['imei_chip_15'.$cont.''].'</td>
                  <td style="padding: .75rem;border: 1px solid #dee2e6;">'.$_SESSION['numero_15'.$cont.''].'</td>
                  </tr>';
                  $cont++;
              }

                
$body_15 .=         '
            </tbody>
          </table>
</body>
</html>';
 
if ($_SESSION['id_equipamento_50'] != NULL) {
    $mail = new PHPMailer;
    try {
        $mail->SetLanguage('br'); // Traduzir para pt-BR
        $mail->isSMTP(); // Seta para usar SMTP
        $mail->SMTPAuth = true; // Libera a autenticação
        $mail->SMTPDebug = 2; // Debug
        $mail->SMTPSecure = 'tls'; // Acesso com TLS exigido pelo Gmail
        $mail->Host = $smtp; // SMTP Server
        $mail->Username = $login_email; // Usuário SMTP
        $mail->Password = $senha_email; // Senha do usuário
        $mail->Port = $porta; // Porta do SMTP
        $mail->setFrom($login_email, 'Alerta'); // Email e nome de quem enviara o e-mail
        $mail->addReplyTo($login_email, 'Alerta'); // E-mail e nome de quem responderá o e-mail
        $mail->addAddress($_SESSION['destinatario_5'], $_SESSION['nome_5']);
        //$mail->addCC('copia@dominio.com.br'); // Enviar cópiar do e-mail
        //$mail->addBCC('copiaoculta@dominio.com.br'); // Enviar uma cópia oculta
        //$mail->addAttachment('image.jpg', 'imagem.jpg'); // Anexa um arquivo
        $mail->isHTML(true); // Seta o envio em HTML
        $mail->CharSet = 'UTF-8'; // Charset da mensagem
        $mail->Subject = 'Funcionário com pendência'; // Título da mensagem
        $mail->Body = $body_5; // Mensagem
        $mail->AltBody = 'Ative o HTML da sua conta.'; // Mensagem alternativa
        $enviar = $mail->send(); // Envia e-mail
        if($enviar):
            echo 'Mensagem enviada com sucesso!';
        else:
            echo 'Erro ao enviar mensagem!<br>';
            echo 'Erro: '.$mail->ErrorInfo;
        endif;
    }catch(Exception $e){
        echo 'Erro ao enviar mensagem!';
        echo 'Erro: '.$mail->ErrorInfo;
    }
}

if ($_SESSION['id_equipamento_100'] != NULL) {
    $mail = new PHPMailer;
    try {
        $mail->SetLanguage('br'); // Traduzir para pt-BR
        $mail->isSMTP(); // Seta para usar SMTP
        $mail->SMTPAuth = true; // Libera a autenticação
        $mail->SMTPDebug = 2; // Debug
        $mail->SMTPSecure = 'tls'; // Acesso com TLS exigido pelo Gmail
        $mail->Host = $smtp; // SMTP Server
        $mail->Username = $login_email; // Usuário SMTP
        $mail->Password = $senha_email; // Senha do usuário
        $mail->Port = $porta; // Porta do SMTP
        $mail->setFrom($login_email, 'Alerta'); // Email e nome de quem enviara o e-mail
        $mail->addReplyTo($login_email, 'Alerta'); // E-mail e nome de quem responderá o e-mail
        $mail->addAddress($_SESSION['destinatario_10'], $_SESSION['nome_10']);
        //$mail->addCC('copia@dominio.com.br'); // Enviar cópiar do e-mail
        //$mail->addBCC('copiaoculta@dominio.com.br'); // Enviar uma cópia oculta
        //$mail->addAttachment('image.jpg', 'imagem.jpg'); // Anexa um arquivo
        $mail->isHTML(true); // Seta o envio em HTML
        $mail->CharSet = 'UTF-8'; // Charset da mensagem
        $mail->Subject = 'Funcionário com pendência'; // Título da mensagem
        $mail->Body = $body_10; // Mensagem
        $mail->AltBody = 'Ative o HTML da sua conta.'; // Mensagem alternativa
        $enviar = $mail->send(); // Envia e-mail
        if($enviar):
            echo 'Mensagem enviada com sucesso!';
        else:
            echo 'Erro ao enviar mensagem!<br>';
            echo 'Erro: '.$mail->ErrorInfo;
        endif;
    }catch(Exception $e){
        echo 'Erro ao enviar mensagem!';
        echo 'Erro: '.$mail->ErrorInfo;
    }
}

if ($_SESSION['id_equipamento_150'] != NULL) {
    $mail = new PHPMailer;
    try {
        $mail->SetLanguage('br'); // Traduzir para pt-BR
        $mail->isSMTP(); // Seta para usar SMTP
        $mail->SMTPAuth = true; // Libera a autenticação
        $mail->SMTPDebug = 2; // Debug
        $mail->SMTPSecure = 'tls'; // Acesso com TLS exigido pelo Gmail
        $mail->Host = $smtp; // SMTP Server
        $mail->Username = $login_email; // Usuário SMTP
        $mail->Password = $senha_email; // Senha do usuário
        $mail->Port = $porta; // Porta do SMTP
        $mail->setFrom($login_email, 'Alerta'); // Email e nome de quem enviara o e-mail
        $mail->addReplyTo($login_email, 'Alerta'); // E-mail e nome de quem responderá o e-mail
        $mail->addAddress($_SESSION['destinatario_15'], $_SESSION['nome_15']);
        //$mail->addCC('copia@dominio.com.br'); // Enviar cópiar do e-mail
        //$mail->addBCC('copiaoculta@dominio.com.br'); // Enviar uma cópia oculta
        //$mail->addAttachment('image.jpg', 'imagem.jpg'); // Anexa um arquivo
        $mail->isHTML(true); // Seta o envio em HTML
        $mail->CharSet = 'UTF-8'; // Charset da mensagem
        $mail->Subject = 'Funcionário com pendência'; // Título da mensagem
        $mail->Body = $body_15; // Mensagem
        $mail->AltBody = 'Ative o HTML da sua conta.'; // Mensagem alternativa
        $enviar = $mail->send(); // Envia e-mail
        if($enviar):
            echo 'Mensagem enviada com sucesso!';
        else:
            echo 'Erro ao enviar mensagem!<br>';
            echo 'Erro: '.$mail->ErrorInfo;
        endif;
    }catch(Exception $e){
        echo 'Erro ao enviar mensagem!';
        echo 'Erro: '.$mail->ErrorInfo;
    }
}

//limpando as sessões
session_unset();    
//fechando a conexão com o banco
$conn->close();
?>