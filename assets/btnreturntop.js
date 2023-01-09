var btnTop = document.getElementById("btnTop");

// Lorsque l'utilisateur fait défiler vers le bas de 20px du haut de la page, afficher le bouton
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btnTop.style.display = "block";
  } else {
    btnTop.style.display = "none";
  }
}

// Lorsque l'utilisateur clique sur le bouton, retourner en haut de la page
function topFunction() {
  document.body.scrollTop = 0; // Pour Safari
  document.documentElement.scrollTop = 0; // Pour Chrome, Firefox, IE et Opera
}
btnTop.addEventListener("click", topFunction);
