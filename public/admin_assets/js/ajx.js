//For Insert Product

$(document).ready(function () {
    $("#CategoryForm").on("submit", function (e) {
        e.preventDefault();
        // var data=$('#CategoryForm').serializeArray();
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
            beforeSend: function () {
                console.log({ data });
            },
            success: function (response) {
               // console.log(response.message);

                // $('#respanel').html(response);
                if(response){
                window.location.href="/admin/category";}
               // $("#CategoryForm")[0].reset();
            },
            error: function (xhr) {
                //console.log(xhr.responseJSON.errors);
                // alert('Error:'+ xhr.responseText);
                
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
        // var data=$('#UpdateCatForm').serializeArray();
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
            beforeSend: function () {
                //console.log({data});
            },
            success: function (response) {
                // $('#respanel').html(response);
                if(response){
                    window.location.href="/admin/category";}
                //console.log(response.message);

                //  $('#UpdateCatForm')[0].reset();
            },
            error: function (xhr) {
                //console.log(xhr.responseJSON.errors);
                // alert('Error:'+ xhr.responseText);

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
    $("#delete-product-form-").on("click", function () {
        let categoryId = $(this).data("id");
        var url = $(this).attr("action");
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: url,
            type: "POST",
            data: {
                categoryId: categoryId,
                _token: csrfToken,
            },
            dataType: "json",
            success: function (response) {
                //  loadCategories(response);
                //console.log(response.message);
                // if(response){
                //     window.location.href="/admin/category";}
            },
            error: function (xhr) {
                errorMessage(xhr.responseJSON.error);
            },
        });
    });
});

//For SubCategory Insert

//For Insert Product

$(document).ready(function () {
    $("#SubCategoryForm").on("submit", function (e) {
        e.preventDefault();
        // var data=$('#SubCategoryForm').serializeArray();
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
            beforeSend: function () {
                //console.log({data});
            },
            success: function (response) {
                //  $('#respanel').html(response);

                $("#SubCategoryForm")[0].reset();
                //   window.location.href = '/admin/subcategory';
                successMessage(response.success);
            },
            error: function (xhr) {
                //console.log(xhr.responseJSON.errors);
                //alert('Error:'+ xhr.responseText);

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

//For Update

$(document).ready(function () {
    $("#UpdateSubCategoryForm").on("submit", function (e) {
        e.preventDefault();
        // var data=$('#UpdateSubCategoryForm').serializeArray();
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
            beforeSend: function () {
                //console.log({data});
            },
            success: function (response) {
                //  $('#respanel').html(response);

                $("#UpdateSubCategoryForm")[0].reset();
                //   window.location.href = '/admin/subcategory';
                successMessage(response.success);
            },
            error: function (xhr) {
                //console.log(xhr.responseJSON.errors);
                //alert('Error:'+ xhr.responseText);

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

