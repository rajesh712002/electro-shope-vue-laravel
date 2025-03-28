//Ajax For Category

//For Insert Category

$(document).ready(function () {
    $("#CategoryForm").on("submit", function (e) {
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
                $(".overlay").hide();
                alert(response.success);
                window.location.href = "/admin/category";
                // $("#CategoryForm")[0].reset();
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//For Category Update

$(document).ready(function () {
    $("#UpdateCatForm").on("submit", function (e) {
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
                alert(response.success);
                window.location.href = "/admin/category";

                //  $('#UpdateCatForm')[0].reset();
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//For Category Delete

$(document).ready(function () {
    $("#delete_product_").on("click", function () {
        let categoryId = $(this).data("id");
        var url = $(this).attr("action");
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: url,
            type: "DELETE",
            data: {
                categoryId: categoryId,
                _token: csrfToken,
            },
            dataType: "json",
            success: function (response) {
                alert(response.success);
                window.location.href = "/admin/category";
            },
            error: function (xhr) {
                errorMessage(xhr.responseJSON.error);
            },
        });
    });
});

//=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//

//Ajax For SubCategory

//For Insert SubCategory

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
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    // $.each(errors, function (key, value) {
                    //     $('[name="' + key + '"]')
                    //         .parent()
                    //         .find(".error, .error_no_margin")
                    //         .text("** " + value[0] + "!");
                    // });

                    if (errors.category) {
                        $("#category")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.category);
                    } else {
                        $("#category")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.category);
                    }

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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//For Update SubCategory

$(document).ready(function () {
    $("#UpdateSubCategoryForm").on("submit", function (e) {
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
                $("#UpdateSubCategoryForm")[0].reset();
                alert(response.success);
                window.location.href = "/admin/subcategory";
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

                    if (errors.category) {
                        $("#category")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.category);
                    } else {
                        $("#category")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.category);
                    }

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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//For DELETE SubCategory

//=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//

//Ajax For Brand

//For Insert Brand

$(document).ready(function () {
    $("#BrandForm").on("submit", function (e) {
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
                $("#BrandForm")[0].reset();
                alert(response.success);
                window.location.href = "/admin/createbrand";
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//For Brand Update

$(document).ready(function () {
    $("#UpdateBrandForm").on("submit", function (e) {
        e.preventDefault();
        var data = new FormData($(this)[0]);
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        //  console.log(data);
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
                //$("#UpdateBrandForm")[0].reset();
                alert(response.success);
                window.location.href = "/admin/brand";
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//

//For Product Insert

$(document).ready(function () {
    $("#ProductForm").on("submit", function (e) {
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
                // $("#ProductForm")[0].reset();
                alert(response.success);
                window.location.href = "/admin/create-products";
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.description) {
                        $("#description")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.description);
                    } else {
                        $("#description")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.description);
                    }

                    if (errors.price) {
                        $("#price")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.price);
                    } else {
                        $("#price")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.price);
                    }

                    if (errors.qty) {
                        $("#qty")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.qty);
                    } else {
                        $("#qty")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.qty);
                    }

                    if (errors.category) {
                        $("#category")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.category);
                    } else {
                        $("#category")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.category);
                    }

                    if (errors.brand) {
                        $("#brand")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.brand);
                    } else {
                        $("#qtbrandy")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.brand);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//For product Update

$(document).ready(function () {
    $("#UpdateProductForm").on("submit", function (e) {
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
                //$("#UpdateProductForm")[0].reset();
                alert(response.success);
                window.location.href = "/admin/product";
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.description) {
                        $("#description")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.description);
                    } else {
                        $("#description")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.description);
                    }

                    if (errors.price) {
                        $("#price")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.price);
                    } else {
                        $("#price")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.price);
                    }

                    if (errors.qty) {
                        $("#qty")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.qty);
                    } else {
                        $("#qty")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.qty);
                    }

                    if (errors.category) {
                        $("#category")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.category);
                    } else {
                        $("#category")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.category);
                    }

                    if (errors.brand) {
                        $("#brand")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.brand);
                    } else {
                        $("#qtbrandy")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.brand);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }
                }
            },
        });
    });
});

//=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//

//For Dynamic Category to SubCategory

$(document).ready(function () {
    $("#category").on("change", function () {
        var category_id = $(this).val();
        $("#sub_category").html("");
        // if (category_id) {
        $.ajax({
            url: "/admin/get-subcategories/" + category_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#sub_category").empty();
                $("#sub_category").append(
                    '<option value="">---Select Subcategory---</option>'
                );
                $.each(data, function (key, value) {
                    $("#sub_category").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            value.subcate_name +
                            "</option>"
                    );
                    console.log(value);
                });

                // $('#sub_category').html('<option value="">Select Subcategory</option>');
                // $.each(data, function(key, value) {
                //     $('#sub_category').append('<option value="'+value.id+'">'+value.subcate_name+'</option>');
                // });
            },
        });
        // }
    });
});

