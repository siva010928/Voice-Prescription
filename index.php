<?php  
require_once 'pdo.php';
session_start();
unset($_SESSION['admin_id']);
if (isset($_SESSION['verf_succ'])) {
      echo "<script>alert('Account Successfully created');</script>";
      unset($_SESSION['verf_succ']);
    }
if (isset($_SESSION['forgotpass_succ'])) {
      echo "<script>alert('Password successfully reset');</script>";
      unset($_SESSION['forgotpass_succ']);
  }
if (isset($_SESSION['forgotpass_succ_mail'])) {
      echo "<script>alert('Successfully Deleted');</script>";
      unset($_SESSION['forgotpass_succ_mail']);
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Sprachscript  |   Home</title>
  </head>
  <body data-spy="scroll"  data-target="#navbarSupportedContent">
    <div id="home">

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
           <a class="navbar-brand" href="#">Sparchscript</a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav ml-auto">
                   <li class="nav-item">
                       <a class="nav-link" href="#home"><i class="fas fa-home home"></i>Home <span class="sr-only">(current)</span></a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="#about"><i class="fas fa-align-left about"></i>About</a>
                   </li>
                   <li class="nav-item">
                      <a class="nav-link" href="#team"><i class="fas fa-users team"></i>Team</a>
                   </li>
                   <li class="nav-item">
                      <a class="nav-link" href="#contact"><i class="fas fa-headset contact"></i>Contact</a>
                   </li>
              </ul>
           </div>

      </nav>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img  src="hq12.jpg" alt="First slide">
      <div class="carousel-caption text-center">
        <h1>Welcome to Sprachscript</h1>
        <h3>Voice-based mobile prescription</h3>
        <a class="btn btn-outline-light btn-lg" href="#start">Get Started</a>
      </div>
    </div>
    <div class="carousel-item">
      <img  src="hq11.jpg" alt="Second slide">
      <div class="carousel-caption text-center">
        <h2>Say Goodbye to all incomprehensible prescriptions</h2>
        <a class="btn btn-outline-warning btn-lg" href="#features">features</a>
      </div>
    </div>
    <div class="carousel-item">
      <img  src="hq13.jpg" alt="Third slide">
      <div class="carousel-caption text-center">
        <p>get intelligible e-prescription<p>
        <p>with</p>
        <p style="font-weight:700;color:#800000">Sparchscript</p>
      </div>
    </div>
    </div>
  </div>
</div>

<div id="start">
  <div class="jumbotron jumbotron-container">
    <div class="text-center">
      <h3 class="heading">get started</h3>
      <div class="heading-underline"></div>
    </div>
  </div>
  <div class="jumbotron jumbotron-fluid" style="background: linear-gradient(rgba(255,255,255,.5),rgba(255,255,255,.5)),url('hq14.jpg') no-repeat center center;">
    <div class="container">
      <a class="btn btn-success btn-lg" href="signup.php">Sign up</a>
      <p id="high">or</p>
      <p>Already a user?</p>
      <a class="btn btn-success btn-lg" href="login.php">Log in</a>
    </div>
  </div>
  </div>

<div id="about">
  <div class="about-section">
          <div class="inner-container">
              <h1>About</h1>
              <p class="text">
                  Adverse drug effects are a major cause of death in the world bacause of medication or prescription errors. Such errors occur due to indecipherable handwritings,drug interactions,confusing drug names etc.
                  Therferore,we, a six-student-team of <strong>first year-Computer Science department,Kumaraguru College Of Technology,Coimbatore</strong> have developed a voice-based mobile prescription software which could eliminate some of these errors because they allow
                  prescription information to be captured through voice response rather than in the physician's handwriting and then generate a E-prescription.
              </p>

          </div>
      </div>
</div>
<div id="features">
<div class="services-section">
    <div class="inner-width">
      <h1 class="section-title">Features</h1>
      <div class="border"></div>
      <div class="services-container">

        <div class="service-box">
          <div class="service-icon">
            <i class="far fa-registered"></i>
          </div>
          <div class="service-title">Registration</div>
          <div class="service-desc">
            Transparent and Advanced Login and Sign-up Options for Doctors.
          </div>
        </div>

        <div class="service-box">
          <div class="service-icon">
            <i class="fa fa-microphone"></i>
          </div>
          <div class="service-title">Vocal</div>
          <div class="service-desc">
            Dictate prescription to the patient while talking to phone or PC running windows through microphone.
          </div>
        </div>

        <div class="service-box">
          <div class="service-icon">
            <i class="fab fa-wpforms"></i>
          </div>
          <div class="service-title">Realistic</div>
          <div class="service-desc">
            Get realistic E-prescription on your mobile with many unique and customized features.
          </div>
        </div>

        <div class="service-box">
          <div class="service-icon">
            <i class="fas fa-edit"></i>
          </div>
          <div class="service-title">Editable</div>
          <div class="service-desc">
            Easily edit/delete by hand any entry that has been made before generating.
          </div>
        </div>

        <div class="service-box">
          <div class="service-icon">
            <i class="far fa-file-pdf"></i>
          </div>
          <div class="service-title">PDF</div>
          <div class="service-desc">
            Generate your E-prescription in a Portable Document Format(PDF) enabling you with easy accessiblity and extensibility.
          </div>
        </div>

        <div class="service-box">
          <div class="service-icon">
            <i class="fas fa-envelope-open-text"></i>
          </div>
          <div class="service-title">Mail</div>
          <div class="service-desc">
            Sit back and easily send/receive the E-prescription directly through your mail
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="team">
  <div class="jumbotron jumbotron-container">
    <div class="col-12 text-center">
      <h3 class="heading">Meet the team</h3>
      <div class="heading-underline"></div>
    </div>
  </div>

<div class="row padding">
   <div class="col-md-6">
     <div class="card text-center">
       <img class="card-img-top" src="hq6.jpg">
       <div class="card-body">
         <h4>Siva Prakash K</h4>
       </div>
     </div>
   </div>
   <div class="col-md-6">
     <div class="card text-center">
       <img class="card-img-top" src="hq7.jpg">
       <div class="card-body">
         <h4>Prasanth P</h4>
       </div>
     </div>
   </div>
</div><!--End of row 1-->

<div class="row padding">
   <div class="col-md-6">
     <div class="card text-center">
       <img class="card-img-top" src="hq8.jpg">
       <div class="card-body">
         <h4>Bharath Sankar M</h4>
       </div>
     </div>
   </div>
   <div class="col-md-6">
     <div class="card text-center">
       <img class="card-img-top" src="hq9.jpg">
       <div class="card-body">
         <h4>Pranav R R</h4>
       </div>
     </div>
   </div>
</div><!--End of row 2-->

<div class="row padding">
   <div class="col-md-6">
     <div class="card text-center">
       <img class="card-img-top" src="tech.jpg">
       <div class="card-body">
         <h4>Kamalesh E</h4>
       </div>
     </div>
   </div>
   <div class="col-md-6">
     <div class="card text-center">
       <img class="card-img-top" src="hq5.1.jpg">
       <div class="card-body">
         <h4>Maharajan M</h4>
       </div>
     </div>
   </div>
</div><!--End of row 3-->
</div><!--End of team-->

<div id="contact">
  <div class="jumbotron jumbotron-container">
    <div class="col-12 text-center">
      <h3 class="heading">Contact Us</h3>
      <div class="heading-underline"></div>
    </div>
  </div>
  <div id="contacts">
  <div class="contact-info">
        <div class="card">
            <i class="icon fas fa-envelope"></i>
            <div class="card-content">
                <h3>Email</h3>
                <span>pranav.19cs@kct.ac.in</span>
            </div>
        </div>

        <div class="card">
            <i class="icon fas fa-phone"></i>
            <div class="card-content">
                <h3>Phone</h3>
                <span>+919344015965</span>
            </div>
        </div>

        <div class="card">
            <i class="icon fas fa-map-marker-alt"></i>
            <div class="card-content">
                <h3>Location</h3>
                <span>Coimbatore</span>
            </div>
        </div>
    </div>

</div>
</div>
<footer>
  <div class="row justify-content-center text-center">
    <div class="col-md-5">
      <h1 style="color:#1ebba3;font-weight: 700;">Sparchscript</h1>
      <p>No more confusion in prescriptions due to drug-interactions and undeciphered handwriting.Now easily generate and send E-presciption to the patients in an accessible PDF format</p>


    </div>

  </div>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
