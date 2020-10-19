<?php
//chamando a sessão
session_start();

//chamar o banco
require_once('../conexao/conexao.php');
require_once('../query/query.php');

/*--------------------------------------------------------------------*/
//VALIDANDO SE TEM NOTA FISCAL

$queryNota = "SELECT numero_nota FROM manager_office WHERE id = '".$_GET['id_off']."'";
$resultadoNota = $conn->query($queryNota);

$rowNota = $resultadoNota->fetch_assoc();

if($rowNota['numero_nota'] === "semNota"){
  $queryWhere = "MOF.id = ".$_GET['id_off']."";
}else{
  $queryWhere = "MOF.numero_nota = (SELECT numero_nota FROM manager_office WHERE id = '".$_GET['id_off']."')";
}

//1º vamos coletar todas as informações que iremos usar no termo

//Office
$somando = 0;

$query_office .= $queryWhere;

$result_windows = $conn->query($query_office);
$office_row = $result_windows->fetch_assoc();

$data_nota = $office_row['data_nota_of'];

$body = "
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Modelo Office</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous' />
  <style type='text/css'>
    th, .user {
        text-align: center !important;
    }
    .font{
        font-size: 11px;
    }
  </style>
</head>
<body>
<div class='container'>            
  <table class='table table-bordered'>
    <thead>
      <tr>
        <th colspan='2'><img class='logo' src='../img/logo.png' width='150' alt='Logo'></th>
        <th colspan='3'>Ficha do Office</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan='5'>Empresa: <span class='font'>".$office_row['empresa']."</span></td> 
      </tr>
      <tr>
        <td colspan='5'>Locacão: <span class='font'>".$office_row['locacao']."</span></td>
      </tr>
      <tr>
        <td colspan='3'>Nota Fiscal: <span class='font'>".$office_row['numero_nota']."</span></td>
        <td colspan='2'>Data: <span class='font'>".$data_nota."</span></td>
      </tr>
      <tr>
        <td colspan='5'>Software: <span class='font'>".$office_row['versao']."</span></td>
      </tr>
      <tr>
        <td colspan='5'>Fornecedor: <span class='font'>".$office_row['fornecedor']."</span></td>
      </tr>
      <tr>
        <th>Patrimônio</th>
        <th colspan='2'>Usuário</th>
        <th colspan='2'>Departamento</th>
      </tr>";
        //trazendo os dados do usuário

            $user_windows = "SELECT 
            MIE.patrimonio, MDD.nome AS departamento, MIF.nome
        FROM
            manager_inventario_equipamento MIE
                LEFT JOIN
            manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
                LEFT JOIN
            manager_dropdepartamento MDD ON MIE.departamento = MDD.id_depart
                LEFT JOIN
            manager_office MOF ON MIE.id_equipamento = MOF.id_equipamento    
            WHERE ".$queryWhere."";
            $result_user_windows = $conn->query($user_windows);
        
        while($windows_user = $result_user_windows->fetch_assoc()){
                $body .="          
                <tr>
                    <td class='user font'>".$windows_user['patrimonio']."</td>
                    <td colspan='2' class='user font'>".$windows_user['nome']."</td>
                    <td colspan='2' class='user font'>".$windows_user['departamento']."</td>
                </tr>";

        }//end While query

    $body .= "
    </tbody> 
  </table>
</div>

</body>
</html>";

//terminou a contagem verifica se tem office, se sim enviar
require_once '../dompdf/autoload.inc.php';
require_once '../dompdf/lib/html5lib/Parser.php';
require_once '../dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once '../dompdf/lib/php-svg-lib/src/autoload.php';
require_once '../dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($body);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('termo_'.$row_fun['nome'].'.pdf',array("Attachment"=>0));//1 - Download 0 - Previa

$conn->close();
?>