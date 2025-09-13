// dashboard.js
document.addEventListener("DOMContentLoaded", () => {
    // User Growth Chart
    const userGrowthCtx = document.getElementById("userGrowthChart").getContext("2d");
    new Chart(userGrowthCtx, {
        type: "line",
        data: {
            labels: [
                "Jan","Feb","Mar","Apr","May","Jun",
                "Jul","Aug","Sep","Oct","Nov","Dec"
            ],
            datasets: [{
                label: "Total Users",
                data: [8500, 8900, 9300, 9700, 10100, 10500, 10900, 11200, 11500, 11800, 12100, 12450],
                borderColor: "#4f46e5",
                backgroundColor: "rgba(79,70,229,0.1)",
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: false },
                x: { grid: { display: false } }
            }
        }
    });

    // Event Distribution Chart
    const eventDistributionCtx = document.getElementById("eventDistributionChart").getContext("2d");
    new Chart(eventDistributionCtx, {
        type: "doughnut",
        data: {
            labels: ["Conferences", "Workshops", "Webinars", "Meetups"],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ["#4f46e5", "#ec4899", "#10b981", "#f59e0b"],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: "bottom" } }
        }
    });

    // Revenue Trend Chart
    const revenueTrendCtx = document.getElementById("revenueTrendChart").getContext("2d");
    new Chart(revenueTrendCtx, {
        type: "bar",
        data: {
            labels: ["Q1", "Q2", "Q3", "Q4"],
            datasets: [
                {
                    label: "Revenue",
                    data: [450000, 520000, 580000, 750000],
                    backgroundColor: "#4f46e5",
                    borderRadius: 6
                },
                {
                    label: "Expenses",
                    data: [320000, 380000, 420000, 480000],
                    backgroundColor: "#10b981",
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => "$" + value / 1000 + "K"
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // Platform Usage Chart
    const platformCtx = document.getElementById("platformChart").getContext("2d");
    new Chart(platformCtx, {
        type: "bar",
        data: {
            labels: ["Web", "iOS", "Android", "Tablet"],
            datasets: [{
                label: "Active Users",
                data: [6540, 3120, 3980, 1210],
                backgroundColor: [
                    "rgba(79,70,229,0.8)",
                    "rgba(236,72,153,0.8)",
                    "rgba(16,185,129,0.8)",
                    "rgba(245,158,11,0.8)"
                ],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Performance Chart
    const performanceCtx = document.getElementById("performanceChart").getContext("2d");
    new Chart(performanceCtx, {
        type: "radar",
        data: {
            labels: ["CPU Usage", "Memory", "Storage", "Network", "Uptime", "Response Time"],
            datasets: [{
                label: "Current Performance",
                data: [85, 75, 90, 65, 95, 80],
                backgroundColor: "rgba(79,70,229,0.2)",
                borderColor: "#4f46e5",
                pointBackgroundColor: "#4f46e5"
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    ticks: { backdropColor: "transparent" }
                }
            }
        }
    });
});
