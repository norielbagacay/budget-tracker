// register.js

function validateForm(event) {
    // Prevent form submission
    event.preventDefault();

    // Get form elements
    var name = document.querySelector('input[name="name"]').value;
    var email = document.querySelector('input[name="email"]').value;
    var password = document.querySelector('input[name="password"]').value;
    var confirmPassword = document.querySelector('input[name="confirm_password"]').value;

    // Regular expression for email validation
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Clear previous error messages
    var errorMessages = document.getElementById('error-messages');
    errorMessages.innerHTML = '';

    // Validation
    var errors = [];

    if (name.trim() === '') {
        errors.push("Name is required.");
    }

    if (!emailPattern.test(email)) {
        errors.push("Please enter a valid email address.");
    }

    if (password.length < 6) {
        errors.push("Password must be at least 6 characters long.");
    }

    if (password !== confirmPassword) {
        errors.push("Passwords do not match.");
    }

    // Display errors or submit form
    if (errors.length > 0) {
        for (var i = 0; i < errors.length; i++) {
            var p = document.createElement('p');
            p.textContent = errors[i];
            errorMessages.appendChild(p);
        }
    } else {
        document.getElementById('register-form').submit();
    }
}

// Attach the validation function to the form submission event
window.onload = function() {
    var form = document.getElementById('register-form');
    if (form) {
        form.onsubmit = validateForm;
    }
};
