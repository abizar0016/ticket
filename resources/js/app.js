// ================== GLOBAL ==================
function handleAttendeeUpdateModal(attendeeId, action) {
    const modal = document.getElementById(`attendeesUpdateModal-${attendeeId}`);
    const backdrop = document.getElementById(
        `attendeesUpdateBackdrop-${attendeeId}`
    );
    const panel = document.getElementById(`attendeesUpdatePanel-${attendeeId}`);

    if (!modal || !backdrop || !panel) return;

    if (action === "open") {
        modal.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
        setTimeout(() => {
            backdrop.classList.remove("opacity-0");
            panel.classList.remove("opacity-0", "translate-y-4", "scale-95");
            panel.classList.add("opacity-100", "translate-y-0", "scale-100");
        }, 10);
    } else {
        backdrop.classList.add("opacity-0");
        panel.classList.remove("opacity-100", "translate-y-0", "scale-100");
        panel.classList.add("opacity-0", "translate-y-4", "scale-95");
        setTimeout(() => {
            modal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }
}

function handleTicketProductUpdateModal(itemsId, action) {
    const modal = document.getElementById(`itemUpdateModal-${itemsId}`);
    const backdrop = document.getElementById(`itemUpdateBackdrop-${itemsId}`);
    const panel = document.getElementById(`itemUpdatePanel-${itemsId}`);

    if (!modal || !backdrop || !panel) return;

    if (action === "open") {
        modal.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
        setTimeout(() => {
            backdrop.classList.remove("opacity-0");
            panel.classList.remove("opacity-0", "translate-y-4", "scale-95");
            panel.classList.add("opacity-100", "translate-y-0", "scale-100");
        }, 10);
    } else {
        backdrop.classList.add("opacity-0");
        panel.classList.remove("opacity-100", "translate-y-0", "scale-100");
        panel.classList.add("opacity-0", "translate-y-4", "scale-95");
        setTimeout(() => {
            modal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }
}

function handlePromoUpdateModal(promoId, action) {
    const modal = document.getElementById(`promoUpdateModal-${promoId}`);
    const backdrop = document.getElementById(`promoUpdateBackdrop-${promoId}`);
    const panel = document.getElementById(`promoUpdatePanel-${promoId}`);

    if (!modal || !backdrop || !panel) return;

    if (action === "open") {
        modal.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
        setTimeout(() => {
            backdrop.classList.remove("opacity-0");
            panel.classList.remove("opacity-0", "translate-y-4", "scale-95");
            panel.classList.add("opacity-100", "translate-y-0", "scale-100");
        }, 10);
    } else {
        backdrop.classList.add("opacity-0");
        panel.classList.remove("opacity-100", "translate-y-0", "scale-100");
        panel.classList.add("opacity-0", "translate-y-4", "scale-95");
        setTimeout(() => {
            modal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }
}

// ================== DOMContentLoaded START ==================
document.addEventListener("DOMContentLoaded", () => {
    // ================== PAYMENT PROOF UPLOAD ==================
    const paymentProofInput = document.getElementById("payment_proof");
    const fileNameSpan = document.getElementById("file-name");
    const previewContainer = document.getElementById("preview-container");
    const previewImage = document.getElementById("preview-image");
    const removeImageBtn = document.getElementById("remove-image");

    if (paymentProofInput) {
        paymentProofInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert("File terlalu besar. Maksimal 5MB.");
                    this.value = "";
                    return;
                }

                fileNameSpan.textContent = file.name;

                if (file.type.match("image.*")) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImage.src = event.target.result;
                        previewContainer.classList.remove("hidden");
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src =
                        "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzODQgNTEyIj48cGF0aCBmaWxsPSIjNmI3MjgwIiBkPSJNMTgxLjkgMjU2LjFjLTUtMTYtNC45LTQ2LjkgMi0xNjQuMWg5LjFjLTYuOSAxMTcuMS00LjggMTQ4LjIgMiAxNjQuMWgtMTMuMXpNMjI0IDI1NnYtMTYwaDE2djE2MGMwIDguOCA3LjIgMTYgMTYgMTZoMTQ0djE2SDI0MGMtMTMuMyAwLTI0LTEwLjctMjQtMjR6TTM4NCAxMjhIMjU2VjBjNi4xLjEgMTYuMSAxLjIgMTYgMTZ2MTEyYzAgOC44IDcuMiAxNiAxNiAxNmg5NnptLTgwIDI1NkMzMDQgMzkyIDI2NCAzODQgMjQ4IDM4NGgtMTMuMWMtNi45LTYxLjktNi4xLTYxLjIgMC0xMjhoMTMuMWMxNiAwIDU2LTggODAgMHYxMjh6Ii8+PC9zdmc+";
                    previewContainer.classList.remove("hidden");
                }
            } else {
                fileNameSpan.textContent = "";
                previewContainer.classList.add("hidden");
            }
        });
    }

    if (removeImageBtn) {
        removeImageBtn.addEventListener("click", function () {
            if (paymentProofInput) {
                paymentProofInput.value = "";
            }
            fileNameSpan.textContent = "";
            previewContainer.classList.add("hidden");
        });
    }

    // ================== EVENT MODAL ==================
    const eventModal = document.getElementById("eventModal");
    const eventBackdrop = document.getElementById("modalBackdrop");
    const eventPanel = document.getElementById("modalPanel");

    document.getElementById("openEventModal")?.addEventListener("click", () => {
        eventModal.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
        setTimeout(() => {
            eventBackdrop.classList.remove("opacity-0");
            eventPanel.classList.remove("opacity-0", "translate-y-4");
        }, 10);
    });

    document
        .getElementById("closeEventModal")
        ?.addEventListener("click", closeEventModal);
    document
        .getElementById("cancelEventModal")
        ?.addEventListener("click", closeEventModal);
    eventModal?.addEventListener("click", (e) => {
        if (e.target === eventModal) closeEventModal();
    });

    function closeEventModal() {
        eventBackdrop.classList.add("opacity-0");
        eventPanel.classList.add("opacity-0", "translate-y-4");
        setTimeout(() => {
            eventModal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }

    // ================== ORGANIZation MODAL ==================
    const organizationModal = document.getElementById("organizationModal");
    const organizationBackdrop = document.getElementById(
        "organizationModalBackdrop"
    );
    const organizationPanel = document.getElementById("organizationModalPanel");

    document
        .getElementById("openOrganizationModal")
        ?.addEventListener("click", () => {
            organizationModal.classList.remove("hidden");
            document.body.classList.add("overflow-hidden");
            setTimeout(() => {
                organizationBackdrop.classList.remove("opacity-0");
                organizationPanel.classList.remove(
                    "opacity-0",
                    "translate-y-4"
                );
            }, 10);
        });

    document
        .getElementById("closeOrganizationModal")
        ?.addEventListener("click", closeOrganizationModal);
    document
        .getElementById("cancelOrganizationModal")
        ?.addEventListener("click", closeOrganizationModal);
    organizationModal?.addEventListener("click", (e) => {
        if (e.target === organizationModal) closeOrganizationModal();
    });

    function closeOrganizationModal() {
        organizationBackdrop.classList.add("opacity-0");
        organizationPanel.classList.add("opacity-0", "translate-y-4");
        setTimeout(() => {
            organizationModal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }

    // ================== ITEM MODAL ==================
    const itemModal = document.getElementById("itemModal");
    const itemBackdrop = document.getElementById("itemBackdrop");
    const itemPanel = document.getElementById("itemPanel");

    document.getElementById("openItemModal")?.addEventListener("click", () => {
        itemModal.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
        setTimeout(() => {
            itemBackdrop.classList.remove("opacity-0");
            itemPanel.classList.remove("opacity-0", "translate-y-4");
        }, 10);
    });

    document
        .getElementById("closeItemModal")
        ?.addEventListener("click", closeItemModal);
    document
        .getElementById("cancelItemModal")
        ?.addEventListener("click", closeItemModal);
    itemModal?.addEventListener("click", (e) => {
        if (e.target === itemModal) closeItemModal();
    });

    function closeItemModal() {
        itemBackdrop.classList.add("opacity-0");
        itemPanel.classList.add("opacity-0", "translate-y-4");
        setTimeout(() => {
            itemModal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }

    // ================== PROMO DISCOUNT VALIDATION ==================
    const promoDiscountInput = document.getElementById("promoDiscount");
    const promoTypeSelect = document.getElementById("promoType");

    function validatePromoDiscount() {
        if (!promoDiscountInput || !promoTypeSelect) return;

        const type = promoTypeSelect.value;
        const max = type === "percentage" ? 100 : 1000000; // batas max
        if (Number(promoDiscountInput.value) > max)
            promoDiscountInput.value = max;
        if (Number(promoDiscountInput.value) < 0) promoDiscountInput.value = 0;
    }

    promoDiscountInput?.addEventListener("input", validatePromoDiscount);
    promoTypeSelect?.addEventListener(
        "change",
        () => (promoDiscountInput.value = "")
    );

    // ================== PROMO MODAL ==================
    const promoModal = document.getElementById("promoModal");
    const promoBackdrop = document.getElementById("promoBackdrop");
    const promoPanel = document.getElementById("promoPanel");

    document
        .getElementById("openAddPromoModal")
        ?.addEventListener("click", () => {
            promoModal.classList.remove("hidden");
            document.body.classList.add("overflow-hidden");
            setTimeout(() => {
                promoBackdrop.classList.remove("opacity-0");
                promoPanel.classList.remove("opacity-0", "translate-y-4");
            }, 10);
        });

    document
        .getElementById("closePromoModal")
        ?.addEventListener("click", closePromoModal);
    document
        .getElementById("cancelPromoModal")
        ?.addEventListener("click", closePromoModal);
    promoModal?.addEventListener("click", (e) => {
        if (e.target === promoModal) closePromoModal();
    });

    function closePromoModal() {
        promoBackdrop.classList.add("opacity-0");
        promoPanel.classList.add("opacity-0", "translate-y-4");
        setTimeout(() => {
            promoModal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }

    // ================= PROMO UPDATE MODAL =================
    document.querySelectorAll("[id^='open-promo-update-modal-']").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const promoId = this.getAttribute("data-id");
            if (promoId) {
                handlePromoUpdateModal(promoId, "open");
            }
        });
    });

    document
        .querySelectorAll(
            '[id^="closePromoUpdateModal-"], [id^="cancelPromoUpdateModal-"]'
        )
        .forEach((button) => {
            button.addEventListener("click", function () {
                const parts = this.id.split("-");
                const promoId = parts.slice(-1)[0];
                if (promoId) {
                    handlePromoUpdateModal(promoId, "close");
                }
            });
        });

    document.querySelectorAll('[id^="promoUpdateModal-"]').forEach((modal) => {
        modal.addEventListener("click", function (e) {
            if (e.target === this) {
                const parts = this.id.split("-");
                const promoId = parts.slice(-1)[0];
                if (promoId) {
                    handlePromoUpdateModal(promoId, "close");
                }
            }
        });
    });

    // ================== ATTENDEE UPDATE MODAL ==================
    document
        .querySelectorAll("#open-attendee-update-modal")
        .forEach((button) => {
            button.addEventListener("click", function (e) {
                e.preventDefault();
                const attendeeId = this.getAttribute("data-id");
                if (attendeeId) {
                    handleAttendeeUpdateModal(attendeeId, "open");
                }
            });
        });

    document
        .querySelectorAll(
            '[id^="closeAttendeesUpdateModal-"], [id^="cancelAttendeesUpdateModal-"]'
        )
        .forEach((button) => {
            button.addEventListener("click", function () {
                const parts = this.id.split("-");
                const attendeeId = parts.slice(-1)[0];
                if (attendeeId) {
                    handleAttendeeUpdateModal(attendeeId, "close");
                }
            });
        });

    document
        .querySelectorAll('[id^="attendeesUpdateModal-"]')
        .forEach((modal) => {
            modal.addEventListener("click", function (e) {
                if (e.target === this) {
                    const attendeeId = this.id.split("-")[1];
                    if (attendeeId) {
                        handleAttendeeUpdateModal(attendeeId, "close");
                    }
                }
            });
        });

    // ================== TIKET & PRIDUCT UPDATE MODAL ==================
    document.querySelectorAll("#open-item-update-modal").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const ticketId = this.getAttribute("data-id");
            if (ticketId) {
                handleTicketProductUpdateModal(ticketId, "open");
            }
        });
    });

    document
        .querySelectorAll(
            '[id^="closeItemUpdateModal-"], [id^="cancelItemUpdateModal-"]'
        )
        .forEach((button) => {
            button.addEventListener("click", function () {
                const parts = this.id.split("-");
                const ticketId = parts.slice(-1)[0];
                if (ticketId) {
                    handleTicketProductUpdateModal(ticketId, "close");
                }
            });
        });

    document.querySelectorAll('[id^="itemUpdateModal-"]').forEach((modal) => {
        modal.addEventListener("click", function (e) {
            if (e.target === this) {
                const ticketId = this.id.split("-")[1];
                if (ticketId) {
                    handleTicketProductUpdateModal(ticketId, "close");
                }
            }
        });
    });

    // ================== DROPDOWNS ==================
    const userMenuButton = document.getElementById("user-menu-button");
    const userMenu = document.getElementById("user-menu");
    let userMenuOpen = false;

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener("click", (e) => {
            e.stopPropagation();
            if (userMenuOpen) {
                closeDropdown(userMenu);
                userMenuOpen = false;
            } else {
                toggleDropdown(userMenu, () => (userMenuOpen = true));
            }
        });

        document.addEventListener("click", (e) => {
            if (
                userMenuOpen &&
                !userMenu.contains(e.target) &&
                !userMenuButton.contains(e.target)
            ) {
                closeDropdown(userMenu);
                userMenuOpen = false;
            } else {
                userMenuOpen = true;
            }
        });
    }

    const createButton = document.getElementById("dropdownCreateButton");
    const createMenu = document.getElementById("dropdownCreate");
    const createArrow = document.getElementById("dropdownArrow");
    let createMenuOpen = false;

    if (createButton && createMenu) {
        createButton.addEventListener("click", (e) => {
            e.stopPropagation();
            toggleDropdown(createMenu, () => {
                createArrow?.classList.toggle("rotate-180");
                createMenuOpen = !createMenuOpen;
            });
        });

        document.addEventListener("click", (e) => {
            if (
                createMenuOpen &&
                !createMenu.contains(e.target) &&
                !createButton.contains(e.target)
            ) {
                closeDropdown(createMenu);
                createArrow?.classList.remove("rotate-180");
                createMenuOpen = false;
            }
        });
    }

    function toggleDropdown(menu, toggleState) {
        menu.classList.remove("hidden");
        setTimeout(() => {
            menu.classList.remove("opacity-0", "scale-95");
            menu.classList.add("opacity-100", "scale-100");
        }, 10);
        toggleState();
    }

    function closeDropdown(menu) {
        menu.classList.remove("opacity-100", "scale-100");
        menu.classList.add("opacity-0", "scale-95");
        setTimeout(() => menu.classList.add("hidden"), 150);
    }

    // ================== SIDEBAR TOGGLE ==================
    const sidebarToggle = document.getElementById("sidebarAdminToggle");
    const sidebar = document.getElementById("sidebarAdmin");

    sidebarToggle?.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full");

        // Toggle icon
        const icon = sidebarToggle.querySelector("i");
        icon.classList.toggle("ri-arrow-right-s-line");
        icon.classList.toggle("ri-arrow-left-s-line");
    });

    // ================== IMAGE PREVIEW ==================
    setupImagePreview(
        "file-upload",
        "preview-image",
        "default-state",
        "preview-state",
        "change-image"
    );
    setupImagePreview(
        "itemFileUpload",
        "itemPreviewImage",
        "itemDefaultState",
        "itemPreviewState",
        "itemChangeImage"
    );

    // ================== Image Preview Setup ==================
    function setupImagePreview(
        fileInputId,
        previewImgId,
        defaultId,
        previewId,
        changeBtnId
    ) {
        const fileInput = document.getElementById(fileInputId);
        const previewImage = document.getElementById(previewImgId);
        const defaultState = document.getElementById(defaultId);
        const previewState = document.getElementById(previewId);
        const changeButton = document.getElementById(changeBtnId);

        if (
            !fileInput ||
            !previewImage ||
            !defaultState ||
            !previewState ||
            !changeButton
        ) {
            return;
        }

        defaultState.addEventListener("click", () => fileInput.click());

        fileInput.addEventListener("change", () => {
            const file = fileInput.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                defaultState.classList.add("hidden");
                previewState.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        });

        changeButton.addEventListener("click", () => fileInput.click());
    }

    // Inisialisasi semua upload image berdasarkan ID
    document.querySelectorAll("[id^=file-upload-]").forEach((input) => {
        const id = input.id.replace("file-upload-", "");
        setupImagePreview(
            `file-upload-${id}`,
            `preview-image-${id}`,
            `default-state-${id}`,
            `preview-state-${id}`,
            `change-image-${id}`
        );
    });

    // ================== MOBILE MENU ==================
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    mobileMenuButton?.addEventListener("click", () => {
        const isExpanded =
            mobileMenuButton.getAttribute("aria-expanded") === "true";
        mobileMenuButton.setAttribute("aria-expanded", !isExpanded);
        mobileMenu.classList.toggle("hidden");
    });

    // ================== NAVBAR SCROLL ==================
    const navbar = document.getElementById("navbar");
    window.addEventListener("scroll", () => {
        if (navbar) {
            navbar.classList.toggle("scrolled-nav", window.scrollY > 10);
        }
    });

    // ================== PRELOADER ==================
    const preloader = document.getElementById("preloader");
    if (preloader) {
        preloader.style.opacity = "0";
        setTimeout(() => {
            preloader.style.display = "none";
        }, 300);
    }

    // ================== ITEM TYPE TOGGLE ==================
    document.querySelectorAll(".item-type-toggle").forEach((btn) => {
        btn.addEventListener("click", function () {
            const selectedType = this.getAttribute("data-type");

            // Ganti class button aktif
            document.querySelectorAll(".item-type-toggle").forEach((el) => {
                el.classList.remove("bg-white", "shadow-sm", "text-indigo-600");
                el.classList.add("text-gray-500");
            });

            this.classList.add("bg-white", "shadow-sm", "text-indigo-600");
            this.classList.remove("text-gray-500");

            // Update value hidden input
            const itemTypeInput = document.getElementById("itemType");
            if (itemTypeInput) {
                itemTypeInput.value = selectedType;
            }

            // Optional: Ganti title/modalTitle?
            const modalTitle = document.getElementById("modalTitle");
            if (modalTitle) {
                modalTitle.textContent =
                    selectedType === "ticket"
                        ? "Add New Ticket"
                        : "Add New Merchandise";
            }
        });
    });
});
