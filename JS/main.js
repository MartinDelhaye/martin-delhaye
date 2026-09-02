// ------------------------ Importation ------------------------
import { initCarrousels } from "./carousel.js";
import { initMenuBurger } from "./menuBurger.js";

// ------------------------ Initialisation ------------------------
window.addEventListener("DOMContentLoaded", async () => {
    initCarrousels();
    initMenuBurger();
});
