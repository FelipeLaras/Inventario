<?php
//sessão
session_start();
//banco de dados
include 'conexao.php';
//DATA DE HOJE
$data_hoje = date('d/m/Y');

/*################## validando ##################*/
//caso o usuário esqueça de informar algum equipamento

$cpu = $_POST['num_patrimonio_cpu'];
$notebook = $_POST['num_patrimonio_notebook'];
$tel = $_POST['modelo_ramal0'];
$scan = $_POST['serie_scan'];

if(($cpu == null) && ($notebook == NULL) && ($tel == NULL) && ($scan == NULL)){
    header('location: add_equip_single.php?error=3');//Erro Preencher pelomenos um equipamento
}

/*################## SALVANDO CPU ##################*/
//2º salvando o equipamento
if($cpu != NULL){
    $query_equipamento_cpu = "INSERT INTO manager_inventario_equipamento 
                                (usuario, 
                                tipo_equipamento, 
                                dominio, 
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
                                status, 
                                data_criacao) VALUES 
                                ('".$_SESSION['id']."',
                                '8',
                                '".$_POST['dominio']."',
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
                                '6',
                                '".$data_hoje."')";
    if($result_equipamento_cpu = mysqli_query($conn, $query_equipamento_cpu)){
        echo "Salvou equipamento</br>";
    }else{
        printf("Erro equipamento: ".mysqli_error($conn));
    }
    
    //2º salvando o office
    //FILE  

    if($_FILES['file_nota_office_cpu']['name'] != NULL){
        //salvando o file da nota
        $tipo_file = $_FILES['file_nota_office_cpu']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_nota_office_cpu']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_office_cpu']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_office_cpu']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

        if($result =  mysqli_query($conn, $sql_file)){
            echo "Salvou Nota Office";
        }else{
            printf("Erro Nota Office: ".mysqli_error($conn));
        }

        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido      

            if (move_uploaded_file($_FILES['file_nota_office_cpu']['tmp_name'], $caminho )){//aplicando o salvamento
            }else{
            echo "Arquivo não foi enviado Office!";
            }//se caso não salvar vai mostrar o erro!

        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido Office!";
            exit;
        }//end IF validação
    }//END ANEXO OFFICE

    if($_POST['serial_nota_office_cpu'] != NULL){//se tiver um serial salva o office
         //OFFICE
        $query_cpu_office = "INSERT INTO manager_office (id_equipamento, 
        locacao, 
        empresa, 
        versao, 
        serial, 
        fornecedor, 
        numero_nota,
        file_nota,
        file_nota_nome,
        data_nota) VALUE
        ((SELECT max(id_equipamento) FROM manager_inventario_equipamento),
        '".$_POST['locacao_office_cpu']."',
        '".$_POST['empresa_office_cpu']."',
        '".$_POST['tipo_office']."',
        '".$_POST['serial_nota_office_cpu']."',
        '".$_POST['fornecedor_cpuOffice']."',
        '";
        empty($_POST['num_nota_office_cpu']) ? $query_cpu_office .= "semNota" : $query_cpu_office .= $_POST['num_nota_office_cpu'];
        $query_cpu_office .= "',
        '".$caminho_db."',
        '".$nome_db."',
        '".$_POST['data_nota_office_cpu']."')";
        if($result_cpu_office = mysqli_query($conn, $query_cpu_office)){
            echo "Salvou Office</br>";

            //pegando o ultimo valor para usar na hora de enviar o modelo
            $query_idOffice = "SELECT max(id) as id FROM manager_office";
            $result_idOffice = mysqli_query($conn, $query_idOffice);
            $idOffice = mysqli_fetch_assoc($result_idOffice);

        }else{
            printf("Erro Office: ".mysqli_error($conn));
        }
    } 

    //3º salvando o windows
    //FILE
    if($_FILES['file_nota_so_cpu']['name'] != NULL){
        //salvando o file da nota
        $tipo_file = $_FILES['file_nota_so_cpu']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_nota_so_cpu']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_so_cpu']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_so_cpu']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação
        
        if($result =  mysqli_query($conn, $sql_file)){
            echo "Salvou Nota Windows</br>";
        }else{
            printf("Erro Nota Windows: ".mysqli_error($conn));
        }

        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido      

            if (move_uploaded_file($_FILES['file_nota_so_cpu']['tmp_name'], $caminho )){//aplicando o salvamento
            }else{
            echo "Arquivo não foi enviado Windows!";
            }//se caso não salvar vai mostrar o erro!

        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido Windows!";
            exit;
        }//end IF validação

    }//END ANEXO WINDOWS    

    //WINDOWS
    $query_cpu_windows = "INSERT INTO manager_sistema_operacional (id_equipamento, 
                                                        locacao, 
                                                        empresa, 
                                                        versao, 
                                                        serial, 
                                                        fornecedor, 
                                                        numero_nota,
                                                        file_nota,
                                                        file_nota_nome,
                                                        data_nota) VALUE
                                                        ((SELECT max(id_equipamento) FROM manager_inventario_equipamento),
                                                        '".$_POST['locacao_cpu']."',
                                                        '".$_POST['empresa_cpu']."',
                                                        '".$_POST['so_cpu']."',
                                                        '".$_POST['serial_so_cpu']."',
                                                        '".$_POST['fornecedor_cpu']."',
                                                        '";
                                                        empty($_POST['num_nota_so_cpu']) ? $query_cpu_windows .= "semNota" : $query_cpu_windows .= $_POST['num_nota_so_cpu'];                                                        
  $query_cpu_windows .= "',                             '".$caminho_db."',
                                                        '".$nome_db."',
                                                        '".$_POST['data_nota_so_cpu']."')"; 

    if($result_cpu_windows = mysqli_query($conn, $query_cpu_windows)){
        echo "Salvou Windows</br>";
    }else{
        echo $query_cpu_windows;
        printf("Erro Windows: ".mysqli_error($conn));
    }

    //pegando o ultimo valor para usar na hora de enviar o modelo
    $query_idWindows = "SELECT max(id) as id FROM manager_sistema_operacional";
    $result_idWindows = mysqli_query($conn, $query_idWindows);
    $idWindows = mysqli_fetch_assoc($result_idWindows);


    header('location: msn_equipamento.php?msn=1&win='.$idWindows['id'].'&off='.$idOffice['id'].'');
}//fim salvando CPU



