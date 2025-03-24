document.addEventListener("DOMContentLoaded", () => {
    carregarProjetosAdmin();

    document.getElementById("form-projeto").addEventListener("submit", function(e) {
        e.preventDefault();
        salvarProjeto();
    });
});

async function carregarProjetosAdmin() {
    try {
        const response = await fetch('projetos.xml.php');
        const xmlText = await response.text();
        const parser = new DOMParser();
        const xml = parser.parseFromString(xmlText, "text/xml");
        
        const projetos = xml.getElementsByTagName("projeto");
        const container = document.getElementById("lista-projetos-admin");
        container.innerHTML = '';

        for(let projeto of projetos) {
            const id = projeto.getElementsByTagName("id")[0].textContent;
            const titulo = projeto.getElementsByTagName("titulo")[0].textContent;
            const status = projeto.getElementsByTagName("status")[0].textContent;
            
            const projetoHTML = `
                <div class="projeto-admin">
                    <h3>${titulo} (${status})</h3>
                    <button onclick="editarProjeto(${id})">Editar</button>
                    <button onclick="excluirProjeto(${id})">Excluir</button>
                </div>
            `;
            container.innerHTML += projetoHTML;
        }
    } catch (error) {
        console.error('Erro ao carregar projetos:', error);
    }
}

async function salvarProjeto() {
    const formData = new FormData(document.getElementById("form-projeto"));
    
    try {
        const response = await fetch('salvar_projeto.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        alert(result.mensagem);
        carregarProjetosAdmin();
        limparForm();
    } catch (error) {
        console.error('Erro ao salvar projeto:', error);
    }
}

async function excluirProjeto(id) {
    if(confirm('Tem certeza que deseja excluir este projeto?')) {
        try {
            const response = await fetch(`remover_projeto.php?id=${id}`);
            const result = await response.json();
            alert(result.mensagem);
            carregarProjetosAdmin();
        } catch (error) {
            console.error('Erro ao excluir projeto:', error);
        }
    }
}

// Funções auxiliares
function limparForm() {
    document.getElementById("form-projeto").reset();
    document.getElementById("preview-imagem").innerHTML = '';
    document.getElementById("projeto-id").value = '';
}