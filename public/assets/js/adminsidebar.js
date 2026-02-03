document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    toggles.forEach(toggle => {
        const icon = toggle.querySelector(".toggle-icon");
        const targetId = toggle.getAttribute("href");
        const targetMenu = document.querySelector(targetId);

        // Saat diklik
        toggle.addEventListener("click", function () {
            // langsung toogle icon
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
        });

        // Saat halaman dimuat, cek apakah submenu aktif (ada .active di dalamnya)
        if (targetMenu && targetMenu.querySelector(".nav-link.active")) {
            new bootstrap.Collapse(targetMenu, { toggle: true });
            toggle.setAttribute("aria-expanded", "true");
            
            //saat sub menu terbuka langsung rotate panah
            if (icon) {
                icon.classList.add("rotate-180");
           }
           
        }
    });
});
