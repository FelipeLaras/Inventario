<html>

<head>
    <link href="../img/favicon.ico" rel="icon" type="image/x-icon" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="../css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
      <link href="../css/font-awesome.css" rel="stylesheet">
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
      <link href="../css/style.css" rel="stylesheet" type="text/css">
      <link href="../css/pages/signin.css" rel="stylesheet" type="text/css">
    
</head>

<body>
    <div class="container">
        <div class="row">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="titulo" style="border-top-left-radius: 10px; ">Nome</th>
                        <th class="titulo">CNPJ</th>
                        <th class="titulo">Numero Contrato</th>
                        <th class="titulo">Tipo</th>
                        <th class="titulo">Data</th>
                        <th class="titulo" style="border-top-right-radius: 10px; ">Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
        //conectando com o bando de dados
        require_once('../conexao/conexao.php');

        //criando a pesquisa 
        $query = "SELECT * FROM manager_contracts WHERE deleted = 0"; //0 = ativo, 1 = desativado
        //Criando a pesquisa para contagem  
        
        //aplicando a regra e organizando na tela
        if ($resultado = $conn->query($query)){
            
                while($row = mysqli_fetch_assoc($resultado)){
                    
                    echo "<tr>
                            <td class='fonte'>".$row['name']."</td>
                            <td class='fonte'>".$row['cnpj']."</td>
                            <td class='fonte'>".$row['number']."</td>                            
                            <td class='fonte'>".$row['type']."</td>
                            <td class='fonte'>".$row['date_start']."</td>
                            <td class='fonte'>
                                <a href='contracts_edit.php?idContrato=".$row['id']."' title='Ver Contrato' class='icon_acao'>
                                  <i class='icon-folder-open'></i>
                                </a> 
                                <a href='#myModal' title='Excluir' class='icon_acao' data-toggle='modal'>
                                  <i class='icon-remove-circle'></i>
                                </a>
                            </td>
                        </tr>";
                    
                }
            }
            
        $conn->close();
        ?>

                </tbody>
            </table>
        </div>
    </div>
</body>
<!--JAVASCRITPS-->
<script src="../js/tabela.js"></script>
<script src="../js/tabela2.js"></script>
<script src="../java.js"></script>
<script src="../jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
</html>