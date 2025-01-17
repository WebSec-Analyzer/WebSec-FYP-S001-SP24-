<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Web Security Analyzer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


  <style>
    .body-bg {
      background: #000337;
    }

    .mainheading {
      font-weight: bold;
      color: white
    }

    .decscription {
      color: white
    }

    .btn_style {
      padding: 10px 20px;
      border-radius: 39px;
      color: white
    }

    .btn_primary_color {
      background: #6A6BB1;
    }

    .btn_primary_color:hover {
      background-color: #6A6BB1;
      color: white;
    }

    .btn_secondary_color {
      background: #74AFBB;
      /* 74AFBB */
    }

    .btn_secondary_color:hover {
      background: #74AFBB;
      color: white;
    }

    .card-style {
      background-color: #6A6BB1;
      margin-bottom: 10px;
    }

    .card-secondary {
      background-color: #74AFBB;
    }

    .card-primary {
      background-color: #6A6BB1;
    }
  </style>
</head>

<body class="body-bg">
  <header>
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand text-white" href="#">Web Security Analyzer</a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown" style="justify-content: end;">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="pricing.html">Pricing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="services.html">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/WebSA/login.html">Assesment</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="contact.html">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="login.html">Login/SignUp</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="container pt-5">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <h1 class="mainheading"> Secure Your Web Presence </h1>
        <p class="decscription">Comprehensive Web Security Analysis to Protect your Business from Cyber Threat.</p>
        <div>
          <button class="btn btn_style btn_primary_color"> Get Started </button>
          <button class="btn btn_style btn_secondary_color ms-3"> Learn More </button>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 text-center">
        <div>
          <img src="./assets/objectone.png" class="img-fluid" alt="object icon">
        </div>
      </div>
    </div>
  </section>
  <section class="container pt-5">
    <div class="row text-center">
      <div class="col-sm-12">
        <h5 style="color: white;"> Vulnerability Assessment </h5>
        <h1 class="mainheading"> Identify And Mitigate Vulnerabilities </h1> 
      </div>
      <div class="col-sm-12">
        <p style="max-width: 800px; margin: auto;" class="text-white">Our Comprehensive Vulnerability Assessment scans your Web applications, Infrastructure and Networks to identify and prioritize security risks.</p>
      </div>
    </div>
    <div class="mt-5">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="card card-style">
            <div class="card-body">
              <h2 class="text-white"> Automated Scanning </h2>
              <p class="text-white mb-0"> Our Advanced Scanning Tools continuously monitor your web assets for Vulnerabilities.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 text-center">
          <img src="./assets/object_other_18.png" class="img-fluid" style="width: 150px;" alt="other">
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="card card-style">
            <div class="card-body">
              <h2 class="text-white"> Detailed Reporting </h2>
              <p class="text-white mb-0"> Receive Comprehensive Reports with actionable recommendations to address identified Vulnerabilities.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 text-center">
          <img src="./assets/object_other_12.png" class="img-fluid" style="width: 150px;" alt="other">
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="card card-style">
            <div class="card-body">
              <h2 class="text-white"> Remidiation Guidance </h2>
              <p class="text-white mb-0"> Our Security Experts provide guidance on how to effectively mitigate and resolve security risks.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 text-center">
          <img src="./assets/object_other_17.png" class="img-fluid" style="width: 150px;" alt="other">
        </div>
      </div>
    </div>

  </section>
  <section class="container pt-5">
    <div class="row text-center">
      <div class="col-sm-12">
        <h5 style="color: white;">User Management </h5>
        <h1 class="mainheading">Empower Your Team With Secure Access </h1>
      </div>
      <div class="col-sm-12">
        <p style="max-width: 800px; margin: auto;" class="text-white">Manage User Access and permissions with our comprehensive user management tools, Ensuring your team can securely access the information they need to do their job effectively. </p>
      </div>
    </div>
    <div class="row my-4">
      <div class="col-sm-12">
        <h1 class="mainheading text-center"> Our Services </h1>
      </div>
      <div class="col-sm-12">
        <img src="./assets/logowsa.png" class="img-fluid" alt="banner">
      </div>
    </div>
  </section>
  <section class="container pt-5">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h1 class="mainheading"> Why Choose Web Security Analyzer? </h1>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card card-secondary my-3">
          <div class="card-body">
            <p class="text-white"> <span style="font-size: 22px;"> <b> Expertise: </b> </span> Our Team consists of certified security professionals with extensive experience in CyberSecurity. </p>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card card-primary my-3">
          <div class="card-body">
            <p class="text-white"> <span style="font-size: 22px;"> <b> Advanced Tools: </b> </span>We utilize cutting-edge tools and techniques to provide accurate and reliable security assessments. </p>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card card-secondary my-3">
          <div class="card-body">
            <p class="text-white"> <span style="font-size: 22px;"> <b> Customized Solutions: </b> </span> Our Services are tailored to meet the unique needs of your business, ensuring optimal protection. </p>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card card-primary my-3">
          <div class="card-body">
            <p class="text-white"> <span style="font-size: 22px;"> <b> Transparent Reporting: </b> </span> We believe in complete tranparency, providing you with detailed and easy-to-understand reports. </p>
          </div>
        </div>
      </div>
    </div>

  </section>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>