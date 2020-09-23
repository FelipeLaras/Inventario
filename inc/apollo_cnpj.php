<?php
   session_start();
   
   if ($_POST['nome'] == '') {//se o formulario estiver vazio, irá buscar o CNPJ
     /*AQUI IRA FAZER A BUSCA NO BANCO DE DADOS DO APOLLO*/
       if ($_POST['gols1'] != NULL) {
       include 'oracle.php'; //chamando o banco do APOLLO
       //query buscando o cnpj dentro do APOLLO
       $query_oracle = 'SELECT nome, cgccpf AS cnpj FROM gruposervopa.FAT_CLIENTE where cgccpf = '.$_POST['gols1'].'';
       //aplicando a query e salvando na variavel $row
       $stid = oci_parse($conn_oracle,$query_oracle);
       oci_execute($stid);
       $row = oci_fetch_array($stid,$res);
      
      if ($row['CNPJ'] != NULL) {// se econtrar o CNPJ!
        $_SESSION['cnpj_apollo'] = $row['CNPJ']; // salva na sessão o CNPJ
        $_SESSION['nome_apollo']  = $row['NOME']; // salva na sessão o nome da empresa
        header('location: contracts_add.php'); // volta para o formulario e mostrar os dados coletados
        exit;
      }else{// não encontrou o cnpj!
       $_SESSION['vazia'] = $_POST['gols1']; // salva o CNPJ que foi digitado pelo usuário
       header('location: contracts_add.php'); // volta para a tela com o numero de cnpj que foi digitado.
      }
   
       oci_free_statement($stid);//Libera todos os recursos associados à instrução ou cursor
       oci_close($conn_oracle);//fechando a conexão com o bando do apollo
     }
   }else{// se o formulario pai estiver preenchido irá salvar o mesmo.
   
     /*SALVANDO CONTRATO PAI*/
     include 'conexao.php'; //chamando banco manager
   
     /*Teremos que amarrar a tabela contratos com a filho e arquivo. Existe um campo chamado contracts_file, contracts_son na tabela manager_contracts(contratos pai), nesses campos que iremos usar para amarrar os mesmo, para isso temos uma regra que pega a ultima ID da tebala e somamos mais um*/
   
     $query_max = "SELECT max(id) AS id_pai FROM manager_contracts";//montando a query
     $resultado_max = mysqli_query($conn, $query_max);//executando a query
     $row_max = mysqli_fetch_assoc($resultado_max);//salvando o resultado
     $id_son_file = ++$row_max['id_pai']; //pegando o resultado e somando mais 1 EX; resultado = 20 + 1 será 21
   
     //query para inserir o cotrato
     $insert_pai = "INSERT INTO manager_contracts (cnpj, name, number, type, type_collection, cnpj_branch, department, date_start, contracts_responsible, mail_responsible, description, contracts_file, contracts_son) 
                   VALUES ('".$_POST['gols1']."', '".$_POST['nome']."', '".$_POST['numero_contrato']."', '".$_POST['t_contrato']."', '".$_POST['t_cobranca']."', '".$_POST['gols2']."', '".$_POST['setor']."', '".$_POST['data_contrato']."', '".$_POST['nome_responsavel']."', '".$_POST['email_responsavel']."', '".$_POST['descricao']."', '".$id_son_file."', '".$id_son_file."')";
     $resultado_pai = mysqli_query($conn, $insert_pai) or die(mysqli_error($conn));
   
     /*SALVANDO FILE DO PAI*/
     if ($_FILES['anexo']['name'] != NULL) {
        
       //coletando informações do FILE 
       $tipo_file = $_FILES['anexo']['type'];//Pegando qual é a extensão do arquivo
       $caminho = "/var/www/html/ti/documentos/";//caminho onde será salvo o FILE
       $caminho_db = "documentos/".$_FILES['anexo']['name'];//pasta onde está o FILE para salvar no Bando de dados
       
        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação   
        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel
   
        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido
            $uploaddir = $caminho;//salvando em uma variavel o caminho do servidor
            $uploadfile = $uploaddir . $_FILES['anexo']['name'];//juntando o caminho/nome_do_arquivo
            if (move_uploaded_file($_FILES['anexo']['tmp_name'], $uploadfile)){//aplicando o salvamento            
             }else {echo "Arquivo não enviado";}//se caso não salvar vai mostrar o erro!
         }else{// se o arquivo não é valido vai levar para tela de erro
            
            var_dump($tipo_file);
            //header("Location: error.php");
            exit;
           }
   
        /*DEPOIS QUE SALVOU NO SERVIDOR VAMOS AGORA SALVAR NO BANCO DE DADOS*/
        /*1º*/
        //Salvar no banco de dados manager_contracts_file 
        //criando a query
         $insert_bd_file = "INSERT INTO manager_contracts_file(name, number_contract, cnpj ,contracts_father, contracts_son, type, file_way) 
     VALUES ('".$_FILES['anexo']['name']."','".$_POST['numero_contrato']."','".$_POST['gols1']."', '".$id_son_file."','".$id_son_file."','".$_FILES['anexo']['type']."','".$caminho_db."')";
        //aplicando a query
       $resultado_insert_file = mysqli_query($conn, $insert_bd_file) or die(mysqli_error($conn));
     }
   
       /*SALVANDO FILHO*/
       $id = 0;//iniciando o contador
       if ($_POST['number_contract0'] != NULL) {
   
         while ($_POST['number_contract'.$id.''] != NULL) {
   
           /*GAMBIARRA IDEM A LINHA 33*/
           $query_max_filho = "SELECT max(id_son) AS id_filho FROM manager_contracts_son";//montando a query
           $resultado_max_filho = mysqli_query($conn, $query_max_filho);//executando a query
           $row_max_filho = mysqli_fetch_assoc($resultado_max_filho);//salvando o resultado
           $id_filho_file = ++$row_max_filho['id_filho']; //pegando o resultado e somando mais 1 EX; resultado = 20 + 1 será 21
           //query de inserção do contrato filho
           $insert_filho = "INSERT INTO manager_contracts_son (number_contract, cnpj, value, data_due, temp_lack, son_file, contracts_father) VALUES ('".$_POST['number_contract'.$id.'']."', '".$_POST['cnpj_filho'.$id.'']."', '".$_POST['valor'.$id.'']."', '".$_POST['data_venc'.$id.'']."', '".$_POST['temp_care'.$id.'']."', '".$id_filho_file."', '".$id_son_file."')";
           //aplicando a query
           $resultado_insert_filho = mysqli_query($conn, $insert_filho) or die(mysqli_error($conn));
  
            /*SALVANDO FILE DO FILHO*/
         if ($_FILES['file_sun'.$id.'']['name'] != NULL) {
              
             //coletando informações do FILE 
             $tipo_file_filho = $_FILES['file_sun'.$id.'']['type'];//Pegando qual é a extensão do arquivo
             $caminho = "/var/www/html/ti/documentos/";//caminho onde será salvo o FILE
             $caminho_db_son = "documentos/".$_FILES['file_sun'.$id.'']['name'];//pasta onde está o FILE para salvar no Bando de dados
             
             /*VALIDAÇÃO DO FILE*/
              $sql_file_filho = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file_filho."'";//query de validação   
              $result_filho_file =  mysqli_query($conn, $sql_file_filho);//aplicando a query
              $row_file = mysqli_fetch_array($result_filho_file);//salvando o resultado em uma variavel
   
              /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
              if ($row_file['type'] != NULL) {//se é arquivo valido
                  $uploaddir = $caminho;//salvando em uma variavel o caminho do servidor
                  $uploadfile = $uploaddir . $_FILES['file_sun'.$id.'']['name'];//juntando o caminho/nome_do_arquivo
                  if (move_uploaded_file($_FILES['file_sun'.$id.'']['tmp_name'], $uploadfile)){//aplicando o salvamento            
                   }else {echo "Arquivo não enviado";}//se caso não salvar vai mostrar o erro!
               }else{// se o arquivo não é valido vai levar para tela de erro
                  header("Location: error.php");
                  exit;
                 }
   
              /*DEPOIS QUE SALVOU NO SERVIDOR VAMOS AGORA SALVAR NO BANCO DE DADOS*/
              /*1º*/
              //Salvar no banco de dados manager_contracts_file 
              //criando a query
   $insert_bd_file = "INSERT INTO manager_contracts_file(name, number_contract, cnpj ,contracts_father, contracts_son, type, file_way) 
           VALUES ('".$_FILES['file_sun'.$id.'']['name']."','".$_POST['number_contract'.$id.'']."','".$_POST['cnpj_filho'.$id.'']."', '".$id_son_file."','".$id_filho_file."','".$_FILES['file_sun'.$id.'']['type']."','".$caminho_db_son."')";
              
              //aplicando a query
             $resultado_insert_file = mysqli_query($conn, $insert_bd_file) or die(mysqli_error($conn));
             }//inicia na 96
   
           $id++;//somando o contador
         }//inicia na linha 83
       }//inicia na linha 81
     $_SESSION['number_father'] = $id_son_file;
     header('location: msn.php');
   }//inicia na linha 28   
   ?>