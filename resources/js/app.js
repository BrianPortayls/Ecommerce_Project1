import Chart from 'chart.js/auto';

window.Chart = Chart;

document.dispatchEvent(new Event('chartjs:ready'));

document.querySelectorAll('[data-admin-nav-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        document.body.classList.add('admin-nav-open');
    });
});

document.querySelectorAll('[data-admin-nav-close]').forEach((button) => {
    button.addEventListener('click', () => {
        document.body.classList.remove('admin-nav-open');
    });
});
