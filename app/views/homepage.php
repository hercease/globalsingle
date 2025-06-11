<!DOCTYPE html>
<html lang="en">
<head>
<title>Home | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Home | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Home | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/homepage">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Home | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/homepage">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/homepage">
    <link rel="manifest" href="manifest.json">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap" id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/tabler-icons.min.css">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/feather.css">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/fontawesome.css">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/material.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style-preset.css">
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.28.1/tabler-icons.min.css" integrity="sha512-UuL1Le1IzormILxFr3ki91VGuPYjsKQkRFUvSrEuwdVCvYt6a1X73cJ8sWb/1E726+rfDRexUn528XRdqrSAOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.2.0/mdb.min.css" integrity="sha512-7Gq9D0o4oucsdul8TfQEy1UtovxpFGnbR4je6T/pS6o31wM2HRDwZYScOQ9oVO5JFLI04EVB3WZMi1LG2dUNjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <script>
        window.env = {
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access'] ?? 1; ?>",
            VAPID_PUBLIC_KEY: "<?php echo VAPID_PUBLIC_KEY ?>",
            ENDPOINT: "<?php echo $rootUrl ?>"
        };
    </script>
    <style>
        :root {
            --primary: #6f42c1; /* Purple (Bootstrap's "indigo") */
            --secondary: #f8f9fa; /* Light gray */
        }

        body {
            font-family: 'Nunito Sans', sans-serif;
            font-weight: 400;
            color: #333;
        }
        
        /* Gradient Hero Section */
        .hero {
            color: white;
        }
        
        /* Feature Cards */
        .feature-card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Testimonials */
        .testimonial-card {
            background: var(--secondary);
            border-left: 4px solid var(--primary);
        }
        
        /* Compensation Plan Tiers */
        .tier-badge {
            background: var(--primary);
            color: white;
        }

        /* Hero Section Styling */
        .hero {
        position: relative;
        color: white;
        }

        /* Ensures text stays above all layers */
        .position-relative.z-2 {
        position: relative;
        z-index: 2;
        }

        /* Optional: Add animation to CTA buttons */
        .btn-light, .btn-outline-light {
        transition: all 0.3s;
        }
        .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255,255,255,0.3);
        }

          /* Custom styles for transparent overlay */
        .owl-carousel .slide-item {
          height: 350px;
          background-size: cover;
          background-position: center;
          position: relative;
        }

      .slide-item .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6); /* Dark transparent overlay */
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        color: #fff;
        padding: 20px;
      }

.overlay h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
  padding: 0.5rem 1rem;
  border-radius: 10px;
}

.overlay p {
  font-size: 1.2rem;
  background: rgba(0, 0, 0, 0.4);
  padding: 0.3rem 0.8rem;
  border-radius: 8px;
}

