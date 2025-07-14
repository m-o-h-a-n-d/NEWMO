<!-- Footer Start -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Get in Touch</h3>
                    <div class="contact-info">
                        <p>
                            <a href="https://www.google.com/maps/search/{{ " $Settings->street $Settings->city  $Settings->country" }}"
                                style="color: inherit;" target="blank">
                                <i class="fa fa-map-marker"></i>
                                {{ $Settings->street }},{{ $Settings->city }},{{ $Settings->country }}
                            </a>
                        </p>
                        <p>
                            <a href="mailto:{{ $Settings->email }}" style="color:inherit; "  target="blank">
                                <i class="fa fa-envelope"></i>
                                {{ $Settings->email }}
                            </a>
                        </p>
                        <p>
                            <a href="tel:{{ $Settings->phone }} " style="color: inherit;"  target="blank">
                                <i class="fa fa-phone"></i>
                                {{ $Settings->phone }}
                            </a>
                        </p>
                        <div class="social">
                            <a href="{{ $Settings->twitter }}"  target="blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="{{ $Settings->facebook }}"  target="blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $Settings->linkedin }}" target="blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="{{ $Settings->instagram }}" target="blank"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $Settings->youtube }}" target="blank"><i class="fab fa-youtube"></i></a>
                            <a href="{{ $Settings->whatsapp }}" target="blank"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Useful Links</h3>
                    <ul>
                        @foreach ($related_sites as $site)
                            <li> <a href="{{ $site->url }}" title="{{ $site->name }}">{{ $site->name }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Quick Links</h3>
                    <ul>
                        <li><a href="{{route('frontend.contact.index')}}">Contact Us </a></li>
                        <li><a href="#">Pellentesque</a></li>
                        <li><a href="#">Aenean vulputate</a></li>
                        <li><a href="#">Vestibulum sit amet</a></li>
                        <li><a href="#">Nam dignissim</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Newsletter</h3>
                    <div class="newsletter">
                        <p>
                            we tell you about News Around The World subscribe Now !
                        </p>
                        <form action="{{ route('frontend.news.subscribe') }}" method="post">
                            @csrf
                            <input class="form-control" type="email" name="email" placeholder="Your email here" />
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->



<!-- Footer Bottom Start -->
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>
                    Copyright &copy; <a href="{{ route('frontend.home') }}">{{ $Settings->side_name }}</a>. All Rights
                    Reserved
                </p>
            </div>

            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
            <div class="col-md-6 template-by">
                <p>Designed By <a href="{{ route('frontend.home') }}">Mohanad</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Footer Bottom End -->
