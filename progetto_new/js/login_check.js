const REGEX_USERNAME = /^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/;
const REGEX_PASSWORD = /^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/;

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

    return checkRegex(username, REGEX_USERNAME) &&
        checkRegex(password, REGEX_PASSWORD);
}

function checkRegex(item, regex) {
    if (!item.value == '' && !regex.test(item.value)) {
        console.log(regex.test(item.value));
        return false;
    }
    console.log(regex.test(item.value));
    return true;
}

document.getElementById("login_form").addEventListener('submit', event => {
    if(!checkLogIn()){
        console.log('Form submission cancelled.');
        event.preventDefault();
    }   
});
