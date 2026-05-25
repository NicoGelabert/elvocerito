function getRandomText() {
  const phrases = [
    "¡Explorá las categorías!",
    "Buscá la empresa o servicio que necesites",
    "Cientos de empresas esperan que los encuentres",
    "Estamos aquí para ayudarte.",
    "Explora nuevas ideas e innovaciones."
  ];
  return phrases[Math.floor(Math.random() * phrases.length)];
}

export function init() {
  const h1Element = document.querySelector('h1');
  if (h1Element) {
    const h2Element = document.createElement('h2');
    h2Element.innerHTML = getRandomText();
    h1Element.parentNode.replaceChild(h2Element, h1Element);
  }
}