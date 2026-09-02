// Carrousel scopé par projet : chaque .projet-carrousel gère son propre
// index actif, indépendamment des autres (contrairement à l'ancienne version
// qui utilisait des ID globaux #diapo/#Precedent/#Suivant en supposant
// qu'un seul carrousel était visible à la fois).

function initCarrousels() {
    document.querySelectorAll("[data-carrousel]").forEach((carrousel) => {
        const slides = carrousel.querySelectorAll(".carrousel-slide");

        // Une seule image : pas besoin de flèches ni d'écouteurs.
        if (slides.length <= 1) return;

        let index = 0;

        function afficherSlide(nouvelIndex) {
            slides[index].classList.remove("active");
            index = (nouvelIndex + slides.length) % slides.length;
            slides[index].classList.add("active");
            carrousel.dataset.indexActif = index;
        }

        const boutonPrecedent = carrousel.querySelector("[data-carrousel-prev]");
        const boutonSuivant = carrousel.querySelector("[data-carrousel-next]");

        boutonPrecedent?.addEventListener("click", () => afficherSlide(index - 1));
        boutonSuivant?.addEventListener("click", () => afficherSlide(index + 1));
    });
}

export { initCarrousels };
