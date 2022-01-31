const REGEX_SQL = /(XOR)|(SELECT)|(DELETE)|(INSERT)|(DROP)|(TABLE)|(VALUES)|(FROM)|(" OR ""=")|(OR 1=1)|(1=1)|(;)|(--)|(>)|(<)|(\/)|(<!--)|(-->)|(\*)|(\/\*)/;
window.onload = function() {
    items = [
        "username",
        "password",
    ];
    items.forEach(function(item) {
        document.getElementById(item).addEventListener("focus", checkLogIn);
    });
}

function checkLogIn() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");

    return checkRegex(username, REGEX_SQL) &&
        checkRegex(password, REGEX_SQL);
}

function checkRegex(item, regex) {
    if (regex.test(item.value)) {
        item.classList.add("error");
        document.getElementById("errore").innerHTML = "Input non validi";
        return false;
    }
    item.classList.remove("error");
    document.getElementById("errore").innerHTML = "";
    return true;
}

document.getElementById("login_form").addEventListener('submit', event => {
    if(!checkLogIn()){
        console.log('Form submission cancelled.');
        event.preventDefault();
    }   
});
