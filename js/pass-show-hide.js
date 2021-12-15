const pswField = document.getElementById("Password"),
pswFieldVerify = document.getElementById("PasswordVerify"),
toggleBtn = document.querySelector(".field i");

toggleBtn.onclick = () => {
    if(pswField.type === "password"){
        pswField.type = "text";
        pswFieldVerify.type = "text";
        toggleBtn.classList.add("active");
    }
    else{
        pswField.type = "password";
        pswFieldVerify.type = "password";
        toggleBtn.classList.remove("active");
    }
}
