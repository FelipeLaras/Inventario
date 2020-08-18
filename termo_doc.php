<?php 
//sessão para o id de quem esta trabalhando
session_start();
//banco
include 'conexao.php';
 /*SALVANDO O TERMO*/

//limitador de caracteres
$limit_caracter = 24;


//Verificando se o arquivo já existe e ESTÁ ATIVO

if($_FILES['termo'] != NULL){

    $queryNomeFile = "SELECT nome FROM manager_inventario_anexo WHERE nome = '".$_FILES['termo']['name']."' AND deletar = '0'";
    $resultNomeFile = mysqli_query($conn, $queryNomeFile);
    
    if($nomeFile = mysqli_fetch_assoc($resultNomeFile)){

        //pegando ultima id do funcionario para mover a tela.acao

        $queryUltiFuncionario = "SELECT max(id_funcionario) as id_funcionario FROM manager_inventario_funcionario";
        $resultUltimoFuncionario = mysqli_query($conn, $queryUltiFuncionario);
        $ultimofuncionario = mysqli_fetch_assoc($resultUltimoFuncionario);

        header('location: inventario_edit.php?id='.$_POST['id_fun'].'&msn=9');

        exit;
    }
}


/*coletando informações do FILE*/ 
$tipo_file = $_FILES['termo']['type'];//Pegando qual é a extensão do arquivo
$caminho = "/var/www/html/ti/documentos/inventario/" . $_FILES['termo']['name'];//caminho onde será salvo o FILE
$caminho_db = "documentos/inventario/".$_FILES['termo']['name'];//pasta onde está o FILE para salvar no Bando de dados

/*VALIDAÇÃO DO FILE*/
$sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

$result =  mysqli_query($conn, $sql_file);//aplicando a query
$row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

/*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
if ($row['type'] != NULL) {//se é arquivo valido  

    //Verificando a quantidade de caracreres tem o nome do arquivo
    $total_sting = strlen($_FILES['termo']['name']);

    if($limit_caracter < $total_sting){

        if($_POST['page'] == 1){//editando equipamento 
            header('location: inventario_equip_edit.php?id_equip='.$_POST['id_equipamento'].'&tipo='.$_POST['tipo_equip'].'&msn=5');
         }else{//editando pelo funcionario
             header('location: inventario_edit.php?id='.$_POST['id_fun'].'&msn=5');
         }
         exit;
    }//if verificação caracteres

    if (move_uploaded_file($_FILES['termo']['tmp_name'], $caminho )){//aplicando o salvamento
        echo "Arquivo enviado para = ".$_FILES['termo']['tmp_name'].$uploadfile;
     }else{
        echo "<br>não deu";

     }//se caso não salvar vai mostrar o erro!
 }else{// se o arquivo não é valido vai levar para tela de erro
    echo "não é arquivo valido";
    exit;
}//end IF salvando o file

/*DEPOIS QUE SALVOU NO SERVIDOR VAMOS AGORA SALVAR NO BANCO DE DADOS*/
/*1º*/
//Salvar no banco de dados manager_contracts_file 
//criando a query

//DATA DE HOJE APRA COLOCAR NO CAMPO DATA_CADASTRO
date_default_timezone_set('America/Sao_Paulo');
$date = date('d/m/Y');

//NOTA FISCAL

if ($_POST['tipo'] == 4) {

    $insert_bd_file = "INSERT INTO manager_inventario_anexo 
                            (id_funcionario,
                            id_equipamento,
                            usuario,
                            tipo_anexo, 
                            nome,
                            caminho, 
                            tipo, 
                            data_criacao) 
                        VALUES 
                            ('".$_POST['id_fun']."',
                            '".$_POST['id_equipamento']."',
                            '".$_SESSION['id']."', 
                            '".$tipo_file."',
                            '".$_FILES['termo']['name']."',
                            '".$caminho_db."', 
                            '4', 
                            '".$date."')";    
    //aplicando a query
    $resultado_insert_file = mysqli_query($conn, $insert_bd_file);

}//end IF tipo = 4