//=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//

//for Admin Password Reset/Change

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
                            .siblings("p")
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
                            .siblings("p")
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
//Email Send

$(document).ready(function () {
    $("#sendInvoiceEmail").on("submit", function (e) {
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
                //$("#sendInvoiceEmail")[0].reset();
                // alert(response.success);
                // window.location.href = "/admin/product";
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

//=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//
// For Coupon Code Create
$(document).ready(function () {
    $("#CouponCodeForm").on("submit", function (e) {
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
                alert(response.success);
                window.location.href = "/admin/coupon";
                // $("#CouponCodeForm")[0].reset();
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
                    if (errors.code) {
                        $("#code")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.code);
                    } else {
                        $("#code")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.code);
                    }

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

                    if (errors.max_uses) {
                        $("#max_uses")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.max_uses);
                    } else {
                        $("#max_uses")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.max_uses);
                    }

                    if (errors.max_uses_user) {
                        $("#max_uses_user")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.max_uses_user);
                    } else {
                        $("#max_uses_user")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.max_uses_user);
                    }

                    if (errors.type) {
                        $("#type")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.type);
                    } else {
                        $("#type")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.type);
                    }

                    if (errors.discount_amount) {
                        $("#discount_amount")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.discount_amount);
                    } else {
                        $("#discount_amount")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.discount_amount);
                    }

                    if (errors.min_amount) {
                        $("#min_amount")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.min_amount);
                    } else {
                        $("#min_amount")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.min_amount);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.starts_at) {
                        $("#starts_at")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.starts_at);
                    } else {
                        $("#starts_at")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.starts_at);
                    }

                    if (errors.expires_at) {
                        $("#expires_at")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.expires_at);
                    } else {
                        $("#expires_at")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.expires_at);
                    }

                    if (errors.description) {
                        $("#description")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.description);
                    } else {
                        $("#description")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.description);
                    }
                }
            },
        });
    });
});

//For Coupon Code Update
$(document).ready(function () {
    $("#UpdateCouponForm").on("submit", function (e) {
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
                alert(response.success);
                window.location.href = "/admin/coupon";

                //  $('#UpdateCouponForm')[0].reset();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.code) {
                        $("#code")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.code);
                    } else {
                        $("#code")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.code);
                    }

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

                    if (errors.max_uses) {
                        $("#max_uses")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.max_uses);
                    } else {
                        $("#max_uses")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.max_uses);
                    }

                    if (errors.max_uses_user) {
                        $("#max_uses_user")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.max_uses_user);
                    } else {
                        $("#max_uses_user")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.max_uses_user);
                    }

                    if (errors.type) {
                        $("#type")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.type);
                    } else {
                        $("#type")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.type);
                    }

                    if (errors.discount_amount) {
                        $("#discount_amount")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.discount_amount);
                    } else {
                        $("#discount_amount")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.discount_amount);
                    }

                    if (errors.min_amount) {
                        $("#min_amount")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.min_amount);
                    } else {
                        $("#min_amount")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.min_amount);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.starts_at) {
                        $("#starts_at")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.starts_at);
                    } else {
                        $("#starts_at")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.starts_at);
                    }

                    if (errors.expires_at) {
                        $("#expires_at")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.expires_at);
                    } else {
                        $("#expires_at")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.expires_at);
                    }

                    if (errors.description) {
                        $("#description")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.description);
                    } else {
                        $("#description")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.description);
                    }
                }
            },
        });
    });
});

//=======//==============//=====================//=========================//=================================================//
//=======//==============//=====================//=========================//=================================================//

//For Banner Insert
$(document).ready(function () {
    $("#BannerForm").on("submit", function (e) {
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
                console.log(response);
                alert(response.success);
                window.location.href = "/admin/banner";
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }

                    if (errors.description) {
                        $("#description")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.description);
                    } else {
                        $("#description")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.description);
                    }
                }
            },
        });
    });
});


//For Banner Update
$(document).ready(function () {
    $("#UpdateBannerForm").on("submit", function (e) {
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
                alert(response.success);
                window.location.href = "/admin/banner";
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

                    if (errors.slug) {
                        $("#slug")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.slug);
                    } else {
                        $("#slug")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.slug);
                    }

                    if (errors.status) {
                        $("#status")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.status);
                    } else {
                        $("#status")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.status);
                    }

                    if (errors.image) {
                        $("#image")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.image);
                    } else {
                        $("#image")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.image);
                    }

                    if (errors.description) {
                        $("#description")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.description);
                    } else {
                        $("#description")
                            .removeClass("is-invalid")
                            // .siblings("p")
                            .removeClass("invalid-feedback")
                            .html(errors.description);
                    }
                }
            },
        });
    });
});

