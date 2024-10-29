<!DOCTYPE html>
@extends('admin.layouts.app')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://cdn.tiny.cloud/1/adkflfpe6mrdbxryjc4huob43fi29gg6o1a9gjfbf22la31k/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.product') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form action="{{ route('admin.update_prod', $product->id) }}" method="POST" id="UpdateProductForm"
                name="UpdateProductForm" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name"
                                                    class="@error('name') is-invalid
                                                        @enderror form-control"
                                                    value="{{ old('name', $product->prod_name) }}"
                                                    placeholder="Product Name">
                                                @error('name')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" name="slug" id="slug" class=" form-control"
                                                    value="{{ old('slug', $product->slug) }}" placeholder="Slug">
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                                    placeholder="Description">{{ old('description', $product->description) }}</textarea>
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Image</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop Images Here or Click To Upload.<br><br>
                                        </div>
                                    </div>
                                    <p></p>
                                    <h6 style="color: red" class="error"></h6>
                                </div>
                            </div>
                            <div class="row" id="productImages">
                                @if (!empty($productImage))
                                    {{-- @dd($productImage) --}}
                                    @foreach ($productImage as $image)
                                        <div class="col-md-3" style="width: 18rem;">
                                            <input type="hidden" name="image_array[]" value="{{ $image->id }}">
                                            <img src="{{ asset('admin_assets/images/' . $image->images) }}"
                                                class="card-img-top" alt="Product Image">
                                            <div class="card-body">
                                                <a href="#" class="btn btn-danger"
                                                    data-file="{{ $image->id }}">Delete</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price"
                                                    class="@error('price') is-invalid
                                                      @enderror form-control"
                                                    placeholder="Price" value="{{ old('price', $product->price) }}">
                                                @error('price')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price"
                                                    class="form-control" placeholder="Compare Price"
                                                    value="{{ old('compare_price', $product->compare_price) }}">
                                                <p class="text-muted mt-3">
                                                    To show a reduced price, move the product’s original price into Compare
                                                    at price. Enter a lower value into Price.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" name="sku" id="sku"
                                                    class="@error('sku') is-invalid
                                                        @enderror form-control"
                                                    value="{{ old('sku', $product->sku) }}" placeholder="sku">
                                                @error('sku')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty"
                                                        name="track_qty" checked>
                                                    <label for="track_qty" class="custom-control-label">Track
                                                        Quantity</label>
                                                    <p></p>
                                                    <h6 style="color: red" class="error"></h6>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" min="0" name="qty" id="qty"
                                                    class="form-control" placeholder="Qty"
                                                    value="{{ old('qty', $product->qty) }}">
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4  mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>

                                        <select name="category" id="category" class="form-control">
                                            <option value="">---select---</option>

                                            @foreach ($category as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sub_category">Sub category</label>
                                        <select name="sub_category" id="sub_category" class="form-control">
                                            <option value="">---select---</option>

                                            {{-- @foreach ($subcategory as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach --}}
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product brand</h2>
                                    <div class="mb-3">
                                        <select name="brand" id="brand" class="form-control">
                                            <option value="">---select---</option>

                                            @foreach ($brand as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        <button type="reset" id="reset">Cancel</button>

                    </div>
                </div>
            </form>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#description',
                plugins: 'lists link image preview code',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code preview',
                menubar: false,
                branding: false
            });
        });
    </script> --}}

    {{-- <script>
        Dropzone.autoDiscover = false;

        const uploadedFiles = new Set(); // To track uploaded files by name

        const dropzone = new Dropzone('#image', {
            url: "{{ route('updateImages') }}",
            maxFiles: 7,
            paramName: 'image',
            params: {
                'product_id': '{{ $product->id }}'
            },
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
            // console.log(image_id);
            // deleteImages(image_id);

            // Also remove the image card from the displayed images
            $(this).closest('.col-md-3').remove();
        });

    
    </script> --}}

    <script>
        Dropzone.autoDiscover = false;
    
        const uploadedFiles = new Set(); // To track uploaded files by name
    
        const dropzone = new Dropzone('#image', {
            url: "{{ route('updateImages') }}",
            maxFiles: 7,
            paramName: 'image',
            params: { 'product_id': '{{ $product->id }}' },
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/jpg,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                this.on('addedfile', function(file) {
                    if (uploadedFiles.has(file.name)) {
                        this.removeFile(file);
                        alert("This image has already been uploaded.");
                    } else if (this.files.length > this.options.maxFiles) {
                        this.removeFile(file);
                        alert("You can only upload a maximum of " + this.options.maxFiles + " images.");
                    } else {
                        uploadedFiles.add(file.name);
                    }
                });
    
                this.on('success', function(file, response) {
                    const html = `<div class="col-md-3" style="width: 18rem;">
                        <input type="hidden" name="image_array[]" value="${response.image_id}">
                        <img src="${response.ImagePath}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="btn btn-danger" data-file="${file.name}" data-id="${response.image_id}">Delete</a>
                        </div>
                    </div>`;
                    $("#productImages").append(html);
                });
    
                this.on('removedfile', function(file) {
                    uploadedFiles.delete(file.name);
                    const deleteButton = $(`.btn-danger[data-file="${file.name}"]`);
                    if (deleteButton.length) {
                        deleteButton.closest('.col-md-3').remove();
                    }
                });
            }
        });
    
        // Handle delete button click
        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault();
            const fileName = $(this).data('file');
            const imageId = $(this).data('id'); // Retrieve the image ID from data-id attribute
    
            console.log("Image ID:", imageId);
            
            // Remove the file from Dropzone
            dropzone.files.forEach((file, index) => {
                if (file.name === fileName) {
                    dropzone.removeFile(file);
                    uploadedFiles.delete(file.name);
                }
            });
    
            // Call deleteImages function with the image ID
            deleteImages(imageId);
    
            // Also remove the image card from the displayed images
            $(this).closest('.col-md-3').remove();
        });
    
        function deleteImages(id) {
            console.log("Image ID:", id);
            if (confirm("Do you want to delete this image?")) {
                $.ajax({
                    url: '{{ route('destroyProductImages') }}',
                    type: 'DELETE',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            // Optionally, remove the deleted image from the DOM
                            $(`.btn-danger[data-id="${id}"]`).closest('.col-md-3').remove();
                        } else {
                            alert(response.message || "An error occurred while deleting the image.");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + (xhr.responseJSON ? xhr.responseJSON.message : "Could not delete the image. Please try again."));
                    }
                });
            }
        }
    </script>
    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#description',
                plugins: 'lists link image preview code table media textcolor paste',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | table | forecolor backcolor | code preview | save',
                menubar: false,
                branding: false,
                // Enable automatic content cleanup
                cleanup: true,
                // Add a save button that could call a custom function
                setup: function(editor) {
                    editor.ui.registry.addButton('save', {
                        text: 'Save',
                        onAction: function() {
                            // Implement your save functionality here
                            alert('Save functionality needs to be implemented!');
                        }
                    });
                },
                // Configure other settings as needed
                image_advtab: true, // Enables advanced image options
                media_dimensions: false, // Disable media dimensions if not needed
                image_caption: true, // Enables image captions
            });
        });
    </script>
@endsection
<script src="{{ asset('admin_assets/js/ajx.js') }}"></script>
