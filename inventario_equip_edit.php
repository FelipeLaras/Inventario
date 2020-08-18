<?php
   //aplicando para usar varialve em outro arquivo
   session_start();
   //chamando conexão com o banco
   require 'conexao.php';
   //Aplicando a regra de login
   if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
   
}elseif (($_SESSION["perfil"] != 0) AND ($_SESSION["perfil"] != 1) && ($_SESSION["perfil"] != 4)) {
       header('location: error.php');
   }   
 
   ?>
<!DOCTYPE html>
<html>
<?php  require 'header.php';?>
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li>
                    <a href="inventario_ti.php"><i class="icon-home"></i>
                    <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="inventario.php"><i class="icon-group"></i>
                        <span>Colaboradores</span>
                    </a>
                </li>
                <li class="active">
                    <a href="inventario_equip.php"><i class="icon-cogs"></i>
                        <span>Equipamentos</span>
                    </a>
                </li>
                <li>
                    <a href="relatorio_auditoria.php"><i class="icon-list-alt"></i>
                        <span>Relatórios</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php 
if ($_GET['msn'] == 1) {
  echo "
    <div class='control-group'>
      <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert'>×</button>
          O equipamento editado com sucesso!!
      </div>
    </div>";
}
if ($_GET['msn'] == 2) {
  echo "
    <div class='control-group'>
      <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert'>×</button>
          Anexo salvo com sucesso!!
      </div>
    </div>";
}
if ($_GET['msn'] == 3) {
  echo "
    <div class='control-group'>
      <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert'>×</button>
          Anexo deletado com sucesso!!
      </div>
    </div>";
}

if ($_GET['msn'] == 5) {
    echo "
    <div class='control-group'>
      <div class='alert alert-block'>
        <button type='button' class='close' data-dismiss='alert'>×</button>
        <h4 style='color: red'>ATENÇÃO!</h4>
        <u style='color: red;'>&ldquo;Nome do seu documento&rdquo;</u> passou o limite de <u style='color: red;'>20</u> caracteres!.
      </div>
    </div>";
  }
