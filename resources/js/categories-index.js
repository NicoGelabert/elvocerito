function replaceH1WithRandomH2() {
    // Seleccionamos el elemento h1
    const h1Element = document.querySelector('h1');
    
    if (h1Element) {
        // Creamos un nuevo elemento h2
        const h2Element = document.createElement('h2');
        
        // Generamos un texto aleatorio
        const randomText = getRandomText();
        
        // Asignamos el texto aleatorio al h2
        h2Element.innerHTML = randomText;
        
        // Reemplazamos el h1 por el h2
        h1Element.parentNode.replaceChild(h2Element, h1Element);
    }
}

// Función que genera un texto aleatorio
function getRandomText() {
    const phrases = [
        "¡Explorá las categorías!",
        "Buscá la empresa o servicio que necesites",
        "Cientos de empresas esperan que los encuentres",
        "Estamos aquí para ayudarte.",
        "Explora nuevas ideas e innovaciones."
    ];

    // Seleccionamos un texto aleatorio del array
    const randomIndex = Math.floor(Math.random() * phrases.length);
    return phrases[randomIndex];
}

// Reemplazar el h1 por h2 con texto aleatorio al cargar la página
replaceH1WithRandomH2();