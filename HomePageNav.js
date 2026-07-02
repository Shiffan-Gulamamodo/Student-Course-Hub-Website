// Get the Hamburger element by ID
const hamburger = document.getElementById('hamburger');

// Get the Navigation Unordered List element inside the nav.bar class
const navUl = document.querySelector('.nav-bars ul')

// Added an event Listener to the Hamburger Menu that listens for a click event
hamburger.addEventListener('click', () => {
    // Toggle the 'active' class on the navigation ul element when the hamburger is clicked
    navUl.classList.toggle('active');
});