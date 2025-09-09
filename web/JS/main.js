// ------------------------ Importation ------------------------
import { initMenuBurger } from "/JS/menuBurger.js";
import { initBackground } from "/JS/threeBackground.js";
import { initProjets } from "/JS/projets.js";

// ------------------------ Initialisation ------------------------
window.addEventListener("DOMContentLoaded", () => {
    initMenuBurger();
    initBackground();
    initProjets();
    window.addEventListener("resize", initMenuBurger);
});
