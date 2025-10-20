const codeInput = document.getElementById("code-input");
codeInput.addEventListener('input', () => {
    codeInput.value = codeInput.value.toUpperCase();
});