/*################## SALVANDO NOTEBOOK ##################*/
//2º salvando o equipamento
if($notebook != NULL){
    $query_equipamento_note = "INSERT INTO manager_inventario_equipamento 
                                (usuario, 
                                tipo_equipamento, 
                                dominio, 
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
                                estado,
                                serialnumber,
                                status, 
                                data_criacao) VALUES 
                                ('".$_SESSION['id']."',
                                '9',
                                '".$_POST['dominio_note']."',
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
                                '".$_POST['situacao_note']."',                                                                                                 
                                '".$_POST['serie_notebook']."',
                                '6',
                                '".$data_hoje."')";
    if($resultado_equipamento_note = mysqli_query($conn, $query_equipamento_note)){
        echo "Salvou equipamento Notebook</br>";
    }else{
        printf("Erro equipamento Notebook: ".mysqli_error($conn));
    }
    
    //2º salvando o office
    //FILE  

    if($_FILES['file_office_note']['name'] != NULL){
        //salvando o file da nota
        $tipo_file = $_FILES['file_office_note']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_office_note']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_office_note']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_office_note']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

        if($result =  mysqli_query($conn, $sql_file)){
            echo "Salvou Nota Office notebook";
        }else{
            printf("Erro Nota Office notebook: ".mysqli_error($conn));
        }

        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido      

            if (move_uploaded_file($_FILES['file_office_note']['tmp_name'], $caminho )){//aplicando o salvamento
            }else{
            echo "Arquivo não foi enviado Office notebook!";
            }//se caso não salvar vai mostrar o erro!

        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido Office notebook!";
            exit;
        }//end IF validação
    }//END ANEXO OFFICE

    if($_POST['serial_office_note'] != NULL){//se tiver um serial salva o office
         //OFFICE
        $query_note_office = "INSERT INTO manager_office (id_equipamento, 
        locacao, 
        empresa, 
        versao, 
        serial, 
        fornecedor, 
        numero_nota,
        file_nota,
        file_nota_nome,
        data_nota) VALUE
        ((SELECT max(id_equipamento) FROM manager_inventario_equipamento),
        '".$_POST['local_note_office']."',
        '".$_POST['empresa_note_office']."',
        '".$_POST['office_note']."',
        '".$_POST['serial_office_note']."',
        '".$_POST['fornecedor_noteOffice']."',
        '";
        empty($_POST['num_office_note']) ? $query_note_office .= "semNota" : $query_note_office .= $_POST['num_office_note'];       
        $query_note_office .= "',
        '".$caminho_db."',
        '".$nome_db."',
        '".$_POST['data_office_note']."')";
        if($result_note_office = mysqli_query($conn, $query_note_office)){
            echo "Salvou Office note</br>";

            //pegando o ultimo valor para usar na hora de enviar o modelo
            $query_idOffice = "SELECT max(id) as id FROM manager_office";
            $result_idOffice = mysqli_query($conn, $query_idOffice);
            $idOffice = mysqli_fetch_assoc($result_idOffice);

        }else{
            printf("Erro Office note: ".mysqli_error($conn));
        }
    } 

    //3º salvando o windows
    //FILE
    if($_FILES['file_so_note']['name'] != NULL){
        //salvando o file da nota
        $tipo_file = $_FILES['file_so_note']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_so_note']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_so_note']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_so_note']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação
        
        if($result =  mysqli_query($conn, $sql_file)){
            echo "Salvou Nota Windows note</br>";
        }else{
            printf("Erro Nota Windows note: ".mysqli_error($conn));
        }

        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido      

            if (move_uploaded_file($_FILES['file_so_note']['tmp_name'], $caminho )){//aplicando o salvamento
            }else{
            echo "Arquivo não foi enviado Windows note!";
            }//se caso não salvar vai mostrar o erro!

        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido Windows note!";
            exit;
        }//end IF validação

    }//END ANEXO WINDOWS

    

    //WINDOWS
    $query_note_windows = "INSERT INTO manager_sistema_operacional (id_equipamento, 
                                                        locacao, 
                                                        empresa, 
                                                        versao, 
                                                        serial, 
                                                        fornecedor, 
                                                        numero_nota,
                                                        file_nota,
                                                        file_nota_nome,
                                                        data_nota) VALUE
                                                        ((SELECT max(id_equipamento) FROM manager_inventario_equipamento),
                                                        '".$_POST['locacao_notebook']."',
                                                        '".$_POST['empresa_notebook']."',
                                                        '".$_POST['so_notebook']."',
                                                        '".$_POST['serial_so_note']."',
                                                        '".$_POST['fornecedor_note']."',
                                                        '";
                                                        empty($_POST['num_so_note']) ? $query_note_windows .= "semNota" : $query_note_windows .= $_POST['num_so_note'];
                                                        
                                                        $query_note_windows .= "',
                                                        '".$caminho_db."',
                                                        '".$nome_db."',
                                                        '".$_POST['data_so_note']."')";
    if($result_cpu_windows = mysqli_query($conn, $query_note_windows)){
        echo "Salvou Windows note</br>";
    }else{
        echo $query_cpu_windows;
        printf("Erro Windows note: ".mysqli_error($conn));
    }

    //pegando o ultimo valor para usar na hora de enviar o modelo
    $query_idWindows = "SELECT max(id) as id FROM manager_sistema_operacional";
    $result_idWindows = mysqli_query($conn, $query_idWindows);
    $idWindows = mysqli_fetch_assoc($result_idWindows);


    header('location: msn_equipamento.php?msn=1&win='.$idWindows['id'].'&off='.$idOffice['id'].'');
}//fim salvando notebook

