@extends('layouts.app')

@section('title', 'News Letter')
@section('content')
 <!----------------------Newsletter section----------------------->
 <div class="container-cstm about-page contacts">
    <section class="about-section  abot bgblue relative">
        <div class="about-banenr-cnt text-center">
            <h2 class="f-42 pb-1 semi-bold">Newsletter</h2>
            <p class="f-18 gray"> Edupalz was born from a simple yet powerful idea: What if students could help each other; anytime, anywhere, in any language? and Subscribe for weekly insights, learning resources, and platform updates: all in your language, wherever you are.</p>
        </div>
      <img src="{{asset('images/plane.svg')}}" class="shape-plane grow" alt="shape" />
      <img src="{{asset('images/shape.svg')}}" class="shape-top grow" alt="shape" />
      <img src="{{asset('images/shape1.svg')}}" class="shape-right grow" alt="shape" />
      <img src="{{asset('images/shape.svg')}}" class="shape-left grow" alt="shape" />
  </section>
  </div>
  <!----------------------Insights----------------------->
  <section class="insights-section relative">
    <div class="container-cstm">
        <div class="insight-banenr-cnt">
            <!-- <h2 class="f-42 pb-5 semi-bold">Get weekly insights, learning resources, and platform updates in any language worldwide</h2> -->
            <h2 class="f-42 pb-5 semi-bold"><b>Weekly check-ins from the EduPalz community.</b><br><span class="f-30">Student stories, helpful resources, and updates, everything you actually want in your inbox.</span></h2>
            <div class="insight-container relative">
            <form id="newLetter" action="{{ route('newsletter.subscribe') }}" method="POST">
            @csrf                    
            <div class="insight-box relative">
                        <input type="email" placeholder="Enter your email" name="email">
                        <span class="atrate">@</span>
                        <button type="submit" id="submitBtn">Sign Up</button>
                    </div>
                </form>
              </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('newLetter').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Submitting...';
    });
</script>

@endsection
