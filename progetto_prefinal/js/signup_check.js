const REGEX_USERNAME = /^.{3,30}$/;
const REGEX_PASSWORD = /^.{3,30}$/;
const REGEX_NOME_COGNOME = /^[a-zA-Z]{3,30}$/;
const REGEX_EMAIL = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
const REGEX_TELEFONO = /^[0-9]{10}$/;
const REGEX_SQL = /(XOR)|(SELECT)|(DELETE)|(INSERT)|(DROP)|(TABLE)|(VALUES)|(FROM)|(" OR ""=")|(OR 1=1)|(1=1)|(;)|(--)|(>)|(<)|(\/)|(<!--)|(-->)|(\*)|(\/\*)/;

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
            document.getElementById(item).addEventListener("focus", checkSQL);
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
        rp.classList.add("error");
        document.getElementById("errore").innerHTML = "Password non coincidono";
        return false;
    }
    rp.classList.remove("error");
    document.getElementById("errore").innerHTML = "";
    return true;
}


function checkSQL() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var nome = document.getElementById("nome");
    var cognome = document.getElementById("cognome");
    var email = document.getElementById("email");
    var telefono = document.getElementById("numero_telefono");

    return checkRegexSQL(username, REGEX_SQL) &&
    checkRegexSQL(password, REGEX_SQL) &&
    checkRegexSQL(nome, REGEX_SQL) &&
    checkRegexSQL(cognome, REGEX_SQL) &&
    checkRegexSQL(email, REGEX_SQL) &&
    checkRegexSQL(telefono, REGEX_SQL);
}

function checkRegexSQL(item, regex) {
    if (regex.test(item.value)) {
        item.classList.add("error");
        document.getElementById("errore").innerHTML = "Input non validi";
        return false;
    }
    item.classList.remove("error");
    document.getElementById("errore").innerHTML = "";
    return true;
}

document.getElementById("signup_form").addEventListener('submit', event => {
    console.log("click")
    if(!checkSignUp() | !checkSQL()){
        console.log('Form submission cancelled.');
        event.preventDefault();
    }
  });
