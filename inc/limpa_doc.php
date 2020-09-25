<?php
    //chamando banco de dados
    require_once('../conexao/conexao.php');

    //função para criar log
    function logMe($msg){

        $fp = fopen('log_exclusao.txt', 'a+b');

        fwrite($fp, $msg);

        fclose($fp);
    }

    //coletando todos os doc que estão com o deletar = 1

    $coletando_doc = "SELECT 
                        id_anexo,
                        caminho, 
                        nome
                        FROM
                            manager_inventario_anexo
                        WHERE
                            deletar = 1 AND
                            documento_deletado = 0";
    $result_doc = $conn->query($coletando_doc);

    //montando a regra para cada documento encontrado

    while($row_doc = mysqli_fetch_assoc($result_doc)){

        $nome = $row_doc['caminho'];

        if(!unlink($nome)){
            echo "Não deletou";
        }else{
            echo "Deletou o arquivo = ".$row_doc['caminho'];
        }
        //informando quais arquivos foram deletados
        logMe("Documento excluido = ".$row_doc['nome']." - no dia ".date('d/m/Y')."\n");

        //informar no banco que o documento foi deletado do sistema
        $info_del = "UPDATE manager_inventario_anexo SET documento_deletado = 1 WHERE id_anexo = ".$row_doc['id_anexo']." ";
        $result_del = $conn->query($info_del);

    }//end WHILE pegando os doc

    //fechando a conexão com o banco
    $conn->close();
?>