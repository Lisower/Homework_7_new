const Button = document.getElementById('Button');
const Exit = document.getElementById('Exit');
const Popup = document.getElementById('Popup');
const Form = document.getElementById('Form');

Button.addEventListener('click', () => {
    Popup.style.display = 'block';
});

Exit_Form.addEventListener('click', () => {
    Popup.style.display = 'none';
});

window.addEventListener('popstate', () => {
    Popup.style.display = 'none';
});