//TERMO DE ENTREGA

if($_POST['tipo'] == 3){
    /*ALTERANDO O STATUS DO TERMO*/

    //buscando todos os equipamento para informar que o termo está baixado
    $all_equip = "SELECT id_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = '".$_POST['id_fun']."'";
    $result_all = mysqli_query($conn, $all_equip);


    while($row_termo = mysqli_fetch_assoc($result_all)){

        $update_termo = "UPDATE manager_inventario_equipamento SET termo = '0' where id_equipamento = '".$row_termo['id_equipamento']."'";
        $resultado_termo = mysqli_query($conn, $update_termo) or die(mysqli_error($conn));

    }//end WHILE all equipamentos    

    /*ALTERANDO STATUS DO USUÁRIO*/
    $update_termofun = "UPDATE manager_inventario_funcionario SET status = '4' where id_funcionario = '".$_POST['id_fun']."'";
    $resultado_termoFU = mysqli_query($conn, $update_termofun) or die(mysqli_error($conn));

    //agora salvando o termo no banco de dados

    if($_POST['id_equipamento'] != NULL){

        $insert_bd_file = "INSERT INTO manager_inventario_anexo 
                                (id_funcionario, 
                                id_equipamento,
                                usuario, 
                                tipo_anexo, 
                                nome, 
                                caminho, 
                                tipo, 
                                data_criacao) 
                            VALUES 
                                ('".$_POST['id_fun']."', 
                                '".$_POST['id_equipamento']."',
                                '".$_SESSION['id']."',  
                                '".$tipo_file."',
                                '".$_FILES['termo']['name']."',
                                '".$caminho_db."', 
                                '3', 
                                '".$date."')";
    }else{
        $insert_bd_file = "INSERT INTO manager_inventario_anexo 
                                (id_funcionario,
                                usuario, 
                                tipo_anexo, 
                                nome, 
                                caminho, 
                                tipo, 
                                data_criacao) 
                            VALUES 
                            ('".$_POST['id_fun']."', 
                            '".$_SESSION['id']."',
                            '".$tipo_file."',
                            '".$_FILES['termo']['name']."',
                            '".$caminho_db."', 
                            '3', 
                            '".$date."')";
    }

    //aplicando a query
    $resultado_insert_file = mysqli_query($conn, $insert_bd_file);

}//end IF tipo = 3

//CHEK-LIST

if($_POST['tipo'] == 5){
    
    //inserindo a nota no equipamento
    $insert_bd_file = "INSERT INTO manager_inventario_anexo 
                            (id_equipamento,
                            usuario, 
                            tipo_anexo, 
                            nome, 
                            caminho, 
                            tipo, 
                            data_criacao) 
                        VALUES
                            ('".$_POST['id_equipamento']."',
                            '".$_SESSION['id']."', 
                            '".$tipo_file."',
                            '".$_FILES['termo']['name']."',
                            '".$caminho_db."', 
                            '5', 
                            '".$date."')";
  
    //aplicando a query
    $resultado_insert_file = mysqli_query($conn, $insert_bd_file);

}//end IF tipo = 5

//voltando para a tela de onde veio
if($_POST['page'] == 1){//editando equipamento 
   header('location: inventario_equip_edit.php?id_equip='.$_POST['id_equipamento'].'&tipo='.$_POST['tipo_equip'].'&msn=2');
}else{//editando pelo funcionario
    header('location: inventario_edit.php?id='.$_POST['id_fun'].'&msn=2');
}//end IF pagina

/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

//data de hoje

$data = date('d/m/Y G:i:s');

//query para salvar log

$log_query = "INSERT manager_log (id_funcionario, id_equipamento, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$_POST['id_fun']."',
                        '".$_POST['id_equipamento']."',
						'".$data."',
						'".$_SESSION["id"]."',
						'6')";
$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

/*_________________________________ FECHANDO O BANCO ______________________________________*/

//fechando o banco de dados
mysqli_close($conn);
?>