.bg-section {
  position: relative;
  background-image: url('public/assets/images/our_services.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  height: 100vh; /* or adjust to content height */
}

.transparent-bg-section {
  position: relative;
}

.transparent-bg-section::before {
  content: '';
  background-image: url('public/assets/images/who_we_are.jpg');
  background-size: cover;
  background-position: center;
  opacity: 0.1; /* Adjust transparency (0 = fully transparent, 1 = fully opaque) */
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: -1;
}
.transparent-faq-section {
  position: relative;
}

.transparent-faq-section::before {
  content: '';
  background-image: url('public/assets/images/faq.jpg');
  background-size: cover;
  background-position: center;
  opacity: 0.1; /* Adjust transparency (0 = fully transparent, 1 = fully opaque) */
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: -1;
}

.offcanvas {
    width: 250px;
}

html {
    scroll-behavior: smooth;
}

</style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="#"><img width="100px" src="public/assets/images/logo_new.png" /></a>

        <!-- Toggler for offcanvas on mobile -->
        <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        <i class="fas fa-bars"></i>
        </button>

        <!-- Offcanvas menu -->
        <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="offcanvasNavbar"
        aria-labelledby="offcanvasNavbarLabel"
        >
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img width="100px" src="public/assets/images/logo_new.png" /></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#who">Who We Are</a></li>
                    <li class="nav-item"><a class="nav-link" href="#compensation">Compensation Plan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Our Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">Faq</a></li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary rounded-2" href="register">Join Now <i class="fas fa-arrow-right ms-1"></i></a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    </nav>
<!-- Navbar -->


    <!-- Hero Section -->
    <!-- Hero Section with Transparent Overlay -->
    <section class="hero position-relative overflow-hidden">
    <!-- Background Image with Transparency -->
        <div class="owl-carousel owl-theme">
            <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');">
                <div class="overlay">
                <h2>Welcome to Global Single Line</h2>
                <p>Generating Success For Life</p>
                </div>
            </div>
            <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');">
                <div class="overlay">
                <h2>Our Core Values</h2>
                <p>Genuinity, Sincerity and Longetivity</p>
                </div>
            </div>
            <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');">
                <div class="overlay">
                <h2>Financial Independence</h2>
                <p>Empowering millions of individuals worldwide</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="who" class="py-5 transparent-bg-section">
        <div class="container">
            <div class="text-center">
                <h2 class="fw-bold">Who We Are?</h2>
                <p class="text-muted">We provide everything you need to succeed</p>
            </div>
            <div class="row">
                <!-- Feature 1 -->

                <div class="col-md-12 text-center">
                    <p>Global Single Line is an online Global Company designed and Established to alleviate Global poverty rate and supporting economic and scoail developments to eradicate Global conflicts in our societies through self generated funds and service charges.</p>
                </div>
                <!-- Feature 2 -->
                <div class="col-md-12 text-center">
                    <p>We are giving out a priviledge to the public to come as stakeholders through a certain membership fee attached with series of bonuese as a compensation packaged for them.</p>
                </div>
                <!-- Feature 3 -->
                <div class="col-md-12  text-center">
                    <p>We believe, many have corrupted the online business industries, but with certain effective and discipline measures, GSL will work tirelessly in empowering individuals to achieve their personal growth.</p>
                </div>
            </div>
        </div>
    </section>


    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Our Services</h2>
                <p class="text-muted">We provide everything you need to succeed</p>
            </div>
            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="fas fa-code fa-2x text-primary"></i>
                            </div>
                            <h5>Software Development</h5>
                            <p class="text-muted">We provide custom software solutions for we and mobile applications for Private na dPublic Organisations. Our team create intuitive and scalable apps designed to grow with your business. Moreso, From "Planning" to "Launch" and "Management", We deliver efficient and relaible disgiatl products.</p>
                        </div>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="fas fa-solid fa-chart-line fa-2x text-primary"></i>
                            </div>
                            <h5>Online Business Trainings</h5>
                            <p class="text-muted">GSL Online business trainings provide flexible, accessible education for entrepreneurs and professionals, with Convenience, Cost-effectiveness and Self-paced learning. Nevertheless, Our Online Business Trainings cover topics like: Leadership & Management, Entrepreneurship, FOREX/Crypto Trading, WEB & Graphic Designs.</p>
                        </div>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <h5>Single Leg MLM Platform</h5>
                            <p class="text-muted">GSL company provide a Single Leg Multi-Level Marketing(MLM) system with a compensation structure where participants earn commissions primarily from Onme TEAM Network, This model can offer a more straightforward approach to the Multi-Level Marketing Industry, Meanwhile, GSL Single Leg Structure focuses on One Global Team, Multiple Levels, Series of Passive Income Opportunities, Simplified strcuture, Individual recruitment task performance and Cirlce out bonus on each stages respectively. emphasaizing personal growths and global team-work advancements.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="fas fa-solid fa-coins fa-2x text-primary"></i>
                            </div>
                            <h5>Crypto Exchange Markets</h5>
                            <p class="text-muted">GSL Crypto Exchnage is a digital platform where individuals can Buy, Sell, Store, and Trade cryptocurrencies like BTC, BNB, ETH, SOL, TON, and others. Meanwhile, We would launch our Native Utility Token(GSL) on SOLANA Blockchain next year to mark the company's a year anniversay celebration. In addition, Our Vendors would become automatic Merchants by giving license to sell Cryptocurrencies on our P2P Trading in October 2025.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <h5>Chat Platform</h5>
                            <p class="text-muted">Our Company provides a chat platform which serves as a digital tool that enables real-time communication between individuals or groups through text, voice, or video. GSL Chat platform facilitates quick and efficiet communication between Members, Vendors and Customer support. Moreover, GSL Chat Rooms For: Employment (Online Jobs, Hybrid jobs & Offline Jobs), Business (E-commerce & Services), Entertainment ( Movie, Music & Lifestyles), Relationships (PefecthMatch & LoveQuotes), Sports(Football & Other Sports). However, All thes above interesting groups would be available after Official Launching</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Compensation Plan Highlights -->
    <section id="compensation" class="py-5 bg-white">
         <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Compensation Plan Growth Path</h2>
      <p class="text-muted">See how your earnings scale with each achievement stage</p>
    </div>

    <!-- Stage Progress Visualization -->
    <div class="row g-4">
      <!-- Left Column: Stage Cards -->
      <div class="col-lg-4">
        <div class="pt-3" style="top: 20px;">
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Selected Stage Details</h5>
            </div>
            <div class="card-body" id="stageDetails">
              <p class="text-muted">Click on any stage to view requirements</p>
            </div>
          </div>
          
          <div class="d-grid">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#fullPlanModal">
              <i class="fas fa-table me-2"></i> View Full Plan Table
            </button>
          </div>
        </div>
      </div>
      
      <!-- Right Column: Visualizations -->
      <div class="col-lg-8">
        <!-- Compensation Growth Chart -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white">
            <h5 class="mb-0">Earnings Potential</h5>
          </div>
          <div class="card-body">
            <canvas id="compensationChart" height="250"></canvas>
          </div>
        </div>
        
        <!-- Network Growth Chart -->
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white">
            <h5 class="mb-0">Team Growth Requirements</h5>
          </div>
          <div class="card-body">
            <canvas id="networkChart" height="250"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


    <!-- FAQ Section -->
    <section id="faq" class="py-5 transparent-faq-section">
    <div class="container">
        <div class="text-center mb-5">
        <h2 class="fw-bold">Frequently Asked Questions</h2>
        <p class="text-muted">Get answers to common questions about our program</p>
        </div>

        <!-- FAQ Accordion -->
        <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
            
            <!-- Item 1 -->
            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">
                    What is Single MLM System?
                </button>
                </h3>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body bg-white">
                        It is Power-Leg MLM system, So therefore, No first-come First-serve, No legs, No Binaries, No Genealogy, Every members queue on a single straight line network.
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    How Can I Register?
                </button>
                </h3>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    You can register your upline or our mobile support.
                </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                    How can i buy Registration PIN?
                </button>
                </h3>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    You can buy registration PIN from our verified vendors login to the APP and contact anyone. Moreover, we need 5,000 vendors across the Global, any member can apply to be a vendor once qualified.
                </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                    Is Multiple Accounts Allowed?
                </button>
                </h3>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    No, one account per user, members found guilty will lose all accounts, if multiple accounts detected without refund.
                </div>
                </div>
            </div>

            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                    What is the sustainability of this platform?
                </button>
                </h3>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                    <div class="accordion-body bg-white">
                        GSL Team hands are on deck to deliver the best, meanwhile, with the support of each member performing his/her tasks, we can last for years.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                    How long does withdrawal take?
                </button>
                </h3>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                    <div class="accordion-body bg-white">
                        15 Minutes
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingEight">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight">
                    Can i refer more the withdrawal take?
                </button>
                </h3>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    Yes, but we encourage you to assist your team and still claim your referral bonus at the same time. Together we can earn more.    
                </div>
                </div>
            </div>

            </div>

            <!-- CTA Below FAQ -->
            <div class="text-center mt-5">
                <p class="mb-3">Still have questions?</p>
                <a href="support" class="btn btn-primary px-4">
                    <i class="fas fa-envelope me-2"></i> Contact Support
                </a>
            </div>
        </div>
        </div>
    </div>
    </section>
    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Ready to Transform Your Income?</h2>
            <p class="lead mb-5">Click the button below to get started today.</p>
            <a href="register" class="btn btn-light btn-lg px-5">Start Your Journey Today</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-body-tertiary">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img width="100px" src="public/assets/images/logo_new.png" />
                    <p class="text-muted fw-bold">Generating success for life</p>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">Home</a></li>
                        <li><a href="#who" class="text-decoration-none text-muted">Who We Are</a></li>
                        <li><a href="#compensation" class="text-decoration-none text-muted">Compensation</a></li>
                        <li><a href="#faq" class="text-decoration-none text-muted">FAQ</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Connect</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-dark"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <p class="text-muted mb-0">&copy; <?php echo date("Y"); ?> GlobalSingleLine. All rights reserved.</p>
        </div>
    </footer>

    <div class="modal fade" id="fullPlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complete Compensation Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>Stage</th>
                        <th>Personal Recruits</th>
                        <th>Total Team</th>
                        <th>Circle Out Bonus</th>
                    </tr>
                    </thead>
                    <tbody id="planTableBody">
                    <!-- Filled by JavaScript -->
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.2.0/mdb.umd.min.js" integrity="sha512-XaBF6KP9xEbPjS0vTWwV3ETXS4EBvYPIkvEPX7B4QcStZEj6JEesGUEHMhbZMH3aaoSmCzXFoZxWBK/GTa2tBw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery (required) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>
    <script src="sw.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/app.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/workboxreg.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbarHeight = document.querySelector('.navbar').offsetHeight;

    document.querySelectorAll('a.nav-link[href^="#"]').forEach(anchor => {
      anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const targetId = this.getAttribute("href").substring(1);
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
          const offsetTop = targetElement.offsetTop - navbarHeight;

          window.scrollTo({
            top: offsetTop,
            behavior: "smooth"
          });

          // Close offcanvas if open (optional for mobile nav)
          const offcanvas = document.querySelector('.offcanvas.show');
          if (offcanvas) {
            const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
            bsOffcanvas.hide();
          }
        }
      });
    });
  });

