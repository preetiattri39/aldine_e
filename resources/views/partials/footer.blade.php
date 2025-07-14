
   <style>
    /* Modal Styles */
        #modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
       #modal  h2 {
          font-size: 24px;
          font-weight: bold;
      }
      #modal  h3 {
          font-size: 18.72px;
          font-weight: bold;
      }
        #modal > div {
            background-color: #fefefe !important;
            margin: 5% auto !important;
            padding: 40px !important;
            border-radius: 16px !important;
            width: 90% !important;
            max-width: 800px !important;
            max-height: 80vh !important;
            overflow-y: auto !important;
            position: relative !important;
            box-shadow: var(--shadow-xl) !important;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 15px;
            transition: color 0.2s ease;
        }

        .close:hover,
        .close:focus {
            color: #333;
        }
footer a{
    cursor: pointer;
}
   </style>
    <footer style="background: #ffffff; padding: 40px 24px; border-top: 2px solid #f0f0f0; margin-top: 0; display: block; width: 100%;">
        <div class="footer-div" style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="color: #666666; font-size: 14px; font-weight: 400;">© 2025 EduPalz Inc. All rights reserved.</div>
            <div class="foooter-links" style="display: flex; gap: 32px; align-items: center;">
                <a  onclick="openModal('privacy')" style="color: #666666; text-decoration: none; font-size: 14px; font-weight: 400; transition: color 0.2s ease;" onmouseover="this.style.color='#333333'" onmouseout="this.style.color='#666666'">Privacy Policy</a>
                <a  onclick="openModal('terms')" style="color: #666666; text-decoration: none; font-size: 14px; font-weight: 400; transition: color 0.2s ease;" onmouseover="this.style.color='#333333'" onmouseout="this.style.color='#666666'">Terms & Conditions</a>
                <a  onclick="openModal('contact')" style="color: #666666; text-decoration: none; font-size: 14px; font-weight: 400; transition: color 0.2s ease;" onmouseover="this.style.color='#333333'" onmouseout="this.style.color='#666666'">Contact Us</a>
                <div id="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
                  <div style="position: relative; width: 80%; max-width: 600px; margin: 0 auto; padding: 20px; background-color: white;">
                      <span class="close" style="position: absolute; top: 10px; right: 10px; font-size: 24px; cursor: pointer;">&times;</span>
                      <div id="modal-content"></div> 
                  </div>
              </div>
            </div>
        </div>
    </footer>

    <script>
        // Modal functionality
        function openModal(type) {
            const modal = document.getElementById('modal');
            const content = document.getElementById('modal-content');
            
            let modalContent = '';
            
            if (type === 'privacy') {
                modalContent = `
                    <h2 style="color: #1E1E1E; margin-bottom: 24px;">Privacy Policy</h2>
                    <p style="margin-bottom: 16px; color: #6B7280;"><strong>Last updated:</strong> January 2025</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Information We Collect</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">EduPalz collects information you provide when creating an account, posting content, and interacting with other students. This includes your academic information, study materials shared, and communication with other users.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">How We Use Your Information</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">We use your information to connect you with relevant study groups, match you with classmates, and provide personalized academic support. We never sell your personal data to third parties.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Data Security</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">We implement industry-standard security measures to protect your personal information. All communications are encrypted and your academic content is stored securely.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Contact Us</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">If you have questions about this Privacy Policy, please contact us at privacy@edupalz.com</p>
                `;
            } else if (type === 'terms') {
                modalContent = `
                    <h2 style="color: #1E1E1E; margin-bottom: 24px;">Terms & Conditions</h2>
                    <p style="margin-bottom: 16px; color: #6B7280;"><strong>Last updated:</strong> January 2025</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Acceptance of Terms</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">By accessing and using EduPalz, you accept and agree to be bound by the terms and provision of this agreement.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">User Conduct</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">EduPalz is a safe space for academic collaboration. Users must respect academic integrity, be supportive of fellow students, and not engage in harassment, plagiarism, or sharing of inappropriate content.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Academic Integrity</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">While we encourage collaboration and peer support, users are responsible for adhering to their institution's academic integrity policies. EduPalz facilitates study help, not academic dishonesty.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Content Sharing</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">Users retain ownership of content they share but grant EduPalz permission to display and distribute this content within the platform to facilitate academic collaboration.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Termination</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">EduPalz reserves the right to terminate accounts that violate these terms or engage in behavior harmful to the community.</p>
                `;
            } else if (type === 'contact') {
                modalContent = `
                    <h2 style="color: #1E1E1E; margin-bottom: 24px;">Contact Us</h2>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Get in Touch</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">We'd love to hear from you! Whether you have questions, feedback, or need support, our team is here to help.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Email</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">
                        <strong>General Support:</strong> support@edupalz.com<br>
                        <strong>Technical Issues:</strong> tech@edupalz.com<br>
                        <strong>Privacy Questions:</strong> privacy@edupalz.com<br>
                        <strong>Business Inquiries:</strong> hello@edupalz.com
                    </p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Response Time</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">We typically respond to all inquiries within 24-48 hours. For urgent technical issues, we aim to respond within 4-6 hours during business hours.</p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Social Media</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">
                        Follow us for updates and student success stories:<br>
                        <strong>Instagram:</strong> @edupalzapp<br>
                        <strong>TikTok:</strong> @edupalz<br>
                        <strong>Twitter:</strong> @edupalzapp
                    </p>
                    
                    <h3 style="color: #1E1E1E; margin-top: 24px; margin-bottom: 12px;">Office</h3>
                    <p style="margin-bottom: 16px; line-height: 1.6;">
                        EduPalz Inc.<br>
                        123 Innovation Drive<br>
                        Toronto, ON M5V 3A8<br>
                        Canada
                    </p>
                `;
            }
            
            content.innerHTML = modalContent;
            modal.style.display = 'block';
        }
        
        // Close modal when clicking the X or outside the modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modal');
            const span = document.getElementsByClassName('close')[0];
            
            span.onclick = function() {
                modal.style.display = 'none';
            }
            
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>

<!-- <footer class="footer-bottom">
  <div class="container-cstm">
    <div class="row align-items-center">
      <div class="col-12 col-md-3">
        <div class="footer-logo">
          <a class="navbar-brand f-40 text-black semi-bold" href="{{ url('/') }}"><img src="{{ asset('images/logo.svg') }}"></a>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <ul class="navbar-nav footer-links">
          <li class="nav-item"><a class="nav-link active" href="{{ url('/') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/about-us') }}">About</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/faq') }}">FAQ</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/news-letter') }}">Newsletter</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/contact-us') }}">Contact</a></li>
        </ul>
      </div>
      <div class="col-12 col-md-3">
        <ul class="footer-social">
          <li class="nav-item"><a class="social-link" href="{{ $instagram }}"><img src="{{ asset('images/insta.svg') }}"></a></li>
         {{--<li class="nav-item"><a class="social-link" href="{{ $reddit }}"><img src="{{ asset('images/link.svg') }}"></a></li>--}}
          <li class="nav-item"><a class="social-link" href="{{ $tiktok }}"><img src="{{ asset('images/tik.svg') }}"></a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<div class="coprright">
  <div class="container-cstm">
    <div class="copyright-flex py-4 d-flex justify-content-center align-items-center">
      <p class="f-14 mb-0">© 2025 Edupalz Inc. All rights reserved|Support: <a href="/">info@edupalz.com</a></p>
    </div>
  </div>
</div> -->
