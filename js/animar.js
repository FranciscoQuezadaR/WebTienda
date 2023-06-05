let animadoDI = document.querySelectorAll(".animadoDI");
let animadoID = document.querySelectorAll(".animadoID")

function mostrarScroll() {
    let scrollTop = document.documentElement.scrollTop;
    for (var i = 0; i < animadoDI.length; i++) {
        let alturaAnimado = animadoDI[i].offsetTop;
        if (alturaAnimado - 500 < scrollTop) {
            animadoDI[i].style.opacity = 1;
            animadoDI[i].classList.add("mostrar")
        }
    }
}

function mostrarScroll2() {
    let scrollTop = document.documentElement.scrollTop;
    for (var i = 0; i < animadoID.length; i++) {
        let alturaAnimado = animadoID[i].offsetTop;
        if (alturaAnimado - 500 < scrollTop) {
            animadoID[i].style.opacity = 1;
            animadoID[i].classList.add("mostrar2")
        }
    }
}

window.addEventListener('scroll', mostrarScroll);
window.addEventListener('scroll', mostrarScroll2);