const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault();
}

continueBtn.onclick = () => {
    if(errorText.textContent != "") {
        errorText.style.display = "block";
    } else {
        errorText.style.display = "none";
    }
}


