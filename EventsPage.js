document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const navUl = document.querySelector('.nav-bars ul');

    hamburger.addEventListener('click', () => {
        navUl.classList.toggle('active');
    });
});
