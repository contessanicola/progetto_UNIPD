const heart1 = document.getElementById("favHeart1");
const heart2 = document.getElementById("favHeart2");
const buttonText = document.getElementById("buttonLikeText");
const button = document.getElementById("buttonLike");

button.addEventListener("click", function () {
    if (heart1.classList.contains("liked")) {
        heart1.classList.remove("liked");
        heart2.style.display = "none";
        heart1.style.display = "initial";
        buttonText.innerText = "Aggiungi ai Preferiti";
      } else {
        heart1.classList.add("liked");
        heart2.style.display = "initial";
        heart1.style.display = "none";
        buttonText.innerText = "Preferito";
      }
});
