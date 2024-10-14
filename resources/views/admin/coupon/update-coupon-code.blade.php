@extends('admin.layouts.app')

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Coupon Code</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.coupons') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
                <div class="col-md-10 mt-4">
                    <div class="alert alert-success">
                        <b>{{ Session::get('success') }}</b>
                    </div>
                </div>
            @endif
        </div>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->

            <div class="container-fluid">
                <form action="{{route('admin.couponUpdate',$couponCode->id)}}" id="UpdateCouponForm" name="UpdateCouponForm" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code">Code</label>
                                        <input type="text" name="code" id="code" class=" form-control"
                                            value="{{ !empty($couponCode) ? $couponCode->code : '' }}" placeholder="Coupon Code">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class=" form-control"
                                            value="{{ !empty($couponCode) ? $couponCode->name : '' }}" placeholder="Coupon Name">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_uses">Max Uses</label>
                                        <input type="text" name="max_uses" id="max_uses" class=" form-control"
                                            value="{{ !empty($couponCode) ? $couponCode->max_uses : '' }}" placeholder="Max Uses">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_uses_user">Max Uses User</label>
                                        <input type="text" name="max_uses_user" id="max_uses_user" class=" form-control"
                                            value="{{ !empty($couponCode) ? $couponCode->max_uses_user : '' }}" placeholder="Max Uses User">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type">Type</label>
                                        <select name="type" id="type" class=" form-control">
                                            <option value="fixed" {{ old('type', $couponCode->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                            <option value="percent" {{ old('type', $couponCode->type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                        </select>

                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="discount_amount">Discount Amount</label>
                                        <input type="text" name="discount_amount" id="discount_amount"
                                            class=" form-control" value="{{ !empty($couponCode) ? $couponCode->discount_amount : '' }}"
                                            placeholder="Discount Amount">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="min_amount">Minimum Amount</label>
                                        <input type="text" name="min_amount" id="min_amount" class=" form-control"
                                            value="{{ !empty($couponCode) ? $couponCode->min_amount : '' }}" placeholder="Minimum Amount">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class=" form-control">
                                            <option value="">---select---</option>
                                            <option value="1" {{ old('status', $couponCode->status) == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status', $couponCode->status) == '0' ? 'selected' : '' }}>Block</option>
                                        </select>
                                        <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{-- <label for="starts_at">Starts At</label> --}}
                                        <input type="text" name="starts_at" id="starts_at" class=" form-control"
                                            value="{{ !empty($couponCode) ? $couponCode->starts_at : '' }}" placeholder="Starts At" hidden>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="expires_at">Expires At</label>
                                        <input type="text" name="expires_at" id="expires_at" class=" form-control"
                                            value="{{ !empty($couponCode) ? $couponCode->expires_at : '' }}" placeholder="Expires At">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class=" form-control" placeholder="Description">{{ !empty($couponCode) ? $couponCode->description : '' }}</textarea>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                        <button type="reset" id="reset">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
<script>
    $(document).ready(function() {
        $('#starts_at').datetimepicker({
            // options here
            format: 'Y-m-d H:i:s',
        });
    });

    $(document).ready(function() {
        $('#expires_at').datetimepicker({
            // options here
            format: 'Y-m-d H:i:s',
        });
    });
</script>
<script src="{{ asset('admin_assets/js/ajx.js') }}"></script>
