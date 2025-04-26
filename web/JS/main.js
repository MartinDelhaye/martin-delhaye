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
let groupH1, textH1, lightH1, pivotLight;

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
    // "/JS/three/fonts/coolveticaRegular.json",
    "/JS/three/fonts/helvetiker_regular.typeface.json",
    function (font) {
      const textGeometry = new TextGeometry(textH1, {
        font: font,
        size: 1,
        depth: 0.2,
        curveSegments: 12,
        bevelEnabled: true, bevelThickness: 0.1, bevelSize: 0.005, bevelOffset: 0, bevelSegments: 3,
      });
      const textMaterial = new THREE.MeshToonMaterial({ color: colorWhite });
      const textMesh = new THREE.Mesh(textGeometry, textMaterial);
      textGeometry.center();
      // Courber la géométrie
      const radius = -10;
      const positionAttribute = textGeometry.attributes.position;
      for (let i = 0; i < positionAttribute.count; i++) {
        const x = positionAttribute.getX(i);
        const y = positionAttribute.getY(i);
        const z = positionAttribute.getZ(i);
        const angle = x / radius;
        const newX = Math.sin(angle) * radius;
        const newZ = Math.cos(angle) * radius - radius;
        positionAttribute.setX(i, newX);
        positionAttribute.setZ(i, newZ);
      }
      textMesh.rotation.x = -Math.PI;
      textMesh.rotation.y = Math.PI;
      // scene.add(textMesh);
      groupH1.add(textMesh);
    }
  );

  // ------------ Lumière principale ------------
  lightprincpale = new THREE.AmbientLight(colorWhite, 3);
  scene.add(lightprincpale);

  // ------------ Lumière H1 ------------
  // pivotLight = new THREE.Object3D();
  // groupH1.add(pivotLight);
  // lightH1 = new THREE.PointLight(colorSecond, 10, 5);
  // lightH1.position.set(0, 0, -2);
  // pivotLight.add(lightH1);

  // addHelper();
  animate();
}

// ------------ Animation loop ------------
function animate() {
  if (pivotLight) {
    pivotLight.rotation.y += 0.03; // tourne autour de Y
    pivotLight.rotation.x = Math.sin(Date.now() * 0.001) * 0.2;
  }
  requestAnimationFrame(animate);
  renderer.render(scene, camera);
}

// ------------ Helper ------------
function addHelper() {
  const axesHelper = new THREE.AxesHelper(5);
  scene.add(axesHelper);
  if (lightH1) {
    const pointLightHelper = new THREE.PointLightHelper(lightH1, 0.5);
    scene.add(pointLightHelper);
  }
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
