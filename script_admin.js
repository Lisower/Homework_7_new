const Button_Stats = document.getElementById('Button_Stats');
const Button_Change = document.getElementById('Button_Change');
const Popup = document.getElementById('Popup');
const Stats = document.getElementById('Stats');
const Form = document.getElementById('Form');

Button_Stats.addEventListener('click', () => {
    window.open('./stats.php', '_blank');
});

Button_Change.addEventListener('click', () => {
    
});

window.addEventListener('popstate', () => {
    Popup.style.display = 'none';
});
