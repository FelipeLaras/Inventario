<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';
//data de hoje
$data_hoje = date('d/m/Y');
/*------------------------------------------------------------------------------------------------ */
//1º verificar se o mesmo informou algum equipamento

if( ($_POST['num_patrimonio_cpu'] == NULL) AND ($_POST['num_patrimonio_notebook'] == NULL) AND ($_POST['numero_ramal0'] == NULL) AND ($_POST['serie_scan'] == NULL) ){

    if($_POST['gols1'] != NULL){
        $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
        $_SESSION['nome_cadastrado'] = $_POST['nome_funcionario'];
        $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
        $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
        $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
    }

    /*---VOLTANDO PARA A TELA - ERRO 3 FALTOU PREENCHER EQUIPAMENTO---*/
    header('location: equip_add.php?error=3');
}//end IF = FALTOU INFORMAR EQUIPAMENTO

/*------------------------------------------------------------------------------------------------ */
//2º Vamos salvar um CPU

if ($_POST['num_patrimonio_cpu'] != NULL) {

    if($_POST['nome_cpu'] == NULL){
            
        $existe_patrimonio_cadastrado = "SELECT * FROM manager_ocs_equip WHERE patrimonio LIKE '%".$_POST['num_patrimonio_cpu']."%'";
        $resultado_patrimonio = mysqli_query($conn, $existe_patrimonio_cadastrado);
        $row_patrimonio = mysqli_fetch_assoc($resultado_patrimonio);

        if($row_patrimonio['patrimonio'] != NULL){//se encontrou um patrimio
            /*---FUNCIONARIO---*/
            $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
            $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
            $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
            $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
            $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
            /*---EQUIPAMENTO---*/
            $_SESSION['numero_patrimonio'] = $row_patrimonio['patrimonio'];
            $_SESSION['dominio'] = $row_patrimonio['dominio'];
            $_SESSION['nome_computador'] = $row_patrimonio['hostname'];
            $_SESSION['fornecedor_cpu'] = $row_patrimonio['fornecedor_cpu'];
            $_SESSION['fornecedor_cpuOffice'] = $row_patrimonio['fornecedor_cpuOffice'];
            $_SESSION['ip'] = $row_patrimonio['ip'];
            $_SESSION['modelo'] = $row_patrimonio['modelo'];        
            $_SESSION['processador'] = $row_patrimonio['processador'];
            $_SESSION['hd'] = $row_patrimonio['hd'];
            $_SESSION['memoria'] = $row_patrimonio['memoria'];
            $_SESSION['numero_serial'] = $row_patrimonio['serial_number'];
            /*---WINDOWS---*/
            $_SESSION['so'] = $row_patrimonio['sistema_operacional'];
            $_SESSION['serial_so'] = $row_patrimonio['chave_windows'];
            /*---OFFICE---*/
            $_SESSION['office'] = $row_patrimonio['office'];
            $_SESSION['serial_office'] = $row_patrimonio['chave_office'];
            /*---VOLTANDO PARA A TELA---*/
            header('location: equip_add.php');
        }else{
            /*---CASO O USUÁRO TENHA DIGITADO ALGUMA COISA---*/
            $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
            $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
            $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
            $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
            $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
            /*---VOLTANDO PARA A TELA - ERRO 2 EQUIPAMENTO NÃO ENCONTRADO---*/
            header('location: equip_add.php?error=2');
        }//end IF = encontrando equipamento 
    }elseif($_POST['empresa_cpu'] == 0){
        $existe_patrimonio_cadastrado = "SELECT * FROM manager_ocs_equip WHERE patrimonio LIKE '%".$_POST['num_patrimonio_cpu']."%'";
        $resultado_patrimonio = mysqli_query($conn, $existe_patrimonio_cadastrado);
        $row_patrimonio = mysqli_fetch_assoc($resultado_patrimonio);

        if($row_patrimonio['patrimonio'] != NULL){//se encontrou um patrimio
            /*---FUNCIONARIO---*/
            $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
            $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
            $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
            $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
            $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
            /*---EQUIPAMENTO---*/
            $_SESSION['numero_patrimonio'] = $row_patrimonio['patrimonio'];
            $_SESSION['dominio'] = $row_patrimonio['dominio'];
            $_SESSION['nome_computador'] = $row_patrimonio['hostname'];
            $_SESSION['fornecedor_cpu'] = $row_patrimonio['fornecedor_cpu'];
            $_SESSION['ip'] = $row_patrimonio['ip'];
            $_SESSION['modelo'] = $row_patrimonio['modelo'];        
            $_SESSION['processador'] = $row_patrimonio['processador'];
            $_SESSION['hd'] = $row_patrimonio['hd'];
            $_SESSION['memoria'] = $row_patrimonio['memoria'];
            $_SESSION['numero_serial'] = $row_patrimonio['serial_number'];
            /*---WINDOWS---*/
            $_SESSION['so'] = $row_patrimonio['sistema_operacional'];
            $_SESSION['serial_so'] = $row_patrimonio['chave_windows'];
            /*---OFFICE---*/
            $_SESSION['office'] = $row_patrimonio['office'];
            $_SESSION['serial_office'] = $row_patrimonio['chave_office'];
            /*---VOLTANDO PARA A TELA---*/
            header('location: equip_add.php');
        }else{
            /*---CASO O USUÁRO TENHA DIGITADO ALGUMA COISA---*/
            $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
            $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
            $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
            $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
            $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
            /*---VOLTANDO PARA A TELA - ERRO 2 EQUIPAMENTO NÃO ENCONTRADO---*/
            header('location: equip_add.php?error=2');
        }//end IF = encontrando equipamento 
    }//end IF = nome_cpu


    /*---------------ANTES DE MAIS NDA IREMOS VERIFICAR SE JÁ NÃO ESTÁ CADASTRADO O EQUIPAMENTO---------------*/
    $verificar_cadastro = "SELECT * FROM manager_inventario_equipamento WHERE patrimonio like '".$_POST['num_patrimonio_cpu']."';";
    $resultado_verificar_cadastro = mysqli_query($conn, $verificar_cadastro);
    $row_verificar = mysqli_fetch_assoc($resultado_verificar_cadastro);

    if($row_verificar['deletar'] == 1){
         /*---VOLTANDO PARA A TELA - ERRO 4 EQUIPAMENTO CONDENADO---*/
         header('location: equip_add.php?error=4');
    }elseif($row_verificar['patrimonio'] == $_POST['num_patrimonio_cpu']){
        /*---VOLTANDO PARA A TELA - ERRO 5 EQUIPAMENTO JÁ CADASTRADO---*/
        header('location: equip_add.php?error=5');
        exit;
    }//end IF = validação se já existe

    /*---------------AGORA SIM IREMOS SALVAR O EQUIPAMENTO---------------*/

    //1º iremos salvar o funcionario
    $existe_funcionario = "SELECT * FROM manager_inventario_funcionario  WHERE cpf = '".$_POST['gols1']."';";
    $result_funcionario = mysqli_query($conn, $existe_funcionario);
    if($row_id_funcionario = mysqli_fetch_assoc($result_funcionario)){
        //se caso já exista um funcionario
        $update = "UPDATE manager_inventario_funcionario 
                    SET 
                    nome = '".$_POST['nome_funcionario']."', 
                    funcao = '".$_POST['funcao_funcionario']."', 
                    departamento = '".$_POST['depart_funcionario']."', 
                    empresa = '".$_POST['empresa_funcionario']."',
                    status = '4'
                    WHERE id_funcionario = '".$row_id_funcionario['id_funcionario']."';";
        
        $result_funcionario = mysqli_query($conn, $update) or die(mysqli_error($conn));
        
        //salvando agora o equipamento
        $new_equipamento = "INSERT INTO manager_inventario_equipamento
                            (id_funcionario,
                            usuario,
                            dominio, 
                            tipo_equipamento, 
                            filial, 
                            locacao, 
                            modelo, 
                            departamento, 
                            patrimonio, 
                            hostname,
                            processador, 
                            hd,
                            memoria,
                            ip, 
                            serialnumber,
                            termo,
                            data_criacao,
                            status)
                            VALUE
                            ('".$row_id_funcionario['id_funcionario']."',
                            '".$_SESSION['id']."',
                            '".$_POST['dominio']."',
                            '8',
                            '".$_POST['empresa_cpu']."',
                            '".$_POST['locacao_cpu']."',
                            '".$_POST['modelo_cpu']."',
                            '".$_POST['depart_cpu']."',
                            '".$_POST['num_patrimonio_cpu']."',
                            '".$_POST['nome_cpu']."',
                            '".$_POST['processador_cpu']."',
                            '".$_POST['hd_cpu']."',
                            '".$_POST['memoria_cpu']."',
                            '".$_POST['ip_cpu']."',
                            '".$_POST['serie_cpu']."',
                            '0',
                            '".$data_hoje."',
                            '1');";
        $result_new_equipamento = mysqli_query($conn, $new_equipamento) or die(mysqli_error($conn));
        

        //salvando a nota do windows
        $tipo_file = $_FILES['file_nota_so_cpu']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_nota_so_cpu']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_so_cpu']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_so_cpu']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if($tipo_file != NULL){
            if ($row['type'] != NULL) {//se é arquivo valido       
                if (move_uploaded_file($_FILES['file_nota_so_cpu']['tmp_name'], $caminho )){//aplicando o salvamento
                    //echo "Arquivo enviado para = ".$_FILES['file_nota_so_cpu']['tmp_name'].$uploadfile;
                }else{
                echo "Arquivo não foi enviado!";
                }//se caso não salvar vai mostrar o erro!
            }else{// se o arquivo não é valido vai levar para tela de erro    
                echo "Arquivo Invalido!";
                exit;
            }//end IF validação
        }//end IF anexo cheio

        /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
        if($_POST['data_nota_so_cpu'] != NULL){
            $data_nota = $_POST['data_nota_so_cpu'];
        }else{
            $data_nota = 'not info';
        }

        //salvando agora o windows
        $new_windows = "INSERT INTO manager_sistema_operacional
                            (id_equipamento, 
                            locacao, 
                            empresa, 
                            versao, 
                            serial, 
                            fornecedor, 
                            numero_nota, 
                            file_nota, 
                            file_nota_nome, 
                            data_nota)
                        VALUES
                            ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                            '".$_POST['locacao_cpu']."',
                            '".$_POST['empresa_cpu']."',
                            '".$_POST['so_cpu']."',
                            '".$_POST['serial_so_cpu']."',
                            '".$_POST['fornecedor_cpu']."',
                            '";
                            empty($_POST['num_nota_so_cpu']) ? $new_windows .= "semNota"  : $new_windows .= $_POST['num_nota_so_cpu'];
                            
        $new_windows .=     "',
                            '".$caminho_db."',
                            '".$nome_db."',
                            '".$data_nota."')";

        $result_new_windows = mysqli_query($conn, $new_windows) or die(mysqli_error($conn));

        //montando uma query para pegar o id do windows e enviar para criar um termo
        $pegando_windows = "SELECT max(id) AS id FROM manager_sistema_operacional";
        $result_windows = mysqli_query($conn, $pegando_windows);
        $row_windows = mysqli_fetch_assoc($result_windows);

        //salvando agora o office

        if($_POST['serial_nota_office_cpu'] != NULL){

            //salvando a nota do windows
            $tipo_file = $_FILES['file_nota_office_cpu']['type'];//Pegando qual é a extensão do arquivo
            $nome_db = $_FILES['file_nota_office_cpu']['name'];
            $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_office_cpu']['name'];//caminho onde será salvo o FILE
            $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_office_cpu']['name'];//pasta onde está o FILE para salvar no Bando de dados

            /*VALIDAÇÃO DO FILE*/
            $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

            $result =  mysqli_query($conn, $sql_file);//aplicando a query
            $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

             if($tipo_file != NULL){   
                /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                if ($row['type'] != NULL) {//se é arquivo valido       
                    if (move_uploaded_file($_FILES['file_nota_office_cpu']['tmp_name'], $caminho )){//aplicando o salvamento
                        //echo "Arquivo enviado para = ".$_FILES['file_nota_office_cpu']['tmp_name'].$uploadfile;
                    }else{
                    echo "Arquivo não foi enviado!";
                    }//se caso não salvar vai mostrar o erro!
                }else{// se o arquivo não é valido vai levar para tela de erro    
                    echo "Arquivo Invalido!";
                    exit;
                }
            }

            /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
            if($_POST['data_nota_office_cpu'] != NULL){
                $data_nota = $_POST['data_nota_office_cpu'];
            }else{
                $data_nota = 'not info';
            }
            
            //salvando agora o office no banco
            $new_office = "INSERT INTO manager_office
                                (id_equipamento, 
                                locacao, 
                                empresa, 
                                versao, 
                                serial, 
                                fornecedor, 
                                numero_nota, 
                                file_nota, 
                                file_nota_nome, 
                                data_nota)
                            VALUES
                                ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                                '".$_POST['locacao_office_cpu']."',
                                '".$_POST['empresa_office_cpu']."',
                                '".$_POST['tipo_office']."',
                                '".$_POST['serial_nota_office_cpu']."',
                                '".$_POST['fornecedor_cpuOffice']."',
                                '";
                                empty($_POST['num_nota_office_cpu']) ? $new_office .= "semNota" : $new_office .= $_POST['num_nota_office_cpu'];
                                
            $new_office .=      "',
                                '".$caminho_db."',
                                '".$nome_db."',
                                '".$data_nota."')";
            $result_new_office = mysqli_query($conn, $new_office) or die(mysqli_error($conn));

            //montando uma query para pegar o id do windows e enviar para criar um termo
            $pegando_office = "SELECT max(id) AS id FROM manager_office";
            $result_office = mysqli_query($conn, $pegando_office);
            $row_office = mysqli_fetch_assoc($result_office);
        }//end teminando de salvar o office
        
    }else{
        //caso o usuário é novo no manager
        $insert_funcionario_new = "INSERT INTO manager_inventario_funcionario
                                        (cpf, 
                                        nome, 
                                        funcao, 
                                        departamento, 
                                        empresa, 
                                        data_cadastro,
                                        usuario, 
                                        status)
                                    VALUES
                                        ('".$_POST['gols1']."', 
                                        '".$_POST['nome_funcionario']."', 
                                        '".$_POST['funcao_funcionario']."',
                                        '".$_POST['depart_funcionario']."',
                                        '".$_POST['empresa_funcionario']."',
                                        '".$data_hoje."',
                                        '".$_SESSION['id']."',
                                        '4')";
        $resultado_new_funcionario = mysqli_query($conn, $insert_funcionario_new) or die(mysqli_error($conn));

        //pegando o ultimo id do funcionario para usar nos SQLs abaixos
        $ultimo_id_funcionario = "SELECT max(id_funcionario) AS id_funcionario FROM manager_inventario_funcionario";
        $result_id_funcionario = mysqli_query($conn, $ultimo_id_funcionario);
        $row_id_funcionario = mysqli_fetch_assoc($result_id_funcionario);

        //salvando agora o equipamento
        $new_equipamento = " INSERT INTO manager_inventario_equipamento
                                (id_funcionario,
                                usuario, 
                                dominio,
                                tipo_equipamento, 
                                filial, 
                                locacao, 
                                modelo, 
                                departamento, 
                                patrimonio, 
                                hostname,
                                processador, 
                                hd,
                                memoria,
                                ip, 
                                serialnumber,
                                data_criacao,
                                status)
                            VALUE
                                ('".$row_id_funcionario['id_funcionario']."',
                                '".$_SESSION['id']."',
                                '".$_POST['dominio']."',
                                '8',
                                '".$_POST['empresa_cpu']."',
                                '".$_POST['locacao_cpu']."',
                                '".$_POST['modelo_cpu']."',
                                '".$_POST['depart_cpu']."',
                                '".$_POST['num_patrimonio_cpu']."',
                                '".$_POST['nome_cpu']."',
                                '".$_POST['processador_cpu']."',
                                '".$_POST['hd_cpu']."',
                                '".$_POST['memoria_cpu']."',
                                '".$_POST['ip_cpu']."',
                                '".$_POST['serie_cpu']."',
                                '".$data_hoje."',
                                '1');";
        $result_new_equipamento = mysqli_query($conn, $new_equipamento);
        

        //salvando a nota do windows
        $tipo_file = $_FILES['file_nota_so_cpu']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_nota_so_cpu']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_so_cpu']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_so_cpu']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido       
            if (move_uploaded_file($_FILES['file_nota_so_cpu']['tmp_name'], $caminho )){//aplicando o salvamento
                //echo "Arquivo enviado para = ".$_FILES['file_nota_so_cpu']['tmp_name'].$uploadfile;
            }else{
            echo "Arquivo não foi enviado!";
            }//se caso não salvar vai mostrar o erro!
        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido!";
            exit;
        }

        /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
        if($_POST['data_nota_so_cpu'] != NULL){
            $data_nota = $_POST['data_nota_so_cpu'];
        }else{
            $data_nota = 'not info';
        }

        //salvando agora o windows
        $new_windows = "INSERT INTO manager_sistema_operacional
                            (id_equipamento, 
                            locacao, 
                            empresa, 
                            versao, 
                            serial, 
                            fornecedor, 
                            numero_nota, 
                            file_nota, 
                            file_nota_nome, 
                            data_nota)
                        VALUES
                            ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                            '".$_POST['locacao_cpu']."',
                            '".$_POST['empresa_cpu']."',
                            '".$_POST['so_cpu']."',
                            '".$_POST['serial_so_cpu']."',
                            '".$_POST['fornecedor_cpu']."',
                            '";
                            empty($_POST['num_nota_so_cpu']) ? $new_windows .= "semNota"  : $new_windows .= $_POST['num_nota_so_cpu'];
                            
        $new_windows .=     "',
                            '".$caminho_db."',
                            '".$nome_db."',
                            '".$data_nota."')";
        $result_new_windows = mysqli_query($conn, $new_windows) or die(mysqli_error($conn));


        //montando uma query para pegar o id do windows e enviar para criar um termo
        $pegando_windows = "SELECT max(id) AS id FROM manager_sistema_operacional";
        $result_windows = mysqli_query($conn, $pegando_windows);
        $row_windows = mysqli_fetch_assoc($result_windows);

        //salvando agora o office

        if($_POST['serial_nota_office_cpu'] != NULL){

            //salvando a nota do windows
            $tipo_file = $_FILES['file_nota_office_cpu']['type'];//Pegando qual é a extensão do arquivo
            $nome_db = $_FILES['file_nota_office_cpu']['name'];
            $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_office_cpu']['name'];//caminho onde será salvo o FILE
            $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_office_cpu']['name'];//pasta onde está o FILE para salvar no Bando de dados

            /*VALIDAÇÃO DO FILE*/
            $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

            $result =  mysqli_query($conn, $sql_file);//aplicando a query
            $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

            /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
            if ($row['type'] != NULL) {//se é arquivo valido       
                if (move_uploaded_file($_FILES['file_nota_office_cpu']['tmp_name'], $caminho )){//aplicando o salvamento
                    //echo "Arquivo enviado para = ".$_FILES['file_nota_office_cpu']['tmp_name'].$uploadfile;
                }else{
                echo "Arquivo não foi enviado!";
                }//se caso não salvar vai mostrar o erro!
            }else{// se o arquivo não é valido vai levar para tela de erro    
                echo "Arquivo Invalido!";
                exit;
            }

            /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
            if($_POST['data_nota_office_cpu'] != NULL){
                $data_nota = $_POST['data_nota_office_cpu'];
            }else{
                $data_nota = 'not info';
            }
            
            //salvando agora o office no banco
            $new_office = "INSERT INTO manager_office
                                (id_equipamento, 
                                locacao, 
                                empresa, 
                                versao, 
                                serial, 
                                fornecedor, 
                                numero_nota, 
                                file_nota, 
                                file_nota_nome, 
                                data_nota)
                            VALUES
                                ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                                '".$_POST['locacao_office_cpu']."',
                                '".$_POST['empresa_office_cpu']."',
                                '".$_POST['tipo_office']."',
                                '".$_POST['serial_nota_office_cpu']."',
                                '".$_POST['fornecedor_cpuOffice']."',                                
                                '";
                                empty($_POST['num_nota_office_cpu']) ? $new_office .= "semNota" : $new_office .= $_POST['num_nota_office_cpu'];
                                
            $new_office .=      "',
                                '".$caminho_db."',
                                '".$nome_db."',
                                '".$data_nota."')";
            $result_new_office = mysqli_query($conn, $new_office) or die(mysqli_error($conn));

            //montando uma query para pegar o id do windows e enviar para criar um termo
            $pegando_office = "SELECT max(id) AS id FROM manager_office";
            $result_office = mysqli_query($conn, $pegando_office);
            $row_office = mysqli_fetch_assoc($result_office);
        }//end teminando de salvar o office
    }

    $_SESSION['patrimonio'] = $_POST['num_patrimonio_cpu'];
    //finalizando manda msn falando que salvou com sucesso!
    header('location: msn_equipamento.php?msn=1&win='.$row_windows['id'].'&off='.$row_office['id'].'&id_funcionario='.$row_id_funcionario['id_funcionario'].'');

}//end IF = salvando o funcionario e equipamento

