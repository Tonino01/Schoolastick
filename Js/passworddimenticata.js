function validateEmail() {
    const email = document.getElementById("email").value;
    const errorMessage = document.getElementById("error-message");
    errorMessage.style.display = "none";
    if (email === "") {
      errorMessage.textContent = "Per favore, inserisci una email valida.";
      errorMessage.style.display = "block";
      return false;  
    }
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(email)) {
      errorMessage.textContent = "Per favore, inserisci un'email valida.";
      errorMessage.style.display = "block";
      return false;  
    }
    alert("Le istruzioni per il reset della password sono state inviate alla tua email.");
    return false; 
  }
  