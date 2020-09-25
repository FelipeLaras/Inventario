<?php
    //aplicando para usar variavel em outro arquivo
    session_start();
    //chamando conexão com o banco
    require_once('../conexao/pesquisa_condb.php');

    //data de hoje
    $date = date('d/m/Y');

    //SALVANDO PDF
    if(($_FILES['file']['type']) != null){//caso tenha um arquivo
        
        //salvando documento
        $tipo_file = $_FILES['file']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file']['name'];
        $caminho = "/var/www/html/ti/documentos/google/" . $_FILES['file']['name'];//caminho onde será salvo o FILE
        $caminho_db = "../documentos/google/".$_FILES['file']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT tipo_arquivo FROM google_validacao_arquivo WHERE tipo_arquivo LIKE '".$tipo_file."'";//query de validação 

        $result =  $conn_db->query($sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['tipo_arquivo'] != NULL) {//se é arquivo valido       
            if (move_uploaded_file($_FILES['file']['tmp_name'], $caminho )){//aplicando o salvamento
                echo "arquivo Enviado!";
            }else{
                echo "Arquivo não foi enviado! ".$caminho." não localizado";//se caso não salvar vai mostrar o erro!
                exit;
            }
        }else{   
            echo "Arquivo Invalido! - Liberado apenas os arquivos com extensão: PDF";// se o arquivo não é valido vai levar para tela de erro 
            exit;
        }

        /*SALVANDO AGORA NO BANCO DE DADOS O DOCUMENTO*/
         $inst = "INSERT INTO google (titulo, body, caminho_arquivo, usuario, data_created) VALUES ('".$_POST['titulo']."', '".$_POST['txtArtigo']."', '".$caminho_db."', '".$_SESSION["id"]."', '".$date."')";
        
         $inst_replace = str_replace("\\", "/", $inst);

         $result = $conn_db->query($inst_replace);  

    }else{
        //SALVANDO A INFORMAÇÃO
        $inst = "INSERT INTO google (titulo, body, usuario, data_created) VALUES ('".$_POST['titulo']."', '".$_POST['txtArtigo']."', '".$_SESSION["id"]."', '".$date."')";
        
        $inst_replace = str_replace("\\", "/", $inst);

        $result = $conn_db->query($inst_replace);       
    }

    header('location: msn_google_s.php');//indo para a tela informando que o mesmo foi salvo

    $conn_db->close();//fechando banco pesquisa(google)

?> 