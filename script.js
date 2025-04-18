let cardEditando = null; // Controla se estamos editando um card

function abrirModal(id) {
  document.getElementById(id).style.display = "block";
}

function fecharModal(id) {
  document.getElementById(id).style.display = "none";
  cardEditando = null;
}

window.onclick = function (event) {
  if (event.target.classList.contains("modal")) {
    event.target.style.display = "none";
    cardEditando = null;
  }
};

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formAdicionarProduto");
  const botaoSalvar = document.getElementById("btnSalvar");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const imagemUrl = document.getElementById("imagemUrl").value.trim();
    const nome = document.getElementById("nomeProduto").value.trim();
    const preco = parseFloat(document.getElementById("precoProduto").value).toFixed(2);
    const quantidade = parseInt(document.getElementById("quantidadeProduto").value.trim());

    if (!imagemUrl || !nome || isNaN(preco) || isNaN(quantidade) || quantidade < 1) {
      alert("Preencha todos os campos corretamente.");
      return;
    }

    const container = document.querySelector(".produtos-container");

    if (cardEditando) {
      // Editar o card existente
      cardEditando.querySelector("img").src = imagemUrl;
      cardEditando.querySelector("img").alt = nome;
      cardEditando.querySelector("h3").textContent = nome;
      cardEditando.querySelector(".preco").textContent = `R$ ${preco}`;
      cardEditando.querySelector(".quantidade").textContent = `Qtd: ${quantidade}`;

      cardEditando = null;
      botaoSalvar.textContent = "Adicionar Produto";
    } else {
      // Verifica se já existe um card com mesmo nome e preço
      const cards = container.querySelectorAll(".produto-card");
      let produtoExistente = null;

      cards.forEach(card => {
        const nomeCard = card.querySelector("h3").textContent;
        const precoCard = card.querySelector(".preco").textContent;

        if (nomeCard === nome && precoCard === `R$ ${preco}`) {
          produtoExistente = card;
        }
      });

      if (produtoExistente) {
        const quantidadeAtual = parseInt(produtoExistente.querySelector(".quantidade").textContent.replace("Qtd: ", ""));
        produtoExistente.querySelector(".quantidade").textContent = `Qtd: ${quantidadeAtual + quantidade}`;
      } else {
        // Cria novo card
        const card = document.createElement("div");
        card.className = "produto-card";

        card.innerHTML = `
          <img src="${imagemUrl}" alt="${nome}" />
          <h3>${nome}</h3>
          <p class="preco">R$ ${preco}</p>
          <p class="quantidade">Qtd: ${quantidade}</p>
          <button onclick="editarProduto(this)">Editar</button>
          <button onclick="removerProduto(this)">Remover</button>
        `;

        container.appendChild(card);
      }
    }

    form.reset();
    fecharModal("modalAdicionarProduto");
  });
});

function removerProduto(button) {
  const card = button.parentElement;
  card.remove();
}

function editarProduto(button) {
  const card = button.parentElement;

  const nome = card.querySelector("h3").textContent;
  const preco = card.querySelector("p.preco").textContent.replace("R$ ", "");
  const imagem = card.querySelector("img").src;
  const quantidade = card.querySelector("p.quantidade")?.textContent.replace("Qtd: ", "") || 1;

  // Preenche os campos do modal
  document.getElementById("imagemUrl").value = imagem;
  document.getElementById("nomeProduto").value = nome;
  document.getElementById("precoProduto").value = preco;
  document.getElementById("quantidadeProduto").value = quantidade;

  // Define o card sendo editado
  cardEditando = card;

  // Abre o modal
  abrirModal("modalAdicionarProduto");

  // Altera o texto do botão
  document.getElementById("btnSalvar").textContent = "Salvar Edição";
}