?>
<div class='widget'>
    <div class="widget-header">
        <h3>
            <i class="icon-home"></i> &nbsp;
            <a href="inventario_ti.php">
                Home
            </a>
            /
            <i class="icon-cogs"></i> &nbsp;
            <a href="inventario_equip.php">
                Equipamento
            </a>
            /
            <?php
                if($_GET['tipo'] == 3){//chip
                    $tipo = "SELECT numero FROM manager_inventario_equipamento WHERE id_equipamento = '".$_GET['id_equip']."'";
                    $result_tipo = mysqli_query($conn, $tipo);
                    $row_tipo = mysqli_fetch_assoc($result_tipo);
                    echo "<i class='fas fa-sim-card fa-1x' style='margin-right: 9px; margin-left: 9px;'></i>".$row_tipo['numero'];
                }
                if($_GET['tipo'] == 1){//celular
                    $tipo = "SELECT modelo FROM manager_inventario_equipamento WHERE id_equipamento = '".$_GET['id_equip']."'";
                    $result_tipo = mysqli_query($conn, $tipo);
                    $row_tipo = mysqli_fetch_assoc($result_tipo);
                    echo "<i class='fas fa-mobile-alt fa-1x' style='margin-right: 9px; margin-left: 9px;'></i>".$row_tipo['modelo'];
                }
                if($_GET['tipo'] == 2){//tablet
                    $tipo = "SELECT modelo FROM manager_inventario_equipamento WHERE id_equipamento = '".$_GET['id_equip']."'";
                    $result_tipo = mysqli_query($conn, $tipo);
                    $row_tipo = mysqli_fetch_assoc($result_tipo);
                    echo "<i class='fas fa-tablet-alt fa-1x' style='margin-right: 9px; margin-left: 9px;'></i>".$row_tipo['modelo'];
                }

            ?>
        </h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#equipamento" data-toggle="tab">Equipamentos</a>
                </li>
                <li>
                    <a href="#anexos" data-toggle="tab">Notas / Termos</a>
                </li>
            </ul>
            <br>
            <div class="tab-content">
                <!--EQUIPAMENTOS-->
                <div class="tab-pane active" id="equipamento">
                    <div class="span3" style="width: 95%;">
                        <div class="widget stacked widget-table action-table">
                                <?php
                                    //pesquisando os arquivos criados.
                                    $query_files = "SELECT 
                                                        IQ.id_equipamento,
                                                        DQ.nome AS equipamento,
                                                        IQ.tipo_equipamento,
                                                        IQ.data_nota,
                                                        IQ.modelo,
                                                        IQ.patrimonio,
                                                        DO.nome AS operadora,
                                                        IQ.operadora AS id_operadora,
                                                        IQ.numero,
                                                        IQ.imei_chip,
                                                        IQ.valor,
                                                        MDSE.nome AS status,
                                                        IQ.status AS id_status,
                                                        IQ.termo,
                                                        IQ.planos_voz,
                                                        IQ.planos_dados,
                                                        MDE.nome AS filial,
                                                        IQ.filial AS id_filial,
                                                        MIF.id_funcionario,
                                                        IQ.situacao AS id_situacao,
                                                        MDST.nome AS situacao,
                                                        IQ.estado AS id_estado,
                                                        MDES.nome AS estado
                                                    FROM
                                                        manager_inventario_equipamento IQ
                                                    LEFT JOIN
                                                        manager_inventario_funcionario MIF ON IQ.id_funcionario = MIF.id_funcionario
                                                    LEFT JOIN
                                                        manager_dropequipamentos DQ ON IQ.tipo_equipamento = DQ.id_equip
                                                    LEFT JOIN
                                                        manager_dropoperadora DO ON IQ.operadora = DO.id_operadora
                                                    LEFT JOIN
                                                        manager_dropstatusequipamento MDSE ON IQ.status = MDSE.id_status
                                                    LEFT JOIN
                                                        manager_dropempresa MDE ON MDE.id_empresa = IQ.filial
                                                    LEFT JOIN
                                                        manager_dropsituacao MDST ON IQ.situacao = MDST.id_situacao
                                                    LEFT JOIN
                                                        manager_dropestado MDES ON IQ.estado = MDES.id
                                                    WHERE
                                                        IQ.deletar = 0 AND 
                                                        IQ.id_equipamento =  ".$_GET['id_equip']."";

                                    $resultado_files = mysqli_query($conn, $query_files);

                                    $row_files = mysqli_fetch_assoc($resultado_files);

                                    /*--------------------------------------------------- CELULAR ------------------------------------------------------------------*/
                                            if($_GET['tipo'] == 1){
echo "
<div class='tab-content'>
    <form action='inventario_edit_alt.php' method='post'>
            <input type='text' value='".$row_files['id_equipamento']."' style='display: none' name='id_equipamento'/>
            <input type='text' value='".$row_files['id_funcionario']."' style='display: none' name='id_funcionario'/>
            <input type='text' value='".$row_files['tipo_equipamento']."' style='display: none' name='tipo_equipamento'/>
            <input type='text' value='2' style='display: none' name='page'/>
            <div class='form-row'>
                <div class='form-group col-md-6'>
        <label for='inputEmail4'>Modelo:</label>
        <input type='text' class='form-control' id='modelo' name='modelo' value='".$row_files['modelo']."' >
        </div>
        <div class='form-group col-md-6'>
        <label for='inputPassword4'>Imei:</label>
        <input type='text' class='form-control' name='imei_chip' value='".$row_files['imei_chip']."' />
        </div>
        <div class='form-group col-md-6'>
        <label for='inputPassword4'>Situação:</label>
        <select id='inputState' class='form-control' name='situacao_equip'>
            <option value='".$row_files['id_situacao']."'>".$row_files['situacao']."</option>
            <option>---</option>";
            $situacao_cel = "SELECT 
                                id_situacao,
                                nome
                            FROM manager_dropsituacao
                            WHERE deletar = 0 ORDER BY nome ASC";
            $result_situacao_cel = mysqli_query($conn, $situacao_cel);
            while($linha_cel = mysqli_fetch_assoc($result_situacao_cel)){
                echo "<option value='".$linha_cel['id_situacao']."'>".$linha_cel['nome']."</option>";
            }                                      
echo " </select>
        </div>
        <div class='form-group col-md-6'>
        <label for='inputPassword4'>Estado:</label>
        <select id='inputState' class='form-control' name='estado_equip'>
            <option value='".$row_files['id_estado']."'>".$row_files['estado']."</option>
            <option>---</option>";
            $estado_cel = "SELECT 
                                id,
                                nome
                            FROM manager_dropestado
                            WHERE deletar = 0 ORDER BY nome ASC";
            $result_estado_cel = mysqli_query($conn, $estado_cel);
            while($linha_estado = mysqli_fetch_assoc($result_estado_cel)){
                echo "<option value='".$linha_estado['id']."'>".$linha_estado['nome']."</option>";
            }                                      
echo " </select>
        </div>
        <div class='form-group col-md-6'>
        <label for='inputPassword4'>Valor:</label>
        <input type='text' class='form-control' name='valor_cel' value='".$row_files['valor']."' / >
        </div>
        <div class='form-group col-md-6'>
        <label for='inputPassword4'>Data Nota:</label>

        <input type='text' class='form-control' name='data_nota_cel' value='".$row_files['data_nota']."'/>
        </div>
        <div class='form-group col-md-6'>
        <label for='inputPassword4'>Acessórios:</label>";

        $acessorios = "SELECT 
        MDA.nome AS acessorios,
        MIA.tipo_acessorio AS id_acessorios
        FROM
        manager_inventario_acessorios MIA
        INNER JOIN
        manager_dropacessorios MDA ON MDA.id_acessorio = MIA.tipo_acessorio
        WHERE
        MIA.id_equipamento = ".$row_files['id_equipamento']."";
        $resultado_acessorios= mysqli_query($conn, $acessorios);

        $contador = 0;

        while ($row_acessorios= mysqli_fetch_assoc($resultado_acessorios)) {

        echo "<input type='checkbox' name='acessorio_celular[]' value='".$row_acessorios['id_acessorios']."' checked='checked'/>".$row_acessorios['acessorios']."</br>";

        //acrecentando no contador
        $contador++;
        }

        $acessorios_new = "SELECT * FROM manager_dropacessorios WHERE id_acessorio NOT IN (";

        $ass = "SELECT MIA.tipo_acessorio AS id_acessorios FROM manager_inventario_acessorios MIA INNER JOIN  manager_dropacessorios MDA ON MDA.id_acessorio = MIA.tipo_acessorio WHERE MIA.id_equipamento = ".$row_files['id_equipamento']."";
        $result_ass = mysqli_query($conn, $ass);


        while($row_ass = mysqli_fetch_assoc($result_ass)){

        $acessorios_new .= "".$row_ass['id_acessorios'].",";

        }
        $acessorios_new .= "'') AND deletar = 0";

        $result_acessorios_new = mysqli_query($conn, $acessorios_new);

        while($row_acessorios_new = mysqli_fetch_assoc($result_acessorios_new)){

        echo "<input type='checkbox' name='acessorio_celular[]' value='".$row_acessorios_new['id_acessorio']."'/>".$row_acessorios_new['nome']."</br>";
        //acrecentando no contador
        $contador++;
        }
        echo "<br />
        </div>
        <div class='form-group col-md-4'>
        <label for='inputState'>Status:</label>
        <select id='inputState' class='form-control' name='status_equip'>
        <option value='".$row_files['id_status']."'>".$row_files['status']."</option>
        ";
        $add = 0;
        $query_status_equip= "SELECT * from manager_dropstatusequipamento WHERE deletar = 0 order by nome";
        $resultado_status_equip = mysqli_query($conn, $query_status_equip);
        echo "<option value=''>---</option>";
        while ($row_status_equip = mysqli_fetch_assoc($resultado_status_equip)) {
        echo "<option value='".$row_status_equip['id_status']."'>".$row_status_equip['nome']."</option>";
        $add++;
        }
        echo "
        </select>
        </div>
        </div>
        <div class='form-group col-md-6'>
        <label for='inputPassword4'>Filial:</label>
        <select id='inputState' class='form-control' name='empresa_equip'>";

        $empresa = "SELECT 
        MDE.nome AS filial, MIE.filial AS id_filial
        FROM
        manager_inventario_equipamento MIE
        INNER JOIN
        manager_dropempresa MDE ON MDE.id_empresa = MIE.filial
        WHERE
        MIE.id_equipamento = ".$row_files['id_equipamento']."";
        $resultado_empresa = mysqli_query($conn, $empresa);

        if ($row_empresa= mysqli_fetch_assoc($resultado_empresa)) {
        echo "<option value='".$row_empresa['id_filial']."'>".$row_empresa['filial']."</option>";
        }            
        echo "<option value=''>---</option>";
        $query_empresa_equip= "SELECT * from manager_dropempresa WHERE deletar = 0 order by nome";
        $resultado_empresa_equip = mysqli_query($conn, $query_empresa_equip);
        while ($row_empresa_equip = mysqli_fetch_assoc($resultado_empresa_equip)) {
        echo "<option value='".$row_empresa_equip['id_empresa']."'>".$row_empresa_equip['nome']."</option>";
        }
        echo "
        </select>
        </div>
        <div class='modal-footer'>
        <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
        <button type='submit' class='btn btn-primary'>Salvar</button>
        </div>
    </form>
</div>
";
                                            }//end IF CELULAR
