<?php
    /*
    #Essa comparação vai funcionar da seguinte forma:
        1 - Tabala = OCS_SOFTWARE
        2 - Tabela = manager_SOFTWARE
        3 - Tabela = COMPARACAO_OCS_SOFTEWARE

    #Compara a tabela 1 com a tabela 2
        a) SE FOR IGUAL = não salva
        b) SE FOR DIFERENTE = salva na tabela 3
    */

    //chamando o banco de dados
    require_once('../conexao/conexao.php');

    /**------------------------------------------- AGORA IREMOS COLETAR AS INFORMAÇÕES DA TABELA 1 -------------------------------------------**/

    $tabela1 = "SELECT patrimonio, software, data_instalacao FROM ocs_software";
    $result_tabela1 = $conn -> query($tabela1);

    /**--------------------------------------------------- AGORA IREMOS REALIZAR A COMPARAÇÃO --------------------------------------------------**/

        while($row_tabela1 = $result_tabela1 -> fetch_assoc()){

            /**------------------------------------------- AGORA IREMOS COLETAR AS INFORMAÇÕES DA TABELA 2 -------------------------------------------**/   

            $tabela2 = "SELECT patrimonio, software_atual FROM manager_software WHERE software_atual = '".$row_tabela1['software']."' AND patrimonio = '".$row_tabela1['patrimonio']."'  ";

            $result_tabela2 = $conn -> query($tabela2);

            while($row_tabela2 = $row_tabela2 -> fetch_assoc()){

                if($row_tabela2['patrimonio'] == NULL){

                    $insere_tabela3 = "INSERT INTO manager_comparacao_ocs 
                                                    (patrimonio,
                                                    software_atual,
                                                    data_instalacao)
                                                VALUES
                                                    ('".$row_tabela1['patrimonio']."',
                                                    '".$row_tabela1['software']."',
                                                    '".$row_tabela1['data_instalacao']."')";
                    $resultado_insere = $conn -> query($insere_tabela3);

                }//fim IF tabela 2

            }//fim WHILE

        }//fim WHILE de comparacação


//fechando o banco de dados
$conn -> close();

//mensagem para finalização
echo "Comparação finalizada!";
?>