/*------------------------------------------------------------------------------------------------ */
//3º Vamos salvar um NOTEBOOK

if ($_POST['num_patrimonio_notebook'] != NULL) {
    if($_POST['nome_notebook'] == NULL){
            
        $existe_patrimonio_cadastrado = "SELECT * FROM manager_ocs_equip WHERE patrimonio LIKE '%".$_POST['num_patrimonio_notebook']."%'";
        $resultado_patrimonio = mysqli_query($conn, $existe_patrimonio_cadastrado);
        $row_patrimonio = mysqli_fetch_assoc($resultado_patrimonio);

        if($row_patrimonio['patrimonio'] != NULL){//se encontrou um patrimio
            /*---FUNCIONARIO---*/
            $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
            $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
            $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
            $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
            $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
             /*---EQUIPAMENTO---*/
            $_SESSION['numero_patrimonio_note'] = $row_patrimonio['patrimonio'];
            $_SESSION['dominio_note'] = $row_patrimonio['dominio'];
            $_SESSION['fornecedor_note'] = $row_patrimonio['fornecedor_note'];
            $_SESSION['nome_computador_note'] = $row_patrimonio['hostname'];
            $_SESSION['ip_note'] = $row_patrimonio['ip'];
            $_SESSION['modelo_note'] = $row_patrimonio['modelo'];
            $_SESSION['processador_note'] = $row_patrimonio['processador'];
            $_SESSION['hd_note'] = $row_patrimonio['hd'];
            $_SESSION['memoria_note'] = $row_patrimonio['memoria'];
            $_SESSION['numero_serial_note'] = $row_patrimonio['serial_number'];
            /*---WINDOWS---*/
            $_SESSION['so_note'] = $row_patrimonio['sistema_operacional'];
            $_SESSION['serial_so_note'] = $row_patrimonio['chave_windows'];
            /*---OFFICE---*/
            $_SESSION['office_note'] = $row_patrimonio['office'];
            $_SESSION['serial_office_note'] = $row_patrimonio['chave_office'];
            /*---VOLTANDO PARA A TELA---*/
            header('location: equip_add.php');
        }else{
            /*---CASO O USUÁRO TENHA DIGITADO ALGUMA COISA---*/
            $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
            $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
            $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
            $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
            $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
            /*---VOLTANDO PARA A TELA - ERRO 2 EQUIPAMENTO NÃO ENCONTRADO---*/
            header('location: equip_add.php?error=2');
        }//end IF = encontrando equipamento 
    }elseif($_POST['empresa_notebook'] == 0){
        $existe_patrimonio_cadastrado = "SELECT * FROM manager_ocs_equip WHERE patrimonio LIKE '%".$_POST['num_patrimonio_notebook']."%'";
        $resultado_patrimonio = mysqli_query($conn, $existe_patrimonio_cadastrado);
        $row_patrimonio = mysqli_fetch_assoc($resultado_patrimonio);

        if($row_patrimonio['patrimonio'] != NULL){//se encontrou um patrimio
           /*---FUNCIONARIO---*/
           $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
           $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
           $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
           $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
           $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
            /*---EQUIPAMENTO---*/
           $_SESSION['numero_patrimonio_note'] = $row_patrimonio['patrimonio'];
           $_SESSION['dominio_note'] = $row_patrimonio['dominio'];
           $_SESSION['fornecedor_note'] = $row_patrimonio['fornecedor_note'];
           $_SESSION['fornecedor_noteOffice'] = $row_patrimonio['fornecedor_noteOffice'];
           $_SESSION['nome_computador_note'] = $row_patrimonio['hostname'];
           $_SESSION['ip_note'] = $row_patrimonio['ip'];
           $_SESSION['modelo_note'] = $row_patrimonio['modelo'];
           $_SESSION['processador_note'] = $row_patrimonio['processador'];
           $_SESSION['hd_note'] = $row_patrimonio['hd'];
           $_SESSION['memoria_note'] = $row_patrimonio['memoria'];
           $_SESSION['numero_serial_note'] = $row_patrimonio['serial_number'];
           /*---WINDOWS---*/
           $_SESSION['so_note'] = $row_patrimonio['sistema_operacional'];
           $_SESSION['serial_so_note'] = $row_patrimonio['chave_windows'];
           /*---OFFICE---*/
           $_SESSION['office_note'] = $row_patrimonio['office'];
           $_SESSION['serial_office_note'] = $row_patrimonio['chave_office'];
           /*---VOLTANDO PARA A TELA---*/
           header('location: equip_add.php');
       }else{
           /*---CASO O USUÁRO TENHA DIGITADO ALGUMA COISA---*/
           $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
           $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
           $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
           $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
           $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
           /*---VOLTANDO PARA A TELA - ERRO 2 EQUIPAMENTO NÃO ENCONTRADO---*/
           header('location: equip_add.php?error=2');
       }//end IF = encontrando equipamento 
    }//end IF = nome_notebbok

    /*------------*/

    if($_POST['observacao_note'] != NULL){
        $observacao_note = $_POST['observacao_note'];
    }else{
        $observacao_note = '0';
    }


    /*---------------ANTES DE MAIS ANDA IREMOS VERIFICAR SE JÁ NÃO ESTÁ CADASTRADO O EQUIPAMENTO---------------*/
    $verificar_cadastro = "SELECT * FROM manager_inventario_equipamento WHERE patrimonio like '".$_POST['num_patrimonio_notebook']."';";
    $resultado_verificar_cadastro = mysqli_query($conn, $verificar_cadastro);
    $row_verificar = mysqli_fetch_assoc($resultado_verificar_cadastro);

    if($row_verificar['deletar'] == 1){
         /*---VOLTANDO PARA A TELA - ERRO 4 EQUIPAMENTO CONDENADO---*/
         header('location: equip_add.php?error=4');
    }elseif($row_verificar['patrimonio'] == $_POST['num_patrimonio_notebook']){
        /*---VOLTANDO PARA A TELA - ERRO 5 EQUIPAMENTO JÁ CADASTRADO---*/
        header('location: equip_add.php?error=5');
        exit;
    }//end IF = validação se já existe

    /*---------------AGORA SIM IREMOS SALVAR O EQUIPAMENTO---------------*/

    //1º iremos salvar o funcionario
    $existe_funcionario = "SELECT * FROM manager_inventario_funcionario  WHERE cpf = '".$_POST['gols1']."';";
    $result_funcionario = mysqli_query($conn, $existe_funcionario);
    if($row_funcionario = mysqli_fetch_assoc($result_funcionario)){
        //se caso já exista um funcionario
        $update = "UPDATE manager_inventario_funcionario 
                    SET 
                    nome = '".$_POST['nome_funcionario']."', 
                    funcao = '".$_POST['funcao_funcionario']."', 
                    departamento = '".$_POST['depart_funcionario']."', 
                    empresa = '".$_POST['empresa_funcionario']."',
                    status = '3' 
                    WHERE id_funcionario = '".$row_funcionario['id_funcionario']."';";
        
        $result_funcionario = mysqli_query($conn, $update) or die(mysqli_error($conn));
        
        //salvando agora o equipamento
        $new_equipamento = "INSERT INTO manager_inventario_equipamento
                                (id_funcionario,
                                usuario,
                                dominio, 
                                tipo_equipamento, 
                                filial, 
                                locacao, 
                                modelo, 
                                departamento, 
                                patrimonio, 
                                hostname,
                                processador,
                                hd,
                                memoria, 
                                ip, 
                                serialnumber, 
                                situacao,
                                observacao, 
                                data_criacao,
                                status)
                            VALUE
                                ('".$row_funcionario['id_funcionario']."',
                                '".$_SESSION['id']."',
                                '".$_POST['dominio_note']."',
                                '9',
                                '".$_POST['empresa_notebook']."',
                                '".$_POST['locacao_notebook']."',
                                '".$_POST['modelo_notebook']."',
                                '".$_POST['depart_notebook']."',
                                '".$_POST['num_patrimonio_notebook']."',
                                '".$_POST['nome_notebook']."',
                                '".$_POST['processador_notebook']."',
                                '".$_POST['hd_note']."',
                                '".$_POST['memoria_note']."',
                                '".$_POST['ip_notebook']."',
                                '".$_POST['serie_notebook']."',
                                '".$_POST['situacao_note']."',
                                '".$observacao_note."',
                                '".$data_hoje."',
                                '1')";
        $result_new_equipamento = mysqli_query($conn, $new_equipamento) or die(mysqli_error($conn));
        

        //salvando a nota do windows
        $tipo_file = $_FILES['file_so_note']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_so_note']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_so_note']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_so_note']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if($tipo_file != NULL){
            if ($row['type'] != NULL) {//se é arquivo valido       
                if (move_uploaded_file($_FILES['file_nota_so_cpu']['tmp_name'], $caminho )){//aplicando o salvamento
                    //echo "Arquivo enviado para = ".$_FILES['file_nota_so_cpu']['tmp_name'].$uploadfile;
                }else{
                echo "Arquivo não foi enviado!";
                }//se caso não salvar vai mostrar o erro!
            }else{// se o arquivo não é valido vai levar para tela de erro    
                echo "Arquivo Invalido!";
                exit;
            }//end IF validação
        }//end IF anexo cheio

        /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
        if($_POST['data_so_note'] != NULL){
            $data_nota = $_POST['data_so_note'];
        }else{
            $data_nota = 'not info';
        }
        //salvando agora o windows
        $new_windows = "INSERT INTO manager_sistema_operacional
                            (id_equipamento, 
                            locacao, 
                            empresa, 
                            versao, 
                            serial, 
                            fornecedor, 
                            numero_nota, 
                            file_nota, 
                            file_nota_nome, 
                            data_nota)
                        VALUES
                            ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                            '".$_POST['locacao_notebook']."',
                            '".$_POST['empresa_notebook']."',
                            '".$_POST['so_notebook']."',
                            '".$_POST['serial_so_note']."',
                            '".$_POST['fornecedor_note']."',
                            '";
                            empty($_POST['num_so_note']) ? $new_windows .= "semNota" : $new_windows .= $_POST['num_so_note'];
        $new_windows .=     "',
                            '".$caminho_db."',
                            '".$nome_db."',
                            '".$data_nota."')";              
        $result_new_windows = mysqli_query($conn, $new_windows) or die(mysqli_error($conn));

        //montando uma query para pegar o id do windows e enviar para criar um termo
        $pegando_windows = "SELECT max(id) AS id FROM manager_sistema_operacional";
        $result_windows = mysqli_query($conn, $pegando_windows);
        $row_windows = mysqli_fetch_assoc($result_windows);

        //salvando agora o office

        if($_POST['serial_office_note'] != NULL){

            //salvando a nota do windows
            $tipo_file = $_FILES['file_office_note']['type'];//Pegando qual é a extensão do arquivo
            $nome_db = $_FILES['file_office_note']['name'];
            $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_office_note']['name'];//caminho onde será salvo o FILE
            $caminho_db = "documentos/tecnicos/".$_FILES['file_office_note']['name'];//pasta onde está o FILE para salvar no Bando de dados

            /*VALIDAÇÃO DO FILE*/
            $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

            $result =  mysqli_query($conn, $sql_file);//aplicando a query
            $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

            if($tipo_file != NULL){
                /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                if ($row['type'] != NULL) {//se é arquivo valido       
                    if (move_uploaded_file($_FILES['file_office_note']['tmp_name'], $caminho )){//aplicando o salvamento
                        //echo "Arquivo enviado para = ".$_FILES['file_office_note']['tmp_name'].$uploadfile;
                    }else{
                    echo "Arquivo não foi enviado!";
                    }//se caso não salvar vai mostrar o erro!
                }else{// se o arquivo não é valido vai levar para tela de erro    
                    echo "Arquivo Invalido!";
                    exit;
                }

            }  

            /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
            if($_POST['data_office_note'] != NULL){
                $data_nota = $_POST['data_office_note'];
            }else{
                $data_nota = 'not date';
            }             
            
            //salvando agora o office no banco
            $new_office = "INSERT INTO manager_office
                                (id_equipamento, 
                                locacao, 
                                empresa, 
                                versao, 
                                serial, 
                                fornecedor, 
                                numero_nota, 
                                file_nota, 
                                file_nota_nome, 
                                data_nota)
                            VALUES
                                ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                                '".$_POST['local_note_office']."',
                                '".$_POST['empresa_note_office']."',
                                '".$_POST['office_note']."',
                                '".$_POST['serial_office_note']."',
                                '".$_POST['fornecedor_noteOffice']."',
                                '";
                                empty($_POST['num_office_note']) ? $new_office .= "semNota" : $new_office .= $_POST['num_office_note'];
                                
            $new_office .=      "',
                                '".$caminho_db."',
                                '".$nome_db."',
                                '".$data_nota."')";
            $result_new_office = mysqli_query($conn, $new_office) or die(mysqli_error($conn));

             //montando uma query para pegar o id do windows e enviar para criar um termo
             $pegando_office = "SELECT max(id) AS id FROM manager_office";
             $result_office = mysqli_query($conn, $pegando_office);
             $row_office = mysqli_fetch_assoc($result_office);
        }//end teminando de salvar o office

        //ENVIANDO PARA O TERMO EM PDF
    $_SESSION['patrimonio'] = $_POST['num_patrimonio_notebook'];

    //finalizando manda msn falando que salvou com sucesso!
    header('location: msn_equipamento.php?msn=2&win='.$row_windows['id'].'&off='.$row_office['id'].'&id_funcionario='.$row_funcionario['id_funcionario'].'');
    //enviar patrimonio para o termo    
    $_SESSION['patrimonio_termo'] = $_POST['num_patrimonio_notebook'];
        
    }else{
        //caso o usuário é novo no manager
        $insert_funcionario_new = "INSERT INTO manager_inventario_funcionario
                                        (cpf, 
                                        nome, 
                                        funcao, 
                                        departamento, 
                                        empresa, 
                                        data_cadastro,
                                        usuario, 
                                        status)
                                    VALUES
                                        ('".$_POST['gols1']."', 
                                        '".$_POST['nome_funcionario']."', 
                                        '".$_POST['funcao_funcionario']."',
                                        '".$_POST['depart_funcionario']."',
                                        '".$_POST['empresa_funcionario']."',
                                        '".$data_hoje."',
                                        '".$_SESSION['id']."',
                                        '3')";
        $resultado_new_funcionario = mysqli_query($conn, $insert_funcionario_new) or die(mysqli_error($conn));

        /*------------*/

        if($_POST['observacao_note'] != NULL){
            $observacao_note = $_POST['observacao_note'];
        }else{
            $observacao_note = '0';
        }

        //pegando o ultimo id do funcionario para usar nos SQLs abaixos
        $ultimo_id_funcionario = "SELECT max(id_funcionario) AS id_funcionario  FROM manager_inventario_funcionario";
        $result_id_funcionario = mysqli_query($conn, $ultimo_id_funcionario);
        $row_funcionario = mysqli_fetch_assoc($result_id_funcionario);

        //salvando agora o equipamento
        $new_equipamento = "INSERT INTO manager_inventario_equipamento
                                (id_funcionario,
                                usuario,
                                dominio, 
                                tipo_equipamento, 
                                filial, 
                                locacao, 
                                modelo, 
                                departamento, 
                                patrimonio, 
                                hostname,
                                processador,
                                hd,
                                memoria, 
                                ip, 
                                serialnumber, 
                                situacao,
                                observacao, 
                                data_criacao,
                                status)
                            VALUE
                                ('".$row_funcionario['id_funcionario']."',
                                '".$_SESSION['id']."',
                                '".$_POST['dominio_note']."',
                                '9',
                                '".$_POST['empresa_notebook']."',
                                '".$_POST['locacao_notebook']."',
                                '".$_POST['modelo_notebook']."',
                                '".$_POST['depart_notebook']."',
                                '".$_POST['num_patrimonio_notebook']."',
                                '".$_POST['nome_notebook']."',
                                '".$_POST['processador_notebook']."',
                                '".$_POST['hd_note']."',
                                '".$_POST['memoria_note']."',
                                '".$_POST['ip_notebook']."',
                                '".$_POST['serie_notebook']."',
                                '".$_POST['situacao_note']."',
                                '".$observacao_note."',
                                '".$data_hoje."',
                                '1')";
        $result_new_equipamento = mysqli_query($conn, $new_equipamento);
        

        //salvando a nota do windows
        $tipo_file = $_FILES['file_so_note']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_so_note']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_so_note']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_so_note']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        if($tipo_file != NULL){
            /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
            if ($row['type'] != NULL) {//se é arquivo valido       
                if (move_uploaded_file($_FILES['file_so_note']['tmp_name'], $caminho )){//aplicando o salvamento
                    //echo "Arquivo enviado para = ".$_FILES['file_so_note']['tmp_name'].$uploadfile;
                }else{
                echo "Arquivo não foi enviado!";
                }//se caso não salvar vai mostrar o erro!
            }else{// se o arquivo não é valido vai levar para tela de erro    
                echo "Arquivo Invalido!";
                exit;
            }

        }

        /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
        if($_POST['data_so_note'] != NULL){
            $data_nota = $_POST['data_so_note'];
        }else{
            $data_nota = 'not info';
        }

        //salvando agora o windows
        $new_windows = "INSERT INTO manager_sistema_operacional
                            (id_equipamento, 
                            locacao, 
                            empresa, 
                            versao, 
                            serial, 
                            fornecedor, 
                            numero_nota, 
                            file_nota, 
                            file_nota_nome, 
                            data_nota)
                        VALUES
                            ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                            '".$_POST['locacao_notebook']."',
                            '".$_POST['empresa_notebook']."',
                            '".$_POST['so_notebook']."',
                            '".$_POST['serial_so_note']."',
                            '".$_POST['fornecedor_note']."',
                            '";
                            empty($_POST['num_so_note']) ? $new_windows .= "semNota" : $new_windows .= $_POST['num_so_note'];
        $new_windows .=     "',
                            '".$caminho_db."',
                            '".$nome_db."',
                            '".$data_nota."')";              
        $result_new_windows = mysqli_query($conn, $new_windows) or die(mysqli_error($conn));



        //salvando a nota do windows
        $tipo_file = $_FILES['file_office_note']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_office_note']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_office_note']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_office_note']['name'];//pasta onde está o FILE para salvar no Bando de dados

        //salvando agora o office

        if($_POST['serial_office_note'] != NULL){

            //salvando a nota do windows
            $tipo_file = $_FILES['file_office_note']['type'];//Pegando qual é a extensão do arquivo
            $nome_db = $_FILES['file_office_note']['name'];
            $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_office_note']['name'];//caminho onde será salvo o FILE
            $caminho_db = "documentos/tecnicos/".$_FILES['file_office_note']['name'];//pasta onde está o FILE para salvar no Bando de dados

            /*VALIDAÇÃO DO FILE*/
            $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

            $result =  mysqli_query($conn, $sql_file);//aplicando a query
            $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

            if($tipo_file != NULL){
                    /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                if ($row['type'] != NULL) {//se é arquivo valido       
                    if (move_uploaded_file($_FILES['file_office_note']['tmp_name'], $caminho )){//aplicando o salvamento
                        //echo "Arquivo enviado para = ".$_FILES['file_office_note']['tmp_name'].$uploadfile;
                    }else{
                    echo "Arquivo não foi enviado!";
                    }//se caso não salvar vai mostrar o erro!
                }else{// se o arquivo não é valido vai levar para tela de erro    
                    echo "Arquivo Invalido!";
                    exit;
                }
            }
           
             /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
            if($_POST['data_office_note'] != NULL){
                $data_nota = $_POST['data_office_note'];
            }else{
                $data_nota = 'not date';
            }  
            
            //salvando agora o office no banco
            $new_office = "INSERT INTO manager_office
                                (id_equipamento, 
                                locacao, 
                                empresa, 
                                versao, 
                                serial, 
                                fornecedor, 
                                numero_nota, 
                                file_nota, 
                                file_nota_nome, 
                                data_nota)
                            VALUES
                                ((SELECT max(id_equipamento) FROM manager_inventario_equipamento), 
                                '".$_POST['local_note_office']."',
                                '".$_POST['empresa_note_office']."',
                                '".$_POST['office_note']."',
                                '".$_POST['serial_office_note']."',
                                '".$_POST['fornecedor_noteOffice']."',
                                '";
                                empty($_POST['num_office_note']) ? $new_office .= "semNota" : $new_office .= $_POST['num_office_note'];
                                
            $new_office .=      "',
                                '".$caminho_db."',
                                '".$nome_db."',
                                '".$data_nota."')";
            $result_new_office = mysqli_query($conn, $new_office) or die(mysqli_error($conn));

             //montando uma query para pegar o id do windows e enviar para criar um termo
             $pegando_office = "SELECT max(id) AS id FROM manager_office";
             $result_office = mysqli_query($conn, $pegando_office);
             $row_office = mysqli_fetch_assoc($result_office);
        }//end teminando de salvar o office

        //ENVIANDO PARA O TERMO EM PDF
        $_SESSION['patrimonio'] = $_POST['num_patrimonio_notebook'];

        //finalizando manda msn falando que salvou com sucesso!
        header('location: msn_equipamento.php?msn=2&win='.$row_windows['id'].'&off='.$row_office['id'].'&id_funcionario='.$row_id_funcionario['id_funcionario'].'&patrimonio='.$_POST['num_patrimonio_notebook'].'');
    }
    

}//end IF = salvando o funcionario e equipamento

