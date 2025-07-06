const leftbararea = document.getElementById('leftbarArea');
const leftbar = document.getElementById('leftbar');
const content = document.getElementById('content');
const robloxLogo = document.getElementById('robloxLogo')
const nomes = ["LUCAS CAMPELO","KAUÊ RIBEIRO SANTOS","JOHN DOE"]; //vamo te q bota esses coiso no mysql ne po
const usuarios = ["SYMMETRICAIZ","JPAOMQJS","JOHN DOE"];

const verification = (nome) => nomes.includes(nome);
const login = () => alert('Não temos LOGIN ainda! Sorry!');
let leftbaropen = true;

leftbararea.onclick = function(){
    switch(leftbaropen) {
        case true:
            leftbaropen = false;
            leftbar.style.margin = "0px 0px 0px -180px";
            content.style.margin = "40px 0px 0px 0px";
            break
        case false:
            leftbaropen = true;
            leftbar.style.margin = "0px";
            content.style.margin = "40px 0px 0px 180px";
            break
    }
};
if (document.getElementById('inscriptionTable')) {
    function UpdateInscriptionTable () {
    const inscriptionTable = document.getElementById('inscriptionTable'); 
    conteudo = `<tr><th>NOME</th><th>USUÁRIO</td></tr>`;
	for (i=0;i<nomes.length;i++){
		conteudo += "<tr>";
        conteudo += `<td>${nomes[i]}</td>`;
        conteudo += `<td>${usuarios[i]}</td>`;
		conteudo += "</tr>";
	}	
    inscriptionTable.innerHTML=conteudo;
    }
    UpdateInscriptionTable()
}


function Verification () {
    const verificationName = document.getElementById('verificationName');
    let nome = verificationName.value.toUpperCase();
    if (nome.trim()) {
        const verificationResult = document.getElementById('verificationResult');
        verificationResult.classList.add('bounce');
        switch(verification(nome)) {
            case true:
                verificationResult.innerText = 'Está listado!';
                break;
            case false:
                verificationResult.innerText = `"${nome}" não está listado!`;
                break;
        }
        verificationResult.onanimationend = () => verificationResult.classList.remove('bounce');
    }
}

const mediaQuery = window.matchMedia("(max-width: 900px)");

function atualizarTexto(e) {
    robloxLogo.innerText = e.matches ? "O" : "ROBLOX";
}

mediaQuery.addEventListener("change", atualizarTexto);
atualizarTexto(mediaQuery); // chamar inicialmente
