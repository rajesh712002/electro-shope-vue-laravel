
//For Insert Product


$(document).ready(function() {
    $('#CategoryForm').on('submit', function(e) {
        e.preventDefault();
        // var data=$('#CategoryForm').serializeArray();
        var data = new FormData($(this)[0]);
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        console.log(data);
        var url = $(this).attr('action');

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },
            contentType: false,
            processData: false,
            data: data,
            beforeSend: function() {
                 console.log({data});
            },
            success: function(response) {
                // $('#respanel').html(response);
                 $('#CategoryForm')[0].reset();
            },
            error: function(xhr) {
                //console.log(xhr.responseJSON.errors);
                // alert('Error:'+ xhr.responseText);

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('[name="' + key + '"]').parent().find(
                            '.error, .error_no_margin').text('** ' + value[
                            0] + '!');
                    });
                }
            }
        });
    });
});


//For SubCategory Insert


//For Insert Product


$(document).ready(function() {
    $('#SubCategoryForm').on('submit', function(e) {
        e.preventDefault();
        // var data=$('#SubCategoryForm').serializeArray();
        var data = new FormData($(this)[0]);
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        console.log(data);
        var url = $(this).attr('action');

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },
            contentType: false,
            processData: false,
            data: data,
            beforeSend: function() {
                 //console.log({data});
            },
            success: function(response) {
              //  $('#respanel').html(response);
                
                 $('#SubCategoryForm')[0].reset();
              //   window.location.href = '/admin/subcategory';
              successMessage(response.success);
            },
            error: function(xhr) {
                //console.log(xhr.responseJSON.errors);
                 //alert('Error:'+ xhr.responseText);
                 

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('[name="' + key + '"]').parent().find(
                            '.error, .error_no_margin').text('** ' + value[
                            0] + '!');
                    });
                }
            }
        });
    });
});