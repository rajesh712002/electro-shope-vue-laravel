@if (Session::has('errors'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close " data-dismiss="alert" aria-hodden="true">x</button>
        <h4><i class="icon fa fa-ban"></i>Error!</h4>{{ Session::get('errors') }}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close " data-dismiss="alert" aria-hodden="true">x</button>
        <h4><i class="icon fa fa-check"></i>Success!</h4>{{ Session::get('success') }}
    </div>
@endif
