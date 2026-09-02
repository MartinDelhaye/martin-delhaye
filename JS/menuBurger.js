function initMenuBurger() {
    const bouton = document.getElementById("menuBurger");
    const nav = document.getElementById("menuNav");

    if (!bouton || !nav) return;

    bouton.addEventListener("click", () => {
        nav.classList.toggle("ouvert");
    });

    // Referme le menu après un clic sur un lien (mobile)
    nav.querySelectorAll("a").forEach((lien) => {
        lien.addEventListener("click", () => nav.classList.remove("ouvert"));
    });
}

export { initMenuBurger };
