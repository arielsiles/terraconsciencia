let counter1 = 1;
let counter2 = 1;
let counter3 = 1;

let contenido = document.getElementById('cont');
let fnd = document.getElementById('fnd');
let cierre = document.getElementById('btnCerrar');

let cerrarVentanaModal = () => {
    contenido.classList.add('cierreMd');
    setTimeout(() => {
        contenido.classList.remove('close');
        fnd.style.display = 'none';
        cierre.style.display = 'none';
    }, 1);
};
window.addEventListener('click', (e) => (e.target === fnd) && cerrarVentanaModal());

const getData = (section) => {

    const baseURL = window.location.hostname === "localhost"
        ? "http://localhost/terraco/PHP/getData.php"
        : "../PHP/getData.php";
    const xhr = new XMLHttpRequest();

    //xhr.open("GET", "../PHP/getData.php?section=" + section, false);
    xhr.open("GET", baseURL + "?section=" + section, false);
    //xhr.open("GET", "http://localhost/terraco/PHP/getData.php?section=" + section, false);
    xhr.send();
    if (xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);
        data.reverse();
        return data;
    } else {
        return [];
    }
};

/*const getData = async (section) => {
    try {
        // Define la URL según el entorno
        const baseURL = window.location.hostname === "localhost"
            ? "http://localhost/terraco/PHP/getData.php"
            : "../PHP/getData.php";

        // Realiza la solicitud
        const response = await fetch(`${baseURL}?section=${section}`);

        // Verifica si la respuesta es exitosa
        if (response.ok) {
            const data = await response.json();
            return data.reverse();
        } else {
            console.error("Error en la respuesta:", response.status);
            return [];
        }
    } catch (error) {
        console.error("Error en la solicitud:", error);
        return [];
    }
};*/

const createCarousel = (section, carouselId) => {
    const data = getData(section);
    const carousel = document.querySelector("#" + carouselId);
    const carouselInner = carousel.querySelector(".carousel-inner");
    data.forEach((item) => {
        const img = document.createElement("img");
        const newSrc = item.src.replace('../', './');
        img.src = newSrc;
        const pdfLink = document.createElement("a");

        const srcPdf = item.pdf_url.replace('../', './');

        //pdfLink.href = item.pdf_url;
        pdfLink.href = srcPdf;

        console.log("--> " + item.pdf_url);

        pdfLink.textContent = "Descargar";
        const iconElement = document.createElement("i");
        iconElement.classList.add("fas", "fa-arrow-alt-circle-down");
        pdfLink.appendChild(iconElement);

        console.log("==> " + srcPdf);
        console.log("item.pdf_url ==> " + item.pdf_url);

        //pdfLink.download = item.pdf_url;
        pdfLink.download = srcPdf;

        pdfLink.classList.add("descarga");
        const p = document.createElement("p");
        const divInt = document.createElement("div");
        divInt.classList.add("desc");
        p.textContent = item.description;
        const div = document.createElement("div");
        div.classList.add("cajaPb");
        div.appendChild(img);
        div.appendChild(divInt);
        divInt.appendChild(p);
        div.appendChild(pdfLink);
        carouselInner.appendChild(div);
    });
    carouselInner.style.transition = "transform 3s ease-in-out 0s";
    const prevButton = carousel.querySelector(".prev");
    const nextButton = carousel.querySelector(".next");
    let currentIndex = 0;
    prevButton.addEventListener("click", () => {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = data.length - 4;
        }
        carouselInner.style.transform = `translateX(-${currentIndex * 360}px)`;
    });
    nextButton.addEventListener("click", () => {
        currentIndex++;
        if (currentIndex >= data.length - 3) {
            currentIndex = 0;
        }
        carouselInner.style.transform = `translateX(-${currentIndex * 360}px)`;
    });
    setInterval(() => {
        currentIndex++;
        if (currentIndex >= data.length - 3) {
            currentIndex = 0;
        }
        carouselInner.style.transform = `translateX(-${currentIndex * 360}px)`;
    }, 9000);
};
createCarousel("seccionpb1", "carousel1");
createCarousel("seccionpb2", "carousel2");
createCarousel("seccionpb3", "carousel3");

function abreCt() {
    document.getElementById("despCt").style.display = "block";
    document.getElementById('giro').style.transform = "rotate(180deg)";
    document.getElementById('cl').style.zIndex = 0;
}
function cierraCt() {
    document.getElementById("despCt").style.display = "none";
    document.getElementById('giro').style.transform = "rotate(0deg)";
    document.getElementById('cl').style.zIndex = -1;
}

function abreConf() {
    document.getElementById('fndCf').style.display = "block";
}
function cierraConf() {
    document.getElementById('fndCf').style.display = "none";
}
window.onload = function () {
    let randomModal = Math.floor(Math.random() * (6 - 1 + 1)) + 1;
    for (let i = 1; i <= 6; i++) {
        const modal = document.getElementById("m" + i);
        if (modal) {
            if (i === randomModal) {
                modal.style.display = "block";
            } else {
                modal.style.display = "none";
            }
        }
    }
};
