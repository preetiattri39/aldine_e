@extends('layouts.app')

@section('title', 'Welcome to Edupalz')
@section('content')
  <!----------------------Banner----------------------->
<!-- <section class="main-banner home relative">
    <div class="section-container">
        <div class="row align-items-center w-100 m-auto">
          <div class="col-12 col-md-6">
              <div class="inner-banenr-cnt">
              <span class="d-block welcome-txt mb-4">Welcome to Edupalz</span> 
                <span class="d-block welcome-txt mb-4">When school gets chaotic, we get it. And we get you.</span>
                <h2 class="f-60 pb-3 semi-bold">Education Made  Social</h2>
               <p class="f-20 pb-3">Study Smarter with Students Around the World, Get Help in Any Language,  Anytime, <span class="semi-bold">100% Free!</span></p> 
                <p class="f-20 pb-3">EduPalz is the first safe space for students around the world to connect over shared academic chaos: in their language, on their terms.</p>
              <button class="arrow-btn">Download Now on the App Store <img src="./images/arrow.svg" class="btn-arw swing" alt="arrow" /></button> 
                <button class="arrow-btn">Download Free on the App Store <img src="./images/arrow.svg" class="btn-arw swing" alt="arrow" /></button>
              </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="home-right-img">
                <img src="{{asset('images/banner.png')}}" class="home-banenr w-100 " alt="banner" />
            </div>
          </div>

        </div>
        <img src="{{asset('images/shape.svg')}}" class="shape-top grow" alt="shape" />
        <img src="{{asset('images/shape1.svg')}}" class="shape-right grow" alt="shape" />
        <img src="{{asset('images/shape.svg')}}" class="shape-left grow" alt="shape" />
        <img src="{{asset('images/shape1.svg')}}" class="shape-bottom grow" alt="shape" />
      </div>
  </section> -->

    <!----------------------Banner----------------------->
<section class="main-banner home relative">
    <div class="hero-container">
        <div class="hero-content">
              <div class="inner-banenr-cnt">
                <span class=" welcome-txt mb-4">Your course. Your language. Your people.</span>
                <h2 class="f-60 pb-3 hero-title semi-bold">Education Made  Social</h2>
                <p class="hero-subtitle f-20 pb-3">EduPalz is the first safe space for students around the world to connect over shared academic chaos: in their language, on their terms.</p>
                <button class="arrow-btn">Download on the App Store for Free</button>
              </div>
            </div>
             <div class="hero-visual">
                <div class="floating-student student-1">👨🏽‍🎓</div>
                <div class="floating-student student-2">👩🏻‍🎓</div>
                <div class="floating-student student-3">🧑🏿‍🎓</div>
                <div class="floating-student student-4">👩🏾‍💻</div>
                <div class="floating-student student-5">🧕🏽</div>
                <div class="floating-student student-6">👨🏻‍💻</div>
          </div>

        </div>
       <!--  <img src="{{asset('images/shape.svg')}}" class="shape-top grow" alt="shape" />
        <img src="{{asset('images/shape1.svg')}}" class="shape-right grow" alt="shape" />
        <img src="{{asset('images/shape.svg')}}" class="shape-left grow" alt="shape" />
        <img src="{{asset('images/shape1.svg')}}" class="shape-bottom grow" alt="shape" /> -->
      </div>
  </section>

<section class="about-section  abot relative">

  <div class="container-cstm about-page">
        <div class="about-banenr-cnt text-center">  
          <div class="section-header">
            <h2 class="section-title semi-bold">About</h2>
            <p class="section-subtitle">The Story Behind Edupalz</p>
          </div>
            <p class="f-18 about-quote">{!!$page->content!!}</p>
        </div>
  </div>
   <!--  <img src="{{asset('images/plane.svg')}}" class="shape-plane grow" alt="shape" />
    <img src="{{asset('images/circle.svg')}}" class="shape-circles left-1" alt="shape" />
    <img src="{{asset('images/shape.svg')}}" class="shape-top grow" alt="shape" />
    <img src="{{asset('images/shape1.svg')}}" class="shape-right grow" alt="shape" />
    <img src="{{asset('images/shape.svg')}}" class="shape-left grow" alt="shape" /> -->
</section>



