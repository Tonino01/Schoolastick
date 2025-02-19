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

  function validateForm() {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("error-message");
    errorMessage.style.display = "none";
    if (email === "") {
      errorMessage.textContent = "Per favore, inserisci un'email.";
      errorMessage.style.display = "block";
      return false;
    }
    if (password === "") {
      errorMessage.textContent = "Per favore, inserisci la tua password.";
      errorMessage.style.display = "block";
      return false;  // Blocca l'invio del form
    }
    return true;
  }
