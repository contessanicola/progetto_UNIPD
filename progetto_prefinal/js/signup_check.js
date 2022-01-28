const REGEX_USERNAME = /^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/;
const REGEX_PASSWORD = /^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/;
const REGEX_NOME_COGNOME = /^[a-zA-Z]{3,30}$/;
const REGEX_EMAIL = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
const REGEX_TELEFONO = /^[0-9]{10}$/;

window.onload = function() {
    if (document.getElementById("signup_form") != null) {
        items = [
            "username",
            "password",
            "nome",
            "cognome",
            "email",
            "numero_telefono"
        ];
        items.forEach(function(item) {
            console.log(item)
            document.getElementById(item).addEventListener("focus", checkSignUp);
        });
    }
}

function checkSignUp() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var rpassword = document.getElementById("rpassword");
    var nome = document.getElementById("nome");
    var cognome = document.getElementById("cognome");
    var email = document.getElementById("email");
    var telefono = document.getElementById("numero_telefono");

    
    return checkRegex(username, REGEX_USERNAME) &&
        checkRegex(password, REGEX_PASSWORD) &&
        checkPassword(password,rpassword) &&
        checkRegex(nome, REGEX_NOME_COGNOME) &&
        checkRegex(cognome, REGEX_NOME_COGNOME) &&
        checkRegex(email, REGEX_EMAIL) &&
        checkRegex(telefono, REGEX_TELEFONO);
}

function checkRegex(item, regex) {
    if (!item.value == '' && !regex.test(item.value)) {
        item.classList.add("error");
        return false;
    }
    item.classList.remove("error");
    return true;
}

function checkPassword(p,rp){
    if (!(p.value === rp.value)) {
        p.classList.add("error");
        rp.classList.add("error");
        return false;
    }
    p.classList.remove("error");
    rp.classList.remove("error");
    return true;
}


document.getElementById("signup_form").addEventListener('submit', event => {
    console.log("click")
    if(!checkSignUp()){
        console.log('Form submission cancelled.');
        event.preventDefault();
    }
  });
