import Splide from '@splidejs/splide';

var productViewHeroElement = document.querySelector('.product-view-hero');
if (productViewHeroElement) {
    var productViewHero = new Splide(productViewHeroElement, {
        type        : 'loop',
        arrows      : false,
});

productViewHero.mount();
};

// const productHeader = document.querySelector(".product_header");
// if (productHeader) {
//     let initialPosition = null;
//     let lastScrollTop = 0;
    
//     window.addEventListener("scroll", () => {
//         const currentScrollPos = window.scrollY;
//         const rect = productHeader.getBoundingClientRect();
        
//         // Calcular la posición inicial solo una vez
//         if (initialPosition === null) {
//             initialPosition = rect.top + currentScrollPos;
//             console.log("Posición inicial del product_header: " + initialPosition);
//         }
        
//         // Detectar si estamos desplazándonos hacia abajo o hacia arriba
//         let isScrollingDown = currentScrollPos > lastScrollTop;
        
//         // Agregar la clase sticky-product si el elemento llega al top de la pantalla
//         if (rect.top <= 0) {
//             productHeader.classList.add("sticky-product");
//         }
        
//         // Quitar la clase sticky-product cuando el elemento vuelve a su posición inicial
//         if (!isScrollingDown && currentScrollPos <= initialPosition) {
//             console.log("El borde superior de product_header ha vuelto a su posición inicial");
//             productHeader.classList.remove("sticky-product");
//         }
        
//         // Actualizar la última posición del scroll
//         lastScrollTop = currentScrollPos;
//     });
// }