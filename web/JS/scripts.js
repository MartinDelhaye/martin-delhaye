// ------------------------ Variable Globale ------------------------

// Menu Burger
let menuNav;
let menuBurger;
let etatNav = false;

// Carrousel
let index = 0;
let tabCarrouselImage = [];
let carrouselImage;
let etatActifDefilement = "auto";
let buttonPre;
let buttonPau;
let buttonSui;
let defilAuto;
let divDiapo;



// ------------------------ Fonction ------------------------
// Menu Burger
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
        // Activer le mode menu burger
        menuBurger.style.display = "block";
        menuBurger.innerHTML = "&#9776;";
        if (!menuBurger.onclick) {
            menuBurger.addEventListener('click', modifEtatNav);
        }

        listePage = document.querySelectorAll("#menuNav a");
        Array.from(listePage).forEach(element => {
            if (!element.onclick) {
                element.addEventListener('click', modifEtatNav);
            }
        });

        if (!etatNav) {
            menuNav.style.display = "none";
        }
    } else {
        // Mode desktop : réinitialise les styles
        menuNav.style.display = "flex";
        menuBurger.style.display = "none"; 
        etatNav = false; 
    }
}



// Carrousel 
// Fonction pour faire défiler les diapos qui prend en paramêtre un nombre qui définit de combien  on se déplace 
function defilementDiapo(bouge) {
    // On incrémente l'index en lui ajoutant "bouge", de plus si il atteint 5 ou -1 ou repart respectivement à 0 et 4s
    index += bouge;
    if (index >= tabCarrouselImage.length) {
        index = 0;
    }
    else if (index < 0) {
        index = tabCarrouselImage.length - 1;
    }
    carrouselImage.src = tabCarrouselImage[index];
}

// fonction qui change l'état entre défilement automatique et manuel
function changeEtatDiapo() {
    switch (etatActifDefilement) {
        case "auto":
            buttonPau.value = "Défilement automatique";
            etatActifDefilement = "pause";
            buttonPre.style.display = "block";
            buttonSui.style.display = "block";
            clearInterval(defilAuto);
            break;
        case "pause":
            buttonPau.value = "Pause";
            etatActifDefilement = "auto";
            buttonPre.style.display = "none";
            buttonSui.style.display = "none";
            defilAuto = setInterval(() => defilementDiapo(1), 3000);
            break;
        default:
            console.log("Il y a une erreur sur l'état de défilement");
            break;
    }
}





// ------------------------ Fonction d'initialisation ------------------------
function init() {   
    console.log("init"+window.location.pathname);

    //Menu Burger
    if(document.getElementById("menuNav")){
        initMenuBurger();
        window.addEventListener("resize", initMenuBurger);

    }

    // Carrousel
    divDiapo = document.getElementById("diapo");
    if (divDiapo !== null) {
        listeUrlProjet = document.getElementsByClassName("carrousel-url");
        carrouselImage = document.getElementById("carrousel-image");
        if (listeUrlProjet.length >0) {
            buttonPau = document.getElementById("carrousel-Pause");
            buttonPre = document.getElementById("carrousel-precedent");
            buttonSui = document.getElementById("carrousel-suivant");

            buttonPau.style.display = "flex";
            tabCarrouselImage[0] = carrouselImage.src;

            Array.from(listeUrlProjet).forEach(element => {
                tabCarrouselImage.push(element.textContent.trim());
            });
            console.log(listeUrlProjet);

            defilAuto = setInterval(() => defilementDiapo(1), 3000);
            buttonPau.addEventListener('click', changeEtatDiapo);
            buttonPre.addEventListener("click", () => defilementDiapo(-1));
            buttonSui.addEventListener("click", () => defilementDiapo(1));
        }else{
            carrouselImage.style.height = "auto";
        }
    }

    // Bouton retour en haut de page
    const scrollReturnTop = document.getElementById("returnTop");
    if(scrollReturnTop !== null){
        // Gestionnaire de scroll
        window.addEventListener("scroll", () => {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

            if (scrollTop > 200) {
                scrollReturnTop.style.opacity = "1"; // Apparition en douceur
                scrollReturnTop.style.pointerEvents = "auto"; // Activé au hover/clic
            } else {
                scrollReturnTop.style.opacity = "0"; // Disparition en douceur
                scrollReturnTop.style.pointerEvents = "none"; // Désactivé
            }
        });
    }

    

}

// Chargement de la page
window.addEventListener("load", init);
