const REGEX_PASSWORD = /^.{0,30}$/;
const REGEX_SQL = /(XOR)|(SELECT)|(DELETE)|(INSERT)|(DROP)|(TABLE)|(VALUES)|(FROM)|(" OR ""=")|(OR 1=1)|(1=1)|(;)|(--)|(>)|(<)|(\/)|(<!--)|(-->)|(\*)|(\/\*)/;

window.onload = function() {
    if (document.getElementById("form_modifica_password") != null) {
        items = [
            "password",            
        ];
        items.forEach(function(item) {
            console.log(item)
            document.getElementById(item).addEventListener("focus", checkSignUp);
        });
    }
}

function checkSignUp() {
    var vecchia_password = document.getElementById("vecchia_password");
    var password = document.getElementById("password");
    var rpassword = document.getElementById("rpassword");
    
    return checkRegexSQL(password, REGEX_SQL) &&
        checkRegexSQL(vecchia_password, REGEX_SQL) &&
        checkRegex(password, REGEX_PASSWORD) &&
        checkPassword(password,rpassword);
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
        console.log(rp);
        rp.classList.add("error");
        document.getElementById("errore").innerHTML = "Password non coincidono";
        return false;
    }
    document.getElementById("errore").innerHTML = "";
    rp.classList.remove("error");
    return true;
}


document.getElementById("form_modifica_password").addEventListener('submit', event => {
    if(!checkSignUp()){
        console.log('Form submission cancelled.');
        event.preventDefault();
    }
  });
