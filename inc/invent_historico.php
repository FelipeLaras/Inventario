<?php  
    //chamando banco
    require 'conexao.php';
    //chamando a sessão
    session_start();

    $data = date('d/m/Y');

    //deletar histórico
    if ($_GET['dell'] == 1){
        $historico = "UPDATE manager_invent_historico SET deletado = 1
        WHERE id = ".$_GET['id']."";
        $resultado_h = mysqli_query($conn, $historico) or die(mysqli_error($conn));
        header('location: inventario_edit.php?id='.$_SESSION['id_funcionario_historico'].'&msn=7');

        /*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

            //data de hoje
            $dataLog = date('d/m/Y G:i:s');

            //query para salvar log

            $log_query = "INSERT manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao)
                            VALUES ('".$_SESSION['id_funcionario_historico']."',
                                    '".$dataLog."',
                                    '".$_SESSION["id"]."',
                                    '9')";
            $result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

        /*_________________________________ FECHANDO O BANCO ______________________________________*/
        exit;
    }

    //editar histórico
    if($_POST['edit_form'] != NULL){
        $historico = "UPDATE 
                            manager_invent_historico 
                        SET 
                            historico = '".$_POST['edit_form']."', 
                            id_usuario ='".$_SESSION["id"]."', 
                            data_historico = '".$data."',
                            status_funcionario = '".$_POST['status_funcionario']."'
                        WHERE 
                            id = ".$_POST['id_historico']."";
        $resultado_h = mysqli_query($conn, $historico) or die(mysqli_error($conn));  
        
        /*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

            //data de hoje
            $dataLog = date('d/m/Y G:i:s');

            //query para salvar log

            $log_query = "INSERT manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao)
                            VALUES ('".$_SESSION['id_funcionario_historico']."',
                                    '".$dataLog."',
                                    '".$_SESSION["id"]."',
                                    '10')";
            $result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

        /*_________________________________ FECHANDO O BANCO ______________________________________*/
    }

    //adionar histórico
    if($_POST['msg_hist'] != NULL){

        $historico = "INSERT INTO manager_invent_historico (historico, id_funcionario, id_usuario, data_historico, status_funcionario) 
        VALUES ('".$_POST['msg_hist']."','".$_POST['id_funcionario']."', '".$_SESSION["id"]."', '".$data."', '".$_POST['status_funcionario']."')";

        $resultado_h = mysqli_query($conn, $historico) or die(mysqli_error($conn));

        /*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

            //data de hoje
            $dataLog = date('d/m/Y G:i:s');

            //query para salvar log

            $log_query = "INSERT manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao)
                            VALUES ('".$_SESSION['id_funcionario_historico']."',
                                    '".$dataLog."',
                                    '".$_SESSION["id"]."',
                                    '8')";
            $result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

        /*_________________________________ FECHANDO O BANCO ______________________________________*/
          
    }    
    
    //voltando para a tela informando que salvou o comentário
    header('location: inventario_edit.php?id='.$_SESSION['id_funcionario_historico'].'&msn=6');

    //encerrar banco e sessão
    mysqli_close($conn);     
    //encerrando a sessão
    unset($_SESSION['id_funcionario_historico']);    
?>

