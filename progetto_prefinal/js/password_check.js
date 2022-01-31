const REGEX_PASSWORD = /^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/;

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
    
    return checkRegex(password, REGEX_PASSWORD) &&
        checkPassword(password,rpassword);
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
        return false;
    }
    rp.classList.remove("error");
    return true;
}


document.getElementById("form_modifica_password").addEventListener('submit', event => {
    if(!checkSignUp()){
        console.log('Form submission cancelled.');
        event.preventDefault();
    }
  });
