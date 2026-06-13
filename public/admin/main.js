Chart.defaults.font.family = 'Inter, sans-serif';
Chart.defaults.color = '#64748B';

const gradientBlue = (ctx) => {
    const g = ctx.createLinearGradient(0, 0, 0, 180);
    g.addColorStop(0, 'rgba(99,102,241,.25)');
    g.addColorStop(1, 'rgba(99,102,241,0)');
    return g;
};

const gradientGreen = (ctx) => {
    const g = ctx.createLinearGradient(0, 0, 0, 180);
    g.addColorStop(0, 'rgba(16,185,129,.25)');
    g.addColorStop(1, 'rgba(16,185,129,0)');
    return g;
};

// ── User Chart ────────────────────────────────────────────────────
const userCtx = document.getElementById('userChart').getContext('2d');
const resumeCtx = document.getElementById('resumeChart').getContext('2d');

const userLabels = @json($userChartData -> pluck('date'));
const userCounts = @json($userChartData -> pluck('count'));
const resumeLabels = @json($resumeChartData -> pluck('date'));
const resumeCounts = @json($resumeChartData -> pluck('count'));

const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
    scales: {
        x: {
            grid: { display: false }, border: { display: false },
            ticks: { font: { size: 11 } }
        },
        y: {
            grid: { color: '#F1F5F9' }, border: { display: false, dash: [3, 3] },
            ticks: { stepSize: 1, font: { size: 11 }, precision: 0 }
        }
    },
    elements: { point: { radius: 3, hoverRadius: 5 } },
};

new Chart(userCtx, {
    type: 'line',
    data: {
        labels: userLabels,
        datasets: [{
            data: userCounts,
            borderColor: '#6366F1',
            backgroundColor: gradientBlue(userCtx),
            borderWidth: 2.5,
            tension: 0.4,
            fill: true,
        }]
    },
    options: commonOptions,
});

new Chart(resumeCtx, {
    type: 'bar',
    data: {
        labels: resumeLabels,
        datasets: [{
            data: resumeCounts,
            backgroundColor: 'rgba(16,185,129,.15)',
            borderColor: '#10B981',
            borderWidth: 2,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        ...commonOptions,
        elements: { ...commonOptions.elements, point: { radius: 0 } },
    },
});

// ── Donut Chart ───────────────────────────────────────────────────
const total = {{ $totalResumes }};
const pub = {{ $publicResumes }};
const priv = {{ $privateResumes }};

new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Công khai', 'Riêng tư'],
        datasets: [{
            data: total > 0 ? [pub, priv] : [0, 1],
            backgroundColor: ['#6366F1', '#E2E8F0'],
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: false,
        cutout: '70%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: (c) => ` ${c.label}: ${c.parsed} CV`
                }
            }
        }
    }
});