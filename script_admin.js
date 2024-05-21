const Button_Stats = document.getElementById('Button_Stats');
const Button_Change = document.getElementById('Button_Change');
const Popup = document.getElementById('Popup');
const Stats = document.getElementById('Stats');
const Form = document.getElementById('Form');

Button_Stats.addEventListener('click', () => {
    fetch('admin.php?action=fetch_stats')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            const table = document.createElement('table');
            let html = '<tr><th>Язык программирования</th><th>Количество использований</th></tr>';
            data.forEach(row => {
                html += `<tr><td>${row.name}</td><td>${row.count}</td></tr>`;
            });
            table.innerHTML = html;
            Popup.innerHTML = '';
            Popup.appendChild(table);
            Popup.style.display = 'block';
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при получении статистики.');
        });
});

Button_Change.addEventListener('click', () => {
    // Your code for handling the change button click
});

window.addEventListener('popstate', () => {
    Popup.style.display = 'none';
});