/*--------------------------------------------------- TABLET ------------------------------------------------------------------*/
                                            if($_GET['tipo'] == 2){
echo "
<div class='tab-content'>
    <form action='inventario_edit_alt.php' method='post'>
        <input type='text' value='".$row_files['id_equipamento']."' style='display: none' name='id_equipamento'/>
        <input type='text' value='".$row_files['id_funcionario']."' style='display: none' name='id_funcionario'/>
        <input type='text' value='".$row_files['tipo_equipamento']."' style='display: none' name='tipo_equipamento'/>
        <input type='text' value='2' style='display: none' name='page'/>
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='inputEmail4'>Modelo:</label>
                 <input type='text' class='form-control' id='modelo' name='modelo' value='".$row_files['modelo']."' >
            </div>
            <div class='form-group col-md-6'>
                <label for='inputEmail4'>Patrimônio:</label>
                 <input type='text' class='form-control' id='modelo' name='patrimonio' value='".$row_files['patrimonio']."' >
            </div>
            <div class='form-group col-md-6'>
                <label for='inputPassword4'>Imei:</label>
                <input type='text' class='form-control' name='imei_chip' value='".$row_files['imei_chip']."' />
            </div>
            <div class='form-group col-md-6'>
                <label for='inputPassword4'>Situação:</label>
                <select id='inputState' class='form-control' name='situacao_equip'>
                <option value='".$row_files['id_situacao']."'>".$row_files['situacao']."</option>
                <option>---</option>";
                $situacao_cel = "SELECT 
                                    id_situacao,
                                    nome
                                FROM manager_dropsituacao
                                WHERE deletar = 0 ORDER BY nome ASC";
                $result_situacao_cel = mysqli_query($conn, $situacao_cel);
                while($linha_cel = mysqli_fetch_assoc($result_situacao_cel)){
                    echo "<option value='".$linha_cel['id_situacao']."'>".$linha_cel['nome']."</option>";
                }                                      
    echo " </select>
            </div>
            <div class='form-group col-md-6'>
            <label for='inputPassword4'>Estado:</label>
            <select id='inputState' class='form-control' name='estado_equip'>
                <option value='".$row_files['id_estado']."'>".$row_files['estado']."</option>
                <option>---</option>";
                $estado_cel = "SELECT 
                                    id,
                                    nome
                                FROM manager_dropestado
                                WHERE deletar = 0 ORDER BY nome ASC";
                $result_estado_cel = mysqli_query($conn, $estado_cel);
                while($linha_estado = mysqli_fetch_assoc($result_estado_cel)){
                    echo "<option value='".$linha_estado['id']."'>".$linha_estado['nome']."</option>";
                }                                      
    echo " </select>
            </div>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Valor:</label>
    <input type='text' class='form-control' name='valor_cel' value='".$row_files['valor']."' / >
    </div>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Data Nota:</label>

    <input type='text' class='form-control' name='data_nota_cel' value='".$row_files['data_nota']."'/>
    </div>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Acessórios:</label>";

    $acessorios = "SELECT 
                        MDA.nome AS acessorios,
                        MIA.tipo_acessorio AS id_acessorios
                    FROM
                        manager_inventario_acessorios MIA
                    LEFT JOIN
                        manager_dropacessorios MDA ON MDA.id_acessorio = MIA.tipo_acessorio
                    WHERE
                        MIA.id_equipamento = ".$row_files['id_equipamento']."";
    $resultado_acessorios= mysqli_query($conn, $acessorios);

    $contador = 0;

    while ($row_acessorios= mysqli_fetch_assoc($resultado_acessorios)) {
        echo "<input type='checkbox' name='acessorio_celular[]' value='".$row_acessorios['id_acessorios']."' checked='checked'/>".$row_acessorios['acessorios']."</br>";
        //acrecentando no contador
        $contador++;
    }

    $acessorios_new = "SELECT 
                            * 
                        FROM 
                            manager_dropacessorios 
                        WHERE 
                            id_acessorio NOT IN (";

    $ass = "SELECT MIA.tipo_acessorio AS id_acessorios FROM manager_inventario_acessorios MIA INNER JOIN  manager_dropacessorios MDA ON MDA.id_acessorio = MIA.tipo_acessorio WHERE MIA.id_equipamento = ".$row_files['id_equipamento']."";
    $result_ass = mysqli_query($conn, $ass);


    while($row_ass = mysqli_fetch_assoc($result_ass)){

        $acessorios_new .= "".$row_ass['id_acessorios'].",";

    }

    $acessorios_new .= "'') AND deletar = 0";

    $result_acessorios_new = mysqli_query($conn, $acessorios_new);

    while($row_acessorios_new = mysqli_fetch_assoc($result_acessorios_new)){

        echo "<input type='checkbox' name='acessorio_celular[]' value='".$row_acessorios_new['id_acessorio']."'/>".$row_acessorios_new['nome']."</br>";
        //acrecentando no contador
        $contador++;
    }
    echo "<br />
            </div>
            <div class='form-group col-md-4'>
            <label for='inputState'>Status:</label>
            <select id='inputState' class='form-control' name='status_equip'>
            <option value='".$row_files['id_status']."'>".$row_files['status']."</option>
            ";
            $add = 0;
            $query_status_equip= "SELECT * from manager_dropstatusequipamento WHERE deletar = 0 order by nome ";
            $resultado_status_equip = mysqli_query($conn, $query_status_equip);
            echo "<option value=''>---</option>";
            while ($row_status_equip = mysqli_fetch_assoc($resultado_status_equip)) {
            echo "<option value='".$row_status_equip['id_status']."'>".$row_status_equip['nome']."</option>";
            $add++;
            }
            echo "
            </select>
            </div>
            </div>
            <div class='form-group col-md-6'>
            <label for='inputPassword4'>Filial:</label>
            <select id='inputState' class='form-control' name='empresa_equip'>
        ";

    $empresa = "SELECT 
                    MDE.nome AS filial, MIE.filial AS id_filial
                FROM
                    manager_inventario_equipamento MIE
                LEFT JOIN
                    manager_dropempresa MDE ON MDE.id_empresa = MIE.filial
                WHERE
                    MIE.id_equipamento = ".$row_files['id_equipamento']."";
    $resultado_empresa = mysqli_query($conn, $empresa);

    if ($row_empresa= mysqli_fetch_assoc($resultado_empresa)) {
        echo "<option value='".$row_empresa['id_filial']."'>".$row_empresa['filial']."</option>";
    }            
    echo "<option value=''>---</option>";
    $query_empresa_equip= "SELECT * from manager_dropempresa WHERE deletar = 0 order by nome";
    $resultado_empresa_equip = mysqli_query($conn, $query_empresa_equip);
    while ($row_empresa_equip = mysqli_fetch_assoc($resultado_empresa_equip)) {
        echo "<option value='".$row_empresa_equip['id_empresa']."'>".$row_empresa_equip['nome']."</option>";
    }
    echo "       </select>
                </div>
                <div class='modal-footer'>
                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
                    <button type='submit' class='btn btn-primary'>Salvar</button>
                </div>
            </form>
        </div>";

                                            }//end IF TABLET
/*--------------------------------------------------- CHIP ------------------------------------------------------------------*/
                                            if($_GET['tipo'] == 3){
echo "
<div class='tab-content'>
    <form action='inventario_edit_alt.php' method='post'>
    <input type='text' value='".$row_files['id_equipamento']."' style='display: none' name='id_equipamento'/>
    <input type='text' value='".$row_files['id_funcionario']."' style='display: none' name='id_funcionario'/>
    <input type='text' value='".$row_files['tipo_equipamento']."' style='display: none' name='tipo_equipamento'/>
    <input type='text' value='2' style='display: none' name='page'/>
    <div class='form-row'>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Operadora:</label>
    <select id='inputState' class='form-control' name='operadora'>
    <option value='".$row_files['id_operadora']."'>".$row_files['operadora']."</option>";

    $operadora = "SELECT MDO.nome AS operadora, MIE.operadora AS id_operadora 
    FROM manager_inventario_equipamento MIE
    INNER JOIN manager_dropoperadora MDO ON MDO.id_operadora = MIE.operadora
    WHERE MIE.id_equipamento = ".$row['id_equipamento']."";
    $resultado_operadora = mysqli_query($conn, $operadora);

    if ($row_operadora = mysqli_fetch_assoc($resultado_operadora)) {
    echo "<option value='".$row_operadora['id_operadora']."'>".$row_operadora['operadora']."</option>";
    }
    echo "<option value=''>---</option>";

    $query_operadora_equip = "SELECT * from manager_dropoperadora WHERE deletar = 0";
    $resultado_operadora_equip = mysqli_query($conn, $query_operadora_equip);
    while ($row_operadora_equip = mysqli_fetch_assoc($resultado_operadora_equip)) {
    echo "<option value='".$row_operadora_equip['id_operadora']."'>".$row_operadora_equip['nome']."</option>";
    }
    echo "
    </select>
    </div>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Planos:</label>";

    $planos = "SELECT planos_voz, planos_dados  FROM manager_inventario_equipamento
    WHERE id_equipamento = ".$row_files['id_equipamento']."";
    $resultado_planos= mysqli_query($conn, $planos);
    $row_planos = mysqli_fetch_assoc($resultado_planos);

    if($row_planos['planos_voz'] != NULL){
    echo "<input type='checkbox' name='voz' value='Voz' checked='checked'/>Voz&nbsp";
    }else{
    echo "<input type='checkbox' name='voz' value='Voz' />Voz&nbsp";
    }

    if($row_planos['planos_dados'] != NULL){
    echo "<input type='checkbox' name='dados' value='dados' checked='checked'/>Dados&nbsp";
    }else{
    echo "<input type='checkbox' name='dados' value='dados' />Dados&nbsp";
    }

    echo "
    </div>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Número:</label>
    <input type='text' class='form-control' id='inputPassword4' name='numero_chip' value='".$row_files['numero']."' onkeydown='javascript: fMasc( this, mTel );'>
    </div>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Imei Chip:</label>
    <input type='text' class='form-control' name='imei_chip' value='".$row_files['imei_chip']."' />
    </div>
    <div class='form-group col-md-4'>
    <label for='inputState'>Status:</label>
    <select id='inputState' class='form-control' name='status_chip'>
    <option value='".$row_files['id_status']."'>".$row_files['status']."</option>
    <option value=''>---</option>
    ";
    $add = 0;
    $query_status_equip= "SELECT * from manager_dropstatusequipamento WHERE id_status != 1 order by nome ASC";
    $resultado_status_equip = mysqli_query($conn, $query_status_equip);
    while ($row_status_equip = mysqli_fetch_assoc($resultado_status_equip)) {
    echo "<option value='".$row_status_equip['id_status']."'>".$row_status_equip['nome']."</option>";
    $add++;
    }
    echo "
    </select>
    </div>
    </div>
    <div class='form-group col-md-6'>
    <label for='inputPassword4'>Filial:</label>
    <select id='inputState' class='form-control' name='empresa_chip'>";

    $empresa = "SELECT MDE.nome AS filial, MIE.filial AS id_filial
    FROM manager_inventario_equipamento MIE
    INNER JOIN manager_dropempresa MDE ON MDE.id_empresa = MIE.filial
    WHERE MIE.id_equipamento = ".$row_files['id_equipamento']."";
    $resultado_empresa = mysqli_query($conn, $empresa);

    if ($row_empresa= mysqli_fetch_assoc($resultado_empresa)) {
    echo "<option value='".$row_empresa['id_filial']."'>".$row_empresa['filial']."</option>";
    }            
    echo "<option value=''>---</option>";
    $query_empresa_equip= "SELECT * from manager_dropempresa WHERE deletar = 0";
    $resultado_empresa_equip = mysqli_query($conn, $query_empresa_equip);
    while ($row_empresa_equip = mysqli_fetch_assoc($resultado_empresa_equip)) {
    echo "<option value='".$row_empresa_equip['id_empresa']."'>".$row_empresa_equip['nome']."</option>";
    }
    echo "
    </select>
    </div>
    <div class='modal-footer'>
    <button class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>
    <button type='submit' class='btn btn-primary'>Salvar</button>
    </div>
    </form>
</div>";
                                            }//end IF CHIP
                                    ?>
                        </div>
                        <!-- /widget -->
                    </div>
                </div>
                <!--ANEXOS-->
                <div class="tab-pane" id="anexos">
                    <div class="span3" style="width: 802px;">
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <div class="control-group">
                                    <div class="controls">
                                        <!-- Button to trigger modal -->
                                        <a href="#myModalanexos" role="button" class="btn btn-info pull-left filho"
                                            data-toggle="modal">+ Nota Fiscal / Termo</a>
                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->
                            </div>
                            <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nome - Documento</th>
                                            <th>Tipo do documento</th>
                                            <th>Data</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    //pesquisando os arquivos criados.
                                    $query_anexo = "SELECT 
                                    MIA.id_anexo,
                                    MIA.nome,
                                    MIA.caminho,
                                    MIA.data_criacao,
                                    MIA.tipo,
                                    MIF.id_funcionario
                                FROM
                                    manager_inventario_equipamento MIE
                                        LEFT JOIN
                                    manager_inventario_funcionario MIF ON MIE.id_funcionario = MIF.id_funcionario
                                        LEFT JOIN
                                    manager_inventario_anexo MIA ON MIE.id_equipamento = MIA.id_equipamento
                                WHERE
                                    MIE.id_equipamento = ".$_GET['id_equip']."
                                    AND MIA.deletar = 0";
                                    
                                    $resultado_anexo = mysqli_query($conn, $query_anexo);

                                      while ($row_anexo = mysqli_fetch_assoc($resultado_anexo)) {

                                    echo "<tr>
                                             <td>
                                                <a href='".$row_anexo['caminho']."' target='_blank'>".$row_anexo['nome']."</a>
                                             </td>
                                             <td>";

                                             if($row_anexo['tipo'] == 3){
                                                 echo "TERMO DE RESPONSABILIDADE";
                                             }

                                            if($row_anexo['tipo'] == 4){
                                                echo "NOTA FISCAL";
                                            }
                                            if($row_anexo['tipo'] == 5){
                                                echo "CHECKLIST";
                                            }

                                     echo "  </td>
                                             <td>
                                                ".$row_anexo['data_criacao']."
                                             </td>
                                             <td>
                                              <a href='#myModalDel".$row_anexo['id_anexo']."' role='button' data-toggle='modal' title='Excluir anexo'>
                                                <i class='btn-icon-only icon-trash' style='color: red;'></i>
                                              </a>
                                             </td>
                                           </tr>                                           
                                           <!-- Modal EXCLUIR ANEXO-->
                                            <div id='myModalDel".$row_anexo['id_anexo']."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                                              <div class='modal-header'>
                                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                <h3 id='myModalLabel'>
                                                  <img src='img/atencao.png' style='width: 10%' />
                                                  ATENCÃO - EXCLUIR ANEXO!
                                                </h3>
                                              </div>
                                              <div class='modal-body'>

                                                <form id='edit-profile' class='form-horizontal' action='inventario_date.php' method='post'>
                                                  <div id='button_pai'>
                                                    <h4>Deseja exluir o anexo ?<p class='linha'>".$row_anexo['nome']."</p></h4>        
                                                  </div>
                                                  <br />
                                                  <input type='text' style='display:none;' value='".$row_anexo['id_anexo']."' name='id_anexo' /><!--gambiarra-->
                                                  <input type='text' style='display:none;' value='".$row_files['id_equipamento']."' name='id_equipamento' /><!--gambiarra-->
                                                  <input type='text' style='display:none;' value='".$row_anexo['id_funcionario']."' name='id_funcionario' /><!--gambiarra-->
                                                  <input type='text' style='display:none;' value='".$row_files['tipo_equipamento']."' name='tipo_equipamento' /><!--gambiarra-->
                                                  <input type='text' style='display:none;' value='2' name='drop' /><!--gambiarra-->
                                                  <div class='modal-footer'>
                                                    <button class='btn' data-dismiss='modal' aria-hidden='true'>Não</button>
                                                    <button class='btn btn-primary'>Sim</button>
                                                  </div>
                                                </form>
                                               </div>
                                            </div>";
                                      }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                </div>
                <!--FIM ANEXO-->                
            </div>
        </div>
    </div>
</div>
<!--JAVASCRITPS TABELAS-->
<script src="js/tabela.js"></script>
<script src="js/tabela2.js"></script>
<script src="java.js"></script>
<script src="jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<!--Paginação entre filho arquivo e pai-->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
</body>
<!--MODAIS-->
<!-- Modal ANEXOS ADICIONAR -->
<div id="myModalanexos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Adicionar Anexo</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" enctype="multipart/form-data" action="termo_doc.php"
            method="post">
            <!--Uma gambiarra para levar o id do contrato para a tela de update-->
            <input type="text" name="id_nota_fiscal" style="display:none"  value="<?php echo $row_files['id_equipamento'] ?>">
            <input type="text" name="id_fun" style="display:none" value="<?php echo $row_files['id_funcionario'] ?>">
            <input type="text" name="tipo_equip" style="display:none" value="<?php echo $_GET['tipo'] ?>">
            <input type="text" name="page" style="display:none" value="1">
            <div class="control-group">
                <label class="control-label required">Tipo:</label>
                <div class="controls">
                    <select id="t_cob" name="tipo" class="span2" required="">                        
                        <option value=''>---</option>
                        <option value='4'>Nota Fiscal</option>
                    <?php
                            $validando = "SELECT status, termo FROM manager_inventario_equipamento WHERE id_equipamento = ".$_GET['id_equip']."";
                            $result_valid = mysqli_query($conn, $validando);
                            $row_valid = mysqli_fetch_assoc($result_valid);

                            if($row_valid['status'] != 1){
                                echo "<option value='5'>Check-List</option>";
                            }

                            if($row_valid['status'] == 1){

                                if($row_valid['termo'] == 1 ){ 
                                    echo "<option value='3'>Termo Entrega</option>";
                                }//end IF termo não assinado  

                            }//end IF status ativo                            
                        ?>                        
                    </select>
                </div>
            </div>            
            <div class="control-group">
                <input name='id_nota_fiscal' value='<?php echo $_GET['id_equip'];?>' style="display:none;"/>
                <input name='page' value='1' style="display:none;"/>
            </div> 
            <div class="control-group">
                <label class="control-label">Selecione:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="file" name="termo" required />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

</html>
<!--MOSTRAR CAMPO ICONE-->
<script>
function mostrar(id) {
    document.getElementById(id).style.display = 'block';
}

function fechar(id) {
    if (document.getElementById(id).style.display == 'block') {
        document.getElementById(id).style.display = 'none';
    } else {
        document.getElementById(id).style.display = 'block';
    }
}
</script>
<?php mysqli_close($conn); ?>