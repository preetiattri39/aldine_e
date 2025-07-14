@extends('layouts.app')

@section('title', 'Contact-us')
@section('content')
  <section class="contact-section relative">
    <div class="container-cstm">
        
        <div class="row">
         <!--    <div class="col-12 col-md-5 mb-4">
                <div class="row">
                    <div class="col-12 col-md-12 mb-3">
                        <div class="contact-info-bx text-center">
                            <img src="{{asset('images/call.png')}}" class="shape-call swing" alt="call" />
                            <p class="f-30 semi-bold mb-0">Phone Number</p>  
                            <p class="f-16 mb-0"><a  class="grey text-decoration-none" href="tel:123456789">123456789</a></p>  
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <div class="contact-info-bx text-center">
                            <img src="{{asset('images/email.png')}}" class="shape-call swing" alt="call" />
                            <p class="f-30 semi-bold mb-0">Email Address</p>  
                            <p class="f-16 mb-0"><a  class="grey text-decoration-none" href="mailto:test@gmail.com">test@gmail.com</a></p>  
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <div class="contact-info-bx text-center">
                            <img src="{{asset('images/map.png')}}" class="shape-call swing" alt="call" />
                            <p class="f-30 semi-bold mb-0">Address</p>  
                            <p class="f-16 mb-0"><a  class="grey text-decoration-none" href="tel:123456789">35926 Zane Junction, Beaumont, Utah - 47953, Virgin Islands, British</a></p>  
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-12 col-md-12 mb-4">
                <div class="contct-banenr-cnt">
                    <h2 class="f-42 semi-bold">Reach Us</h2>
                    <p class="f-20 pb-4 grey">We’d love to hear from you! Drop us a message, and we’ll be in touch soon.</p>
                    <div class="contact-form-bx relative">
                    <form id="contactForm" action="{{ route('contact-us') }}" method="POST">
                                @csrf
                                <div class="form-field mb-4">
                                <label for="fname" class="d-block">Name</label>
                                <input type="text" id="fname" name="name"value="{{ old('name') }}" placeholder="Enter your name">
                                </div>
                                <div class="form-field mb-4">
                                <label for="email" class="d-block">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                                </div>
                                <div class="form-field mb-4">
                                <label for="message" class="d-block">How can we help?</label>
                                <textarea name="message" class="form-area" rows="5" placeholder="Enter your message">{{ old('message') }}</textarea>
                                </div>
                                <button class="sbmt-btn text-white" id="submitBtn">Submit</button>
                            </form>
                      </div>
                </div>
            </div>
           
        </div>
       
    </div>
    <img src="{{asset('images/poly.svg')}}" class="shape-poly-top" alt="shape" />
    <img src="{{asset('images/poly1.svg')}}" class="shape-polygn-right" alt="shape" />
</section>
<script>
    document.getElementById('contactForm').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Submitting...';
    });
</script>

@endsection