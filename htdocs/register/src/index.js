var password1 = document.getElementById("password1"), password2 = document.getElementById("password2");

function validatePassword(){
    /*
    if(password1.value == "") {
    password1.setCustomValidity("Please Enter a Password");
    }
    else if(password2.value == "") {
        password2.setCustomValidity("Please Enter a Password");
    } // :)
    else if(password1.value != password2.value) {
    password2.setCustomValidity("Passwords Don't Match");
    } else {
    password2.setCustomValidity('');
    }
    */
    if(password1.value != password2.value) {
        password2.setCustomValidity("Passwords Don't Match");
    } else {
        password2.setCustomValidity('');
    }
}

password1.onchange = validatePassword();
password2.onchange = validatePassword();
//password2.onkeyup = validatePassword();