//Ajax For Category

//For Insert Category

$(document).ready(function () {
    $("#CategoryForm").on("submit", function (e) {
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
                // $("#CategoryForm")[0].reset();
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
                window.location.href = "/admin/createsubcategories";
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
                $("#ProductForm")[0].reset();
                alert(response.success);
                window.location.href = "/admin/createproducts";
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

//

$(document).ready(function () {
    // $.ajax({
    //     url: "/admin/getcategories",
    //     type: "GET",
    //     dataType: "json",
    //     success: function (data) {
    //         $("#category").empty();
    //         $("#category").append('<option value="">Select Category</option>');
    //         $.each(data, function (key, value) {
    //             $("#category").append(
    //                 '<option value="' +
    //                     value.id +
    //                     '">' +
    //                     value.name +
    //                     "</option>"
    //             );
    //         });
    //     },
    // });

    $("#category").on('change',function () {
        var category_id = $(this).val();
        $('#sub_category').html('');
        // if (category_id) {
            $.ajax({
                url: "/admin/getsubcategories/" + category_id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#sub_category").empty();
                    $("#sub_category").append(
                        '<option value="">---Select Subcategory---</option>'
                    );
                    $.each(data, function (key, value) {
                        $("#sub_category").append(
                            '<option value="' + value.id +'">' + value.subcate_name + "</option>"
                        );
                    });
                    
                    // $('#sub_category').html('<option value="">Select State</option>');
                    // $.each(data, function(key, value) {
                    //     $('#sub_category').append('<option value="'+value.id+'">'+value.subcate_name+'</option>');
                    // });
                },
            });
       // }
    });
});
