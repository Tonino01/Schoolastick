const infoBtn = document.getElementById('info-btn');
const logoBtn = document.getElementById('logo-btn');
const infoBox = document.getElementById('info-box');
const mainContent = document.getElementById('main-content');
const welcomeContent = document.getElementById('welcome-content');

infoBtn.addEventListener('click', () => {
    welcomeContent.style.display = 'none';
    infoBox.classList.add('show');
});

logoBtn.addEventListener('click', () => {
    welcomeContent.style.display = 'block';
    infoBox.classList.remove('show');
});