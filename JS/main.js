// ------------------------ Importation ------------------------
import { gsap } from "gsap";

// ------------------------ Initialisation ------------------------
window.addEventListener("DOMContentLoaded", async () => {
    console.log("DOM fully loaded and parsed");
    gsap.to("#box", { x: 200, duration: 1, backgroundColor: "red" });
});