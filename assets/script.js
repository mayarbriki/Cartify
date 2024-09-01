window.addEventListener('scroll', function() {
    const header = document.getElementById('main-header');
    const title = header.querySelector('h1');

    if (window.scrollY > 50) {
        header.classList.add('scrolled');
        title.classList.remove('transparent');
        title.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
        title.classList.remove('scrolled');
        title.classList.add('transparent');
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const showSignupButton = document.getElementById('show-signup');
    const signupForm = document.getElementById('signup-form');
    const closeFormButton = document.getElementById('close-form');

    // Show the signup form
    showSignupButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        signupForm.classList.add('active');
    });

    // Hide the signup form
    closeFormButton.addEventListener('click', function() {
        signupForm.classList.remove('active');
    });
});
