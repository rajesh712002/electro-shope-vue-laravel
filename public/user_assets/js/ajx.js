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
        $(".overlay").show();

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
                window.location.href = "/user/cart";
            },
            error: function (xhr) {
        $(".overlay").hide();

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

// $(document).ready(function () {
//     $("#DecreaseCartForm").on("click", function (e) {
//         e.preventDefault();
//         var data = new FormData($(this)[0]);
//         let csrfToken = $('meta[name="csrf-token"]').attr("content");
//         console.log(data);
//         var url = $(this).attr("action");

//         $.ajax({
//             url: url,
//             type: "POST",
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             },
//             contentType: false,
//             processData: false,
//             data: data,

//             success: function (response) {
//                 // $("#DecreaseCartForm")[0].reset();
//                 // alert(response.success);
//                 window.location.href = "/user/cart";
//             },
//             error: function (xhr) {
//                 if (xhr.status === 422) {
//                     var errors = xhr.responseJSON.errors;
//                     // $.each(errors, function (key, value) {
//                     //     $('[name="' + key + '"]')
//                     //         .parent()
//                     //         .find(".error, .error_no_margin")
//                     //         .text("** " + value[0] + "!");
//                     // });
//                 }
//             },
//         });
//     });
// });

//User Cart Functionality

function updateQuantity(cartId, action) {
    let url =
        action === "increase"
            ? "/user/cart/increase/" + cartId
            : "/user/cart/decrease/" + cartId;

    $.ajax({
        url: url,
        method: "PUT",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#cart-quantity-" + cartId).val(response.newQty);
                $("#cart-total-" + cartId).text(response.newTotal);
                $("#cart-discount").text(response.discount_amount);
                $("#discount_code").val(response.coupon_code);
                $("#remove_coupon").hide();
                console.log(response);
                updateCartSummary();
            } else {
                alert(response.message);
            }
        },
    });
}

function removeItem(cartId) {
    let url = "/user/cart/remove_item/" + cartId;

    $.ajax({
        url: url,
        method: "DELETE",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#cart-item-" + cartId).remove();
                $("#cart-discount").text(response.discount_amount);
                $("#discount_code").val(response.coupon_code);
                $("#remove_coupon").hide();
                updateCartSummary();
            }
        },
    });
}

$("#apply_discount").click(function () {
    let couponCode = $("#discount_code").val();
    let url = "/user/apply_coupon";

    if (!couponCode) {
        alert("Please enter a coupon code.");
        return;
    }

    $.ajax({
        url: url,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            coupon_code: couponCode,
        },
        success: function (response) {
            if (response.success) {
                // Update the total price and show discount
                $("#cart-total").text(response.newTotal);
                $("#cart-discount").text(response.discountAmount);
                alert("Coupon applied successfully!");
                $("#remove_coupon").show();
            } else {
                $("#remove_coupon").show();
                alert(response.message);

            }
        },
        error: function () {
            alert(
                "An error occurred while applying the coupon. Please try again."
            );
        },
    });
});

// Remove Coupon logic
$(document).ready(function () {
    $("#remove_coupon").on("click", function () {
        $.ajax({
            url: "/user/remove_coupon",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    // Reset the discount and coupon code fields
                    $("#cart-discount").text(response.discount_amount);
                    $("#discount_code").val("");

                    $("#remove_coupon").hide();
                    updateCartSummary();

                    console.log(response.message);
                } else {
                    alert("Error removing coupon");
                }
            },
            error: function (error) {
                alert("Error processing request");
            },
        });
    });
});

// Fetch coupons when the modal is triggered
$(document).ready(function () {
    $("#couponModal").on("show.bs.modal", function () {
        $.ajax({
            url: "/user/get_coupons",
            method: "GET",
            success: function (response) {
                let couponList = $("#couponList");
                couponList.empty();
                if (response.length > 0) {
                    $.each(response, function (index, coupon) {
                        couponList.append(`
                               <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Code:</strong><span style="color: red;"> ${
                            coupon.code
                        }</span> <br>
                        <strong>Max Uses:</strong> ${coupon.max_uses} <br>
                      
                        <strong>Expires on:</strong> ${coupon.expires_at}
                    </div>
                    <div>
                    <strong>Discount:</strong> 
                    ${
                        coupon.discount_type === "fixed"
                            ? `$${coupon.discount_amount} ${coupon.type}`
                            : `${coupon.discount_amount} ${coupon.type}`
                    } <br>
                    <strong>Name:</strong> ${coupon.name} <br>
                    <strong>Minimum Amount:</strong> ${coupon.min_amount} <br>
                    </div>
                   
                </li>
                        `);
                    });
                } else {
                    couponList.append(
                        '<li class="list-group-item">No coupons available at this time.</li>'
                    );
                }
            },
            error: function () {
                $("#couponList").html(
                    '<li class="list-group-item">Failed to load coupons.</li>'
                );
            },
        });
    });
});