// Your PHP data converted to JavaScript
const stages = [
  {stage: 1, downlines: 2, total_downlines: 15, compensation: 10, task_info: 'Personally recruit 2 downlines (15 total)'},
  {stage: 2, downlines: 2, total_downlines: 85, compensation: 20, task_info: 'Personally recruit 2 downlines (85 total)'},
  {stage: 3, downlines: 4, total_downlines: 385, compensation: 50, task_info: 'Personally recruit 4 downlines (385 total)'},
  {stage: 4, downlines: 5, total_downlines: 1585, compensation: 115, task_info: 'Personally recruit 5 downlines (1,585 total)'},
  {stage: 5, downlines: 5, total_downlines: 7585, compensation: 250, task_info: 'Personally recruit 5 downlines (7,585 total)'},
  {stage: 6, downlines: 10, total_downlines: 38585, compensation: 2000, task_info: 'Personally recruit 10 downlines (38,585 total)'},
  {stage: 7, downlines: 12, total_downlines: 235585, compensation: 8000, task_info: 'Personally recruit 12 downlines (235,585 total)'}
];

// 1. Populate the modal table
const tableBody = document.getElementById('planTableBody');
tableBody.innerHTML = stages.map(stage => `
  <tr>
    <td class="fw-bold">${stage.stage}</td>
    <td>${stage.downlines}</td>
    <td>${stage.total_downlines.toLocaleString()}</td>
    <td class="text-success fw-bold">$${stage.compensation.toLocaleString()}</td>
  </tr>
`).join('');

