const robloxLogo = document.getElementById('robloxLogo')

const leftbararea = document.getElementById('leftbarArea');
const leftbar = document.getElementById('leftbar');
const content = document.getElementById('content');

let leftbaropen = true;

// LEFT BAR //
function AbreFecha() {
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
leftbararea.onclick = () => {
    return AbreFecha();
}
// fecha automatico no celular
window.addEventListener('DOMContentLoaded', () => {
    if (window.innerWidth <= 900) {
        AbreFecha();
    }
});

// ROBLOX LOGO //
const mediaQuery = window.matchMedia("(max-width: 900px)");

function atualizarTexto(e) {
    robloxLogo.innerText = e.matches ? "O" : "ROBLOX";
}

mediaQuery.addEventListener("change", atualizarTexto);
mediaQuery.addEventListener("change", AbreFecha);
atualizarTexto(mediaQuery); // chamar inicialmente