@extends('admin.layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

        <title>Laravel 11 Multiple Image Upload Example - ItSolutionStuff.com</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

    <body>
        <div class="container">

            <div class="card mt-5">

                <div class="card-body">

                    @session('success')
                        <div class="alert alert-success" role="alert">
                            {{ $value }}
                        </div>
                        @foreach (Session::get('images') as $image)
                            <img src="images/{{ $image['name'] }}" width="300px">
                        @endforeach
                    @endsession

                    <form action="{{ route('admin.store_prod') }}" method="POST" enctype="multipart/form-data"
                        class="mt-2">
                        @csrf

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Image</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    {{-- <input type="file" name="image" id="image"
                                class=" form-control form-control-lg " value="{{ old('image') }}">
                            <p></p>
                            <h6 style="color: red" class="error"></h6> --}}
                                    <div class="dz-message needsclick">
                                        <br>Drop Images Here or Click To Upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="productImages">

                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Upload</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>


    {{-- <script>
        Dropzone.autoDiscover = false;
        const dropzone = $('#image').dropzone({
            // init: function() {
            //     this.on('addedfile', function(file) {
            //         if (this.files.length > 1) {
            //             this.removeFile(this.files[0]);
            //         }
            //     });
            // },
            url: "{{ route('storeImage') }}",
            maxFiles: 4,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/jpg,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                // $("#image_id").val(response.image_id);

                var html = `<div class="col-md-3" style="width: 18rem;">
                    <input type="hidden" name="image_array[]" value="${response.image_id}">
                        <img src="${response.ImagePath}" class="card-img-top" alt="...">
                        <div class="card-body">
                        <a href="#" class="btn btn-danger">Delete</a>
                        </div>
                    </div>`;
                    $("#productImages").append(html);
            }
        });
    </script> --}}

    {{-- <script>
        Dropzone.autoDiscover = false;

        const uploadedFiles = new Set(); // To track uploaded files by name

        const dropzone = $('#image').dropzone({
            url: "{{ route('storeImage') }}",
            maxFiles: 4,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/jpg,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                this.on('addedfile', function(file) {
                    // Check if file is already uploaded
                    if (uploadedFiles.has(file.name)) {
                        this.removeFile(file); // Remove duplicate file
                        alert("This image has already been uploaded."); // Notify user
                    } else if (this.files.length > this.options.maxFiles) {
                        this.removeFile(file); // Remove excess file
                        alert("You can only upload a maximum of " + this.options.maxFiles +
                            " images."); // Notify user
                    } else {
                        uploadedFiles.add(file.name); // Add file name to the set
                    }
                });

                this.on('success', function(file, response) {
                    var html = `<div class="col-md-3" style="width: 18rem;">
                        <input type="hidden" name="image_array[]" value="${response.image_id}">
                            <img src="${response.ImagePath}" class="card-img-top" alt="...">
                            <div class="card-body">
                            <a href="#" class="btn btn-danger" data-file="${file.name}">Delete</a>
                            </div>
                        </div>`;
                    $("#productImages").append(html);
                });

                this.on('removedfile', function(file) {
                    uploadedFiles.delete(file.name); // Remove from the set when file is removed
                });
            }
        });

        // Handle delete button
        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault();
            const fileName = $(this).data('file');
            // Remove the file from Dropzone
            dropzone.files.forEach((file, index) => {
                if (file.name === fileName) {
                    dropzone.removeFile(file);
                }
            });
            $(this).closest('.col-md-3').remove(); // Remove the card from the DOM
        });
    </script> --}}

    <script>
        Dropzone.autoDiscover = false;

        const uploadedFiles = new Set(); // To track uploaded files by name

        const dropzone = new Dropzone('#image', {
            url: "{{ route('storeImage') }}",
            maxFiles: 4,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/jpg,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                this.on('addedfile', function(file) {
                    // Check if file is already uploaded
                    if (uploadedFiles.has(file.name)) {
                        this.removeFile(file); // Remove duplicate file
                        alert("This image has already been uploaded."); // Notify user
                    } else if (this.files.length > this.options.maxFiles) {
                        this.removeFile(file); // Remove excess file
                        alert("You can only upload a maximum of " + this.options.maxFiles +
                        " images."); // Notify user
                    } else {
                        uploadedFiles.add(file.name); // Add file name to the set
                    }
                });

                this.on('success', function(file, response) {
                    var html = `<div class="col-md-3" style="width: 18rem;">
                        <input type="hidden" name="image_array[]" value="${response.image_id}">
                            <img src="${response.ImagePath}" class="card-img-top" alt="...">
                            <div class="card-body">
                            <a href="#" class="btn btn-danger" data-file="${file.name}">Delete</a>
                            </div>
                        </div>`;
                    $("#productImages").append(html);
                });

                this.on('removedfile', function(file) {
                    uploadedFiles.delete(file.name); // Remove from the set when file is removed
                    // Optionally, you can also remove the related image card from the DOM here if needed
                    const deleteButton = $(`.btn-danger[data-file="${file.name}"]`);
                    if (deleteButton.length) {
                        deleteButton.closest('.col-md-3').remove();
                    }
                });
            }
        });

        // Handle delete button
        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault();
            const fileName = $(this).data('file');

            // Remove the file from Dropzone
            dropzone.files.forEach((file, index) => {
                if (file.name === fileName) {
                    dropzone.removeFile(file); // Remove file from Dropzone
                    uploadedFiles.delete(file.name); // Remove from the set
                }
            });

            // Also remove the image card from the displayed images
            $(this).closest('.col-md-3').remove();
        });
    </script>



    </html>
@endsection
