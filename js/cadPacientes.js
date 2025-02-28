function inicializarTabela(idTabela) {
  return $(idTabela).DataTable({
      scrollX: true,
      language: {
          decimal: "",
          emptyTable: "Nenhum registro disponível",
          info: "Mostrando _START_ - _END_ de _TOTAL_ registros",
          infoEmpty: "Não há registros",
          infoFiltered: "(Filtrado de _MAX_ total de registros)",
          thousands: ",",
          lengthMenu: "Mostrar _MENU_",
          loadingRecords: "Carregando...",
          processing: "Processando...",
          search: "Filtrar: ",
          zeroRecords: "Nenhum resultado encontrado",
          paginate: {
              first: "Primeiro",
              last: "Último",
              next: "Próximo",
              previous: "Anterior"
          },
          aria: {
              sortAscending: ": classificar coluna em ordem crescente",
              sortDescending: ": classificar coluna em ordem decrescente"
          }
      },
      pageLength: 5,
      lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
  });
}

function configurarSelecaoLinha(tabela, inputNome, inputID) {
  tabela.on('click', 'tr', function () {
      var data = tabela.row(this).data();
      if (data) {
          document.querySelector(inputNome).value = `${data[0]} - ${data[1]}`;
          document.querySelector(inputID).value = data[0];
      }
  });
}

function dialogDelete(obj) {
  if (window.confirm("Confirma a exclusão do registro?")) {
      var urlRedirect = obj.getAttribute("redirect");
      window.location.href = "././" + urlRedirect;
  }
}

var tbPacientes = inicializarTabela('#tbPacientes');
var tbMedicos = inicializarTabela('#tbMedicos');

configurarSelecaoLinha(tbPacientes, "#inputNomePaciente", "#inputIDPaciente");
configurarSelecaoLinha(tbMedicos, "#inputNomeMedico", "#inputIDMedico");
