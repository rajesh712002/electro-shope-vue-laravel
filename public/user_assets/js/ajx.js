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
                    // $.each(errors, function (key, value) {
                    //     $('[name="' + key + '"]')
                    //         .parent()
                    //         .find(".error, .error_no_margin")
                    //         .text("** " + value[0] + "!");
                    // });
                    // var errors = response.error;

                    if (errors.old_password) {
                        $("#old_password")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.old_password);
                    } else {
                        $("#old_password")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.old_password);
                    }

                    if (errors.new_password) {
                        $("#new_password")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.new_password);
                    } else {
                        $("#new_password")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.new_password);
                    }

                    if (errors.confirm_password) {
                        $("#confirm_password")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.confirm_password);
                    } else {
                        $("#confirm_password")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.confirm_password);
                    }
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

//==========================================================================================

//User Addresses

$(document).ready(function () {
    $("#CheckoutForm").on("submit", function (e) {
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
                $("#CheckoutForm")[0].reset();
                alert("Order Placed Successfully");
                window.location.href = "/cart";
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    if (errors.first_name) {
                        $("#first_name")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.first_name);
                    } else {
                        $("#first_name")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.first_name);
                    }

                    if (errors.last_name) {
                        $("#last_name")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.last_name);
                    } else {
                        $("#last_name")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.last_name);
                    }

                    if (errors.email) {
                        $("#email")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.email);
                    } else {
                        $("#email")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.email);
                    }

                    if (errors.country) {
                        $("#country")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.country);
                    } else {
                        $("#country")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.country);
                    }

                    if (errors.address) {
                        $("#address")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.address);
                    } else {
                        $("#address")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.address);
                    }

                    if (errors.appartment) {
                        $("#appartment")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.appartment);
                    } else {
                        $("#appartment")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.appartment);
                    }

                    if (errors.city) {
                        $("#city")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.city);
                    } else {
                        $("#city")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.city);
                    }

                    if (errors.state) {
                        $("#state")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.state);
                    } else {
                        $("#state")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.state);
                    }

                    if (errors.mobile) {
                        $("#mobile")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.mobile);
                    } else {
                        $("#mobile")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.mobile);
                    }

                    if (errors.card_number) {
                        $("#card_number")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.card_number);
                    } else {
                        $("#card_number")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.card_number);
                    }

                    if (errors.expiry_date) {
                        $("#expiry_date")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.expiry_date);
                    } else {
                        $("#expiry_date")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.expiry_date);
                    }

                    if (errors.zip) {
                        $("#zip")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.zip);
                    } else {
                        $("#zip")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.zip);
                    }

                    if (errors.cvv) {
                        $("#cvv")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.cvv);
                    } else {
                        $("#cvv")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.cvv);
                    }
                }
            },
        });
    });
});

//=======//==============//=====================//============================//

$(document).ready(function () {
    $("#DecreaseCartForm").on("click", function (e) {
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
                // $("#DecreaseCartForm")[0].reset();
                // alert(response.success);
                window.location.href = "/cart";
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    // $.each(errors, function (key, value) {
                    //     $('[name="' + key + '"]')
                    //         .parent()
                    //         .find(".error, .error_no_margin")
                    //         .text("** " + value[0] + "!");
                    // });
                }
            },
        });
    });
});

//=======//==============//=====================//============================//
$("#payment_method_one").on("click", function () {
    if ($(this).is(":checked") == true) {
        $("#CardPaymentForm").addClass("d-none");
    }
});

$("#payment_method_two").on("click", function () {
    if ($(this).is(":checked") == true) {
        $("#CardPaymentForm").removeClass("d-none");
    }
});

//=======//==============//=====================//============================//

$(document).ready(function () {
    $("#ProductRatingForm").on("submit", function (e) {
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
                // $("#ProductRatingForm")[0].reset();
                // alert(response.success);
                // window.location.href = "";
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    if (errors.first_name) {
                        $("#name")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.first_name);
                    } else {
                        $("#name")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.first_name);
                    }
                }
            },
        });
    });
});
