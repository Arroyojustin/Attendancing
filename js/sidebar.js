(function(l) {
    "use strict";
    
    l("#sidebarToggle").on("click", function() {
        l("body").toggleClass("sidebar-toggled");
        
        // Smooth transition for toggling the sidebar
        l(".sidebar-container").toggleClass("toggled");
        
        // Adjust sidebar width and icon sizes when toggled
        if (l(".sidebar-container").hasClass("toggled")) {
            l(".sidebar-link").each(function() {
                l(this).find("span").hide(); // Hide text
                l(this).find("i").css({
                    "font-size": "1.5rem",
                    "width": "100%",
                    "display": "flex",
                    "justify-content": "center",
                    "align-items": "center"
                });
            });
        } else {
            l(".sidebar-link").each(function() {
                l(this).find("span").show(); // Show text
                l(this).find("i").css({
                    "font-size": "1.4rem",
                    "width": "auto",
                    "display": "inline-block",
                    "justify-content": "center",
                    "align-items": "center"
                });
            });
        }
    });
}(jQuery));

jQuery(document).ready(function() {
    jQuery("#sidebar-toggle").on("click", function() {
        jQuery(".sidebar-container").toggleClass("d-none");
        jQuery(".sidebar-container").toggleClass("toggled");

        // Toggle the visibility of the spans
        if (jQuery(".sidebar-container").hasClass("toggled")) {
            jQuery(".sidebar-link span").hide(); // Hide spans
        } else {
            jQuery(".sidebar-link span").show(); // Show spans
        }
    });
});