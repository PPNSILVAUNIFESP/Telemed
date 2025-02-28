<?php
  include "php/conn.php";

  $alteraID = $_GET['altera'] ?? null;
  $btnAlterar = false;
  $formAction = 'php/insertScripts.php?tabela=tbmedicos';

  $nomeInput = "";
  $CRMInput = "";
  $especialidade_FKInput = "";
  $data_cadastroInput = "";

  if (!empty($alteraID)) {
      $sql = "SELECT `nome`, `CRM`, `especialidade_FK`, `data_cadastro` FROM `tbmedicos` WHERE `medico` = $alteraID";    
      $result = $conn->query($sql); 
      $row = $result->fetch_assoc();

      if ($row) {
          $btnAlterar = true;
          $formAction = "php/updateScripts.php?tabela=tbmedicos&id=$alteraID";
          $nomeInput = $row["nome"];
          $CRMInput = $row["CRM"];
          $especialidade_FKInput = $row["especialidade_FK"];
          $data_cadastroInput = $row["data_cadastro"];
      }
  }

  include 'topSite.html';
?>

<div class="container-fluid pr-5 pl-5">
  <div class="card mt-4 mb-4">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title m-0"><i class="fas fa-user-md mr-2"></i>Cadastro de Médicos</h3>
    </div>
    <div class="card-body">
      <form action="<?php echo $formAction; ?>" method="post">
        <div class="form-group">
          <label class="font-weight-bold">Nome:</label>
          <input type="text" class="form-control" name="inputMedicoNome" placeholder="Digite o nome" value="<?php echo htmlspecialchars($nomeInput); ?>" required>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">CRM:</label>
          <input type="text" class="form-control" name="inputCRM" placeholder="Digite o CRM" value="<?php echo htmlspecialchars($CRMInput); ?>" required>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Especialidade:</label>
          <select class="form-control" name="inputEspecialidadeFK" required>
            <option value="">Selecione</option>
              <?php
                $sql = "SELECT `especialidade`, `descricao` FROM `tbespecialidades` ORDER BY `descricao`";
                $result = $conn->query($sql);    
                while ($row = $result->fetch_assoc()) {
                  $selected = ($especialidade_FKInput == $row["especialidade"]) ? "selected" : "";
                  echo '<option value="'.htmlspecialchars($row["especialidade"]).'" '.$selected.'>'.htmlspecialchars($row["descricao"]).'</option>';
                }
              ?>
          </select>
        </div>
        <input type="hidden" id="idMedico">
        <?php if ($btnAlterar) { ?>
          <input class="btn btn-primary" style="width:120px" type="submit" value="Alterar">
          <a class="btn btn-secondary" href="Cmedico.php" style="width:120px" role="submit">Cancelar</a>
        <?php } else { ?>
          <input class="btn btn-primary" style="width:120px" type="submit" value="Cadastrar">
        <?php } ?>
      </form>

      <hr class="mt-5">
      <h3 class="card-title mt-4 mb-4">Médicos Cadastrados</h3>      
      <table id="tbMedicos" class="display compact nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Médico</th>
            <th>CRM</th>
            <th>Especialidade</th>
            <th>Data Cadastro</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>       
            <?php
              $sql = "SELECT m.medico, m.nome, m.CRM, m.especialidade_FK, e.descricao AS especialidadeDescricao, m.data_cadastro 
                      FROM tbmedicos m 
                      JOIN tbespecialidades e ON m.especialidade_FK = e.especialidade
                      ORDER BY m.nome";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                $dataCadastroFormatada = date("d/m/Y", strtotime($row["data_cadastro"]));
                echo "<tr>
                        <td>{$row["medico"]}</td>
                        <td>".htmlspecialchars($row["nome"])."</td>
                        <td>{$row["CRM"]}</td>
                        <td>".htmlspecialchars($row["especialidadeDescricao"])."</td>
                        <td>{$dataCadastroFormatada}</td>
                        <td>
                          <a href='Cmedico.php?altera={$row["medico"]}'><i class='fas fa-sync-alt text-info mr-3'></i></a>
                          <i redirect='php/deleteScripts.php?tabela=tbmedicos&id={$row["medico"]}' class='fas fa-trash-alt text-danger' onclick='dialogDelete(this)' style='cursor:pointer'></i>
                        </td>
                      </tr>";
              }
            ?>
        </tbody>             
      </table>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  });
</script>
<script type="text/javascript" src="vendor/DataTables/datatables.min.js"></script>
<script src="js/cadMedicos.js"></script>
</body>
</html>

<?php $conn->close(); ?>
