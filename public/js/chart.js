document.addEventListener("DOMContentLoaded", function () {
    // Get chart data from window
    const chartLabels = window.chartLabels;
    const revenueData = window.revenueData;
    const salesData = window.salesData;

    // Currency formatter (Rupiah)
    const moneyFormat = (value) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(value);

    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 1500,
            easing: 'easeOutQuart'
        },
        plugins: {
            legend: { 
                display: false 
            },
            tooltip: {
                backgroundColor: "#fff",
                bodyColor: "#111827",
                borderColor: "#f3f4f6",
                borderWidth: 1,
                padding: 12,
                titleFont: {
                    size: 14
                },
                bodyFont: {
                    size: 14
                },
                cornerRadius: 8,
                boxPadding: 6,
                usePointStyle: true,
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + 
                              (context.dataset.label.includes('Revenue') 
                               ? moneyFormat(context.parsed.y) 
                               : `${context.parsed.y} item(s) sold`);
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    };

    // Responsive font sizes
    const getFontSize = () => {
        return window.innerWidth < 768 ? 10 : 12;
    };

    // ========================= Revenue Chart ========================= //
    const revenueCtx = document.getElementById("revenueChart").getContext("2d");
    new Chart(revenueCtx, {
        type: "line",
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: "Total Revenue",
                    data: revenueData,
                    borderColor: "#f43f5e",
                    backgroundColor: "rgba(244, 63, 94, 0.1)",
                    borderWidth: 2,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#f43f5e",
                    pointBorderWidth: 2,
                    pointRadius: window.innerWidth < 768 ? 3 : 5,
                    pointHoverRadius: window.innerWidth < 768 ? 5 : 7,
                    tension: 0.3,
                    fill: true,
                },
            ],
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: "#6b7280",
                        font: {
                            size: getFontSize()
                        },
                        callback: moneyFormat,
                        padding: 8
                    },
                    grid: {
                        color: "rgba(209, 213, 219, 0.3)",
                        drawBorder: false
                    },
                },
                x: {
                    ticks: {
                        color: "#6b7280",
                        font: {
                            size: getFontSize()
                        },
                        padding: 8
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                },
            },
        },
    });

    // ========================= Sales Chart ========================= //
    const salesCtx = document.getElementById("salesChart").getContext("2d");
    new Chart(salesCtx, {
        type: "line",
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: "Items Sold",
                    data: salesData,
                    borderColor: "#3b82f6",
                    backgroundColor: "rgba(59, 130, 246, 0.1)",
                    borderWidth: 2,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#3b82f6",
                    pointBorderWidth: 2,
                    pointRadius: window.innerWidth < 768 ? 3 : 5,
                    pointHoverRadius: window.innerWidth < 768 ? 5 : 7,
                    tension: 0.3,
                    fill: true,
                },
            ],
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: "#6b7280",
                        font: {
                            size: getFontSize()
                        },
                        stepSize: 1,
                        padding: 8
                    },
                    grid: {
                        color: "rgba(209, 213, 219, 0.3)",
                        drawBorder: false
                    },
                },
                x: {
                    ticks: {
                        color: "#6b7280",
                        font: {
                            size: getFontSize()
                        },
                        padding: 8
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                },
            },
        },
    });
});