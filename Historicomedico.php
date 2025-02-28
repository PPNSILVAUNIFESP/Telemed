<?php
include "php/conn.php";
include 'topSite.html';

$medicoSelecionado = $_GET['id'] ?? -1;
?>

<div class="container-fluid px-3">
    <div class="card mt-3 mb-3">
        <div class="card-header bg-dark text-white">
            <h3 class="card-title m-0">Histórico Médico</h3>
        </div>
        <div class="card-body">
            <h3>Selecione o Médico</h3>
            <form method="post">
                <div class="form-group">
                    <select class="form-control" id="historicoMedico">
                        <option value="-1" <?= ($medicoSelecionado == -1) ? 'selected' : '' ?>>Todos</option>
                        <?php
                        $query = "SELECT DISTINCT medico, nome, crm FROM tbmedicos ORDER BY nome ASC";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row["medico"] == $medicoSelecionado) ? 'selected' : '';
                            echo "<option value='{$row["medico"]}' {$selected}>{$row["nome"]} - CRM: {$row["crm"]}</option>";
                        }
                        ?>
                    </select>
                </div>
            </form>

            <hr class="mt-3">
            <h3 class="card-title mt-4 mb-4">Agendamentos</h3>
            <table id="tbHistorico" class="display compact nowrap w-100">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Paciente</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT c.consulta, p.nome AS paciente, c.horario, c.data, m.medico
                            FROM tbconsultas c
                            INNER JOIN tbmedicos m ON c.medico_FK = m.medico
                            INNER JOIN tbpacientes p ON c.paciente_FK = p.paciente";

                    if ($medicoSelecionado != -1) {
                        $sql .= " WHERE c.medico_FK = ?";
                    }

                    $stmt = $conn->prepare($sql);

                    if ($medicoSelecionado != -1) {
                        $stmt->bind_param("i", $medicoSelecionado);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dataFormatada = date("d/m/Y", strtotime($row["data"]));
                            echo "<tr>
                                    <td>{$row["consulta"]}</td>
                                    <td>{$row["paciente"]} <span class='idsTable'>(id: {$row["medico"]})</span></td>
                                    <td>{$dataFormatada}</td>
                                    <td>{$row["horario"]}</td>
                                    <td>
                                        <i redirect='php/deleteScripts.php?tabela=tbconsultasMedico&id={$row["consulta"]}' 
                                           class='fas fa-trash-alt text-danger' 
                                           onclick='dialogDelete(this)' 
                                           style='cursor:pointer'>
                                        </i>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Nenhum agendamento encontrado</td></tr>";
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
<script src="vendor/DataTables/datatables.min.js"></script>
<script src="js/historicos.js"></script>
</body>
</html>
