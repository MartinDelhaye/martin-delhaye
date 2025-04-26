// ------------------------ Importation ------------------------
import { initMenuBurger } from "/JS/menuBurger.js";
import * as THREE from "/JS/three/three.module.js";
import { FontLoader } from "/JS/three/loaders/FontLoader.js";
import { TextGeometry } from "/JS/three/geometries/TextGeometry.js";

// ------------------------ Variable Globale ------------------------
let camera, scene, renderer;
let accueil, accueilWidth, accueilHeight, accueilRatio;
let colorMain, colorSecond, colorBlack, colorWhite;
let lightprincpale;
let groupH1, textH1, textH1Radius, textGeometryH1;

function init() {
    recupInfoDOM();
    initMenuBurger();
    window.addEventListener("resize", initMenuBurger);
    initThreeJS();
}

function recupInfoDOM() {
    const rootStyles = getComputedStyle(document.documentElement);
    colorMain = rootStyles.getPropertyValue('--color-main').trim();
    colorSecond = rootStyles.getPropertyValue('--color-second').trim();
    colorBlack = rootStyles.getPropertyValue('--color-black').trim();
    colorWhite = rootStyles.getPropertyValue('--color-white').trim();
    textH1 = document.querySelector("h1").textContent;
    accueil = document.getElementById("accueil");
}

function initThreeJS() {
    scene = new THREE.Scene();
    accueilWidth = accueil.clientWidth;
    accueilHeight = accueil.clientHeight;
    accueilRatio = accueilWidth / accueilHeight;

    camera = new THREE.PerspectiveCamera(230, accueilRatio, 1, 1000);
    camera.position.z = 5;
    camera.lookAt(new THREE.Vector3(0, 0, 0));

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(accueil.clientWidth, accueil.clientHeight);
    let rendererDomElement = renderer.domElement;
    rendererDomElement.style.position = "absolute";
    rendererDomElement.style.top = "0";
    rendererDomElement.style.left = "0";
    rendererDomElement.style.zIndex = "-1";
    accueil.appendChild(rendererDomElement);

    groupH1 = new THREE.Group();
    scene.add(groupH1);
    // ------------ Texte ------------
    const loader = new FontLoader();
    loader.load(
        "/JS/three/fonts/helvetiker_regular.typeface.json",
        function (font) {
            textGeometryH1 = new TextGeometry(textH1, {
                font: font,
                size: 1,
                depth: 0.2,
                curveSegments: 12,
                bevelEnabled: true, bevelThickness: 0.1, bevelSize: 0.005, bevelOffset: 0, bevelSegments: 3,
            });
            const textMaterial = new THREE.MeshToonMaterial({ color: colorWhite });
            const textMeshH1 = new THREE.Mesh(textGeometryH1, textMaterial);
            textGeometryH1.center();
            // Courber la géométrie
            textH1Radius = -20;
            courbText(textGeometryH1, textH1Radius);
            
            textMeshH1.rotation.x = -Math.PI;
            textMeshH1.rotation.y = Math.PI;
            groupH1.add(textMeshH1);
        }
    );
    // ------------ Lumière principale ------------
    lightprincpale = new THREE.AmbientLight(colorWhite, 3);
    scene.add(lightprincpale);
    // addHelper();
    animate();
}

function courbText(textGeometry, radius ) {
    const positionAttribute = textGeometry.attributes.position;
    for (let i = 0; i < positionAttribute.count; i++) {
        const x = positionAttribute.getX(i);
        const angle = x / radius;
        const newX = Math.sin(angle) * radius;
        const newZ = Math.cos(angle) * radius - radius;
        positionAttribute.setX(i, newX);
        positionAttribute.setZ(i, newZ);
    }
    positionAttribute.needsUpdate = true;
}

// ------------ Animation loop ------------
function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
}

// ------------ Helper ------------
function addHelper() {
    const axesHelper = new THREE.AxesHelper(5);
    scene.add(axesHelper);
}

function onWindowResize() {
    accueilWidth = accueil.clientWidth;
    accueilHeight = accueil.clientHeight;
    accueilRatio = accueilWidth / accueilHeight;
    camera.aspect = accueilRatio;
    camera.updateProjectionMatrix();
    renderer.setSize(accueilWidth, accueilHeight);
}

window.addEventListener("resize", onWindowResize);
window.addEventListener("DOMContentLoaded", init);