<!-- Comparison Section -->
<section class="comparison section">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Why Choose EduPalz?</h2>
                <p class="section-subtitle">See how we stack up against other student platforms</p>
            </div>
            <div class="comparison-grid">
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-icon other-platforms-icon">✕</div>
                        <h3 class="comparison-title">Other Platforms</h3>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Cost</span>
                        <span class="feature-status status-negative">Monthly subscription fees</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Content Quality</span>
                        <span class="feature-status status-negative">AI generated content that may not reflect actual course material</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Support</span>
                        <span class="feature-status status-negative">As course content gets harder, support feels less personal</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Language Support</span>
                        <span class="feature-status status-negative">Mostly English only</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Community</span>
                        <span class="feature-status status-negative">You're studying alone with no one to relate to</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Access</span>
                        <span class="feature-status status-negative">"Premium" paywall blocks you when you need help most</span>
                    </div>
                </div>

                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-icon edupalz-icon">✓</div>
                        <h3 class="comparison-title">EduPalz</h3>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Cost</span>
                        <span class="feature-status status-positive">100% FREE</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Content Quality</span>
                        <span class="feature-status status-positive">Real notes from students in your exact course</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Support</span>
                        <span class="feature-status status-positive">Built on real student experience from those who've taken the course</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Language Support</span>
                        <span class="feature-status status-positive">Supports multiple languages</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Community</span>
                        <span class="feature-status status-positive">Join a student powered community that actually gets it</span>
                    </div>
                    <div class="comparison-item">
                        <span class="feature-label">Access</span>
                        <span class="feature-status status-positive">Everything unlocked: help on assignments, notes, exams, etc</span>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Features Section -->
<section class="features section">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Features That Matter</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">❓</div>
                    <h3 class="feature-title">Quick Solve</h3>
                    <p class="feature-description">Ask & get peer answers in minutes</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3 class="feature-title">Find Connections</h3>
                    <p class="feature-description">Match with classmates taking the same course</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3 class="feature-title">StudyCrew</h3>
                    <p class="feature-description">Join a StudyCrew to access shared notes, past and current exams, midterms, and real time help from classmates in your exact course. Whether you're stuck on an assignment, confused about a lecture, or just need a quick explanation, your crew has your back. You can even find peer tutoring or help others out. This is more than a group, it's your go to academic support system.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💪</div>
                    <h3 class="feature-title">Motivational Wall</h3>
                    <p class="feature-description">For students to support each other</p>
                </div>
            </div>
        </div>
</section>

 <!-- FAQ Section -->
    <section class="faq section">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Everything you need to know about EduPalz</p>
            </div>
            <div class="faq-grid">
                <div class="faq-item">
                    <h3 class="faq-question" onclick="toggleFaq(this)">Is this actually free?</h3>
                    <p class="faq-answer">Yes, completely free. No hidden fees, no premium upgrades, no credit card required.</p>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question" onclick="toggleFaq(this)">Can I get help with my specific homework without joining groups or video calls?</h3>
                    <p class="faq-answer">Absolutely. Just post your question and get answers, no group meetings or video calls required.</p>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question" onclick="toggleFaq(this)">Can I ask questions anonymously so no one knows it's me?</h3>
                    <p class="faq-answer">Yes, you can post, ask, and answer completely anonymously. Your identity stays private.</p>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question" onclick="toggleFaq(this)">What subjects can I get help with?</h3>
                    <p class="faq-answer">Any subject you're struggling with, math, science, English, history, languages, test prep, you name it.</p>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question" onclick="toggleFaq(this)">What if I ask a stupid question, will people make fun of me?</h3>
                    <p class="faq-answer">There are no stupid questions here. Our community is focused on helping each other succeed, not judging. Plus, you can ask anonymously if you prefer.</p>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question" onclick="toggleFaq(this)">Why not just use ChatGPT or other AI?</h3>
                    <p class="faq-answer">AI gives you generic answers that don't match your specific textbook, teacher's style, or assignment requirements. When you're stuck at 2am before a test, you need someone who actually took your class and knows what your teacher expects.</p>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question" onclick="toggleFaq(this)">Will this actually help me pass my classes or is it just another thing to do?</h3>
                    <p class="faq-answer">Get real help from students who've solved the same problems you're facing. Quick answers, proven solutions, no busywork.</p>
                </div>
            </div>
        </div>
    </section>


