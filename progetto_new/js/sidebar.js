function overlay(isShow){
    var elm = document.getElementById('overlay')
    if (isShow) {
      elm.style.display = 'block';
    } else {
      elm.style.display = 'none';
    }
  }
  
  function openNav() {
    overlay(true);
      document.getElementById('sidebar').style.width="15em";
      document.getElementById('menuButton').src="../media/menu_remove.svg";
  }
  
  function closeNav() {
    overlay(false);
      document.getElementById('sidebar').style.width="0";
      document.getElementById('menuButton').src="../media/menu_add.svg";
  }

  //Modifiche al JS sidebar fatte il 21-01-22
  //Aggiunto Overlay quando si apre la sidebar, si disattiva quando si schiaccia in qualsiasi altra parte
  //BUG: quando si riclicca il bottone per la chiusura, la sidebar non si chiude e rimane aperta