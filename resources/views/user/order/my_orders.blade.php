@include('user.includes.header')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('usershop') }}">Shop</a></li>
                    <li class="breadcrumb-item"><a class="white-text">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('user.includes.account_panel')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>
                        <div class="card-body p-4" id="order-data">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Orders #</th>
                                            <th>Purchased Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($order->isNotEmpty())
                                            @foreach ($order as $orders)
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="{{ route('user.order_detail', $orders->id) }}">{{ $orders->id }}</a>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($orders->created_at)->format('d M, Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($orders->status == 'pending')
                                                            <button type="button" class="btn btn-info"><span
                                                                    class="fa fa-bars" aria-hidden="true"></span>
                                                                Pending</button>
                                                        @elseif($orders->status == 'shipped')
                                                            <button type="button" class="btn btn-primary"><span
                                                                    class="fa fa-cog fa-spin" aria-hidden="true"></span>
                                                                Shipped</button>
                                                        @elseif($orders->status == 'out for delivery')
                                                            <button type="button" class="btn btn-warning"><span
                                                                    class="fa fa-cog fa-spin" aria-hidden="true"></span>
                                                                Out For Delivery!</button>
                                                        @elseif($orders->status == 'delivered')
                                                            <button type="button" class="btn btn-success"><span
                                                                    class="fa fa-check-circle"
                                                                    aria-hidden="true"></span> Delivered</button>
                                                        @elseif($orders->status == 'cancelled')
                                                            <button type="button" class="btn btn-danger"> <i
                                                                    class="fa fa-close"></i> Cancelled</button>
                                                        @elseif($orders->status == 'refunded')
                                                            <button type="button" class="btn btn-secondary"> <i
                                                                    class="fa fa-coins"></i>
                                                                Refunded</button>
                                                        @endif

                                                    </td>
                                                    <td><i class="fa fa-inr" aria-hidden="true"></i>
                                                        {{ $orders->grand_total }}</td>

                                                    @if ($orders->status == 'pending')
                                                        <td>
                                                            <form id="delete-order-form-{{ $orders->id }}"
                                                                class="delete_cat" method="post"
                                                                action="{{ route('user.remove_order', $orders->id) }}">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                            <button type="submit"
                                                                onclick="deleteOrder({{ $orders->id }})"
                                                                id="submit" class="btn btn-sm btn-danger"><i
                                                                    class="fa fa-times"></i></button>
                                                        </td>
                                                    @else
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="pagination-container">
                        {{ $order->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    function deleteOrder(id) {
        // alert(id);
        
        if (confirm("Do you really want to Cancle this Order ?")) {
            document.getElementById("delete-order-form-" + id).submit();
            document.querySelector(".overlay").style.display = "flex";

        }

    }

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchOrders(page);
        });

        function fetchOrders(page) {
            $.ajax({
                url: "?page=" + page,
                success: function(data) {
                    $('#order-data').html($(data).find('#order-data').html());
                    
                    $('.pagination-container').html($(data).find('.pagination-container').html());
                }
            });
        }
    });
</script>
@include('user.includes.footer')
