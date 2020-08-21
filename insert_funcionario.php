<?php
    //chamando as sessões
    session_start();

    //chamando o banco de dados
    include 'conexao.php';

    //data hoje
    $data_hoje = date('d/m/Y');

    /*---------------------- VERIFICANDO SE O CPF JÁ NÃO ESTA CADASTRADO----------------------*/

    $select_fun = "SELECT id_funcionario, cpf FROM manager_inventario_funcionario WHERE cpf = '".$_POST['cpf']."'";
    $resultado_select = mysqli_query($conn, $select_fun);
    $linha_select = mysqli_fetch_assoc($resultado_select);
    
    //aplicando a regra caso tenha um funcionario
    if($linha_select['cpf'] != NULL){
        //fazendo um update

        $updateFuncionario = "UPDATE manager_inventario_funcionario SET usuario =s '".$_SESSION['id']."', cpf = '".$_POST['cpf']."', nome = '".$_POST['nome']."', funcao = '".$_POST['funcao']."', departamento = '".$_POST['departamento']."', empresa = '".$_POST['empresa']."', data_cadastro = '".$data_hoje."', status = '9' WHERE id_funcionario = '".$linha_select['id_funcionario']."'";

        $resultupdate = mysqli_query($conn, $updateFuncionario) or die(mysqli_error($conn));

    }else{        
        /*---------------------- SALVANDO O FUNCIONARIO ----------------------*/

        $insert_fun = "INSERT INTO manager_inventario_funcionario 
                            (usuario,
                            cpf, 
                            nome,
                            funcao,
                            departamento,
                            empresa,
                            data_cadastro,
                            status)
                        VALUES
                            ('".$_SESSION['id']."',
                            '".$_POST['cpf']."',
                            '".$_POST['nome']."',
                            '".$_POST['funcao']."',
                            '".$_POST['departamento']."',
                            '".$_POST['empresa']."',
                            '".$data_hoje."',
                            '9')";
        $result_fun = mysqli_query($conn, $insert_fun) or die(mysqli_error($conn));
    }
    //fechando o banco
    mysqli_close($conn);
   
?>
<html>
<?php  require 'header.php'?>
<div class="widget widget-nopad" style='margin-top: 23px;'>
    <div class="widget-header"> <i class="icon-user"></i>
        <h3>Novo Cadastro</h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="widget big-stats-container" style='margin-bottom: -17px;margin-top: 4px;'>
            <div class="widget-content">
                <h5 class="bigstats" style="text-align: center;margin-top: 29px;">Cadastro efetuado com sucesso!</h5>
            </div>
            <div class="widget-content">
                <h6 class="bigstats" style='text-align: center;'>Volte e <span style="color: red">não esqueça de ATUALIZAR</span> a página antes de
                    continuar!</h6>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" onclick="fechar()" style='float: right;'>Fechar</button>
            </div>
            <!-- /widget-content -->
        </div>
    </div>
</div>
<script>
function fechar(){
    window.close();
}
</script>

</html>