/*------------------------------------------------------------------------------------------------ */
//4º Vamos salvar um Ramal


if($_POST['numero_ramal0'] != NULL){

    //contador caso tenha mais de um Ramal
    $contador_ramal = 0;
    
    /*---------------AGORA SIM IREMOS SALVAR O EQUIPAMENTO---------------*/

    //1º iremos salvar o funcionario
    $existe_funcionario = "SELECT * FROM manager_inventario_funcionario  WHERE cpf = '".$_POST['gols1']."';";
    $result_funcionario = mysqli_query($conn, $existe_funcionario);
    if($row_funcionario = mysqli_fetch_assoc($result_funcionario)){

        //se caso já exista um funcionario
        $update = "UPDATE manager_inventario_funcionario 
                    SET 
                    nome = '".$_POST['nome_funcionario']."', 
                    funcao = '".$_POST['funcao_funcionario']."', 
                    departamento = '".$_POST['depart_funcionario']."', 
                    empresa = '".$_POST['empresa_funcionario']."',
                    status = '3' 
                    WHERE id_funcionario = '".$row_funcionario['id_funcionario']."';";
        
        $result_funcionario = mysqli_query($conn, $update) or die(mysqli_error($conn));

        while($_POST['numero_ramal'.$contador_ramal.'']){
            
            /*---------------ANTES DE MAIS ANDA IREMOS VERIFICAR SE JÁ NÃO ESTÁ CADASTRADO O EQUIPAMENTO---------------*/
            $verificar_cadastro = "SELECT * FROM manager_inventario_equipamento WHERE numero =  '".$_POST['numero_ramal'.$contador_ramal.'']."';";
            $resultado_verificar_cadastro = mysqli_query($conn, $verificar_cadastro);
            $row_verificar = mysqli_fetch_assoc($resultado_verificar_cadastro);

            if($row_verificar['deletar'] == 1){
                /*---VOLTANDO PARA A TELA - ERRO 4 EQUIPAMENTO CONDENADO---*/
                header('location: equip_add.php?error=4');
            }elseif($row_verificar['patrimonio'] == $_POST['numero_ramal'.$contador_ramal.'']){
                /*---VOLTANDO PARA A TELA - ERRO 5 EQUIPAMENTO JÁ CADASTRADO---*/
                header('location: equip_add.php?error=5');
                exit;
            }//end IF = validação se já existe

            //salvando agora o equipamento
            $new_equipamento = "INSERT INTO manager_inventario_equipamento
                                    (id_funcionario, 
                                    tipo_equipamento, 
                                    filial, 
                                    locacao,
                                    modelo,
                                    numero,
                                    data_criacao,
                                    usuario, 
                                    status)
                                VALUE
                                    ('".$row_funcionario['id_funcionario']."',
                                    '5',
                                    '".$_POST['empresa_ramal'.$contador_ramal.'']."',
                                    '".$_POST['local_ramal'.$contador_ramal.'']."',
                                    '".$_POST['modelo_ramal'.$contador_ramal.'']."',
                                    '".$_POST['numero_ramal'.$contador_ramal.'']."',
                                    '".$data_hoje."',
                                    '".$_SESSION['id']."',
                                    '1')";
            $result_new_equipamento = mysqli_query($conn, $new_equipamento) or die(mysqli_error($conn));

            //ENVIANDO PARA O TERMO EM PDF
           $_SESSION['numero_ramal'.$contador_ramal.''] = $_POST['numero_ramal'.$contador_ramal.''];
           $_SESSION['id_funcionario'] = $row_funcionario['id_funcionario'];

            //somando no contador
            $contador_ramal++;
        }//END WHILE cadastrando ramal  
      //finalizando manda msn falando que salvou com sucesso!
     header('location: msn_equipamento.php?id_funcionario='.$row_funcionario['id_funcionario'].'&ramal=1');
    }else{
        //contador caso tenha mais de um Ramal
        $contador_ramal = 0;

        //caso o usuário é novo no manager
        $insert_funcionario_new = "INSERT INTO manager_inventario_funcionario
                                        (cpf, 
                                        nome, 
                                        funcao, 
                                        departamento, 
                                        empresa, 
                                        data_cadastro,
                                        usuario, 
                                        status)
                                    VALUES
                                        ('".$_POST['gols1']."', 
                                        '".$_POST['nome_funcionario']."', 
                                        '".$_POST['funcao_funcionario']."',
                                        '".$_POST['depart_funcionario']."',
                                        '".$_POST['empresa_funcionario']."',
                                        '".$data_hoje."',
                                        '".$_SESSION['id']."',
                                        '3')";
        $resultado_new_funcionario = mysqli_query($conn, $insert_funcionario_new) or die(mysqli_error($conn));

        //pegando o ultimo id do funcionario para usar nos SQLs abaixos
        $ultimo_id_funcionario = "SELECT max(id_funcionario) AS id_funcionario  FROM manager_inventario_funcionario";
        $result_id_funcionario = mysqli_query($conn, $ultimo_id_funcionario);
        $row_id_funcionario = mysqli_fetch_assoc($result_id_funcionario);

        while($_POST['numero_ramal'.$contador_ramal.'']){
            
            /*---------------ANTES DE MAIS ANDA IREMOS VERIFICAR SE JÁ NÃO ESTÁ CADASTRADO O EQUIPAMENTO---------------*/
            $verificar_cadastro = "SELECT * FROM manager_inventario_equipamento WHERE ipdi =  '".$_POST['numero_ramal'.$contador_ramal.'']."';";
            $resultado_verificar_cadastro = mysqli_query($conn, $verificar_cadastro);
            $row_verificar = mysqli_fetch_assoc($resultado_verificar_cadastro);

            if($row_verificar['deletar'] == 1){
                /*---VOLTANDO PARA A TELA - ERRO 4 EQUIPAMENTO CONDENADO---*/
                header('location: equip_add.php?error=4');
            }elseif($row_verificar['patrimonio'] == $_POST['numero_ramal'.$contador_ramal.'']){
                /*---VOLTANDO PARA A TELA - ERRO 5 EQUIPAMENTO JÁ CADASTRADO---*/
                header('location: equip_add.php?error=5');
                exit;
            }//end IF = validação se já existe

            //salvando agora o equipamento
            $new_equipamento = "INSERT INTO manager_inventario_equipamento
                                    (id_funcionario, 
                                    tipo_equipamento, 
                                    filial, 
                                    locacao,
                                    modelo,
                                    departamento,
                                    numero,
                                    data_criacao,
                                    usuario, 
                                    status)
                                VALUE
                                    ('".$row_id_funcionario['id_funcionario']."',
                                    '5',
                                    '".$_POST['empresa_ramal'.$contador_ramal.'']."',
                                    '".$_POST['local_ramal'.$contador_ramal.'']."',            
                                    '".$_POST['modelo_ramal'.$contador_ramal.'']."',
                                    '".$_POST['depart_funcionario']."',
                                    '".$_POST['numero_ramal'.$contador_ramal.'']."',
                                    '".$data_hoje."',
                                    '".$_SESSION['id']."',
                                    '1')";
            $result_new_equipamento = mysqli_query($conn, $new_equipamento) or die(mysqli_error($conn));
            //ENVIANDO PARA O TERMO EM PDF
            $_SESSION['numero_ramal'.$contador_ramal.''] = $_POST['numero_ramal'.$contador_ramal.''];

            //somando no contador
            $contador_ramal++;
        }//END WHILE cadastrando ramal    

        //finalizando manda msn falando que salvou com sucesso!
        header('location: msn_equipamento.php?id_funcionario='.$row_id_funcionario['id_funcionario'].'&ramal=1');
    }//end IF = salvando equipamento
}//finalizando RAMAL


