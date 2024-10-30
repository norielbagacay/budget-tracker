function validatesignin(event) {
        
    event.preventDefault();


    var email = document.getElementById('email').value;


    // Regular expression for email validation
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

 
    var errorMessages = document.getElementById('error-messages');
    errorMessages.innerHTML = '';

    // Validation
    var errors = [];

    if (!emailPattern.test(email)) {
        errors.push("Please enter a valid email address.");
    }

 
    // Display errors or submit form
    if (errors.length > 0) {
        for (var i = 0; i < errors.length; i++) {
            var p = document.createElement('p');
            p.textContent = errors[i];
            errorMessages.appendChild(p);
        }
    } else {
        document.getElementById('login-form').submit();
    }
}