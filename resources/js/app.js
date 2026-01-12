import './bootstrap';

// Requisito de la Task: Log para verificar carga [cite: 69, 73]
console.log("🚀 PixelProject: Sistema cargado correctamente.");

// Un pequeño script interactivo para tu red social/tienda
document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            console.log(`Navegando a: ${link.innerText}`);
        });
    });
});