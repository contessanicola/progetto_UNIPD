const REGEX_SQL = /(XOR)|(SELECT)|(DELETE)|(INSERT)|(DROP)|(TABLE)|(VALUES)|(FROM)|(" OR ""=")|(OR 1=1)|(1=1)|(;)|(--)|(>)|(<)|(\/)|(<!--)|(-->)|(\*)|(\/\*)/;

window.onload = function() {
    if (document.getElementById("form_modifica_casa") != null) {
        items = [
            "provincia",
            "citta",
            "via",
            "descrizione",
        ];
        items.forEach(function(item) {
            document.getElementById(item).addEventListener("focus", checkSQL);
        });
    }
}

function checkSQL() {
    var provincia = document.getElementById("provincia");
    var citta = document.getElementById("citta");
    var via = document.getElementById("via");
    var descrizione = document.getElementById("descrizione");

    return checkRegexSQL(provincia, REGEX_SQL) &&
    checkRegexSQL(citta, REGEX_SQL) &&
    checkRegexSQL(via, REGEX_SQL) &&
    checkRegexSQL(descrizione, REGEX_SQL);
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

document.getElementById("form_modifica_casa").addEventListener('submit', event => {
    console.log("click")
    if(!checkSQL()){
        console.log('Form submission cancelled.');
        event.preventDefault();
    }
  });
