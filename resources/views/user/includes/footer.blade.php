<footer class="bg-dark mt-5">
    <div class="container pb-5 pt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Get In Touch</h3>
                    <p> <br>
                        123 feet Rind Road, Ahmedabad, India <br>
                        electro2024@gamil.com <br>
                        980 823 7221</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Important Links</h3>
                    <ul>
                        <li><a href="{{ route('aboutus') }}" title="About">About</a></li>
                        <li><a href="{{ route('contactus') }}" title="Contact Us">Contact Us</a></li>
                        <li><a href="{{ route('privacy') }}" title="Privacy">Privacy</a></li>
                        <li><a href="#" title="Privacy">Terms & Conditions</a></li>
                        <li><a href="#" title="Privacy">Refund Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>My Account</h3>
                    <ul>
                        <li><a href="{{ route('userlogin') }}" title="Sell">Login</a></li>
                        <li><a href="{{ route('register') }}" title="Advertise">Register</a></li>
                        <li><a href="#" title="Contact Us">My Orders</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="copy-right text-center">
                        <p>Always Welcome </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="{{ asset('user_assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('user_assets/js/custom.js') }}"></script>
<script src="{{ asset('user_assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('user_assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('user_assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('user_assets/js/slick.min.js') }}"></script>
<script>
    window.onscroll = function() {
        myFunction()
    };

    var navbar = document.getElementById("navbar");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }
</script>
</body>

</html>
