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
let accueilShaderMaterial, accueilPlane;
let mouse;
let uZoom;
let zoomOperation = 0.01;

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

    createBackgroundShader();

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

// ------------------------ Fonction pour créer le fond shader ------------------------
function createBackgroundShader() {
    mouse = new THREE.Vector2(0.5, 0.5); // centrer la souris au début

    window.addEventListener('mousemove', (event) => {
        mouse.x = 1.0 -(event.clientX / window.innerWidth);
        mouse.y =  (event.clientY / window.innerHeight); // [-1, 1] inversé Y
    });

    const colorMainVec3 = hexToVec3(colorMain);
    const colorSecondVec3 = hexToVec3(colorSecond);

    // Uniforms
    uZoom = 10.0;
    const uniforms = {
        iTime: { value: 0 },
        iResolution: { value: new THREE.Vector3(accueilWidth, accueilHeight, 1) },
        iMouse: { value : mouse},
        colMain: { value: colorMainVec3 },
        colSecond: { value: colorSecondVec3 },
        uZoom: { value: uZoom },
        uTimeScale: { value: 2.0 },
        uOrbitSpeed: { value: 3.0 },
    };

    // Shader Material
    accueilShaderMaterial = new THREE.ShaderMaterial({
        uniforms: uniforms,
        vertexShader: document.getElementById('backgroundShaderVertex').textContent,
        fragmentShader: document.getElementById('backgroundShaderFragment').textContent,
    });
    
    // Plane
   // Calcul dynamique
    const planeHeight = 25; // tu choisis une hauteur "fixe" par exemple
    const planeWidth = planeHeight * accueilRatio; // largeur proportionnelle

    accueilPlane = new THREE.Mesh(
        new THREE.PlaneGeometry(planeWidth, planeHeight),
        accueilShaderMaterial
    );
   
    accueilPlane.material.depthWrite = false;
    scene.add(accueilPlane);
}
function hexToVec3(hex) {
    hex = hex.replace('#', '');
    const bigint = parseInt(hex, 16);
    const r = ((bigint >> 16) & 255) / 255;
    const g = ((bigint >> 8) & 255) / 255;
    const b = (bigint & 255) / 255;
    return new THREE.Vector3(r, g, b);
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
    // Update du shader
    if (accueilShaderMaterial) {
        accueilShaderMaterial.uniforms.iTime.value = performance.now() * 0.001;
    }

    if (uZoom){
        console.log(zoomOperation);
        uZoom += zoomOperation;
        if (uZoom > 10.0) {
            zoomOperation = -Math.abs(zoomOperation);
        }
        if (uZoom < 9.0) {
            zoomOperation = Math.abs(zoomOperation);
        }
        accueilShaderMaterial.uniforms.uZoom.value = uZoom;
    }

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

    const planeHeight = 25;
    const planeWidth = planeHeight * accueilRatio;
    accueilPlane.geometry.dispose(); // Important de libérer l'ancienne mémoire
    accueilPlane.geometry = new THREE.PlaneGeometry(planeWidth, planeHeight);
    if (accueilShaderMaterial) {
        accueilShaderMaterial.uniforms.iResolution.value.set(accueilWidth, accueilHeight, 1);
    }
}

window.addEventListener("resize", onWindowResize);
window.addEventListener("DOMContentLoaded", init);

