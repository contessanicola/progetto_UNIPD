function overlay(isShow){
    var overlay = document.getElementById('overlay')
    if (isShow) {
      overlay.style.display = 'block';
    } else {
      overlay.style.display = 'none';
    }
  }

  function openNav() {
    overlay(true);
    document.getElementById('sidebar').style.width="35em";
    document.getElementById('menuButton').src="../media/menu_remove.svg";
    inhibitOpenMenu = true;
  }
  
  function closeNav() {
    setTimeout(() => {
      overlay(false);
        document.getElementById('sidebar').style.width="0";
        document.getElementById('menuButton').src="../media/menu_add.svg";
    }, 200);
  }

  window.onscroll = function scrollFunction() {
    if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
      document.getElementById("backToTop").classList.remove("hide");
    } else {
      document.getElementById("backToTop").classList.add("hide");
    }
  }