// 2. Create charts
document.addEventListener('DOMContentLoaded', function() {
  // Compensation Chart
  const compCtx = document.getElementById('compensationChart').getContext('2d');
  new Chart(compCtx, {
    type: 'bar',
    data: {
      labels: stages.map(s => `Stage ${s.stage}`),
      datasets: [{
        label: 'Monthly Earnings ($)',
        data: stages.map(s => s.compensation),
        backgroundColor: '#3b82f6',
        borderColor: '#1e40af',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'USD' }
        }
      },
      onClick: (e, elements) => {
        if (elements.length > 0) {
          updateStageDetails(stages[elements[0].index]);
        }
      }
    }
  });

  // Network Growth Chart
  const networkCtx = document.getElementById('networkChart').getContext('2d');
  new Chart(networkCtx, {
    type: 'line',
    data: {
      labels: stages.map(s => `Stage ${s.stage}`),
      datasets: [
        {
          label: 'Personal Recruits',
          data: stages.map(s => s.downlines),
          borderColor: '#10b981',
          backgroundColor: 'transparent',
          tension: 0.3,
          yAxisID: 'y'
        },
        {
          label: 'Total Team',
          data: stages.map(s => s.total_downlines),
          borderColor: '#6366f1',
          backgroundColor: 'transparent',
          tension: 0.3,
          yAxisID: 'y1'
        }
      ]
    },
    options: {
      responsive: true,
      interaction: { mode: 'index' },
      scales: {
        y: {
          type: 'linear',
          display: true,
          position: 'left',
          title: { display: true, text: 'Personal Recruits' }
        },
        y1: {
          type: 'logarithmic',
          display: true,
          position: 'right',
          title: { display: true, text: 'Total Team (log scale)' },
          grid: { drawOnChartArea: false }
        }
      },
      onClick: (e, elements) => {
        if (elements.length > 0) {
          updateStageDetails(stages[elements[0].index]);
        }
      }
    }
  });

  // Update stage details card
  function updateStageDetails(stage) {
    document.getElementById('stageDetails').innerHTML = `
      <h5 class="text-primary">Stage ${stage.stage}</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><i class="fas fa-user-plus text-muted me-2"></i> <strong>${stage.downlines}</strong> personal recruits</li>
        <li class="mb-2"><i class="fas fa-users text-muted me-2"></i> <strong>${stage.total_downlines.toLocaleString()}</strong> total team</li>
        <li class="mb-3"><i class="fas fa-dollar-sign text-muted me-2"></i> <strong>$${stage.compensation.toLocaleString()}</strong>/Circle Out Bonus</li>
      </ul>
      <p class="small text-muted mb-0">${stage.task_info}</p>
    `;
  }

  // Initialize with first stage
  updateStageDetails(stages[0]);

  document.addEventListener('DOMContentLoaded', function() {
            const carousel = new mdb.Carousel(document.getElementById('materialCarousel'), {
                touch: true,
                interval: 5000,
                pause: 'hover'
            });
            
            // Add smooth transition effect
            document.querySelectorAll('.carousel-item').forEach(item => {
                item.style.transition = 'transform 0.6s ease-in-out';
            });
        });

    
  $(".owl-carousel").owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    nav: false,
    dots: false
  });

});
</script>
</body>
</html>