function updateCartSummary() {
    let total = 0;

    // Iterate through each cart item row
    $('tr[id^="cart-item-"]').each(function () {
        let cartId = $(this).attr("id").split("-")[2]; // Extract cart ID from row ID
        let quantity = parseInt($("#cart-quantity-" + cartId).val());
        let price = parseFloat(
            $("#cart-total-" + cartId)
                .text()
                .replace(/[^0-9.-]+/g, "")
        );

        if (!isNaN(quantity) && !isNaN(price)) {
            total += price;
        }
    });

    // Update the subtotal and total in the cart summary
    $("#cart-subtotal").text(total.toFixed(2));
    $("#cart-total").text(total.toFixed(2));
    // $("#cart-discount").text(discountTotal.toFixed(2));
}

//=======//==============//=====================//============================//

$(document).ready(function () {
    // Hide all forms on page load
    $("#CardPaymentForm").addClass("d-none");
    $("#CardPaymentFormOne").addClass("d-none");
    $("#CardPaymentFormTwo").addClass("d-none");
    $("#CardPaymentFormThree").addClass("d-none");
    $("#CardPaymentFormFour").addClass("d-none");

    // Check which payment method is selected on page load and show the correct form
    if ($("#payment_method").is(":checked")) {
        $("#CardPaymentForm").removeClass("d-none");
    } else if ($("#payment_method_one").is(":checked")) {
        $("#CardPaymentFormOne").removeClass("d-none");
    } else if ($("#payment_method_two").is(":checked")) {
        $("#CardPaymentFormTwo").removeClass("d-none");
    } else if ($("#payment_method_three").is(":checked")) {
        $("#CardPaymentFormThree").removeClass("d-none");
    } else if ($("#payment_method_four").is(":checked")) {
        $("#CardPaymentFormFour").removeClass("d-none");
    }

    // Event listener for COD
    $("#payment_method_one").on("click", function () {
        if ($(this).is(":checked") == true) {
            $("#CardPaymentFormOne").removeClass("d-none");
            $("#CardPaymentFormTwo").addClass("d-none");
            $("#CardPaymentFormThree").addClass("d-none");
            $("#CardPaymentFormFour").addClass("d-none");
        }
    });

    // Event listener for Stripe
    $("#payment_method_two").on("click", function () {
        if ($(this).is(":checked") == true) {
            $("#CardPaymentFormTwo").removeClass("d-none");
            $("#CardPaymentFormOne").addClass("d-none");
            $("#CardPaymentFormThree").addClass("d-none");
            $("#CardPaymentFormFour").addClass("d-none");
        }
    });

    // Event listener for PayPal
    $("#payment_method_three").on("click", function () {
        if ($(this).is(":checked") == true) {
            $("#CardPaymentFormThree").removeClass("d-none");
            $("#CardPaymentFormOne").addClass("d-none");
            $("#CardPaymentFormTwo").addClass("d-none");
            $("#CardPaymentFormFour").addClass("d-none");
        }
    });

    // Event listener for Braintree
    $("#payment_method_four").on("click", function () {
        if ($(this).is(":checked") == true) {
            $("#CardPaymentFormFour").removeClass("d-none");
            $("#CardPaymentFormThree").addClass("d-none");
            $("#CardPaymentFormOne").addClass("d-none");
            $("#CardPaymentFormTwo").addClass("d-none");
        }
    });

    // None
    $("#payment_method").on("click", function () {
        if ($(this).is(":checked") == true) {
            $("#CardPaymentFormOne").addClass("d-none");
            $("#CardPaymentFormTwo").addClass("d-none");
            $("#CardPaymentFormThree").addClass("d-none");
            $("#CardPaymentFormFour").addClass("d-none");
        }
    });
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
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                } else {
                    // Default redirect or action if no redirect URL is provided
                    window.location.href = "{{route('viewproduct')}}";
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    if (errors.name) {
                        $("#name")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.name);
                    } else {
                        $("#name")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.name);
                    }

                    if (errors.rating) {
                        $("#rating")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.rating);
                    } else {
                        $("#rating")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.rating);
                    }

                    if (errors.comment) {
                        $("#comment")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.comment);
                    } else {
                        $("#comment")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.comment);
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
                }
            },
        });
    });
});

$(document).ready(function () {
    $("#SubCategoryForm").on("submit", function (e) {
        e.preventDefault();
        var data = new FormData($(this)[0]);
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        console.log(data);
        var url = $(this).attr("action");

        $(".overlay").show();
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
                $("#SubCategoryForm")[0].reset();
                alert(response.success);
                // window.location.href = "/admin/createsubcategories";
            },
        });
    });
});
