const heart1 = document.getElementById("favHeart1");
const heart2 = document.getElementById("favHeart2");
const button = document.getElementById("buttonLikeText");

button.addEventListener("click", function () {
    if (heart1.classList.contains("liked")) {
        heart1.classList.remove("liked");
        heart2.style.display = "none";
        heart1.style.display = "initial";
        button.innerText = "Tolto dai Preferiti";
      } else {
        heart1.classList.add("liked");
        heart2.style.display = "initial";
        heart1.style.display = "none";
        button.innerText = "Aggiunto ai Preferiti";
      }
});
