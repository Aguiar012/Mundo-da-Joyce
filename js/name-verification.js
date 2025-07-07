function Verification() {
  const input = document.getElementById('verificationName');
  const nomeDigitado = input.value.trim().toUpperCase();
  const tabela = document.getElementById('inscriptionTable');
  const linhas = tabela.getElementsByTagName('tr');
  const resultado = document.getElementById('verificationResult');
  let encontrado = false;

  for (let i = 1; i < linhas.length; i++) {
    const nomeNaTabela = linhas[i].cells[0].textContent.trim().toUpperCase();
    if (nomeDigitado === nomeNaTabela) {
      encontrado = true;
      break;
    }
  }

  resultado.classList.add('bounce');
  resultado.innerText = encontrado
    ? 'Está listado!'
    : `"${nomeDigitado}" não está listado!`;

  resultado.onanimationend = () => resultado.classList.remove('bounce');
}