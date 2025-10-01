    // @ts-nocheck
document.addEventListener("DOMContentLoaded", () => {
    const {
        userGrowth = {},
        revenueTrend = {},
        publishedEvents = {},
        platformUsage = {},
        performance = {},
    } = window.dashboardData || {};

    /** ===== User Growth (Line Chart) ===== */
    const userGrowthCtx = document
        .getElementById("userGrowthChart")
        ?.getContext("2d");
    if (userGrowthCtx) {
        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ];
        const userGrowthData = months.map((_, i) => userGrowth[i + 1] || 0);

        new Chart(userGrowthCtx, {
            type: "line",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Total Users",
                        data: userGrowthData,
                        borderColor: "#4f46e5",
                        backgroundColor: "rgba(79,70,229,0.1)",
                        tension: 0.4,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                        },
                    },
                },
            },
        });
    }

    /** ===== Published Events (Line Chart) ===== */
    const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];
    const publishedEventData = months.map(
        (_, i) => window.dashboardData.publishedEvents[i + 1] || 0
    );

    new Chart(document.getElementById("publishedEventsChart"), {
        type: "line",
        data: {
            labels: months,
            datasets: [
                {
                    label: "Published Events",
                    data: publishedEventData,
                    borderColor: "#4f46e5",
                    backgroundColor: "rgba(79,70,229,0.1)",
                    fill: true,
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                    },
                },
            },
        },
    });

    /** ===== Best Seller (Bar Chart) ===== */
    const eventLabels = Object.keys(window.dashboardData.bestSellerEvents);
    const eventData = Object.values(window.dashboardData.bestSellerEvents);

    new Chart(document.getElementById("bestSellerChart"), {
        type: "bar",
        data: {
            labels: eventLabels,
            datasets: [
                {
                    label: "Orders",
                    data: eventData,
                    backgroundColor: "#4f46e5",
                    borderRadius: 6,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                    },
                },
            },
        },
    });

    /** ===== Reports per Event (Bar Chart) ===== */
    const reportData = window.dashboardData.reportEvents || [];

    const reportLabels = reportData.map((item) => item.title);
    const reportCounts = reportData.map((item) => item.total);

    new Chart(document.getElementById("reportEventsChart"), {
        type: "bar",
        data: {
            labels: reportLabels,
            datasets: [
                {
                    label: "Reports",
                    data: reportCounts,
                    backgroundColor: "rgba(79,70,229,0.8)",
                    borderRadius: 6,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                    },
                },
            },
        },
    });

    /** ===== MOST INCOME ===== */
    const incomeCtx = document
        .getElementById("mostIncomeChart")
        ?.getContext("2d");

    if (incomeCtx) {
        const incomeLabels = Object.keys(window.dashboardData.mostIncome || {});
        const incomeData = Object.values(window.dashboardData.mostIncome || {});

        new Chart(incomeCtx, {
            type: "line",
            data: {
                labels: incomeLabels,
                datasets: [
                    {
                        label: "Revenue",
                        data: incomeData,
                        borderColor: "#10b981",
                        backgroundColor: "rgba(16,185,129,0.1)",
                        tension: 0.4,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        offset: true,
                        grid: { display: false },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return "Rp " + value.toLocaleString();
                            },
                        },
                        suggestedMax: 100,
                    },
                },
            },
        });
    }
});
