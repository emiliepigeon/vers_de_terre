// numbers.js

document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour animer un nombre
    function animateNumber(element, start, end, duration) {
        let current = start;
        const range = end - start;
        const increment = end > start ? 1 : -1;
        const stepTime = Math.abs(Math.floor(duration / range));
        const timer = setInterval(function() {
            current += increment;
            if (element.dataset.endValue === "70") {
                element.textContent = current + " %";
            } else if (element.dataset.endValue === "1200") {
                element.textContent = current + " kg/h";
            } else {
                element.textContent = current;
            }
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    // Fonction pour vérifier si un élément est visible
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Sélectionner tous les éléments h4 avec la classe num-bg
    const numberElements = document.querySelectorAll('h4.num-bg');

    // Fonction pour démarrer l'animation si l'élément est visible
    function startAnimationIfVisible() {
        numberElements.forEach(element => {
            if (isElementInViewport(element) && !element.classList.contains('animated')) {
                const endValue = parseInt(element.dataset.endValue, 10);
                animateNumber(element, 0, endValue, 2000); // 2000ms = 2 secondes
                element.classList.add('animated');
            }
        });
    }

    // Vérifier la visibilité au chargement et au scroll
    window.addEventListener('load', startAnimationIfVisible);
    window.addEventListener('scroll', startAnimationIfVisible);
});
