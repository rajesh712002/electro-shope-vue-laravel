//For User Password Reset/Change

$(document).ready(function () {
    $("#ChangePasswordForm").on("submit", function (e) {
        e.preventDefault();

        var data = new FormData($(this)[0]);
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        console.log(data);
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            data: data,

            success: function (response) {
                // alert(response.success);
                // // window.location.href = "/admin/category";
                //  $("#ChangePasswordForm")[0].reset();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]')
                            .parent()
                            .find(".error, .error_no_margin")
                            .text("** " + value[0] + "!");
                    });
                    // var errors = response.error;

                    // if (errors.old_password) {
                    //     $("#old_password")
                    //         .addClass("is-invalid")
                    //         .siblings("p")
                    //         .addClass("invalid-feedback")
                    //         .html(errors.old_password);
                    // } else {
                    //     $("#old_password")
                    //         .removeClass("is-invalid")
                    //         .siblings("p")
                    //         .removeClass("invalid-feedback")
                    //         .html(errors.old_password);
                    // }

                    // if (errors.new_password) {
                    //     $("#new_password")
                    //         .addClass("is-invalid")
                    //         .siblings("p")
                    //         .addClass("invalid-feedback")
                    //         .html(errors.new_password);
                    // } else {
                    //     $("#new_password")
                    //         .removeClass("is-invalid")
                    //         .siblings("p")
                    //         .removeClass("invalid-feedback")
                    //         .html(errors.new_password);
                    // }

                    // if (errors.confirm_password) {
                    //     $("#confirm_password")
                    //         .addClass("is-invalid")
                    //         .siblings("p")
                    //         .addClass("invalid-feedback")
                    //         .html(errors.confirm_password);
                    // } else {
                    //     $("#confirm_password")
                    //         .removeClass("is-invalid")
                    //         .siblings("p")
                    //         .removeClass("invalid-feedback")
                    //         .html(errors.confirm_password);
                    // }
                }
            },
        });
    });
});



 //=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//

//For User Update Profile

$(document).ready(function () {
    $("#ProfileUpdateForm").on("submit", function (e) {
        e.preventDefault();

        var data = new FormData($(this)[0]);
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        console.log(data);
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            data: data,

            success: function (response) {
                // alert(response.success);
                // // window.location.href = "/admin/category";
                //  $("#ChangePasswordForm")[0].reset();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]')
                            .parent()
                            .find(".error, .error_no_margin")
                            .text("** " + value[0] + "!");
                    });
                    
                }
            },
        });
    });
});

