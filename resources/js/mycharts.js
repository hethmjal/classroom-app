import Chart from 'chart.js/auto';

const labels = [
    'assigned',
    'submitted',
   
];

const data = {
    labels: labels,
    datasets: [{
        data: [3, 7],
    }]
};

const config = {
    type: 'pie',
    data: data,
    options: {}
};

new Chart(
    document.getElementById('myChart'),
    config
);

