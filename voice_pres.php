<?php  
session_start();
require_once 'pdo.php';
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;
// require 'PHPMailer\PHPMailer\src\Exception.php';
// require 'PHPMailer\PHPMailer\src\PHPMailer.php';
// require 'PHPMailer\PHPMailer\src\SMTP.php';
$diagnosis_all="";
$prescription_all="";
// if (!isset($_SESSION['admin_id'])) {
//   die('Access denied');
// }
if (isset($_POST['submit'])) {
  for ($i=1; $i <100 ; $i++) { 
    if (isset($_POST['diagnosis'.$i])) {
      if ($i==1) {
        $diagnosis_all.=$_POST['diagnosis'.$i];
      }
      else{
        $diagnosis_all.="\n"."and"."\n".$_POST['diagnosis'.$i];
      }
      
      
    }
  }
  for ($i=1; $i <100 ; $i++) { 
    if (isset($_POST['prescription'.$i])) {
      if ($i==1) {
        $prescription_all.=$_POST['prescription'.$i];
      }
      else{
        $prescription_all.="\n"."and"."\n".$_POST['prescription'.$i];
      }
      
    }
  }
  $stmt=$pdo->prepare('INSERT INTO patients(patient_name,admin_id,email,symptoms,diagnosis,prescription,advice,age,gender) VALUES(:patient_name,:admin_id,:email,:symptoms,:diagnosis,:prescription,:advice,:age,:gender)');
  $stmt->execute(array(
    ':patient_name'=>$_POST['patient_name'],
    ':admin_id'=>$_SESSION['admin_id'],
    ':symptoms'=>$_POST['symptoms'],
    ':email'=>$_POST['email'],
    'diagnosis'=>$diagnosis_all,
    ':prescription'=>$prescription_all,
    ':advice'=>$_POST['advice'],
    ':age'=>$_POST['age'],
    ':gender'=>$_POST['gender']
  ));
  $patient_id=$pdo->lastInsertId();
  $stmt=$pdo->prepare('SELECT * FROM admins JOIN patients ON admins.admin_id=patients.admin_id WHERE patient_id=:patient_id');
  $stmt->execute(array(
    ':patient_id'=>$patient_id
  ));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);
  $html_code='<h1>Medical Prescription</h1>
  <h2>'.$row['hospital_name'].'</h2>'."   ".'<h2>Phone No:'.$row['phone_no'].'</h2>
  <h2>doctor\'s Name:'.$row['first_name'].'</h2>
  <p>Doctor\'s id:'.$row['doctor_id'].'</p>
  <h1>Patient\'s Information</h1>
  <p>Patient name:'.$row['patient_name'].'</p><p>Patient_id:'.$row['patient_id'].'</p>
  <p>Age:'.$row['age'].'</p><p>Gender:'.$row['gender'].'</p>
  <p>Patient\'s email:'.$_POST['email'].'</p>
  <p>Symptoms:'.$row['symptoms'].'</p>';
  for ($i=1; $i <100 ; $i++) { 
    if (isset($_POST['diagnosis'.$i])) {
      $html_code.='<p>Diagnosis'.$i.':<br>'.$_POST['diagnosis'.$i].'</p>';
    }
  }
  for ($i=1; $i <100 ; $i++) { 
    if (isset($_POST['prescription'.$i])) {
      $html_code.='<p>Prescription'.$i.':<br>'.$_POST['prescription'.$i].'</p>';
    }
  }
  $html_code.='<p>Advice:'.$row['advice'].'</p>
  <p><img src="signatures/'.$row['sign'].'" height="50px" width="170px" /><br><h2>Signature</h2></p>
  <p><img src="seals/'.$row['seal'].'" height="80px" style=" float:right;" width="95px" /></p>';
  include 'pdf.php';
  $pdf=new Pdf();
  $file_name=$_POST['patient_name'].'_'.$patient_id.'.pdf';
  $pdf->load_html($html_code);
  $pdf->render();
  $file=$pdf->output();
  file_put_contents($file_name, $file);

  $mail = new PHPMailer(true);
  try { 
    $mail->SMTPDebug = 2;                  
    $mail->isSMTP();                       
    $mail->Host  = 'smtp.gmail.com';          
    $mail->SMTPAuth = true;              
    $mail->Username = 'siva010928@gmail.com';        
    $mail->Password = 'taqwunzgjzzdrnpl';            
    $mail->SMTPSecure = 'tls';               
    $mail->Port  = 587; 
    $mail->setFrom('siva010928@gmail.com', 'Siva');    
    $mail->addAddress($_POST['email'], $_POST['patient_name']); 
    $mail->isHTML(true);                 
    $mail->Subject = 'Customer Details';      //Sets the Subject of the message
    $mail->Body = 'Patient\'s details:';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients'; 
    $mail->AddAttachment($file_name);             //Adds an attachment from a path on the filesystem
    $mail->send();
    echo '<script>alert("prescription has been sent to patient\'s email.");
    window.location.href="voice_pres.php";</script>';
  } catch (Exception $e) { 
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; 
  }

  
}
?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/voice.css">
    <title>Sprachscript  |   Dashboard</title>
  </head>
