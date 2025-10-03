// @ts-nocheck
document.addEventListener("DOMContentLoaded", () => {
    const {
        userGrowth = {},
        revenueTrend = {},
        publishedEvents = {},
        platformUsage = {},
        performance = {},
        bestSellerEvents = {},
        reportEvents = [],
        mostIncome = {}
    } = window.dashboardData || {};

    const months = [
        "Jan","Feb","Mar","Apr","May","Jun",
        "Jul","Aug","Sep","Oct","Nov","Dec"
    ];

    /** ===== User Growth (Line Chart) ===== */
    const userGrowthCtx = document
        .getElementById("userGrowthChart")
        ?.getContext("2d");

    if (userGrowthCtx) {
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
                        ticks: { stepSize: 1, precision: 0 },
                    },
                },
            },
        });
    }

    /** ===== Published Events (Line Chart) ===== */
    const publishedEventsCtx = document
        .getElementById("publishedEventsChart")
        ?.getContext("2d");

    if (publishedEventsCtx) {
        const publishedEventData = months.map(
            (_, i) => publishedEvents[i + 1] || 0
        );

        new Chart(publishedEventsCtx, {
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
                        ticks: { stepSize: 1, precision: 0 },
                    },
                },
            },
        });
    }

    /** ===== Best Seller (Bar Chart) ===== */
    const bestSellerCtx = document
        .getElementById("bestSellerChart")
        ?.getContext("2d");

    if (bestSellerCtx) {
        const eventLabels = Object.keys(bestSellerEvents);
        const eventData = Object.values(bestSellerEvents);

        new Chart(bestSellerCtx, {
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
                        ticks: { stepSize: 1, precision: 0 },
                    },
                },
            },
        });
    }

    /** ===== Reports per Event (Bar Chart) ===== */
    const reportCtx = document
        .getElementById("reportEventsChart")
        ?.getContext("2d");

    if (reportCtx) {
        const reportLabels = reportEvents.map((item) => item.title);
        const reportCounts = reportEvents.map((item) => item.total);

        new Chart(reportCtx, {
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
                        ticks: { stepSize: 1, precision: 0 },
                    },
                },
            },
        });
    }

    /** ===== MOST INCOME (Line Chart) ===== */
    const incomeCtx = document
        .getElementById("mostIncomeChart")
        ?.getContext("2d");

    if (incomeCtx) {
        const incomeLabels = Object.keys(mostIncome);
        const incomeData = Object.values(mostIncome);

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
                            callback: (value) =>
                                "Rp " + value.toLocaleString(),
                        },
                        suggestedMax: 100,
                    },
                },
            },
        });
    }
});
