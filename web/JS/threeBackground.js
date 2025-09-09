import * as THREE from "/JS/three/three.module.js";

// ------------------------ Variables privées ------------------------
let camera, scene, renderer;
let body, bodyWidth, bodyHeight, bodyRatio;
let bodyShaderMaterial, bodyPlane;
let mouse;
let uZoom;

// ------------------------ Initialisation ------------------------
function initBackground() {
    recupInfoDOM();
    initThreeJS();
    window.addEventListener("resize", onWindowResize);
}

function recupInfoDOM() {
    body = document.querySelector("body");
}

function initThreeJS() {
    scene = new THREE.Scene();
    bodyWidth = body.offsetWidth;
    bodyHeight = body.offsetHeight;
    bodyRatio = bodyWidth / bodyHeight;

    camera = new THREE.PerspectiveCamera(230, bodyRatio, 1, 1000);
    camera.position.z = 5;
    camera.lookAt(new THREE.Vector3(0, 0, 0));

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(body.offsetWidth, body.offsetHeight);
    let rendererDomElement = renderer.domElement;
    rendererDomElement.style.position = "absolute";
    rendererDomElement.style.top = "0";
    rendererDomElement.style.left = "0";
    rendererDomElement.style.zIndex = "-1";
    body.appendChild(rendererDomElement);

    createBackgroundShader();
    animate();
}

// ------------------------ Shader ------------------------
function createBackgroundShader() {
    mouse = new THREE.Vector2(0.5, 0.5);

    window.addEventListener('mousemove', (event) => {
        mouse.x = 1.0 - (event.clientX / window.innerWidth);
        mouse.y = (event.clientY / window.innerHeight);
    });

    const rootStyles = getComputedStyle(document.documentElement);
    const colorMain = rootStyles.getPropertyValue('--color-main').trim();
    const colorSecond = rootStyles.getPropertyValue('--color-second').trim();

    const colorMainVec3 = hexToVec3(colorMain);
    const colorSecondVec3 = hexToVec3(colorSecond);

    uZoom = 10.0;
    const uniforms = {
        iTime: { value: 0 },
        iResolution: { value: new THREE.Vector3(bodyWidth, bodyHeight, 1) },
        iMouse: { value: mouse },
        colMain: { value: colorMainVec3 },
        colSecond: { value: colorSecondVec3 },
        uZoom: { value: uZoom },
        uTimeScale: { value: 2.0 },
        uOrbitSpeed: { value: 3.0 },
    };

    bodyShaderMaterial = new THREE.ShaderMaterial({
        uniforms: uniforms,
        vertexShader: document.getElementById('backgroundShaderVertex').textContent,
        fragmentShader: document.getElementById('backgroundShaderFragment').textContent,
    });

    const planeHeight = 25;
    const planeWidth = planeHeight * bodyRatio;

    bodyPlane = new THREE.Mesh(
        new THREE.PlaneGeometry(planeWidth, planeHeight),
        bodyShaderMaterial
    );
    bodyPlane.material.depthWrite = false;
    scene.add(bodyPlane);
}

function hexToVec3(hex) {
    hex = hex.replace('#', '');
    const bigint = parseInt(hex, 16);
    const r = ((bigint >> 16) & 255) / 255;
    const g = ((bigint >> 8) & 255) / 255;
    const b = (bigint & 255) / 255;
    return new THREE.Vector3(r, g, b);
}

// ------------------------ Animation ------------------------
function animate() {
    requestAnimationFrame(animate);
    if (bodyShaderMaterial) {
        bodyShaderMaterial.uniforms.iTime.value = performance.now() * 0.001;
    }
    renderer.render(scene, camera);
}

// ------------------------ Resize ------------------------
function onWindowResize() {
    bodyWidth = body.offsetWidth;
    bodyHeight = body.offsetHeight;
    bodyRatio = bodyWidth / bodyHeight;
    camera.aspect = bodyRatio;
    camera.updateProjectionMatrix();
    renderer.setSize(bodyWidth, bodyHeight);

    const planeHeight = 25;
    const planeWidth = planeHeight * bodyRatio;
    bodyPlane.geometry.dispose();
    bodyPlane.geometry = new THREE.PlaneGeometry(planeWidth, planeHeight);

    if (bodyShaderMaterial) {
        bodyShaderMaterial.uniforms.iResolution.value.set(bodyWidth, bodyHeight, 1);
    }
}

export { initBackground };