<body>
  <?php  
    if (isset($_SESSION['voice_pres_succ'])) {
      echo "<script>alert(".$_SESSION['voice_pres_succ'].");</script>";
      unset($_SESSION['voice_pres_succ']);
    }
    if (isset($_SESSION['update_succ'])) {
      echo "<script>alert('Profile successfully updated');</script>";
      unset($_SESSION['update_succ']);
    }
    ?>
  <header>
    <div class="row justify-content-center text-center">
      <div class="col-md-5">
        <h1 style="color:#1ebba3;font-weight: 700;text-transform:uppercase;">Sparchscript</h1>
        <p>Online voice based mobile E-prescription generator</p>
      </div>
    </div>
  </header>
  <div class="jumbotron jumbotron-container">
    <div class="col-12 text-center">
      <h3 class="heading">Dashboard</h3>
      <p>Please fill in the details below to generate the E-prescription</p>
      <button type="button" onclick="redirecttoresetpassword();return false;" style="float: left;" class="btn btn-link">Reset password</button>
            <button type="button" onclick="redirecttoindex();return false;" style="float: right;" class="btn btn-link">Log out</button>
      <div class="heading-underline"></div>
      
    </div>
  </div>
  <div style="background:linear-gradient(rgba(255,255,255,.5),rgba(255,255,255,.5)),url('new.jpg') no-repeat center center;" class="container">
    <form  id="form1" method="post">
      <div class="form-group">
      <label for="patient_name">Patient's name:</label>
      <div class="input-group">
       <input type="text" class="form-control" required placeholder="Enter Patient's name" id="patient_name" name="patient_name" aria-label="Recipient's username" aria-describedby="basic-addon2">
      <div class="input-group-append">
          <button onclick="vr('patient_name');return false;" class="btn btn-outline-secondary" type="button"><i  class="fa fa-microphone"></i></button>
      </div>
      </div>
    </div>
      <div class="form-group">
        <label for="age">Patient's Age:</label>
        <input type="number" class="form-control" min=1 max=200 name="age" placeholder="Enter patient's age">
      </div>
      <p style="text-transform: uppercase;font-weight:700">Gender:</p>
      <div class="form-check">
         <input class="form-check-input" type="radio" name="gender" required value="male" checked>
              <label class="form-check-label" for="gender">Male</label>
      </div>
      <div class="form-check">
           <input class="form-check-input" type="radio" name="gender"  value="female">
              <label class="form-check-label" for="gender">Female</label>
       </div>
       <div class="form-group">
       <label for="email">Patient's email :</label>
       <div class="input-group">
        <input type="email" class="form-control" required placeholder="Enter Patient's email" name="email" aria-label="Recipient's username" aria-describedby="basic-addon2">
       <div class="input-group-append">
           <button  class="btn btn-outline-secondary" type="button"><span style="font-weight:700;">@</span></button>
       </div>
       </div>
     </div>
     <p style="text-transform: uppercase;font-weight:700">Symptoms:</p>
     <div class="input-group">
       <textarea name="symptoms" id="symptoms" class="form-control custom-control" rows="3"></textarea>
       <span onclick="vr('symptoms');return false;" class="input-group-addon btn btn-outline-secondary"><i class="fa fa-microphone"></i></span>
      </div>
        <p style="font-weight:700;">DIAGNOSIS:<input type="button"  class="input-group-addon btn btn-outline-secondary" id="adddia" style="font-size:20px;margin:20px;" value="+"></p>


      <div id="dia_fields">

      </div>


      <div class="field">
        <p style="font-weight:700;">PRESCRIPTION:<input type="button" class="input-group-addon btn btn-outline-secondary" id="addpres" style="font-size:20px;margin:20px;" value="+"></p>
      </div>


      <div id="pres_fields">

      </div>


      <p style="text-transform: uppercase;font-weight:700">advice:</p>
      <div class="input-group">
        <textarea name="advice" required id="advice" class="form-control custom-control" rows="3"></textarea>
        <span onclick="vr('advice');return false;" class="input-group-addon btn btn-outline-secondary"><i class="fa fa-microphone"></i></span>
       </div>
       <div class="clearfix">
            <button class="btn btn-success" type="submit" style="float: left; margin-top: 2em;" name="submit" form="form1"> Generate Pdf</button>
            <button type="button" onclick="redirecttothis();return false;" style="float: right; margin-top: 2em;" class="btn btn-info">Next script</button>
        </div>
        <div class="clearfix">
          <button type="button" onclick="redirecttodelete();return false;" style="float: right;color: green" class="btn btn-link">Delete account</button>
    <button type="button" onclick="redirecttoupdate();return false;" style="float: left;color: green;" class="btn btn-link">Update Profile</button>
        </div>



    </form>

  </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>

  <script type="text/javascript">

    function redirecttoindex() {
      window.location.href="logout.php";
    }
    function redirecttothis() {
      window.location.href="voice_pres.php";
    }
    function redirecttoresetpassword() {
      window.location.href="reset.php";
    }
     function redirecttodelete() {
      window.location.href="delete.php";
    }
    function redirecttoupdate() {
      window.location.href="edit.php";
    }
    countdia=0;
    $(document).ready(function(){
      $('#adddia').click(function(event){
        event.preventDefault();
        countdia++;
        $('#dia_fields').append('<div id="dia'+countdia+'">\
          <p style="text-transform: uppercase;font-weight:700" >Diagnosis'+countdia+':<div class="input-group"><textarea class="form-control custom-control" rows="3" required id="diagnosis'+countdia+'" name="diagnosis'+countdia+'"></textarea><input class="input-group-addon btn btn-outline-secondary" type="button" style="font-size:20px;margin:20px;" value="-" onclick="$(\'#dia'+countdia+'\').remove(); countdia--; return false;"></p> <span onclick="vr(\'diagnosis'+countdia+'\');return false;" \
          class="input-group-addon btn btn-outline-secondary"><i class="fa fa-microphone"></i></span></div>');

      });
      });


    


    countpres=0;
    $(document).ready(function(){
      $('#addpres').click(function(event){
        event.preventDefault();
        countpres++;
        $('#pres_fields').append('<div id="pres'+countpres+'">\
          <p style="text-transform: uppercase;font-weight:700" >Prescription'+countpres+':<div class="input-group"><textarea class="form-control custom-control" rows="3" required id="prescription'+countpres+'" name="prescription'+countpres+'"></textarea><input class="input-group-addon btn btn-outline-secondary" type="button" style="font-size:20px;margin:20px;" value="-" onclick="$(\'#pres'+countpres+'\').remove(); countdia--; return false;"></p> <span onclick="vr(\'prescription'+countpres+'\');return false;" \
          class="input-group-addon btn btn-outline-secondary"><i class="fa fa-microphone"></i></span></div>');

      });
      });

  </script>

  <script>
      function vr(a) {
        if (window.hasOwnProperty('webkitSpeechRecognition')) {
          var recognition = new webkitSpeechRecognition();
          recognition.continuous = false;
          recognition.interimResults = false;
          recognition.lang = "en-US";
          recognition.start();

        recognition.onresult = function(e) {
            document.getElementById(a).value= e.results[0][0].transcript;
            console.log(e.results[0][0].transcript);
            console.log(e);
            recognition.stop();
            };

          recognition.onerror = function(e) {
            recognition.stop();
            }

        }
        else{
            alert("your browser does not support voice recognition.")
        }
      }
</script>
</body>
</html>
</body>
</html>