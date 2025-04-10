  function abrirModal(id) {
    document.getElementById(id).style.display = "block";
  }

  function fecharModal(id) {
    document.getElementById(id).style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target.classList.contains("modal")) {
      event.target.style.display = "none";
    }
  };
