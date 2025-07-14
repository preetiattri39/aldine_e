@extends('layouts.app')

@section('title', 'Faq')
@section('content')

<!----------------------Faq section----------------------->
<!-- <div class="container-cstm about-page faq">
  <section class="about-section  abot bgblue relative">
    <div class="about-banenr-cnt text-center">
      <h2 class="f-42 pb-1 semi-bold">Frequently Asked Questions</h2>
      <p class="f-18 gray">Edupalz was born from a simple yet powerful idea: What if students could help each other; anytime, anywhere, in any language,and online forums were either overwhelming or unhelpful.</p>
    </div>
    <img src="{{asset('images/plane.svg')}}" class="shape-plane grow" alt="shape" />
    <img src="{{asset('images/shape.svg')}}" class="shape-top grow" alt="shape" />
    <img src="{{asset('images/shape1.svg')}}" class="shape-right grow" alt="shape" />
    <img src="{{asset('images/shape.svg')}}" class="shape-left grow" alt="shape" />
  </section>
</div>
 -->

<!----------------------faq----------------------->
<section id="faq" class="faq-section relative">
  <div class="container-cstm">
    <div class="faq-banenr-cnt text-center">
      <h2 class="f-42 pb-1 semi-bold">Frequently Asked Questions</h2>
      <p class="f-18 pb-3 grey">A list of frequently asked questions to help users troubleshoot issues or learn more about the app.</p>
      <div class="search-container relative">
        <form action="{{ route('faq.search') }}" method="GET">

          <div class="search-box relative">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><img src="{{asset('images/search.svg')}}" class="search-icon"></button>
          </div>
        </form>
      </div>

      <div class="faq-accordion ">
        <div class="accordion accordion-flush" id="faqAccordion">
          @foreach($faqs as $index => $faq)
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $index }}">
              <button class="accordion-button collapsed" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapse{{ $index }}"
                aria-expanded="false"
                aria-controls="collapse{{ $index }}">
                {{ $faq->question }}
              </button>
            </h2>
            <div id="collapse{{ $index }}" class="accordion-collapse collapse"
              aria-labelledby="heading{{ $index }}"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                {!! $faq->answer !!}
              </div>
            </div>
          </div>
          @endforeach
        </div>

      </div>
    </div>
  </div>
</section>

@endsection