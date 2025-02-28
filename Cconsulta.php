<?php
  include "php/conn.php";
  include 'topSite.html';

  $tituloPagina = "Cadastro de Consultas";
  $formAction = "php/insertScripts.php?tabela=tbconsultas";
?>

<div class="container-fluid pr-3 pl-3">
  <div class="card mt-3 mb-3">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title m-0"><i class="fas fa-stethoscope mr-2"></i>Cadastro de Consultas</h3>
    </div>
    <div class="card-body">
        <form action="php/insertScripts.php?tabela=tbconsultas" method="post">
            <div class="form-group ">
                <div class="row">
                    <div class="col-12">
                        <label class="font-weight-bold">Paciente:</label>

                        <form action="" method="post">
        <div class="form-group ">          
        <select class="form-control" id="selecapaciente">
        <option value="-1" <?= ($pacienteSelecionado == -1) ? 'selected' : '' ?>>Todos</option>
        <?php
        $sql = "SELECT DISTINCT paciente, nome, cpf FROM tbpacientes ORDER BY nome ASC";
        $result = $conn->query($sql); 
        
        while ($row = $result->fetch_assoc()) {
            $selected = ($row["paciente"] == $pacienteSelecionado) ? 'selected' : '';
            echo '<option value="' . $row["paciente"] . '" ' . $selected . '>'  . $row["nome"] . ' - CPF: ' . $row["cpf"] . '</option>';
        }
        ?>
        </div>
      </select>
    </form>     

                        </div>
                    <div class="col-12">
                        <label class="font-weight-bold">Médico:</label>
                        <form action="" method="post">
        <div class="form-group ">          
        <select class="form-control" id="selecaomedico">
        <option value="-1" <?= ($medicoSelecionado == -1) ? 'selected' : '' ?>>Todos</option>
        <?php
       $sql = "SELECT DISTINCT medico, nome, crm FROM tbmedicos ORDER BY nome ASC";
       $result = $conn->query($sql); 
       
       while ($row = $result->fetch_assoc()) {
           $selected = ($row["medico"] == $medicoSelecionado) ? 'selected' : '';
           echo '<option value="' . $row["medico"] . '" ' . $selected . '>' . $row["nome"] . ' - ' . $row["crm"] .  '</option>';
          }
        ?>
        </div>
      </select>
    </form>     
      
                      </div> 
                  
                </div>  
               <div class="row">
                    <div class="col-12 col-lg-6">
                        <label class="font-weight-bold">Data:</label>
                        <input class="form-control mb-3" type="date" name="inputDataConsulta" required>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="font-weight-bold">Horário:</label>
                        <input class="form-control mb-3" type="time" name="inputHorario" required>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <input class="btn btn-primary" style="width:120px" type="submit" value="Cadastrar">
                        <a class="btn btn-secondary" href="Cconsulta.php" style="width:120px" role="submit">Limpar</a>
                    </div>
                </div>
            </div>
        </form>    

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
<script src="js/cadConsultas.js"></script>
</body>
</html>
