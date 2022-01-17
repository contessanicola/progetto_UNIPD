var sidebar = document.getElementById("sidebar");
var menu = document.getElementById("menuButton");

menu.addEventListener("click", function() {
    if (sidebar.classList.contains("hide")) {
        sidebar.classList.remove("hide");
        menu.src = "../media/menu_remove.svg";

    } else {
        sidebar.classList.add("hide");
        menu.src = "../media/menu_add.svg";
    }

});