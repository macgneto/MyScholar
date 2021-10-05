/*!
    * Start Bootstrap - SB Admin v6.0.1 (https://startbootstrap.com/templates/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    (function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);





// Add Record
function addRecord() {
    // get values
    var arithmos = $("#arithmos").val();
    // number = first_name.trim();
    // var last_name = $("#last_name").val();
    // last_name = last_name.trim();
    // var email = $("#email").val();
    // email = email.trim();

    if (arithmos == "") {
        alert("First name field is required!");
    }
    // else if (last_name == "") {
    //     alert("Last name field is required!");
    // }
    // else if (email == "") {
    //     alert("Email field is required!");
    // }
    else {
        // Add record
        $.post("..student/create.php", {
            number: number,
            // last_name: last_name,
            // email: email
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");

            // read records again
            readRecords();

            // clear fields from the popup
            // $("#first_name").val("");
            // $("#last_name").val("");
            // $("#email").val("");
        });
    }
}
