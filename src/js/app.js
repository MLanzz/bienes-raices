document.addEventListener('DOMContentLoaded', function() {
    eventListeners();

    darkMode();
});


function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);
};

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar');

};

function darkMode() {

    // const SODarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // if (SODarkMode.matches) {
    //     document.body.classList.add('dark-mode');
    // } else {
    //     document.body.classList.remove('dark-mode');
    // }

    // SODarkMode.addEventListener('change', function() {
    //     if (SODarkMode.matches) {
    //         document.body.classList.add('dark-mode');
    //     } else {
    //         document.body.classList.remove('dark-mode');
    //     }
    // })

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    })
}