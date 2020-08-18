<?php
    session_start();

    //chamando o banco de dados
    include 'conexao.php';
    /*-------------------------------------------------------------------------------------*/

    //pegando a data de hoje
    $data_hoje = date('d/m/Y');
    
    /*-------------------------------------------------------------------------------------*/

    //1º vamos retirar o funcionario do equipamento e trocar o status 

    if($_POST['pageone'] != NULL){
        $update_funcionario = "UPDATE manager_inventario_equipamento 
        SET 
            id_funcionario = '0', 
            status = '".$_POST['id_status']."',
            data_vigencia = '$data_hoje'
        WHERE 
            id_equipamento = '".$_POST['id_equip']."'";

    $result_funcionario = mysqli_query($conn, $update_funcionario) or die(mysqli_error($conn));

    }else{
        //2º vamos incluir um funcionario no equipamento e trocar o status 

        $update_new_funcionario = "UPDATE manager_inventario_equipamento 
        SET 
            id_funcionario = '".$_POST['id_funcionario']."', 
            status = '1'
        WHERE 
            id_equipamento = '".$_POST['id_equip']."'";

        $result_funcionario_new = mysqli_query($conn, $update_new_funcionario) or die(mysqli_error($conn));

    }    
  
    //3º vamos salvar histórico de vigência

    $data_vigencia = "INSERT INTO  manager_data_vigencia
                            (id_equipamento,
                            id_funcionario,
                            id_usuario,
                            data_vigencia)
                        VALUES
                            ('".$_POST['id_equip']."',
                            '".$_POST['id_funcionario']."',
                            '".$_SESSION['id']."',
                            '".$data_hoje."'
                            )";
    $result_vigencia = mysqli_query($conn, $data_vigencia) or die(mysqli_error($conn));
    
    /*-------------------------------------------------------------------------------------*/

    //fechando a conexão com o banco de dados
    mysqli_close($conn);

    /*-------------------------------------------------------------------------------------*/

    //enviando de volta para o equip.php
    
    if($_POST['pageone'] != NULL){
        
        header('location: equip.php?msn=1');

    }else{
        header('location: equip_disponivel.php?msn=2');
    }
?>