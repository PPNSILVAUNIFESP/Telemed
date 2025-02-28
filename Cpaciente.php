<?php
  include "php/conn.php";

  $alteraID = $_GET['altera'];
  $btnAlterar = false;
  $formAction = 'php/insertScripts.php?tabela=tbpacientes';

  $nomeInput = "";
  $CPFInput = "";
  $Plano = "";
  $data_nascimento = "";

  if(!is_null($alteraID) && $alteraID != ""){
    $sql = "SELECT `nome`, `cpf`, `plano`, `data_nascimento` FROM `tbpacientes` WHERE `paciente` =" . $alteraID;    
    $result = $conn->query($sql); 
    
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $btnAlterar = true;
        $formAction = 'php/updateScripts.php?tabela=tbpacientes&id='.$alteraID;
        $nomeInput = $row["nome"];
        $CPFInput = $row["cpf"];
        $Plano = $row["plano"];
        $data_nascimento = $row["data_nascimento"];
      }
    }
  }

  include 'topSite.html'; 
?>

<div class="container-fluid pr-5 pl-5">
  <div class="card mt-4 mb-4">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title m-0"><i class="fas fa-user-injured mr-2"></i>Cadastro de Pacientes</h3>
    </div>
    <div class="card-body">
      <form action="<?php echo $formAction; ?>" method="post">
        <div class="form-group">
          <label class="font-weight-bold">Nome:</label>
          <input type="text" class="form-control" name="inputPacienteNome" placeholder="Digite o nome" value="<?php echo isset($nomeInput) ? $nomeInput : ''; ?>" required>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">CPF:</label>
          <input type="text" class="form-control" name="inputCPF" placeholder="Digite o CPF" value="<?php echo isset($CPFInput) ? $CPFInput : ''; ?>" required>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Data de Nascimento:</label>
          <input type="date" class="form-control" name="inputDataNascimento" value="<?php echo isset($data_nascimento) ? $data_nascimento : ''; ?>" required>
        </div>
        <div class="form-group">
          <input type="checkbox" name="inputPlano" value="1" <?php echo ($Plano == "1") ? 'checked' : ''; ?>>
          <label class="font-weight-bold">Possui Plano</label>
        </div>
        <input type="text" class="form-control" id="idPaciente" style="display:none">
        <?php if ($btnAlterar) { ?>        
          <input class="btn btn-primary" style="width:120px" type="submit" value="Alterar">
          <a class="btn btn-secondary" href="Cpaciente.php" style="width:120px" role="submit">Cancelar</a>
        <?php } else { ?>
          <input class="btn btn-primary" style="width:120px" type="submit" value="Cadastrar">
        <?php } ?>
      </form>
      <hr class="mt-5">
      <h3 class="card-title mt-4 mb-4">Pacientes Cadastrados</h3>      
      <table id="tbPacientes" class="display compact nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Paciente</th>
            <th>CPF</th>
            <th>Plano</th>
            <th>Data Nascimento</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
<?php
  $sql = "SELECT `paciente`, `nome`, `cpf`, `plano`, `data_nascimento` FROM `tbpacientes`";
  $result = $conn->query($sql);  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $dataNascimento = date_create($row["data_nascimento"]);
      $dataNascimentoFormatada = date_format($dataNascimento,"d/m/Y");    
      echo '<tr>';
      echo '<td>'. $row["paciente"] .'</td>';
      echo '<td>'. $row["nome"] .'</td>';
      echo '<td>'. $row["cpf"] .'</td>';
      echo '<td>'. ($row["plano"] == "1" ? "Sim" : "Não") .'</td>';
      echo '<td>'. $dataNascimentoFormatada .'</td>';
      echo '<td><a href="Cpaciente.php?altera='.$row["paciente"].'"><i class="fas fa-sync-alt text-info mr-3"></i></a>
            <i redirect="php/deleteScripts.php?tabela=tbpacientes&id='.$row["paciente"].'" class="fas fa-trash-alt text-danger" onclick="dialogDelete(this)" style="cursor:pointer"></i></td>';
      echo '</tr>';
    }
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
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
<script type="text/javascript" src="vendor/DataTables/datatables.min.js"></script>
<script src="js/cadPacientes.js"></script>
</body>
</html>
<?php $conn->close(); ?>