/*################## SALVANDO SCANNER ##################*/

if($_POST['serie_scan']){
    //1º verificar se já existe o scanner
    $queryVerificar = "SELECT id_equipamento FROM manager_inventario_equipamento WHERE serialnumber = '".$_POST['serie_scan']."'";
    $resultVerificar = mysqli_query($conn, $queryVerificar);

    if($linhaVerificar = mysqli_fetch_assoc($resultVerificar)){
        header('location: add_equip_single.php?error=5');//Erro Equpamento já cadastrado
        exit;
    }

    //2º Cadastrando o equipamento
    $salvandoEquipamento = "INSERT INTO manager_inventario_equipamento 
                                                        (usuario,
                                                        tipo_equipamento,
                                                        id_funcionario,
                                                        filial,
                                                        locacao,
                                                        fornecedor_scan,
                                                        modelo,
                                                        departamento,
                                                        serialnumber,
                                                        situacao,
                                                        data_criacao,
                                                        numero_nota,
                                                        data_fim_contrato,
                                                        status,
                                                        patrimonio)
                                                        VALUES
                                                        ('".$_SESSION['id']."',
                                                        '10',
                                                        '".$_POST['responsavel_scan']."',
                                                        '".$_POST['empresa_scan']."',
                                                        '".$_POST['locacao_scan']."',
                                                        '".$_POST['fornecedor_scan']."',
                                                        '".$_POST['modelo_scan']."',
                                                        '".$_POST['departamento_scan']."',
                                                        '".$_POST['serie_scan']."',
                                                        '".$_POST['tipo_scan']."',
                                                        '".$data_hoje."',
                                                        '".$_POST['num_nota_scan']."',
                                                        '".$_POST['data_contrato_scan']."',
                                                        '1',
                                                        '".$_POST['patrimonio_scan']."')";
    $aplicandoSalvamento = mysqli_query($conn, $salvandoEquipamento);

    //3º salvando a nota fiscal
    //FILE
    if($_FILES['file_nota_scan']['name'] != NULL){
        //salvando o file da nota
        $tipo_file = $_FILES['file_nota_scan']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file_nota_scan']['name'];
        $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota_scan']['name'];//caminho onde será salvo o FILE
        $caminho_db = "documentos/tecnicos/".$_FILES['file_nota_scan']['name'];//pasta onde está o FILE para salvar no Bando de dados

        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação
        
        if($result =  mysqli_query($conn, $sql_file)){
            echo "Salvou Nota Scanner</br>";
        }else{
            printf("Erro Nota Scanner: ".mysqli_error($conn));
        }

        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido      

            if (move_uploaded_file($_FILES['file_nota_scan']['tmp_name'], $caminho )){//aplicando o salvamento
            }else{
            echo "Arquivo não foi enviado scanner!";
            }//se caso não salvar vai mostrar o erro!

        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido scanner!";
            exit;
        }//end IF validação

        //Agora no banco de dados

        //coletando o id do equipamento
        $queryIdEquipamento = "SELECT max(id_equipamento) id_equipamento FROM manager_inventario_equipamento";
        $resultadoIdEquipamento = mysqli_query($conn, $queryIdEquipamento);
        $linhaIdEquipamento = mysqli_fetch_assoc($resultadoIdEquipamento);
        
        //salvando
        $notaScaner = "INSERT INTO manager_inventario_anexo 
                                        (id_funcionario,
                                        id_equipamento,
                                        usuario,
                                        caminho,
                                        nome,
                                        tipo,
                                        data_criacao)
                                        VALUES
                                        ('".$_POST['responsavel_scan']."',
                                        '".$linhaIdEquipamento['id_equipamento']."',
                                        '".$_SESSION['id']."',
                                        '".$caminho_db."',
                                        '".$nome_db."',
                                        '4',
                                        '$data_hoje')";
        $resultadoNotaScanner = mysqli_query($conn, $notaScaner)or die(mysqli_error($conn));                           

    }//END ANEXO

    header('location: add_equip_single.php?ok=1');
}//fim salvando scanner

//fechando o banco de dados
mysqli_close($conn);
?>