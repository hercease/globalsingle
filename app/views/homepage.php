<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your MLM Brand</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.2.0/mdb.min.css" integrity="sha512-7Gq9D0o4oucsdul8TfQEy1UtovxpFGnbR4je6T/pS6o31wM2HRDwZYScOQ9oVO5JFLI04EVB3WZMi1LG2dUNjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #6f42c1; /* Purple (Bootstrap's "indigo") */
            --secondary: #f8f9fa; /* Light gray */
        }
        
        /* Gradient Hero Section */
        .hero {
            background: linear-gradient(135deg, #6f42c1 0%, #3a0ca3 100%);
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
          .carousel-item {
      height: 500px;
      background-size: cover;
      background-position: center;
      position: relative;
    }

    .carousel-item::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.5); /* Overlay */
      z-index: 1;
    }

    .carousel-caption {
      z-index: 2;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .carousel-caption h1,
    .carousel-caption p {
      color: #fff;
      display: inline-block;
    }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">MLM Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Compensation Plan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary rounded" href="#">Join Now <i class="fas fa-arrow-right ms-1"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <!-- Hero Section with Transparent Overlay -->
    <section class="hero position-relative overflow-hidden">
    <!-- Background Image with Transparency -->
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');">
            <div class="carousel-caption">
            <h1>Welcome to Smallyfares</h1>
            <p>Your smart travel partner</p>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url('https://source.unsplash.com/1600x900/?airplane');">
            <div class="carousel-caption">
            <h1>Book Flights & Hotels</h1>
            <p>Fast, reliable and affordable</p>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url('https://source.unsplash.com/1600x900/?beach,resort');">
            <div class="carousel-caption">
            <h1>Explore the World</h1>
            <p>Discover amazing destinations</p>
            </div>
        </div>
        </div>

        <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose Us?</h2>
                <p class="text-muted">We provide everything you need to succeed</p>
            </div>
            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="fas fa-chart-line fa-2x text-primary"></i>
                            </div>
                            <h5>Proven Compensation Plan</h5>
                            <p class="text-muted">Earn through multiple streams including direct sales, team bonuses, and leadership rewards.</p>
                        </div>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                            </div>
                            <h5>Training Academy</h5>
                            <p class="text-muted">Access our step-by-step training system to build your business faster.</p>
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
                            <h5>Global Community</h5>
                            <p class="text-muted">Connect with top earners in our private network for mentorship.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Compensation Plan Highlights -->
    <section class="py-5 bg-white">
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
    <section class="py-5">
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
                    How much does it cost to join?
                </button>
                </h3>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    We offer starter packs beginning at $49.99, which includes your initial product kit and training access. Premium membership ($199) includes additional marketing tools and 1-on-1 coaching.
                </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    How do I get paid?
                </button>
                </h3>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    Earnings are paid weekly via direct deposit or PayPal. You'll earn commissions from personal sales (20-30%), team overrides (5-15%), and leadership bonuses (up to 5% company-wide pool).
                </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                    Is there training provided?
                </button>
                </h3>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    Yes! You'll get instant access to our <strong>MLM Success Academy</strong> with video tutorials, scripts, and weekly live training calls. Top earners host monthly Q&A sessions exclusively for members.
                </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="accordion-item border-0 mb-3 rounded overflow-hidden shadow-sm">
                <h3 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                    How much time do I need to commit?
                </button>
                </h3>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body bg-white">
                    Many members see results with 5-7 hours/week. Our system is designed for part-time participation, but full-time members typically achieve higher ranks faster.
                </div>
                </div>
            </div>

            </div>

            <!-- CTA Below FAQ -->
            <div class="text-center mt-5">
            <p class="mb-3">Still have questions?</p>
            <a href="#" class="btn btn-primary px-4">
                <i class="fas fa-envelope me-2"></i> Contact Support
            </a>
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Success Stories</h2>
                <p class="text-muted">Hear from our top earners</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/50" alt="User" class="rounded-circle me-3">
                            <div>
                                <h6 class="mb-0">Sarah Johnson</h6>
                                <small class="text-muted">Diamond Rank</small>
                            </div>
                        </div>
                        <p>"I went from $500/month to over $15,000/month in just 1 year with this system. The training made all the difference!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <!-- Add 2 more testimonials -->
            </div>
        </div>
    </section>

    1761895349

    <!-- CTA Section -->
    <section class="py-5 bg-dark text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Ready to Transform Your Income?</h2>
            <p class="lead mb-5">Join now and get instant access to our training portal and mentorship program</p>
            <a href="#" class="btn btn-primary btn-lg px-5">Start Your Journey Today</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-body-tertiary">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>MLM Brand</h5>
                    <p class="text-muted">Helping entrepreneurs build wealth since 2023</p>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">FAQ</a></li>
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
    <script>
// Your PHP data converted to JavaScript
const stages = [
  {stage: 1, downlines: 2, total_downlines: 15, compensation: 6, task_info: 'Personally recruit 2 downlines (15 total)'},
  {stage: 2, downlines: 4, total_downlines: 75, compensation: 16, task_info: 'Personally recruit 4 downlines (75 total)'},
  {stage: 3, downlines: 4, total_downlines: 375, compensation: 39, task_info: 'Personally recruit 4 downlines (375 total)'},
  {stage: 4, downlines: 6, total_downlines: 1875, compensation: 77, task_info: 'Personally recruit 6 downlines (1,875 total)'},
  {stage: 5, downlines: 8, total_downlines: 9375, compensation: 240, task_info: 'Personally recruit 8 downlines (9,375 total)'},
  {stage: 6, downlines: 8, total_downlines: 46875, compensation: 1988, task_info: 'Personally recruit 8 downlines (46,875 total)'},
  {stage: 7, downlines: 18, total_downlines: 234375, compensation: 9986, task_info: 'Personally recruit 18 downlines (234,375 total)'}
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
});
</script>
</body>
</html>