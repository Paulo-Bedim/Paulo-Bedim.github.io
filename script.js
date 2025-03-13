document.addEventListener("DOMContentLoaded", function () {
    carregarProjetos();
  });
  
  function carregarProjetos() {
    fetch("projetos.php")
      .then((response) => response.json())
      .then((data) => {
        let listaProjetos = document.getElementById("lista-projetos");
        listaProjetos.innerHTML = "";
  
        data.forEach((projeto) => {
          let item = document.createElement("li");
          item.innerHTML = `<strong>${projeto.titulo}</strong> - ${projeto.descricao} <br> <em>Status: ${projeto.status}</em>`;
          listaProjetos.appendChild(item);
        });
      })
      .catch((error) => console.error("Erro ao carregar projetos:", error));
  }
  