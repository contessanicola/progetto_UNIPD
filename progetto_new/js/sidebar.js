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

  //Modifiche al JS sidebar fatte il 23-01-22
  //Aggiunto Overlay quando si apre la sidebar, si disattiva quando si schiaccia in qualsiasi altra parte
  //BUG: quando si riclicca il bottone per la chiusura, la sidebar non si chiude e rimane aperta
  //aggiunto timeout 200 ms per gestire la chiusura del pulsante menu 