// modal-category.js
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalAddCategory");
    const backdrop = document.getElementById("modalAddCategoryBackdrop");
    const panel = document.getElementById("modalAddCategoryPanel");

    const openBtn = document.getElementById("openModalAddCategory");
    const closeBtn = document.getElementById("closeAddCategoryModal");
    const closeOnBackdrop = true;

    const openModal = () => {
        modal.classList.remove("hidden");
        setTimeout(() => {
            backdrop.classList.add("opacity-100");
            panel.classList.remove("translate-y-4", "scale-95", "opacity-0");
            panel.classList.add("translate-y-0", "scale-100", "opacity-100");
        }, 10);
    };

    const closeModal = () => {
        backdrop.classList.remove("opacity-100");
        panel.classList.remove("translate-y-0", "scale-100", "opacity-100");
        panel.classList.add("translate-y-4", "scale-95", "opacity-0");

        setTimeout(() => {
            modal.classList.add("hidden");
        }, 200);
    };

    // Open button
    if (openBtn) {
        openBtn.addEventListener("click", openModal);
    }

    // Close button
    if (closeBtn) {
        closeBtn.addEventListener("click", closeModal);
    }

    // Close on backdrop click
    if (closeOnBackdrop && backdrop) {
        backdrop.addEventListener("click", closeModal);
    }

    // Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && !modal.classList.contains("hidden")) {
            closeModal();
        }
    });
});
