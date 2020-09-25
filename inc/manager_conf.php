<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require_once('../conexao/conexao.php');

//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
  header('location: ../front/index.html');

}elseif ($_SESSION["perfil"] != 0) {

    header('location: ../front/error.php');
  }

require_once('header.php');
require_once('../query/query_dropdowns.php');


?>
<!--Chamando a Header-->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="active">
                    <a href="manager_conf.php"><i class="icon-user"></i>
                        <span>Usuários</span>
                    </a>
                </li>
                <li>
                    <a href="manager_drop_inventario.php"><i class="icon-list-alt"></i>
                        <span>Drop-Downs</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="widget widget-table action-table">
    <div class="widget-header">
        <h3>
            <i class="icon-lithe icon-home"></i> <a href="manager.php">&nbsp; Home</a>
            /
            <i class="icon-lithe icon-wrench"></i> <a href="manager_conf.php">&nbsp; Configurações</a>
            /
            <i class="icon-lithe icon-user"></i> <a href="javascript:">&nbsp; Usuário</a>
        </h3>
    </div>
    <div class="widget-content">
        <div class="widget-header">
            <?php if ($_SESSION['usuario'] != NULL) {
            echo "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert'>×</button>
            <strong>Usuário &quot".$_SESSION['usuario']."&quot cadastrado com sucesso!</strong>
          </div>";
          unset($_SESSION['usuario']);
          }?>
            <div class="control-group">
                <div class="controls">
                    <!-- Button to trigger modal -->
                    <a href="#myModal" role="button" class="btn btn-info pull-left filho" data-toggle="modal"
                        title="Adicionar novo usuário">
                        <i class='fas fa-plus' style="margin-right: 10px"></i>Usuário
                    </a>
                </div>
                <!-- /control-group -->
            </div>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th class="td-actions">Ações</th>
                </tr>
            </thead>
            <?php
          $query_show_user = "SELECT 
                                    MP.id_profile AS id, 
                                    MP.profile_name AS nome, 
                                    MP.profile_mail AS email, 
                                    MPT.type_name AS perfil,
                                    MP.profile_deleted AS ativo
                              FROM 
                                    manager_profile MP
                              LEFT JOIN 
                                    manager_profile_type MPT ON MP.profile_type = MPT.type_profile order by MP.id_profile";
          $resultado_show = $conn->query($query_show_user)or die(mysqli_error($conn));

            while ($row_show = mysqli_fetch_assoc($resultado_show)) {
             echo "<tbody>
                    <tr>
                        <td>".$row_show['id']."</td>
                        <td>".$row_show['nome']."</td>
                         <td>".$row_show['email']."</td>
                        <td>".$row_show['perfil']."</td>
                        <td class='td-actions'>";
                        if($row_show['ativo'] == 0){
                            echo "                      
                                <a href='edit_front.php?id=".$row_show['id']."' id='editar' title='Editar'>
                                    <i class='fas fa-user-edit'></i>
                                </a>
                                <a href='desativar.php?id=".$row_show['id']."' id='desativar' title='Desativar'>
                                    <i class='fas fa-times'></i>
                                </a>";
                        }else{
                            echo " <a href='desativar.php?id=".$row_show['id']."' id='ativar' title='Ativar'>
                                        <i class='fas fa-check'></i>
                                    </a>";
                        }
                           
            echo "      </td>
                    </tr>
                  </tbody>";
            }
          ?>
        </table>
    </div>
</div>
<!-- Le javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/excanvas.min.js"></script>
<script src="../js/chart.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/base.js"></script>
</body>
<!-- Modal NOVO USUÁRIO -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Novo Usuário</h3>
    </div>
    <div class="modal-body">
        <!--Colocar a tabela Aqui!-->
        <form id="edit-profile" class="form-horizontal" action="manager_add.php" method="post"
            oninput="outputHash.value = md5(inputString.value)">
            <div class="control-group">
                <label class="control-label">Nome Completo:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="text" name="name_user" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">E-mail:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" type="email" name="email_user" required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Perfil:</label>
                <div class="controls">
                    <select id='t_cont' name='perfil_user' class='span2' required>
                        <option value=''>---</option>
                        <?php
                        //query buscando os perfis
                        while ($row_perfil = $resultado_perfil->fetch_assoc()) {
                            echo "<option value='".$row_perfil['type_profile']."'>".$row_perfil['type_name']."</option>";
                        }
                            $conn->close();
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Senha:</label>
                <div class="controls">
                    <input class="cpfcnpj span2" id="inputString" type="password" name="password_user" required />
                    <!--MD5-->
                    <input type="text" for="inputString" name="outputHash" id="outputHash" style="display:none;">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
<!-- /controls -->
<!-- MD5 -->
<script src="../js/md5.js"></script>

</html>