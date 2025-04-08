// Obtém os pedais do LocalStorage ou inicia um array vazio
let pedais = JSON.parse(localStorage.getItem("pedais")) || [];

// Exibe os pedais na tela
function carregarPedais() {
  const container = document.getElementById("pedais-container");
  container.innerHTML = pedais
    .map(
      (pedal, index) => `
    <div class="pedal">
      <img src="${pedal.imagem}" alt="${pedal.nome}">
      <h3>${pedal.nome}</h3>
      <p><strong>Marca:</strong> ${pedal.marca}</p>
      <p><strong>Preço:</strong> R$${pedal.preco}</p>
      <button onclick="editarPedal(${index})">Editar</button>
      <button onclick="deletarPedal(${index})">Excluir</button>
    </div>
  `
    )
    .join("");
}

// Salvar ou atualizar um pedal
function salvarPedal() {
  const id = document.getElementById("pedal-id").value;
  const novoPedal = {
    nome: document.getElementById("nome").value,
    marca: document.getElementById("marca").value,
    preco: document.getElementById("preco").value,
    imagem: document.getElementById("imagem").value,
    descricao: document.getElementById("descricao").value,
  };

  if (id) {
    pedais[id] = novoPedal; // Atualiza o pedal existente
  } else {
    pedais.push(novoPedal); // Adiciona um novo pedal
  }

  localStorage.setItem("pedais", JSON.stringify(pedais));
  document.getElementById("formulario").style.display = "none";
  carregarPedais();
}

// Excluir um pedal
function deletarPedal(index) {
  pedais.splice(index, 1);
  localStorage.setItem("pedais", JSON.stringify(pedais));
  carregarPedais();
}

// Preenche o formulário para edição
function editarPedal(index) {
  document.getElementById("pedal-id").value = index;
  document.getElementById("nome").value = pedais[index].nome;
  document.getElementById("marca").value = pedais[index].marca;
  document.getElementById("preco").value = pedais[index].preco;
  document.getElementById("imagem").value = pedais[index].imagem;
  document.getElementById("descricao").value = pedais[index].descricao;
  document.getElementById("formulario").style.display = "block";
}

// Mostra o formulário para adicionar um novo pedal
function mostrarFormulario() {
  document.getElementById("pedal-id").value = "";
  document.getElementById("formulario").style.display = "block";
}

// Carrega os pedais ao iniciar
carregarPedais();
