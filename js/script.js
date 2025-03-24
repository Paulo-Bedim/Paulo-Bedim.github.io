document.addEventListener("DOMContentLoaded", function () {
  carregarProjetos();

  document.getElementById("form-contato").addEventListener("submit", function (e) {
    e.preventDefault();
    enviarMensagem();
  });
});

function carregarProjetos() {
  fetch("../php/projetos.xml.php")
    .then((response) => response.text())
    .then((xmlText) => {
      let parser = new DOMParser();
      let xml = parser.parseFromString(xmlText, "text/xml");
      let projetos = xml.getElementsByTagName("projeto");

      let listaProjetos = document.getElementById("lista-projetos");
      listaProjetos.innerHTML = "";

      for (let i = 0; i < projetos.length; i++) {
        let projeto = projetos[i];
        let id = projeto.getElementsByTagName("id")[0].textContent;
        let titulo = projeto.getElementsByTagName("titulo")[0].textContent;
        let descricao = projeto.getElementsByTagName("descricao")[0].textContent;
        let status = projeto.getElementsByTagName("status")[0].textContent;
        let imagem = projeto.getElementsByTagName("imagem")[0]?.textContent || '';

        let item = document.createElement("li");
        item.className = "projeto-item";
        item.innerHTML = `
          <div class="projeto-card">
            ${imagem ? `<img src="../img/projetos/${imagem}" alt="${titulo}" class="projeto-imagem">` : ''}
            <div class="projeto-info">
              <h3>${titulo}</h3>
              <p>${descricao}</p>
              <span class="projeto-status ${status.toLowerCase().replace(' ', '-')}">${status}</span>
            </div>
          </div>
        `;
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
