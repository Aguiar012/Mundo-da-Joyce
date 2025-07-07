document.addEventListener("DOMContentLoaded", () => {
  const div = document.getElementById("frase");
  if (!div) return;

  fetch("mensagem-gpt.php")
    .then(res => res.json())
    .then(data => {
      if (data.mensagem) {
        div.innerText = data.mensagem;
      } else {
        div.innerText = data.erro || "Nenhuma resposta recebida.";
      }
    })
    .catch(() => {
      div.innerText = "Erro ao obter mensagem.";
    });
});