document.addEventListener('DOMContentLoaded', function () {
    const superAdminMenuButton = document.getElementById("superAdminMenuButton");
    const superAdminMenu = document.getElementById("superAdminMenu");

    superAdminMenuButton?.addEventListener("click", (e) => {
        e.stopPropagation();
        superAdminMenu.classList.toggle("hidden");
    });

    if (superAdminMenu && superAdminMenuButton) {
        document.addEventListener("click", (e) => {
            if (!superAdminMenu.contains(e.target) && !superAdminMenuButton.contains(e.target)) {
                superAdminMenu.classList.add("hidden");
            }
        });
    }
    
    function toggleSubmenu(submenuId) {
        const submenuContent = document.querySelector(`.submenu-content[data-submenu="${submenuId}"]`);
        const submenuIcon = document.querySelector(`.submenu-icon[data-submenu="${submenuId}"]`);

        if (submenuContent.style.maxHeight && submenuContent.style.maxHeight !== '0px') {
            submenuContent.style.maxHeight = '0px';
            submenuIcon.classList.remove('rotate-180');
        } else {
            submenuContent.style.maxHeight = submenuContent.scrollHeight + 'px';
            submenuIcon.classList.add('rotate-180');
        }
    }

    document.querySelectorAll('.menu-item[data-submenu]').forEach(trigger => {
        trigger.addEventListener('click', function () {
            const submenuId = this.getAttribute('data-submenu');
            toggleSubmenu(submenuId);
        });
    });


    const sidebarToggles = document.querySelectorAll('#sidebarSuperAdminToggle');
    const sidebar = document.querySelector('#sidebarSuperAdmin');
    const mainContent = document.querySelector('#mainContentSuperAdmin');

    sidebarToggles.forEach(toggle => {
        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
            mainContent.classList.toggle("md:ml-80");
            mainContent.classList.toggle("w-full");
        });
    });

});