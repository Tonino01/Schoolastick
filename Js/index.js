const infoBtn = document.getElementById('info-btn');
const logoBtn = document.getElementById('logo-btn');
const netStrikeBtn = document.getElementById('NetStrike-btn'); 
const infoBox = document.getElementById('info-box');
const netStrikeBox = document.getElementById('NetStrike-box'); 
const mainContent = document.getElementById('main-content');
const welcomeContent = document.getElementById('welcome-content');

infoBtn.addEventListener('click', () => {
    welcomeContent.style.display = 'none';
    infoBox.classList.add('show');
    netStrikeBox.classList.remove('show'); 
});

logoBtn.addEventListener('click', () => {
    welcomeContent.style.display = 'block';
    infoBox.classList.remove('show');
    netStrikeBox.classList.remove('show'); 
});

netStrikeBtn.addEventListener('click', () => { 
    
    welcomeContent.style.display = 'none';
    netStrikeBox.classList.add('show');
    infoBox.classList.remove('show'); 
});