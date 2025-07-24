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

function handleOrdersUpdateModal(ordersId, action) {
    const modal = document.getElementById(`orderUpdateModal-${ordersId}`);
    const backdrop = document.getElementById(`orderUpdateBackdrop-${ordersId}`);
    const panel = document.getElementById(`orderUpdatePanel-${ordersId}`);

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

// ================== DOMContentLoaded START ==================
document.addEventListener("DOMContentLoaded", () => {
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

    // ================== ORGANIZER MODAL ==================
    const organizerModal = document.getElementById("organizerModal");
    const organizerBackdrop = document.getElementById("organizerModalBackdrop");
    const organizerPanel = document.getElementById("organizerModalPanel");

    document
        .getElementById("openOrganizerModal")
        ?.addEventListener("click", () => {
            organizerModal.classList.remove("hidden");
            document.body.classList.add("overflow-hidden");
            setTimeout(() => {
                organizerBackdrop.classList.remove("opacity-0");
                organizerPanel.classList.remove("opacity-0", "translate-y-4");
            }, 10);
        });

    document
        .getElementById("closeOrganizerModal")
        ?.addEventListener("click", closeOrganizerModal);
    document
        .getElementById("cancelOrganizerModal")
        ?.addEventListener("click", closeOrganizerModal);
    organizerModal?.addEventListener("click", (e) => {
        if (e.target === organizerModal) closeOrganizerModal();
    });

    function closeOrganizerModal() {
        organizerBackdrop.classList.add("opacity-0");
        organizerPanel.classList.add("opacity-0", "translate-y-4");
        setTimeout(() => {
            organizerModal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }, 300);
    }

    // ================== ITEM MODAL ==================
    const itemModal = document.getElementById("itemModal");
    const itemBackdrop = document.getElementById("itemBackdrop");
    const itemPanel = document.getElementById("itemPanel");

    document
    .getElementById("openItemModal")
    ?.addEventListener("click", () => {
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

    // ================== ORDER UPDATE MODAL ==================
    document.querySelectorAll("#open-order-update-modal").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const orderId = this.getAttribute("data-id");
            if (orderId) {
                handleOrdersUpdateModal(orderId, "open");
            }
        });
    });

    document
        .querySelectorAll(
            '[id^="closeOrderUpdateModal-"], [id^="cancelOrderUpdateModal-"]'
        )
        .forEach((button) => {
            button.addEventListener("click", function () {
                const parts = this.id.split("-");
                const orderId = parts.slice(-1)[0];
                if (orderId) {
                    handleOrdersUpdateModal(orderId, "close");
                }
            });
        });

    document.querySelectorAll('[id^="orderUpdateModal-"]').forEach((modal) => {
        modal.addEventListener("click", function (e) {
            if (e.target === this) {
                const orderId = this.id.split("-")[1];
                if (orderId) {
                    handleOrdersUpdateModal(orderId, "close");
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
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebar = document.querySelector("aside");
    const mainContent = document.getElementById("main-content");

    sidebarToggle?.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full");

        // Toggle main content margin
        mainContent.classList.toggle("md:ml-64");
        mainContent.classList.toggle("w-full");

        // Toggle icon
        const icon = sidebarToggle.querySelector("i");
        icon.classList.toggle("ri-arrow-left-s-line");
        icon.classList.toggle("ri-arrow-right-s-line");
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

        // Cegah error jika salah satu elemen tidak ada
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
});
