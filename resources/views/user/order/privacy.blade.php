<!DOCTYPE html>
@include('user.includes.header')

<html>

<head>
    <title>Privacy Policy</title>
</head>

<body>
    

    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        @if (Auth::check())
                            <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a></li>
                        @else
                            <li class="breadcrumb-item"><a class="white-text" href="{{ route('userdeshboard') }}">Home</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item">About Us</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10">
            <div class="container">
                <!DOCTYPE html>
                <html>

                <head>
                    <title>Privacy Policy</title>
                </head>

                <body>
                    <h4 style="color: red">Privacy Policy</h4>
                    <p>Welcome to our Privacy Policy page! Your privacy is critically important to us.</p>

                    <h4 style="color: green">Information We Collect</h4>
                    <p>We collect information to provide better services to our users.</p>

                    <h4 style="color: red">How We Use Information</h4>
                    <p>We use the information we collect to maintain and improve our services.</p>

                    <h4 style="color: green">Information Sharing</h4>
                    <p>We do not share personal information with companies, organizations, and individuals outside of
                        our organization unless one of the following circumstances applies:</p>
                    <ul>
                        <li>With your consent</li>
                        <li>For external processing</li>
                        <li>For legal reasons</li>
                    </ul>

                    <h4 style="color: red">Data Security</h4>
                    <p>We work hard to protect our users from unauthorized access to or unauthorized alteration,
                        disclosure, or destruction of information we hold.</p>

                    <h4 style="color: green">Changes to This Policy</h4>
                    <p>Our Privacy Policy may change from time to time. We will post any privacy policy changes on this
                        page.</p>

                    <h4 style="color: red">Contact Us</h4>
                    <p>If you have any questions about this Privacy Policy, please contact us at [Your Contact
                        Information].</p>
                </body>

                </html>


            </div>
        </section>
    </main>
    @include('user.includes.footer')


    