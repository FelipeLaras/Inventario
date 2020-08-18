<?php
    //abre as sessões
    session_start();
    //chama banco de dados
    include "conexao.php";


    /*##########    CPU    ##########*/

    if(!empty($_POST['gols2'])){//se caso ele preencheu o campo "patrimônio"

        /*1º vamos ver se o equipamento não está cadastrado */
        $query_verificando = "SELECT patrimonio, deletar FROM manager_inventario_equipamento WHERE patrimonio = ".$_POST['gols2']."";
        $result_verificando = mysqli_query($conn, $query_verificando);

        if($row_verificando = mysqli_fetch_assoc($result_verificando)){
            if($row_verificando['deletar'] == 1){
                header('location: add_equip_single.php?error=4');//Erro equipamento já cadastrado porém condenado
                exit;
            }else{
                header('location: add_equip_single.php?error=5');//Erro equipamento já cadastrado
                exit;
            }            
        }

        /*2º buscar as informações */
        $query_equip = "SELECT * FROM manager_ocs_equip WHERE patrimonio LIKE '%".$_POST['gols2']."%'";
        $result_equip = mysqli_query($conn, $query_equip);

        if($row_equip = mysqli_fetch_assoc($result_equip)){//montando as sessões
            //equipamento
            $_SESSION['numero_patrimonio'] = $row_equip['patrimonio'];
            $_SESSION['dominio'] = $row_equip['dominio'];
            $_SESSION['nome_computador'] = $row_equip['hostname'];
            $_SESSION['ip'] = $row_equip['ip'];
            $_SESSION['modelo'] = $row_equip['modelo'];
            $_SESSION['processador'] = $row_equip['processador'];
            $_SESSION['hd'] = $row_equip['hd'];
            $_SESSION['memoria'] = $row_equip['memoria'];
            $_SESSION['numero_serial'] = $row_equip['serial_number'];
            //office
            $_SESSION['office'] = $row_equip['office'];
            $_SESSION['serial_office'] = $row_equip['chave_office'];
            //windows
            $_SESSION['so'] = $row_equip['sistema_operacional'];
            $_SESSION['serial_so'] = $row_equip['chave_windows'];
            //voltando com as sessões preenchidas
            header('location: add_equip_single.php');

        }else{
            header('location: add_equip_single.php?error=2');//Erro equipamento já cadastrado
        }
        
        exit;
    }else{
        header('location: add_equip_single.php?error=3');//Erro Preencher pelomenos um equipamento
    }
    
    /*##########    NOTEBOOK    ##########*/

    if(!empty($_POST['gols3'])){//se caso ele preencheu o campo "patrimônio"

        /*1º vamos ver se o equipamento não está cadastrado */
        $query_verificando = "SELECT patrimonio, deletar FROM manager_inventario_equipamento WHERE patrimonio = ".$_POST['gols3']."";
        $result_verificando = mysqli_query($conn, $query_verificando);

        if($row_verificando = mysqli_fetch_assoc($result_verificando)){
            if($row_verificando['deletar'] == 1){
                header('location: add_equip_single.php?error=4');//Erro equipamento já cadastrado porém condenado
                exit;
            }else{
                header('location: add_equip_single.php?error=5');//Erro equipamento já cadastrado
                exit;
            }            
        }

        /*2º buscar as informações */
        $query_equip = "SELECT * FROM manager_ocs_equip WHERE patrimonio LIKE '%".$_POST['gols3']."%'";
        $result_equip = mysqli_query($conn, $query_equip);

        if($row_equip = mysqli_fetch_assoc($result_equip)){//montando as sessões
            //equipamento
            $_SESSION['numero_patrimonio_note'] = $row_equip['patrimonio'];
            $_SESSION['dominio_note'] = $row_equip['dominio'];
            $_SESSION['nome_computador_note'] = $row_equip['hostname'];
            $_SESSION['ip_note'] = $row_equip['ip'];
            $_SESSION['modelo_note'] = $row_equip['modelo'];
            $_SESSION['processador_note'] = $row_equip['processador'];
            $_SESSION['hd_note'] = $row_equip['hd'];
            $_SESSION['memoria_note'] = $row_equip['memoria'];
            $_SESSION['numero_serial_note'] = $row_equip['serial_number'];
            //office
            $_SESSION['office_note'] = $row_equip['office'];
            $_SESSION['serial_office_note'] = $row_equip['chave_office'];
            //windows
            $_SESSION['so_note'] = $row_equip['sistema_operacional'];
            $_SESSION['serial_so_note'] = $row_equip['chave_windows'];
            //voltando com as sessões preenchidas
            header('location: add_equip_single.php');

        }else{
            header('location: add_equip_single.php?error=2');//Erro equipamento já cadastrado
        }
        
        exit;
    }else{
        header('location: add_equip_single.php?error=3');//Erro Preencher pelomenos um equipamento
    }


    //fim
    mysqli_close($conn);
?>