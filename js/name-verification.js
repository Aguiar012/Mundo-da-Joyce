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
