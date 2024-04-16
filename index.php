<?php
session_start();
require_once("assets/php/connection.php");
if(isset($_POST["submit"])) {
    echo "I am called";
    echo "email: " . $_SESSION["email"];
    

    $otp = "";
    // Concatenate the individual OTP input values
    $otp .= $_POST["otp1"];
    $otp .= $_POST["otp2"];
    $otp .= $_POST["otp3"];
    $otp .= $_POST["otp4"];
    $otp .= $_POST["otp5"];
    $otp .= $_POST["otp6"];

    echo $otp;

    $email = $_SESSION["email"];
    $userOtp = "SELECT * FROM users WHERE email = '$email'";
    $response = $conn->query($userOtp);
    
    if ($response) {
        $userData = $response->fetch_assoc();
        $correctOtp = $userData['otp'];
        $timeValue = new DateTime($userData['timeValue']); // Convert DATETIME to DateTime object

        $currentTime = new DateTime(); // Current DateTime object
        
        // Calculate the expiry time (current time + 60 seconds)
        $expiryTime = $timeValue->modify('+60 seconds');

        if ($currentTime > $expiryTime) {
            // OTP has expired
            echo "OTP expired";
        }else if ($otp != $correctOtp) {
          echo "Incorrect OTP";
        }
        else {
          echo "otp valid";
            // Check if email already exists in loggedin_users table
            $exists_query = "SELECT * FROM loggedin_users WHERE email='$email'";
            $exists_result = $conn->query($exists_query);
            if (!$exists_result) {
              // Error in database query
              echo ("Database query error: " . $conn->error);
          }
          
          if ($exists_result->num_rows == 0) {
              // Email does not exist in loggedin_users table, insert it
              $dateValue = date("Y-m-d H:i:s");
              $insert_query = "INSERT INTO loggedin_users (email, timeValue) VALUES ('$email', '$dateValue')";
              if (!$conn->query($insert_query)) {
                  // Error inserting record
                  echo ("Error inserting record into loggedin_users table: " . $conn->error);
              }
              else{
                // Success response
                echo "OTP verification successful";
                  // Rest of your code for handling the result of the query
                }
          }
          
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="zxx">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Title -->
    <title>ExamSafari - One solution for all tension</title>
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700;900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap"
      rel="stylesheet"
    />
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="assets/css/animate.min.css" />
    <!-- IcoFont Min CSS -->
    <link rel="stylesheet" href="assets/css/icofont.min.css" />
    <!-- IcoMoon Min CSS -->
    <link rel="stylesheet" href="assets/css/icomoon.min.css" />
    <!-- Font Awesome Min CSS -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <!-- Mean Menu CSS -->
    <link rel="stylesheet" href="assets/css/meanmenu.css" />
    <!-- Magnific Popup Min CSS -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css" />
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css" />
    <!-- flickity CSS -->
    <link rel="stylesheet" href="assets/css/flickity.css" />
    <link rel="stylesheet" href="assets/css/flickity-fade.css" />
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css" />
  </head>
  <body>
    <!-- Start Preloader Section -->
    <div class="techSoft-preloader">
      <svg id="triangle" viewBox="-3 -4 39 39">
        <polygon
          fill="#EFEFEF"
          stroke="#5764ec"
          stroke-width="1"
          points="16,0 32,32 0,32"
        ></polygon>
      </svg>
      <div class="loader-text">Please Wait</div>
    </div>
    <!-- End Preloader Section -->
    <!-- Start Navbar Section -->
    <div class="navbar-area">
      <div class="techSoft-responsive-nav techSoft-fixed-nav">
        <div class="container">
          <div class="techSoft-responsive-menu">
            <div class="logo">
              <a href="index.html">
                <img src="assets/img/logo-black.png" alt="logo" />
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="techSoft-nav techSoft-fixed-nav">
        <div class="container">
          <nav class="navbar navbar-expand-md navbar-light">
            <a class="navbar-brand" href="index.html">
              <img src="assets/img/logo-black.png" alt="logo" />
            </a>
            <div
              class="collapse navbar-collapse mean-menu"
              id="navbarSupportedContent"
            >
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a href="index.html" class="nav-link"
                    >Home </i
                  ></a>
                  
                </li>
                <li class="nav-item">
                  <a href="about.html" class="nav-link">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="services.html" class="nav-link"
                    >Services </a>
                 
                </li>
                <li class="nav-item">
                  <a href="project.html" class="nav-link"
                    >Carrer </a>
                 
                </li>
                
                <li class="nav-item">
                  <a href="#" class="nav-link"
                    >Blog</a>
                 
                </li>
                <li class="nav-item">
                  <a href="contact.html" class="nav-link"
                    >Contact </a>
                </li>
                <li class="nav-item d-lg-none">
                    <button class="btn btn-primary open-signup">Signup</button>
                </li>
              </ul>
              <div class="option-item navber-search-box d-none d-lg-block">
                <i class="search-btn fa fa-search"></i>
                <i class="close-btn fa fa-times"></i>
                <div class="search-overlay search-popup">
                  <div class="search-box">
                    <form class="search-form">
                      <input
                        class="search-input"
                        name="search"
                        placeholder="Search"
                        type="text"
                      />
                      <button class="search-button" type="submit">
                        <i class="fa fa-search"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              <!--signup-->
              <div>
                <button class="btn btn-primary open-signup d-none d-lg-block">Signup</button>
                <div class="signup-popup-container" id="signup-popup-container">
                  <div class="signup-popup-card">
                    <div class="margin-right w-100">
                      <i class="close-signup fa fa-times"></i>
                    </div>
                    <div class="container">
                      <h2 class="text-center mb-3" style="color:hsl(19, 100%, 50%);">Sign up</h2>
                      <form id="loginForm"  style="display: flex;flex-direction: column;">
                        <label class="signup-label"><b>Email</b></label>  
                        <input type="text" id="email" name="email" placeholder="email" class="rounded p-2 signup-input-email-field mb-3" style="border-color:darkgray;" required>
                          <button type="submit" class="btn btn-primary rounded-3">submit</button>
                          <p id="message"></p>
                      </form>
                      <div class="d-none" id="otpForm">
                      <form id="otpVerificationForm" style="display: flex;flex-direction: column;">
    <label class="signup-label"><b>Email</b></label>  
    <input type="text" id="emailValue" name="emailValue" placeholder="email" class="rounded p-2 signup-input-email-field" style="border-color:darkgray;" disabled>
    <label><b>Enter OTP:</b></label>
    <p>TimeLeft: <span id="timeLeft"></span></p>
    <div class="otp-container">
        <input type="text" class="otp-input" name="otp1" id="otp1" maxlength="1" require>
        <input type="text" name="otp2" class="otp-input" id="otp2" maxlength="1" disabled require>
        <input type="text" name="otp3" class="otp-input" id="otp3" maxlength="1" disabled require>
        <input type="text" name="otp4" class="otp-input" id="otp4" maxlength="1" disabled>
        <input type="text" name="otp5" class="otp-input" id="otp5" maxlength="1" disabled>
        <input type="text" name="otp6" class="otp-input" id="otp6" maxlength="1" disabled>
    </div>


    <p>
    <button type="submit" class="btn btn-primary rounded-3">submit</button>
    <p id="otpResponse"></p>
</form>
<div style="text-align:right">
      <button class="text-primary" id="resendOtp">Resend OTP</button>
    </div>

                    </div>
                  </div>
                </div>
                
                  
                </div>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <!-- End Navbar Section -->
    <!-- Start Home Slider Section -->
    <div class="home-slider-area">
      <div
        class="home-slider flickity-dots-absolute"
        data-flickity='{ "bgLazyLoad": 1, "bgLazyLoad": true, "fade": false, "wrapAround": true, "prevNextButtons": true, "autoPlay": 7000, "pauseAutoPlayOnHover": false }'
      >
        <div
          class="home-slider-single-item"
          data-flickity-bg-lazyload="assets/img/slider-1.jpg"
        >
          <div class="container">
            <div class="row d-flex align-items-center">
              <div class="col">
                <div class="home-slider-content">
                  <h1 class="home-slider-title">
                    Find <span class="color-text">Accomodation</span> Near Your Exam City.
                  </h1>
                  <div class="home-slider-description">
                    <p>
                      We are providing best accomadation service to the student nearby exam center which reduces tension of the students during exam time.
                    </p>
                  </div>
                  <div class="home-slider-btn-box">
                    <a href="#0" class="btn btn-primary mr-15">Book now</a>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="home-slider-single-item"
          data-flickity-bg-lazyload="assets/img/slider-2.jpg"
        >
          <div class="container">
            <div class="row">
              <div class="col">
                <div class="home-slider-content">
                  <h1 class="home-slider-title">
                    We Provide Transport Services
                  </h1>
                  <div class="home-slider-description">
                    <p>
                      We are providing transport services at the cheaper price to the students travelling from one city to another city for their examination.
                    </p>
                  </div>
                  <div class="home-slider-btn-box">
                    
                    <a href="#0" class="btn btn-primary">Book Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="home-slider-single-item"
          data-flickity-bg-lazyload="assets/img/slider-3.jpg"
        >
          <div class="container">
            <div class="row">
              <div class="col">
                <div class="home-slider-content">
                  <h1 class="home-slider-title">
                    Transport with Accomadation
                  </h1>
                  <div class="home-slider-description">
                    <p>
                      We are providing transport and accomadation services to the students travelling from one city to another city for their examinations.
                    </p>
                  </div>
                  <div class="home-slider-btn-box">
                    
                    <a href="#0" class="btn btn-primary">Book Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Home Slider Section -->
    <!-- Start Services Section -->
    <section class="services-area-1 section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="section-title">
              <h6>What We Do</h6>
              <h2>Our Services</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="single-services-box-1 single-services-box-img-1">
              <div class="services-icon-12">
                <i class="devops icon"></i>
              </div>
              <h3>Accomadation Services</h3>
              <p>
                We partnered with a network of trusted hotels and accomadations to offer students during their exam days.
              </p>
              <div class="services-btn">
                <a href="single-services.html" class="services-btn-one"
                  >Read More</a
                >
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-services-box-1 single-services-box-img-2">
              <div class="services-icon-12">
                <i class="machineLearning icon"></i>
              </div>
              <h3>Transport Services</h3>
              <p>
                Our dedicated transport services ensures that the students reach their exam destination safely and on time.
				
              </p>
              <div class="services-btn">
                <a href="single-services.html" class="services-btn-one"
                  >Read More</a
                >
				
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-services-box-1 single-services-box-img-3">
              <div class="services-icon-12">
                <i class="microservice icon"></i>
              </div>
              <h3>Travel+Accomadation</h3>
              <p>
                Combine convenience ad cost effectiveness with ExamSafari's integrated transport and accomadation Packages.
              </p>
              <div class="services-btn">
                <a href="single-services.html" class="services-btn-one"
                  >Read More</a
                >
              </div>
            </div>
          </div>
          <!-- Service more button -->
          <div class="col-lg-12 col-md-12">
            <div class="services-more-btn-box text-center">
              <a class="btn btn-primary" href="#0">View All Services</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Services Section -->
    <!-- Start About Section -->
    <section class="about-area bg-grey section-padding">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-12">
            <div class="about-content">
              <h6>What we do ?</h6>
              <h2>
                We provide, accomadation,and Transport
                <span class="color-text">Services</span>
              </h2>
              <p>
                We offer affordable accommodation and transport services for students journeying between cities for exams. Say goodbye to logistical worries and focus on your studies. Our dedicated team ensures your comfort and safety, all at unbeatable prices. 
              </p>

              <div class="about-blockquote">
                <h3>
                  Trust ExamSafari to make your exam journey smooth and hassle-free. Travel confidently, study diligently, with ExamSafari by your side
                </h3>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="about-image">
              <img src="assets/img/about.jpg" alt="img" />
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End About Section -->
    <!-- Start Why Choose Us Section -->
    <section class="whychoose-area section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="section-title">
              <h6>Why ExamSafari</h6>
              <h2>Why Trust Us?</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="whychoose-single-item">
              <div class="whychoose-icon-box">
                <img src="assets/img/icon/icon-1.svg" alt="svg icon" />
              </div>
              <div class="whychoose-info">
                <h3>Reliable Accommodation</h3>
                <p>
                  ExamSafari ensures comfortable and secure lodging options at budget-friendly rates, allowing students to rest and recharge before exams.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="whychoose-single-item">
              <div class="whychoose-icon-box">
                <img src="assets/img/icon/icon-2.svg" alt="svg icon" />
              </div>
              <div class="whychoose-info">
                <h3>Safe Transport</h3>
                <p>
                  We prioritize safety, offering reliable transportation services to ensure students reach their exam destinations promptly and securely.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="whychoose-single-item">
              <div class="whychoose-icon-box">
                <img src="assets/img/icon/icon-3.svg" alt="svg icon" />
              </div>
              <div class="whychoose-info">
                <h3>Competitive Pricing</h3>
                <p>
                  With ExamSafari, students can access affordable travel solutions without compromising on quality, making exam preparations financially feasible.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="whychoose-single-item">
              <div class="whychoose-icon-box">
                <img src="assets/img/icon/icon-4.svg" alt="svg icon" />
              </div>
              <div class="whychoose-info">
                <h3>Dedicated Support</h3>
                <p>
                  Our attentive team provides round-the-clock assistance, addressing any concerns or inquiries promptly to ensure a smooth and stress-free exam journey.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="whychoose-single-item">
              <div class="whychoose-icon-box">
                <img src="assets/img/icon/icon-5.svg" alt="svg icon" />
              </div>
              <div class="whychoose-info">
                <h3>Quality Fooding</h3>
                <p>
                  ExamSafari goes beyond transportation and accommodation by offering nutritious and delicious meal options.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="whychoose-single-item">
              <div class="whychoose-icon-box">
                <img src="assets/img/icon/icon-6.svg" alt="svg icon" />
              </div>
              <div class="whychoose-info">
                <h3>Positive Feedback</h3>
                <p>
                  Countless satisfied students vouch for ExamSafari's exceptional services, showcasing our track record of reliability, affordability, and customer satisfaction. 
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Why Choose Us Section -->

	<section class="workprocess-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h6>3 Step Booking Process</h6>
                        <h2>Our Booking Process</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="workprocess-single-item">
                        <div class="workprocess-icon-box">
							<span class="workprocess-icon-number">1</span>
                        </div>
                        <div class="workprocess-info">
                            <h3>Select </h3>
                            <p>Select the interested service which you preferred during your exam and click over book now.</p>
                        </div>
						<div class="workprocess-number-bg"><span>1</span></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="workprocess-single-item">
                        <div class="workprocess-icon-box">
							<span class="workprocess-icon-number">2</span>
                        </div>
                        <div class="workprocess-info">
                            <h3>Book</h3>
                            <p>Fill the required details and click on book now button to book your preferred service</p>
                        </div>
						<div class="workprocess-number-bg"><span>2</span></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="workprocess-single-item">
                        <div class="workprocess-icon-box">
							<span class="workprocess-icon-number">3</span>
                        </div>
                        <div class="workprocess-info">
                            <h3>Payment</h3>
                            <p>Pay the required amount of service and get your accomadation ready during exam time.</p>
                        </div>
						<div class="workprocess-number-bg"><span>3</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End How It Works Section -->
	<!-- Start Project Section -->
	<section class="project-flip-area section-padding">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="section-title">
						<h6>Popular cities</h6>
						<h2>We are available in the cities</h2>
					</div>
				</div>
			</div>
			<div class="row">
				
				<div class="col-md-12">
					<div class="row project-flip-container">
						<!-- project-item -->
						<div class="col-lg-4 col-md-6 project-flip-grid all itsolution">
							<div class="project-flip-box">
								<div class="project-flip-content">
									<div class="project-flip-box-front text-center">
										<img src="assets/img/projects/projects-1.jpg" alt="project image">
										
									</div>
									  <div class="project-flip-box-back text-center">
										<img src="assets/img/projects/projects-3.jpg" alt="project image">
										<div class="inner">
										 
										  <button class="btn-primary flip-box-button">View Project</button>
										</div>
									  </div>
								</div>
							</div>
						</div>
						<!-- project-item -->
						<div class="col-lg-4 col-md-6 project-flip-grid all appsdevelopment">
							<div class="project-flip-box">
								<div class="project-flip-content">
									<div class="project-flip-box-front text-center">
										<img src="assets/img/projects/projects-2.jpg" alt="project image">
										<div class="inner">
										 
										</div>
									</div>
									  <div class="project-flip-box-back text-center">
										<img src="assets/img/projects/projects-5.jpg" alt="project image">
										<div class="inner">
										  
										  <button class="btn-primary flip-box-button">View Project</button>
										</div>
									  </div>
								</div>
							</div>
						</div>
						<!-- project-item -->
						<div class="col-lg-4 col-md-6 project-flip-grid all digitalsolution">
							<div class="project-flip-box">
								<div class="project-flip-content">
									<div class="project-flip-box-front text-center">
										<img src="assets/img/projects/projects-3.jpg" alt="project image">
										
									</div>
									  <div class="project-flip-box-back text-center">
										<img src="assets/img/projects/projects-3.jpg" alt="project image">
										<div class="inner">
										  
										  <button class="btn-primary flip-box-button">View Project</button>
										</div>
									  </div>
								</div>
							</div>
						</div>
						<!-- project-item -->
						<div class="col-lg-4 col-md-6 project-flip-grid all itsolution">
							<div class="project-flip-box">
								<div class="project-flip-content">
									<div class="project-flip-box-front text-center">
										<img src="assets/img/projects/projects-4.jpg" alt="project image">
										
									</div>
									  <div class="project-flip-box-back text-center">
										<img src="assets/img/projects/projects-3.jpg" alt="project image">
										<div class="inner">
										  
										  <button class="btn-primary flip-box-button">View Project</button>
										</div>
									  </div>
								</div>
							</div>
						</div>
						<!-- project-item -->
						<div class="col-lg-4 col-md-6 project-flip-grid all digitalsolution">
							<div class="project-flip-box">
								<div class="project-flip-content">
									<div class="project-flip-box-front text-center">
										<img src="assets/img/projects/projects-5.jpg" alt="project image">
										
									</div>
									  <div class="project-flip-box-back text-center">
										<img src="assets/img/projects/projects-1.jpg" alt="project image">
										<div class="inner">
										  
										  <button class="btn-primary flip-box-button">View Project</button>
										</div>
									  </div>
								</div>
							</div>
						</div>
						<!-- project-item -->
						<div class="col-lg-4 col-md-6 project-flip-grid all appsdevelopment">
							<div class="project-flip-box">
								<div class="project-flip-content">
									<div class="project-flip-box-front text-center">
										<img src="assets/img/projects/projects-6.jpg" alt="project image">
										
									</div>
									  <div class="project-flip-box-back text-center">
										<img src="assets/img/projects/projects-3.jpg" alt="project image">
										<div class="inner">
										 
										  <button class="btn-primary flip-box-button">View Project</button>
										</div>
									  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- project more button -->
				<div class="col-lg-12 col-md-12">
					<div class="project-flip-more-btn-box text-center">
						<a class="btn btn-primary" href="#0">View All Projects</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Project Section -->
	<!-- Start Counter Section -->
	<section class="counter-area2 section-padding">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 counter-item">
					<div class="single-counter2">
						<div class="counter-contents">
							<h2>
                                <span class="counter-number">6</span>
                                <span>+</span>
                            </h2>
							<h3 class="counter-heading"> Services </h3>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 counter-item">
					<div class="single-counter2">
						<div class="counter-contents">
							<h2>
                                <span class="counter-number">3</span>
                                <span>k+</span>
                            </h2>
							<h3 class="counter-heading">Users</h3>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 counter-item">
					<div class="single-counter2">
						<div class="counter-contents">
							<h2>
                                <span class="counter-number">250</span>
                                <span>+</span>
                            </h2>
							<h3 class="counter-heading">Partners</h3>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 counter-item">
					<div class="single-counter2">
						<div class="counter-contents">
							<h2>
                                <span class="counter-number">50</span>
                                <span>+</span>
                            </h2>
							<h3 class="counter-heading">Exams</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
 
    <!-- Start Testimonials Section -->
    <section class="testimonial-area pt-50 pb-100">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-title">
              <h6>Our Client Say</h6>
              <h2>Testimonials</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="testimonial-slide">
              <div class="owl-carousel owl-theme">
                <!-- testimonials item -->
                <div class="single-testimonial">
                  <div class="testimonial-content-inner">
                    <div class="testimonial-text">
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut laboredolore magna
                        aliqua
                      </p>
                      <div class="rating-box">
                        <ul>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                        <h6>Google</h6>
                      </div>
                    </div>
                    <div class="author-info-box">
                      <div class="author-img">
                        <img
                          src="assets/img/client/testimonial-1.jpg"
                          alt="testimonial"
                        />
                      </div>
                      <div class="author-bio-info">
                        <h3>Saabir al-Obeid</h3>
                        <span>Managing Director</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- testimonials item -->
                <div class="single-testimonial">
                  <div class="testimonial-content-inner">
                    <div class="testimonial-text">
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut laboredolore magna
                        aliqua
                      </p>
                      <div class="rating-box">
                        <ul>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                        <h6>Google</h6>
                      </div>
                    </div>
                    <div class="author-info-box">
                      <div class="author-img">
                        <img
                          src="assets/img/client/testimonial-2.jpg"
                          alt="testimonial"
                        />
                      </div>
                      <div class="author-bio-info">
                        <h3>Ruben Houston</h3>
                        <span>Service Manager</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- testimonials item -->
                <div class="single-testimonial">
                  <div class="testimonial-content-inner">
                    <div class="testimonial-text">
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut laboredolore magna
                        aliqua
                      </p>
                      <div class="rating-box">
                        <ul>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                        <h6>Google</h6>
                      </div>
                    </div>
                    <div class="author-info-box">
                      <div class="author-img">
                        <img
                          src="assets/img/client/testimonial-3.jpg"
                          alt="testimonial"
                        />
                      </div>
                      <div class="author-bio-info">
                        <h3>Rose Hopkins</h3>
                        <span>Account Manager</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- testimonials item -->
                <div class="single-testimonial">
                  <div class="testimonial-content-inner">
                    <div class="testimonial-text">
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut laboredolore magna
                        aliqua
                      </p>
                      <div class="rating-box">
                        <ul>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                        <h6>Google</h6>
                      </div>
                    </div>
                    <div class="author-info-box">
                      <div class="author-img">
                        <img
                          src="assets/img/client/testimonial-4.jpg"
                          alt="testimonial"
                        />
                      </div>
                      <div class="author-bio-info">
                        <h3>Monica Frazier</h3>
                        <span>Solutions Coordinator</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Testimonials Section -->
   
    <!-- Start Hire Section -->
    <section class="consultation-area section-padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2">
            <div class="consultation-content text-center">
              <h2>
                We’re here to help and answer any question you might have.
              </h2>
              <p>Free Consultation About Our IT Solutions For Your Business</p>
              <a href="tel:080707555321" class="btn btn-primary">
                Let’s Talk Now</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Hire Section -->
   <!-- Start Faq Section -->
	<section class="faq-area section-padding">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="section-title">
						<h6>Frequently Ask Question</h6>
						<h2>Have a Question?</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<div class="faq-accordion first-faq">
						<ul class="accordion">
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> What Does a Creative Agency Do?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> How Long Does Web Development Normally Take?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> Will You Increase My Website Speed?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> What Does a Website Designer Do?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="faq-accordion">
						<ul class="accordion">
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> Does a Better Website Make More Money?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> Are UX and UI an Important Part of Web Design?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> How Do You Help With Branding?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
							<li class="accordion-item">
								<a class="accordion-title" href="javascript:void(0)"> <i class="fa fa-caret-down"></i> What Does AI-powered Marketing Mean in Web Design?</a>
								<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa officia deserunt mollit anim id est laborum.</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Faq Section -->
    <!-- Start Footer Section -->
    <section class="footer-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 footer-box-item">
            <div class="footer-about footer-list">
              <a class="footer-logo" href="#">
                <img src="assets/img/logo.png" class="white-logo" alt="logo" />
              </a>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, nostrud consectetur
              </p>
              <ul class="footer-social-icon">
                <li>
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fab fa-linkedin"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fab fa-youtube"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 footer-box-item">
            <div class="footer-list">
              <h5 class="title">Company</h5>
              <ul class="footer-nav-links">
                <li><a href="about.html">About Us</a></li>
                <li><a href="projects.html">Latest Project</a></li>
                <li><a href="services.html">IT Solutions</a></li>
                <li><a href="services.html">Digital Solutions</a></li>
                <li><a href="team.html">Team Member</a></li>
                <li><a href="contact.html">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 footer-box-item">
            <div class="footer-list">
              <h5 class="title">Services</h5>
              <ul class="footer-nav-links">
                <li><a href="#">IT Strategy</a></li>
                <li><a href="#">Network Services</a></li>
                <li><a href="#">Software Audits</a></li>
                <li><a href="#">Business Intelligence</a></li>
                <li><a href="#">Data Science</a></li>
                <li><a href="#">Virtual Workstation</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 footer-box-item">
            <div class="footer-list">
              <h5 class="title">Contact Info</h5>
              <div class="footer-contact-info">
                <ul class="footer-contact-list">
                  <li>
                    <span>Address:</span> 526 Melrose Street, Water Mill, New
                    York.
                  </li>
                  <li>
                    <span>Phone:</span>
                    <a href="tel:080707555321">+080 707 555-321</a>
                  </li>
                  <li>
                    <span>Email:</span>
                    <a href="mailto:random@example.com"
                      >contact-info@example.com</a
                    >
                  </li>
                </ul>
                <div class="footer-info-newsletter">
                  <form class="newsletter-form">
                    <input
                      type="email"
                      class="input-newsletter"
                      placeholder="Enter your email"
                      name="EMAIL"
                      required=""
                      autocomplete="off"
                    />
                    <button class="btn btn-primary" type="submit">
                      Subscribe Now
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Footer Section -->
    <!-- Start Footer Copyright Section -->
    <div class="copyright-area">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-6">
            <p>
              © 2024 - All Rights Reserved - Designed by
              <span class="author-name">Cute Themes.</span>
            </p>
          </div>
          <div class="col-lg-6 col-md-6">
            <ul>
              <li><a href="terms-condition.html">Terms & Conditions</a></li>
              <li><a href="privacy-policy.html">Privacy Policy</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Footer Copyright Section -->
    <!-- Start Go Top Section -->
    <div class="go-top">
      <i class="fas fa-chevron-up"></i>
      <i class="fas fa-chevron-up"></i>
    </div>
    <!-- End Go Top Section -->
    <!-- jQuery Min JS -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Popper Min JS -->
    <script src="assets/js/popper.min.js"></script>
    <!-- Bootstrap Min JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- MeanMenu JS  -->
    <script src="assets/js/jquery.meanmenu.js"></script>
    <!-- Appear Min JS -->
    <script src="assets/js/jquery.appear.min.js"></script>
    <!-- Waypoints Min JS -->
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <!-- CounterUp Min JS -->
    <script src="assets/js/jquery.counterup.js"></script>
    <!-- Owl Carousel Min JS -->
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- Magnific Popup Min JS -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Isotope Min JS -->
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!-- Scroll To Fixed JS -->
    <script src="assets/js/jquery-scrolltofixed.js"></script>
    <!-- flickity JS -->
    <script src="assets/js/flickity.pkgd.min.js"></script>
    <script src="assets/js/bg-lazyload.js"></script>
    <script src="assets/js/flickity-fade.js"></script>
    <!-- WOW Min JS -->
    <script src="assets/js/wow.min.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>


    <script src="assets/js/login.js"></script>
  </body>
</html>
