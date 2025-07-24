document.addEventListener("DOMContentLoaded", function () {
    // Ambil data chart dari window
    const chartLabels = window.chartLabels;
    const revenueData = window.revenueData;
    const salesData = window.salesData;

    // Format mata uang (Rupiah)
    const moneyFormat = (value) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(value);

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
                    borderWidth: 3,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#f43f5e",
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: "easeOutQuart",
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: "#6b7280",
                        callback: moneyFormat,
                    },
                    grid: {
                        color: "rgba(209, 213, 219, 0.3)",
                    },
                },
                x: {
                    ticks: {
                        color: "#6b7280",
                    },
                    grid: {
                        display: false,
                    },
                },
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#fff",
                    bodyColor: "#111827",
                    borderColor: "#f3f4f6",
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: (ctx) => moneyFormat(ctx.parsed.y),
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
                    borderWidth: 3,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#3b82f6",
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: "easeOutQuart",
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: "#6b7280",
                        stepSize: 1,
                    },
                    grid: {
                        color: "rgba(209, 213, 219, 0.3)",
                    },
                },
                x: {
                    ticks: {
                        color: "#6b7280",
                    },
                    grid: {
                        display: false,
                    },
                },
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#fff",
                    bodyColor: "#111827",
                    borderColor: "#f3f4f6",
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: (ctx) => `${ctx.parsed.y} item(s) sold`,
                    },
                },
            },
        },
    });
});
