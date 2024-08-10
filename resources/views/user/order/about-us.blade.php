{{-- <?php include 'includes/header.php'; ?> --}}
@include('user.includes.header')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    @if (Auth::check())
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('usershop')}}">Home</a></li>
                       @else
                       <li class="breadcrumb-item"><a class="white-text" href="{{route('userdeshboard')}}">Home</a></li>

                    @endif
                    <li class="breadcrumb-item">About Us</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <h1 class="my-3">About Us</h1>
           <p> Welcome to Electro-Shop, your number one source for all things electronic. We're dedicated to giving you
            the very best of electronics, with a focus on quality, customer service, and uniqueness.</p>

            <p>Founded in 2024, Electro-Shop has come a long way from its beginnings. When we first started out, our
            passion for providing top-notch electronics drove us to start our own business. We now serve customers all
            over India.</p>

            <p>At Electro-Shop, we offer a wide range of products to meet all your electronic needs:</p>

            <p>Mobile Phones  ==>  Stay connected with the latest smartphones and accessories from leading brands.</p>
            <p> Laptops  ==>  Find the perfect laptop for work, gaming, or school with our diverse selection.</p>
            <p>Watches ==>  Discover stylish and functional watches that suit every occasion.</p>
            <p> Televisions  ==>  Enjoy your favorite shows and movies on high-quality TVs that bring entertainment to life.</p>
            <p>Our mission is to provide customers with the best shopping experience by offering top-quality products,
            excellent customer service, and unbeatable prices. We believe in putting our customers first, and our team
            is committed to helping you find the perfect products that meet your needs and budget.</p>

            <p>Thank you for choosing Electro-Shop. We hope you enjoy our products as much as we enjoy offering them to
            you. If you have any questions or comments, please don't hesitate to contact us.</p>

            <p>Sincerely,</p>

            <p> The Electro-Shop Team</p>


        </div>
    </section>
</main>
{{-- <?php include 'includes/footer.php'; ?> --}}
@include('user.includes.footer')

