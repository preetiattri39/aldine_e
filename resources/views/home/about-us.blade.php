@extends('layouts.app')

@section('title', 'About-us')
@section('content')

<div class="container-cstm about-page">
  <section class="about-section  abot bgblue relative">
        <div class="about-banenr-cnt text-center">
            <h2 class="f-42 pb-1 semi-bold">About</h2>
            <p class="semi-bold f-22 pb-3">The Story Behind Edupalz</p>
            <p class="f-18 gray">{!!$page->content!!}</p>
        </div>
  
    <img src="{{asset('images/plane.svg')}}" class="shape-plane grow" alt="shape" />
    <img src="{{asset('images/circle.svg')}}" class="shape-circles left-1" alt="shape" />
    <img src="{{asset('images/shape.svg')}}" class="shape-top grow" alt="shape" />
    <img src="{{asset('images/shape1.svg')}}" class="shape-right grow" alt="shape" />
    <img src="{{asset('images/shape.svg')}}" class="shape-left grow" alt="shape" />
</section>
</div>

<!----------------------what we beleive----------------------->
<section class="believe-section relative">
    <div class="container-cstm">
        <div class="believe-banenr-cnt text-center">
            <h2 class="f-42 pb-4 semi-bold">What We Believe In </h2>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="relative beleive-box text-center">
                        <img src="{{asset('images/future.png')}}" class="future-icon" />
                        <h4 class="f-30 semi-bold">The Future We See</h4>
                        <!-- <p class="f-18 grey">To create a world where every student, regardless of language or background, has free,  instant access to peer to peer learning; making education more collaborative, inclusive,  and barrier free.</p> -->
                        <p class="f-18 grey">A world where no student has to fake confidence just to survive school. Where they can speak in their own language and feel seen. That world starts here.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="relative beleive-box text-center">
                        <img src="{{asset('images/future1.png')}}" class="future-icon" />
                        <h4 class="f-30 semi-bold">The Change We’re Making</h4>
                        <!-- <p class="f-18 grey">At Edupalz, our mission is simple: Empower students to learn, connect, and succeed,  together. We’re building a global learning community where students help each other in  any language, at any time, for free; because education should be accessible, social, and  limitless.</p> -->
                        <p class="f-18 grey">EduPalz is a response to burnout, isolation, and pressure. We’re building a community that’s safe, multilingual, and emotionally real, because school is hard enough without pretending.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="{{asset('images/poly.svg')}}" class="shape-poly" alt="shape" />
    <img src="{{asset('images/poly1.svg')}}" class="shape-polygn" alt="shape" />
</section>
@endsection
