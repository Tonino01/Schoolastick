function validateSignupForm() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm-password").value;
    var errorMessage = document.getElementById("error-message");

    errorMessage.innerHTML = "";

    if (name === "" || email === "" || password === "" || confirmPassword === "") {
        errorMessage.innerHTML = "Tutti i campi sono obbligatori.";
        return false;
    }

    var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!emailPattern.test(email)) {
        errorMessage.innerHTML = "Inserisci un'email valida.";
        return false;
    }

    if (password.length < 6) {
        errorMessage.innerHTML = "La password deve contenere almeno 6 caratteri.";
        return false;
    }

    if (password !== confirmPassword) {
        errorMessage.innerHTML = "Le password non corrispondono.";
        return false;
    }

    alert("Registrazione completata con successo!");
    return true;
}

// Funzione per alternare la visibilità della password
function togglePassword() {
    var passwordField = document.querySelector("input[name='password']");
    var toggleIcon = document.getElementById("toggle-password");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

// Funzione per alternare la visibilità della conferma password
function toggleConfirmPassword() {
    var confirmPasswordField = document.querySelector("input[name='confirm-password']");
    var toggleIcon = document.getElementById("toggle-confirm-password");

    if (confirmPasswordField.type === "password") {
        confirmPasswordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        confirmPasswordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}


