document.addEventListener("DOMContentLoaded", function () {
  carregarProjetos();

  document.getElementById("form-contato").addEventListener("submit", function (e) {
    e.preventDefault();
    enviarMensagem();
  });
});

function carregarProjetos() {
  fetch("projetos.xml.php")
    .then((response) => response.text())
    .then((xmlText) => {
      let parser = new DOMParser();
      let xml = parser.parseFromString(xmlText, "text/xml");
      let projetos = xml.getElementsByTagName("projeto");

      let listaProjetos = document.getElementById("lista-projetos");
      listaProjetos.innerHTML = "";

      for (let i = 0; i < projetos.length; i++) {
        let titulo = projetos[i].getElementsByTagName("titulo")[0].textContent;
        let descricao = projetos[i].getElementsByTagName("descricao")[0].textContent;
        let status = projetos[i].getElementsByTagName("status")[0].textContent;

        let item = document.createElement("li");
        item.innerHTML = `<strong>${titulo}</strong> - ${descricao} <br> <em>Status: ${status}</em>`;
        listaProjetos.appendChild(item);
      }
    })
    .catch((error) => console.error("Erro ao carregar projetos:", error));
}

function enviarMensagem() {
  let formData = new FormData(document.getElementById("form-contato"));

  fetch("salvar_mensagem.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    alert(data.success || data.error);
  })
  .catch(error => console.error("Erro ao enviar mensagem:", error));
}
