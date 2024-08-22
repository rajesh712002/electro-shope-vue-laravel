@include('user.includes.header')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('usershop')}}">Shop</a></li>
                    <li class="breadcrumb-item"><a class="white-text" >My Account</a></li>
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
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>
                        <div class="card-body p-4">
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
                                        @if($order->isNotEmpty())
                                        @foreach($order as $orders)
                                        <tr>
                                            <td>
                                                <a href="{{route('user.order_detail',$orders->id)}}">{{$orders->id}}</a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($orders->created_at)->format('d M, Y')}}</td>
                                            <td>
                                                @if($orders->status == 'pending')
                                                <button type="button" class="btn btn-info"><span class="fa fa-bars" aria-hidden="true"></span> Pending</button>
                                                
                                                @elseif($orders->status == 'shipped')
                                                <button type="button" class="btn btn-primary"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> Shipped</button>

                                                @elseif($orders->status == 'out for delivery')
                                                <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> Out For Delivery!</button>
                                              
                                                @elseif($orders->status == 'delivered')
                                                <button type="button" class="btn btn-success"><span class="fa fa-check-circle" aria-hidden="true"></span> Delivered</button>

                                                @elseif($orders->status == 'cancelled')
                                              <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i> Cancelled</button>

                                                @endif
                                                
                                            </td>
                                            <td><i class="fa fa-inr" aria-hidden="true"></i> {{$orders->grand_total}}</td>
                                        </tr>
                                        @endforeach
                                                @endif          
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('user.includes.footer')