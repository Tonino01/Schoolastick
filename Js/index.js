const infoBtn = document.getElementById('info-btn');
const logoBtn = document.getElementById('logo-btn');
const netStrikeBtn = document.getElementById('NetStrike-btn');
const vocariBtn = document.getElementById('Vocari-btn'); // Aggiunto
const schoolQBtn = document.getElementById('SchoolQ-btn'); // Aggiunto

const infoBox = document.getElementById('info-box');
const netStrikeBox = document.getElementById('NetStrike-box');
const vocariBox = document.getElementById('Vocari-box'); // Aggiunto
const schoolQBox = document.getElementById('schoolQ-box'); // Aggiunto

const mainContent = document.getElementById('main-content');
const welcomeContent = document.getElementById('welcome-content');

infoBtn.addEventListener('click', () => {
    welcomeContent.style.display = 'none';
    infoBox.classList.add('show');
    netStrikeBox.classList.remove('show');
    vocariBox.classList.remove('show'); // Nascondi Vocari-box
    schoolQBox.classList.remove('show'); // Nascondi SchoolQ-box
});

logoBtn.addEventListener('click', () => {
    welcomeContent.style.display = 'block';
    infoBox.classList.remove('show');
    netStrikeBox.classList.remove('show');
    vocariBox.classList.remove('show'); // Nascondi Vocari-box
    schoolQBox.classList.remove('show'); // Nascondi SchoolQ-box
});

netStrikeBtn.addEventListener('click', () => {
    welcomeContent.style.display = 'none';
    netStrikeBox.classList.add('show');
    infoBox.classList.remove('show');
    vocariBox.classList.remove('show'); // Nascondi Vocari-box
    schoolQBox.classList.remove('show'); // Nascondi SchoolQ-box
});

vocariBtn.addEventListener('click', () => { // Aggiunto
    welcomeContent.style.display = 'none';
    vocariBox.classList.add('show');
    infoBox.classList.remove('show');
    netStrikeBox.classList.remove('show');
    schoolQBox.classList.remove('show'); // Nascondi SchoolQ-box
});

schoolQBtn.addEventListener('click', () => { // Aggiunto
    welcomeContent.style.display = 'none';
    schoolQBox.classList.add('show');
    infoBox.classList.remove('show');
    netStrikeBox.classList.remove('show');
    vocariBox.classList.remove('show'); // Nascondi Vocari-box
});