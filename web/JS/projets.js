// ------------------------ Variables privées ------------------------
let projets;
let id;
let index_MD = 0;
let listeImages = [];
let etatActifDefilement_MD = "auto";
let buttonPre_MD;
let buttonPau_MD;
let buttonSui_MD;
let defilAuto_MD;
let divDiapo;

// ------------------------ Initialisation ------------------------
function initProjets() {
    console.log("----------------------- Init Projets -----------------------");
    projets = document.querySelectorAll(".projet");
    projets.forEach(projet => {
        projet.addEventListener("click", () => {
            id = projet.dataset.id;
            chargerProjet(id);
        });
    });

    divDiapo = document.getElementById("diapo");
    buttonPau_MD = document.getElementById("Pause");
    buttonPre_MD = document.getElementById("Precedent");
    buttonSui_MD = document.getElementById("Suivant");

    buttonPau_MD.addEventListener('click', () => {
        console.log("clic pause");
        changeEtatDiapo_MD();
    });
    buttonPre_MD.addEventListener("click", () => defilementDiapo_MD(-1));
    buttonSui_MD.addEventListener("click", () => defilementDiapo_MD(1));
}

// ------------------------ Carrousel ------------------------
function defilementDiapo_MD(bouge_MD) {
    index_MD += bouge_MD;
    if (index_MD == listeImages.length) index_MD = 0;
    else if (index_MD == -1) index_MD = listeImages.length - 1;
    divDiapo.style.backgroundImage = "url('" + listeImages[index_MD] + "')";
}

function changeEtatDiapo_MD() {
    console.log("Change etat : ");
    switch (etatActifDefilement_MD) {
        case "auto":
            console.log("auto");
            buttonPau_MD.value = "Défilement automatique";
            etatActifDefilement_MD = "pause";
            buttonPre_MD.style.display = "block";
            buttonSui_MD.style.display = "block";
            clearInterval(defilAuto_MD);
            break;
        case "pause":
            console.log("pause");
            buttonPau_MD.value = "Pause";
            etatActifDefilement_MD = "auto";
            buttonPau_MD.style.display = "flex";
            buttonPre_MD.style.display = "none";
            buttonSui_MD.style.display = "none";
            clearInterval(defilAuto_MD);
            defilAuto_MD = setInterval(() => defilementDiapo_MD(1), 1000);
            break;
        default:
            console.log("Erreur état diapo");
            break;
    }
}

// ------------------------ Gestion des projets ------------------------
async function chargerProjet(id) {
    projets = document.querySelectorAll(".projet");
    projets.forEach(projetFocus => {
        if (id != projetFocus.dataset.id) {
            projetFocus.classList.remove("active");
        } else {
            projetFocus.classList.add("active");
        }
    });

    document.getElementById("projet-container").classList.remove("noactive");
    document.getElementById("projet-container").classList.add("active");

    try {
        const response = await fetch(`/PHP/get-projet.php?id_projet=${id}`);
        const data = await response.json();

        if (data.statut === "ok") {
            let project = data.projet;
            let actualTitre = document.getElementById("projet-titre").textContent;

            document.getElementById("projet-titre").textContent = project.titre_projet;
            document.getElementById("projet-description").textContent = project.texte_projet;

            let url = document.getElementById("projet-url");
            url.style.display = project.url_projet ? "flex" : "none";
            if (project.url_projet) url.href = project.url_projet;

            let github = document.getElementById("projet-github");
            github.style.display = project.urlGitHub_projet ? "flex" : "none";
            if (project.urlGitHub_projet) github.href = project.urlGitHub_projet;

            // Carrousel
            listeImages = [project.illustration_projet];
            divDiapo.style.backgroundImage = "url('" + project.illustration_projet + "')";

            if (project.images.length > 1) {
                console.log("Plusieurs images");
                console.log(project.images);
                listeImages.push(project.illustration_projet);
                project.images.forEach(image => {
                    listeImages.push(image["url_image"]);
                });

                etatActifDefilement_MD = "pause";
                changeEtatDiapo_MD();

                // buttonPau_MD.replaceWith(buttonPau_MD.cloneNode(true));
                // buttonPre_MD.replaceWith(buttonPre_MD.cloneNode(true));
                // buttonSui_MD.replaceWith(buttonSui_MD.cloneNode(true));
                
                // buttonPau_MD.addEventListener('click', ()=>{
                //     console.log("clic pause");
                //     changeEtatDiapo_MD();
                // });
                // buttonPre_MD.addEventListener("click", () => defilementDiapo_MD(-1));
                // buttonSui_MD.addEventListener("click", () => defilementDiapo_MD(1));
                buttonPau_MD.style.display = "flex";
            } else {
                console.log("Une seule image");
                buttonPau_MD.style.display = "none";
                buttonPre_MD.style.display = "none";
                buttonSui_MD.style.display = "none";
                clearInterval(defilAuto_MD);
            }

            // Toggle si on clique sur le même projet
            if (actualTitre == project.titre_projet) {
                document.getElementById("projet-container").classList.remove("active");
                document.getElementById("projet-container").classList.add("noactive");
                document.getElementById("projet-titre").textContent = "";
                document.getElementById("projet-description").textContent = "";
                projets.forEach(projetRemove => projetRemove.classList.remove("active"));

                github.style.display = "none";
                url.style.display = "none";
                buttonPau_MD.style.display = "none";
                buttonPre_MD.style.display = "none";
                buttonSui_MD.style.display = "none";
                clearInterval(defilAuto_MD);
                etatActifDefilement_MD = "pause";
                // changeEtatDiapo_MD();
            }
        }
    } catch (err) {
        console.error("Erreur API :", err);
    }
}

export { initProjets };
