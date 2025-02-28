document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário
        
        let paciente = document.querySelector("#selecaopaciente").value;
        let medico = document.querySelector("#selecaomedico").value;
        let data = document.querySelector("input[name='inputDataConsulta']").value;
        let horario = document.querySelector("input[name='inputHorario']").value;

        if (paciente === "-1" || medico === "-1" || !data || !horario) {
            alert("Por favor, preencha todos os campos.");
            return;
        }

        let formData = new FormData();
        formData.append("paciente_FK", paciente);
        formData.append("medico_FK", medico);
        formData.append("data", data);
        formData.append("horario", horario);

        fetch("php/insertScripts.php?tabela=tbconsultas", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Consulta cadastrada com sucesso!");
                window.location.reload();
            } else {
                alert("Erro ao cadastrar consulta: " + data.message);
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            alert("Erro ao cadastrar consulta.");
        });
    });
});
