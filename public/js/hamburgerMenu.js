$(document).ready(function () {
    let menuIcon = document.querySelector('.hamburger-menu');
    let menuNav = document.querySelector('.navbar');
    if (menuIcon) {
        menuIcon.addEventListener('click', () => {
            menuNav.classList.toggle('change');
            menuIcon.classList.toggle('cross');
        });
    }
});