<!-- Testimonials Section - Fresh 20 Testimonials -->
<section class="testimonials section">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Trusted by Students Worldwide</h2>
                <p class="section-subtitle">Here's what they're saying...</p>
            </div>
            <div class="testimonials-wrapper">
                <div class="testimonials-track">
                    <!-- Fresh Testimonial #1 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">NI</div>
                            <div class="testimonial-info">
                                <h4>Nia</h4>
                                <p>1st-year Nursing @ TMU 🇨🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"Bro I literally posted on EduPalz like 'yo does anyone have bio 101 notes?' and this random guy from BC sent me an entire Google Drive. Instant lifesaver."</p>
                    </div>

                    <!-- Fresh Testimonial #2 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">IS</div>
                            <div class="testimonial-info">
                                <h4>Isaac</h4>
                                <p>Engineering @ University of Manchester 🇬🇧</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I didn't expect anyone to reply but this girl was like 'omg I took that last term, here's my cheat sheet.' And I was like wait people actually help here??"</p>
                    </div>

                    <!-- Fresh Testimonial #3 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">CH</div>
                            <div class="testimonial-info">
                                <h4>Chloe</h4>
                                <p>2nd-year CompSci @ NTU 🇸🇬</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I found someone doing the exact same course as me but in like, Australia. We're both failing, but together now."</p>
                    </div>

                    <!-- Fresh Testimonial #4 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">JO</div>
                            <div class="testimonial-info">
                                <h4>Jordan</h4>
                                <p>Business @ UBC 🇨🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"Not gonna lie I joined just to lurk but ended up in a whole convo about failing calc and now we're groupchat besties. Like how did I end up in a wholesome study cult?"</p>
                    </div>

                    <!-- Fresh Testimonial #5 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">TA</div>
                            <div class="testimonial-info">
                                <h4>Tania</h4>
                                <p>Grade 12 @ Sacred Heart High 🇿🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"My school's group chat is literally dry. EduPalz? I met a girl in Brazil who helped me make a study tracker and now I'm weirdly motivated???"</p>
                    </div>

                    <!-- Fresh Testimonial #6 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">OM</div>
                            <div class="testimonial-info">
                                <h4>Omar</h4>
                                <p>Grade 11 @ Al Mawakeb School 🇦🇪</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I asked for help with chem and this dude sent me an entire playlist he made to study. Like who even does that?? EduPalz people apparently."</p>
                    </div>

                    <!-- Fresh Testimonial #7 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">SI</div>
                            <div class="testimonial-info">
                                <h4>Sienna</h4>
                                <p>1st-year Psych @ McGill University 🇨🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I used to pay for all these trashy study apps. Now I just ask for stuff on here and real humans reply. With memes sometimes."</p>
                    </div>

                    <!-- Fresh Testimonial #8 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">JU</div>
                            <div class="testimonial-info">
                                <h4>Jules</h4>
                                <p>Grade 12 @ British School Manila 🇵🇭</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"It's not even just notes. One time I had an academic breakdown and someone was like 'been there bestie, here's how I survived.' Bro I almost cried."</p>
                    </div>

                    <!-- Fresh Testimonial #9 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">MA</div>
                            <div class="testimonial-info">
                                <h4>Maya</h4>
                                <p>2nd-year Law @ University of Cape Town 🇿🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"EduPalz is lowkey better than therapy. Y'all be sending notes, voice notes, AND emotional support."</p>
                    </div>

                    <!-- Fresh Testimonial #10 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">ZA</div>
                            <div class="testimonial-info">
                                <h4>Zayd</h4>
                                <p>Grade 12 @ Lahore Grammar School 🇵🇰</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I don't even ask on Reddit anymore. EduPalz has better vibes and no gatekeeping. Just students being real."</p>
                    </div>

                    <!-- Fresh Testimonial #11 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">EL</div>
                            <div class="testimonial-info">
                                <h4>Ella</h4>
                                <p>Grade 11 @ Lycée Français Charles de Gaulle 🇫🇷</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"My ADHD cannot handle boring study apps. But EduPalz? People explain stuff in normal words like 'this part's dumb but here's what it means.' I understood it IMMEDIATELY."</p>
                    </div>

                    <!-- Fresh Testimonial #12 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">KE</div>
                            <div class="testimonial-info">
                                <h4>Kev</h4>
                                <p>Grade 12 @ Crescent Heights High 🇨🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"Someone literally said 'yo don't overthink this, here's how I did it' and just sent the answer with a mini breakdown. Bless their soul fr."</p>
                    </div>

                    <!-- Fresh Testimonial #13 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">ZU</div>
                            <div class="testimonial-info">
                                <h4>Zuri</h4>
                                <p>Grade 10 @ Nairobi International School 🇰🇪</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"Lowkey I joined for notes but now I stay for the people. It's like everyone here is trying to survive school together."</p>
                    </div>

                    <!-- Fresh Testimonial #14 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">AV</div>
                            <div class="testimonial-info">
                                <h4>Ava</h4>
                                <p>Grade 11 @ Bishop's College 🇱🇰</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I hate asking questions in class cause the teachers make it weird. On EduPalz I just post and someone replies like 'omg same.' I don't feel dumb anymore."</p>
                    </div>

                    <!-- Fresh Testimonial #15 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">CA</div>
                            <div class="testimonial-info">
                                <h4>Carlos</h4>
                                <p>Grade 10 @ Colégio Bandeirantes 🇧🇷</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"The girl who helped me was like 3 grades ahead and still took time to explain it. Like bro, who raised you. EduPalz is different."</p>
                    </div>

                    <!-- Fresh Testimonial #16 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">LA</div>
                            <div class="testimonial-info">
                                <h4>Layla</h4>
                                <p>Grade 12 @ Merivale High School 🇨🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I'm literally making international academic friends??? Not in a weird way. Just cool students tryna help each other pass."</p>
                    </div>

                    <!-- Fresh Testimonial #17 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">AM</div>
                            <div class="testimonial-info">
                                <h4>Amir</h4>
                                <p>Grade 11 @ St. George's College 🇬🇧</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"Not me becoming besties with a girl in Morocco because we both suck at bio."</p>
                    </div>

                    <!-- Fresh Testimonial #18 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">NO</div>
                            <div class="testimonial-info">
                                <h4>Noor</h4>
                                <p>Grade 12 @ The American School of Dubai 🇦🇪</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"It's giving: 'we're all in this together' but for people who actually reply when you need help."</p>
                    </div>

                    <!-- Fresh Testimonial #19 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">KA</div>
                            <div class="testimonial-info">
                                <h4>Kaitlyn</h4>
                                <p>Grade 11 @ SMK Sri Aman 🇲🇾</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"I post, someone helps. I help back when I can. That's literally it. No paywalls, no begging for access, no annoying ads. Just vibes."</p>
                    </div>

                    <!-- Fresh Testimonial #20 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">TO</div>
                            <div class="testimonial-info">
                                <h4>Tomi</h4>
                                <p>Grade 12 @ International School of Lagos 🇳🇬</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"If I had EduPalz last year I swear I wouldn't have cried before every math test. People here get it. They BEEN struggling too."</p>
                    </div>

                    <!-- Loop back for seamless animation -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">NI</div>
                            <div class="testimonial-info">
                                <h4>Nia</h4>
                                <p>1st-year Nursing @ TMU 🇨🇦</p>
                            </div>
                        </div>
                        <p class="testimonial-text">"Bro I literally posted on EduPalz like 'yo does anyone have bio 101 notes?' and this random guy from BC sent me an entire Google Drive. Instant lifesaver."</p>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- CTA Section -->
<section class="cta-section section">
        <div class="cta-content">
            <h2 class="cta-title">Now you know. Download the EduPalz app for free today</h2>
            <p class="cta-subtitle">Hundreds of students are already using EduPalz to CONNECT, SHARE, and SUPPORT each other. Will you be next?</p>
            <a href="#" class="cta-button">Download on the App Store for Free</a>
        </div>
</section>

</div>
</body>
<script>
        // FAQ Toggle Function
        function toggleFaq(element) {
            const answer = element.nextElementSibling;
            const isActive = element.classList.contains('active');
            
            // Close all FAQ items
            document.querySelectorAll('.faq-question').forEach(q => {
                q.classList.remove('active');
                q.nextElementSibling.classList.remove('active');
            });
            
            // If this item wasn't active, open it
            if (!isActive) {
                element.classList.add('active');
                answer.classList.add('active');
            }
        }
        </script>
@endsection