/*------------------------------------------------------------------------------------------------ */
//5º Vamos salvar um Scanner


if($_POST['serie_scan'] != NULL){

    /*---------------AGORA SIM IREMOS SALVAR O EQUIPAMENTO---------------*/

    //1º iremos salvar o funcionario
    $existe_funcionario = "SELECT * FROM manager_inventario_funcionario  WHERE cpf = '".$_POST['gols1']."';";
    $result_funcionario = mysqli_query($conn, $existe_funcionario);
    if($row_funcionario = mysqli_fetch_assoc($result_funcionario)){

        //se caso já exista um funcionario
        $update = "UPDATE manager_inventario_funcionario 
                    SET 
                    nome = '".$_POST['nome_funcionario']."', 
                    funcao = '".$_POST['funcao_funcionario']."', 
                    departamento = '".$_POST['depart_funcionario']."', 
                    empresa = '".$_POST['empresa_funcionario']."',
                    status = '4' 
                    WHERE id_funcionario = '".$row_funcionario['id_funcionario']."';";
        
        $result_funcionario = mysqli_query($conn, $update) or die(mysqli_error($conn));
            
        /*---------------ANTES DE MAIS ANDA IREMOS VERIFICAR SE JÁ NÃO ESTÁ CADASTRADO O EQUIPAMENTO---------------*/
        $verificar_cadastro = "SELECT * FROM manager_inventario_equipamento WHERE serialnumber =  '".$_POST['serie_scan']."'";
        $resultado_verificar_cadastro = mysqli_query($conn, $verificar_cadastro);
        $row_verificar = mysqli_fetch_assoc($resultado_verificar_cadastro);

        if($row_verificar['deletar'] == 1){
            /*---VOLTANDO PARA A TELA - ERRO 4 EQUIPAMENTO CONDENADO---*/
            header('location: equip_add.php?error=4');
        }elseif($row_verificar['serialnumber'] == $_POST['serie_scan']){
            /*---VOLTANDO PARA A TELA - ERRO 5 EQUIPAMENTO JÁ CADASTRADO---*/
            header('location: equip_add.php?error=5');
            exit;
        }//end IF = validação se já existe

        //salvando agora o equipamento
        $new_equipamento = "INSERT INTO manager_inventario_equipamento
        (id_funcionario, 
        usuario,
        tipo_equipamento, 
        filial, 
        locacao,
        modelo,
        patrimonio,";
if($_POST['tipo_scan'] == 4){
    $new_equipamento .= "situacao, fornecedor_scan, data_fim_contrato,";
            }else{
    $new_equipamento .= "situacao, numero_nota,";           
            } 
    $new_equipamento .= "
        data_criacao, 
        status)
        VALUE
        ('".$row_funcionario['id_funcionario']."',
        '".$_SESSION['id']."',
        '10',
        '".$_POST['empresa_scan']."',
        '".$_POST['locacao_scan']."',
        '".$_POST['modelo_scan']."',
        '".$_POST['patrimonio_scan']."',";
        if($_POST['tipo_scan'] == 4){
$new_equipamento .= "'4','".$_POST['fornecedor_scan']."','".$_POST['data_contrato_scan']."',";
        }else{
$new_equipamento .= "'5','".$_POST['num_nota_scan']."',";            
        }
$new_equipamento .= "

        '".$data_hoje."',
        '1');";

        $result_new_equipamento = mysqli_query($conn, $new_equipamento) or die(mysqli_error($conn));

        //salvando nota fical caso tenha

        if($_FILES['file_nota_scan']['type']){
             //salvando a nota do windows
             $tipo_file = $_FILES['file_nota_scan']['type'];//Pegando qual é a extensão do arquivo
             $nome_db = $_FILES['file_nota_scan']['name'];
             $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_scan']['name'];//caminho onde será salvo o FILE
             $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_scan']['name'];//pasta onde está o FILE para salvar no Bando de dados
 
             /*VALIDAÇÃO DO FILE*/
             $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
 
             $result =  mysqli_query($conn, $sql_file);//aplicando a query
             $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel
 
             if($tipo_file != NULL){
                     /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
                 if ($row['type'] != NULL) {//se é arquivo valido       
                     if (move_uploaded_file($_FILES['file_nota_scan']['tmp_name'], $caminho )){//aplicando o salvamento
                         //echo "Arquivo enviado para = ".$_FILES['file_nota_scan']['tmp_name'].$uploadfile;
                     }else{
                     echo "Arquivo não foi enviado!";
                     }//se caso não salvar vai mostrar o erro!
                 }else{// se o arquivo não é valido vai levar para tela de erro    
                     echo "Arquivo Invalido!";
                     exit;
                 }//end IF enviando arquivo
             }//end IF validação arquivo

             /*SALVANDO O FILE NO BANDO DE DADOS*/

            $nota_scan = "INSERT INTO manager_inventario_anexo (id_equipamento, usuario, tipo_anexo, caminho, nome, data_criacao)
                           VALUE 
                        ((SELECT MAX(id_equipamento) FROM manager_inventario_equipamento), '".$_SESSION['id']."', '".$tipo_file."', '".$caminho_db."', '".$nome_db."', '".$data_hoje."')";
            $result_scan = mysqli_query($conn, $nota_scan) or die(mysqli_error($conn));
        }//end IF arquivo nota

        //finalizando manda msn falando que salvou com sucesso!
        header('location: msn_equipamento.php?id_funcionario='.$row_funcionario['id_funcionario'].'&scan=1');
    }else{

        //caso o usuário é novo no manager
        $insert_funcionario_new = "INSERT INTO manager_inventario_funcionario
                                        (cpf,
                                        nome, 
                                        funcao, 
                                        departamento, 
                                        empresa, 
                                        data_cadastro,
                                        usuario, 
                                        status)
                                    VALUES
                                        ('".$_POST['gols1']."', 
                                        '".$_POST['nome_funcionario']."', 
                                        '".$_POST['funcao_funcionario']."',
                                        '".$_POST['depart_funcionario']."',
                                        '".$_POST['empresa_funcionario']."',
                                        '".$data_hoje."',
                                        '".$_SESSION['id']."',
                                        '4')";
        $resultado_new_funcionario = mysqli_query($conn, $insert_funcionario_new) or die(mysqli_error($conn));

        //pegando o ultimo id do funcionario para usar nos SQLs abaixos
        $ultimo_id_funcionario = "SELECT max(id_funcionario) AS id_funcionario  FROM manager_inventario_funcionario";
        $result_id_funcionario = mysqli_query($conn, $ultimo_id_funcionario);
        $row_id_funcionario = mysqli_fetch_assoc($result_id_funcionario);
            
        /*---------------ANTES DE MAIS ANDA IREMOS VERIFICAR SE JÁ NÃO ESTÁ CADASTRADO O EQUIPAMENTO---------------*/
        $verificar_cadastro = "SELECT * FROM manager_inventario_equipamento WHERE serialnumber =  '".$_POST['serie_scan']."'";
        $resultado_verificar_cadastro = mysqli_query($conn, $verificar_cadastro);
        $row_verificar = mysqli_fetch_assoc($resultado_verificar_cadastro);

        if($row_verificar['deletar'] == 1){
            /*---VOLTANDO PARA A TELA - ERRO 4 EQUIPAMENTO CONDENADO---*/
            header('location: equip_add.php?error=4');
        }elseif($row_verificar['serialnumber'] == $_POST['serie_scan']){
            /*---VOLTANDO PARA A TELA - ERRO 5 EQUIPAMENTO JÁ CADASTRADO---*/
            header('location: equip_add.php?error=5');
            exit;
        }//end IF = validação se já existe

       //salvando agora o equipamento
      $new_equipamento = "INSERT INTO manager_inventario_equipamento
        (id_funcionario, 
        usuario,
        tipo_equipamento, 
        filial, 
        locacao,
        modelo,
        patrimonio,";
if($_POST['tipo_scan'] == 4){
    $new_equipamento .= "situacao, fornecedor_scan, data_fim_contrato,";
            }else{
    $new_equipamento .= "situacao, numero_nota,";           
            } 
    $new_equipamento .= "
        data_criacao, 
        status)
        VALUE
        ('".$row_id_funcionario['id_funcionario']."',
        '".$_SESSION['id']."',
        '10',
        '".$_POST['empresa_scan']."',
        '".$_POST['locacao_scan']."',
        '".$_POST['modelo_scan']."',
        '".$_POST['patrimonio_scan']."',";
        if($_POST['tipo_scan'] == 4){
$new_equipamento .= "'4','".$_POST['fornecedor_scan']."','".$_POST['data_contrato_scan']."',";
        }else{
$new_equipamento .= "'5','".$_POST['num_nota_scan']."',";            
        }
$new_equipamento .= "

        '".$data_hoje."',
        '1');";
       $result_new_equipamento = mysqli_query($conn, $new_equipamento) or die(mysqli_error($conn));

       //salvando nota fical caso tenha

       if($_FILES['file_nota_scan']['type']){
        //salvando a nota do windows
        $tipo_file = $_FILES['file_nota_scan']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_nota_scan']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_scan']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_scan']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        if($tipo_file != NULL){
                /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
            if ($row['type'] != NULL) {//se é arquivo valido       
                if (move_uploaded_file($_FILES['file_nota_scan']['tmp_name'], $caminho )){//aplicando o salvamento
                    //echo "Arquivo enviado para = ".$_FILES['file_nota_scan']['tmp_name'].$uploadfile;
                }else{
                echo "Arquivo não foi enviado!";
                }//se caso não salvar vai mostrar o erro!
            }else{// se o arquivo não é valido vai levar para tela de erro    
                echo "Arquivo Invalido!";
                exit;
            }//end IF enviando arquivo
        }//end IF validação arquivo

        /*SALVANDO O FILE NO BANDO DE DADOS*/

       $nota_scan = "INSERT INTO manager_inventario_anexo (id_equipamento, tipo_anexo, caminho, nome, data_criacao)
                      VALUE 
                   ((SELECT MAX(id_equipamento) FROM manager_inventario_equipamento), '".$tipo_file."', '".$caminho_db."', '".$nome_db."', '".$data_hoje."')";
       $result_scan = mysqli_query($conn, $nota_scan) or die(mysqli_error($conn));
   }//end IF arquivo nota

       //finalizando manda msn falando que salvou com sucesso!
        header('location: msn_equipamento.php?id_funcionario='.$row_id_funcionario['id_funcionario'].'&scan=1');
    }//end IF = salvando equipamento
}//finalizando SCANNER

//fechando o banco de dados
mysqli_close($conn);

?>