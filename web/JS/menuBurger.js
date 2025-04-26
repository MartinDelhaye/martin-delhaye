// ------------------------ Variable Globale ------------------------
let menuNav;
let menuBurger;
let etatNav = false;

// ------------------------ Fonction ------------------------
function modifEtatNav() {
    if (etatNav == false) {
        menuNav.style.display = "flex";
        menuBurger.innerHTML = "&times;";
        etatNav = true;
    } else {
        menuNav.style.display = "none";
        menuBurger.innerHTML = "&#9776;";
        etatNav = false;
    }
}

function initMenuBurger() {
    menuNav = document.getElementById('menuNav');
    menuBurger = document.getElementById('menuBurger');
    if (window.innerWidth < 768) {
        // Mode mobile
        menuBurger.style.display = "block";
        menuBurger.innerHTML = "&#9776;";
        if (!menuBurger.onclick) {
            menuBurger.addEventListener('click', modifEtatNav);
        }
        let listePage = document.querySelectorAll("#menuNav li");
        Array.from(listePage).forEach(element => {
            if (!element.onclick) {
                element.addEventListener('click', modifEtatNav);
            }
        });
        if (!etatNav) {
            menuNav.style.display = "none";
        }
    } else {
        // Mode desktop
        menuNav.style.display = "flex";
        menuBurger.style.display = "none"; 
        etatNav = false; 
    }
}

export { initMenuBurger };