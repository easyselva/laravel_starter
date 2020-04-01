const ps = new PerfectScrollbar('#sidebar-content', {
    wheelSpeed: 0.5,
    swipeEasing: true,
    wheelPropagation: false,
    maxScrollbarLength: 50
});
$(document).ready(function () {
    $(window).resize(function () {
        ps.update();
    });
    $("#toggle-sidebar,#overlay").click(function () {
        $("body").toggleClass("sidebar-open");
    });
    $("#sidemenu-link").click(function () {
        if ($("body").hasClass("sidebar-mini")) {
            $("body").removeClass("sidebar-mini");
            $("#sidebar").unbind("hover");
            $("#sidemenu-link").removeClass("la-angle-double-right");
            $("#sidemenu-link").addClass("la-angle-double-left");
        } else {
            $("body").addClass("sidebar-mini");
            $("#sidemenu-link").addClass("la-angle-double-right");
            $("#sidemenu-link").removeClass("la-angle-double-left");
            $("#sidebar").hover(
                function () {
                    $("body").addClass("sidebar-hovered");
                },
                function () {
                    $("body").removeClass("sidebar-hovered");
                }
            )
        }
    });
    // Dropdown menu
    $(".sidebar-dropdown > a").click(function () {
        // $(".sidebar-submenu").slideUp(200);
        if ($(this).parent().hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            //   $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }
    });
    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $("body").addClass("desktop");
        // $("body").addClass("sidebar-open");
    }
    $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
            $('.dropdown-submenu .show').removeClass("show");
        });
        return false;
    });
});
