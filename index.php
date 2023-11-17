<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<?php
include ("classes/conn.php");
include ("classes/signup.php");
include ("classes/login.php");
include ("classes/user.php");
include ("classes/settings.php");

session_start();
if(isset($_COOKIE['alnajat_userid']) && is_numeric($_COOKIE['alnajat_userid']))
{
    $id = $_COOKIE['alnajat_userid'];
    $login = new Login();
    $result = $login->check_login($id);

    if($result)
    {
        $user = new User();
        $user_data = $user->get_data($id);
        $loggedin = 1;
        if(!$user_data)
        {
          $loggedin = 0;
        }
    }else
    {
      $loggedin = 0;
    }
}else
{
  $loggedin = 0;
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['submit2'])){
  $signup = new Signup();
  $result = $signup->evaluate($_POST);
  $username = "";
  $password = "";
  if($result != ""){
                         echo "
            <!-- Modal -->
            <div class='modal fade' id='exampleModalerror2' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='exampleModalLabel'>عذرا</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <br>
                    <center><img src='error.png' width='100px'></center>
                    <br>
                    <center>$result</center>
                </div>
                <div class='modal-footer'>
                    <button class='btn btn-primary' data-bs-dismiss='modal' style='width: 100%;'>Ok</button>
                </div>
            </div>
            </div>
            </div>";
            echo "<script>
            const myModalerror2 = new bootstrap.Modal('#exampleModalerror2');

            window.addEventListener('DOMContentLoaded', () => {
            
                myModalerror2.show();
            });
            </script>";
  }else
  {
      header("Location: index.php");
      die;
  }
  $username = $_POST['username_signup'];
  $password = $_POST['password_signup'];
 }
 if(isset($_POST['password']))
    {
        $setting_class = new Settings();
        $setting_class->save_settings($_POST,  $_COOKIE['alnajat_userid']);
        header("Location: index.php");
        die;
    }
  if(isset($_POST['submit1'])){
    $login = new Login();
    $result2 = $login->evaluate_login($_POST);
    if($result2 != ""){
                     echo "
            <!-- Modal -->
            <div class='modal fade' id='exampleModalerror' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='exampleModalLabel'>عذرا</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <br>
                    <center><img src='error.png' width='100px'></center>
                    <br>
                    <center>$result2</center>
                </div>
                <div class='modal-footer'>
                    <button class='btn btn-primary' data-bs-dismiss='modal' style='width: 100%;'>Ok</button>
                </div>
            </div>
            </div>
            </div>";
            echo "<script>
            const myModalerror = new bootstrap.Modal('#exampleModalerror');

            window.addEventListener('DOMContentLoaded', () => {
            
                myModalerror.show();
            });
            </script>";
    }else
    {
        header("Location: index.php");
        die;
    }
    $id = $_COOKIE['alnajat_userid'];
    $username_login = $_POST['username_login'];
    $password_login = $_POST['password_login'];
  }
}
$user = new User();
if($loggedin == 1){
  $_SESSION['alnajat_userid'] = $_COOKIE['alnajat_userid'];
  $id = $_SESSION['alnajat_userid'];
  $teachers = $user->get_teacher($user_data['userid']);
  if($user_data['type'] == "teacher"){
    $requests = $user->get_requests($user_data['userid']);
  }
}
$ranks = $user->get_students();
?>
<!DOCTYPE html>
<html lang="ar" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//code.tidio.co/apkhxarir9cu6v0hi4ydwxfcmpgj3wzd.js" async></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.min.js"
      integrity="sha512-jq8sZI0I9Og0nnZ+CfJRnUzNSDKxr/5Bvha5bn7AHzTnRyxUfpUArMzfH++mwE/hb2efOo1gCAgI+1RMzf8F7g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>AL najat study</title>
    <style>
       body {
              background-image: linear-gradient(910deg, #232845 0%, #12100e 74%);
              height: auto;
              transition: background-color 0.3s;
       }
       .button {
        background-color: #ffffff00;
        color: #fff;
        width: 10em;
        height: 2.9em;
        border: #3654ff 0.2em solid;
        border-radius: 11px;
        text-align: right;
        transition: all 0.6s ease;
        margin-left: 20px;
      }
        body.white-mode {
            background-color: white;
        }
      .button:hover {
        background-color: #3654ff;
        cursor: pointer;
      }

      .button svg {
        width: 1.6em;
        position: absolute;
        display: flex;
        transition: all 0.6s ease;
        fill: white;
      }

      .button:hover svg {
        transform: translateX(5px);
      }

      .text {
        margin: 0 1.5em
      }
      .profile_picture
      {
        border-radius: 50%;
        width: 150px;
        height: 150px;
      }
      a
      {
          text-decoration: none;
      }
        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
      h1
      {
            text-shadow:
      0 0 7px #fff
        }
          #row1
      {
          width: 50%;
      }
      #row2
      {
          width: 50%;
      }
      #row3
      {
          width: 50%;
      }
     #row3
      {
          width: 50%;
      }
      #row4
      {
          width: 50%;
      }
      #row5
      {
          width: 50%;
      }
      @media only screen and (max-width: 768px) {
      #header_img
      {
          display: none;
      }
      #row1
      {
          width: 100%;
      }
      #row2
      {
          width: 100%;
      }
      #row3
      {
          width: 100%;
      }
      #row4
      {
          width: 100%;
      }
      #row5
      {
          width: 90%;
      }
      }
      .btn-primary
      {
          background-image: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
      }
              .spinner-container {
            position: relative;
        }

        .spinner-container {
            position: fixed;
             background-image: linear-gradient(910deg, #232845 0%, #12100e 74%);
            z-index: 100;
            display: grid;
            place-items: center;
            height: 100%;
            width: 100%;
            position: fixed;
        }

        .spinner {
            width: 84px;
            height: 84px;
            top: 70%;
            animation: spinner-y0fdc1 2s infinite ease;
            transform-style: preserve-3d;
        }

        .spinner>.loading {
            background-color: rgba(0, 77, 255, 0.2);
            height: 100%;
            position: absolute;
            width: 100%;
            border: 2px solid #004dff;
        }

        .spinner .loading:nth-of-type(1) {
            transform: translateZ(-22px) rotateY(180deg);
        }

        .spinner .loading:nth-of-type(2) {
            transform: rotateY(-270deg) translateX(50%);
            transform-origin: top right;
        }

        .spinner .loading:nth-of-type(3) {
            transform: rotateY(270deg) translateX(-50%);
            transform-origin: center left;
        }

        .spinner .loading:nth-of-type(4) {
            transform: rotateX(90deg) translateY(-50%);
            transform-origin: top center;
        }

        .spinner .loading:nth-of-type(5) {
            transform: rotateX(-90deg) translateY(50%);
            transform-origin: bottom center;
        }

        .spinner .loading:nth-of-type(6) {
            transform: translateZ(22px);
        }

        @keyframes spinner-y0fdc1 {
            0% {
                transform: rotate(45deg) rotateX(-25deg) rotateY(25deg);
            }

            50% {
                transform: rotate(45deg) rotateX(-385deg) rotateY(25deg);
            }

            100% {
                transform: rotate(45deg) rotateX(-385deg) rotateY(385deg);
            }
        }
        /* The switch - the box around the slider */
.switch {
  font-size: 17px;
  position: relative;
  display: inline-block;
  width: 3.5em;
  height: 2em;
}
/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  --background: #28096b;
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: var(--background);
  transition: .5s;
  border-radius: 30px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 1.4em;
  width: 1.4em;
  border-radius: 50%;
  left: 10%;
  bottom: 15%;
  box-shadow: inset 8px -4px 0px 0px #fff000;
  background: var(--background);
  transition: .5s;
}

input:checked + .slider {
  background-color: #522ba7;
}

input:checked + .slider:before {
  transform: translateX(100%);
  box-shadow: inset 15px -4px 0px 15px #fff000;
}
.card2 {
  position: relative;
  width: 100%;
  height: 254px;
  background-color: #111;
  color: #fff;
  display: flex;
  flex-direction: column;
  justify-content: end;
  padding: 12px;
  gap: 12px;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 30px;
}

.card2::before {
  content: '';
  position: absolute;
  inset: 0;
  left: -5px;
  margin: auto;
  width: 100%;
  height: 264px;
  margin-left: 3px;
  border-radius: 10px;
  background: linear-gradient(-45deg, #e81cff 0%, #40c9ff 100% );
  z-index: -10;
  pointer-events: none;
  transition: all 0.5s ease-out;
}

.card2::after {
  content: "";
  z-index: -1;
  position: absolute;
  inset: 0;
  background: linear-gradient(-45deg, #fc00ff 0%, #00dbde 100% );
  transform: translate3d(0, 0, 0) scale(0.95);
  filter: blur(20px);
}

.card2 h2 {
  font-size: 30px;
  text-transform: capitalize;
  font-weight: 700;
}
.card2 h3 {
  font-size: 30px;
  font-weight: 200;
}
.card2 p:not(.heading) {
  font-size: 14px;
}

.card2 p:last-child {
  color: #e81cff;
  font-weight: 600;
}

.card2:hover::after {
  filter: blur(30px);
}

.card2:hover::before {
  transform: scaleX(0.97) scaleY(1.14);
}
.card3 {
  width: 100%;
  height: 244px;
  border-radius: 20px;
  padding: 5px;
  box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
  background-image: linear-gradient(144deg,#AF40FF, #5B42F3 50%,#00DDEB);
}

.card__content3 {
  background: rgb(5, 6, 45);
  border-radius: 17px;
  color: white;
  width: 100%;
  height: 100%;
}
.bg-transparent
{
    backdrop-filter: blur(200px);
}
    </style>
</head>
<body>
        <div class="spinner-container">
        <div class="spinner">
            <div class="loading"></div>
            <div class="loading"></div>
            <div class="loading"></div>
            <div class="loading"></div>
            <div class="loading"></div>
            <div class="loading"></div>
        </div>
    </div>
<nav class="navbar fixed-top navbar-expand-lg bg-transparent">
<div class="container-fluid">
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">الصفحة الرئيسة</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTopteam" aria-controls="offcanvasTop">فريق العمل</a>
        </li>
        <li class="nav-item" style="margin-top: -10px; margin-left: 20px;">
          <label class="switch">
            <input type="checkbox" id="darkModeSwitch" checked>
            <span class="slider"></span>
          </label>
        </li>
        <?php if($loggedin == 0){ ?>
        <li class="nav-item">
        <button class="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <svg viewBox="0 0 512 512"><path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>
        <div class="text">
          تسجيل دخول
        </div>
        </button>
        </li>
        <?php } ?>
        <?php if($loggedin != 0){ ?>
        <div class="dropdown" style="margin-left: 30px;">
        <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#profile" aria-controls="offcanvasRight"><svg id="prof" height="2em" fill="white" viewBox="0 0 512 512"><path d="M406.5 399.6C387.4 352.9 341.5 320 288 320H224c-53.5 0-99.4 32.9-118.5 79.6C69.9 362.2 48 311.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208c0 55.7-21.9 106.2-57.5 143.6zm-40.1 32.7C334.4 452.4 296.6 464 256 464s-78.4-11.6-110.5-31.7c7.3-36.7 39.7-64.3 78.5-64.3h64c38.8 0 71.2 27.6 78.5 64.3zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-272a40 40 0 1 1 0-80 40 40 0 1 1 0 80zm-88-40a88 88 0 1 0 176 0 88 88 0 1 0 -176 0z"/></svg></a>
      </div>
        <li class="nav-item">
          <a class="nav-link"><?php echo htmlspecialchars($user_data['username']); ?></a>
        </li>
        <?php } ?>
      </ul>
    </div>
    </div>
    <a class="navbar-brand" href="#"><img src="najat.png" width="170px" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<br>
<br></br>
<div id="header_alnajat" style="display: flex; justify-content: center;">
<?php if($loggedin == 0){ ?>
  <h1 style="margin-top: 150px; text-align: center; font-size: 40px;">أدرس بذكاء مع النجاة</h1>
<?php }else{ ?>
  <h1 style="margin-top: 150px; text-align: center; font-size: 40px;">مرحبا <?php echo htmlspecialchars($user_data['name']) ?></h1>
  <?php } ?>
<center><img id="header_img" src="header.png" width="340px" alt=""></center>
</div>
<br>
<p style="text-align: center;">أدرس...  أطلب معلم...  أختبر نفسك</p>
<br><br>
<center><div class="row justify-content-center" id="row1">
    <div class="col" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTopvideos" aria-controls="offcanvasTop">
    <div class="card3" style="width: 100%;">
    <div class="card__content3">
    <br>
    <center><img src="videos.png" width="100px" alt=""></center>
    <br>
    <center><h3>فيديوهات تعليمية</h3></center>
    </div>
    </div>
    </div>
    <div class="col" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop2" aria-controls="offcanvasTop">
    <div class="card3" style="width: 100%;">
    <div class="card__content3">
    <br>
    <center><img src="books.png" width="90px" alt=""></center>
    <br><br>
    <center><h3>الكتب المدرسية</h3></center>
    </div>
    </div>
    </div>
</div></center>
    <br></br>
<div class="text-center">

  <center><div class="row justify-content-center" id="row2">
<div class="col md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop2" aria-controls="offcanvasTop">

    <div class="card3" style="width: 100%;">
    <div class="card__content3">
    <br>
    <img src="file.png" width="90px" alt="">
    <br><br>
    <center><h3>مذكرات</h3></center>
    </div>
    </div>
  </div>
  <?php if($loggedin == 1){ ?>
  <?php if($user_data['type'] == "student"){ ?>
<div class="col md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop11" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="teacher.png" width="90px" alt="">
    <br><br>
    <center><h3>طلب معلم</h3></center>
    </div>
    </div>
<?php } ?>
<?php } ?>
  <?php if($loggedin == 0){ ?>
<div class="col md-6" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal90">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="teacher.png" width="90px" alt="">
    <br><br>
    <center><h3>طلب معلم</h3></center>
    </div>
    </div>
  </div>
</div>
<?php }
if($loggedin == 1){?>
<?php if($user_data['type'] == "teacher"){ ?>
  <div class="col md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop50">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="teacher.png" width="90px" alt="">
    <br><br>
    <center><h3>الطلبات</h3></center>
    </div>
    </div>
  </div>
</div>
<?php } ?>
<?php } ?>
<br></br>
</div>
</div>
<center><h1>للمذاكرة</h1></center
<br><br>
<center><div class="row justify-content-center" id="row3">
  <div class="col md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="file.png" width="90px" alt="">
    <br><br>
    <center><h3>نماذج اختبارات</h3></center>
    </div>
    </div>
  </div>
    <div class="col" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasToplab" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="computer.png" width="90px" alt="">
    <br><br>
    <center><h3>مشاريع تدريبية للحاسوب</h3></center>
    </div>
    </div>
  </div>
  </div>
</center>
<br>
<center><h1>اخرى</h1></center>
<br>
<center>
<div class="row justify-content-center" id="row4">
<div class="col" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTopranks" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="ranks.png" width="120px" alt="">
    <br><br>
    <center><h3>ترتيب الطلاب</h3></center>
    </div>
    </div>
  </div>
  <div class="col" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTopteam" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="team.png" width="120px" alt="">
    <br><br>
    <center><h3>فريق العمل</h3></center>
    </div>
    </div>
  </div>
  </div>
</div>
</div>
<br></br>
<center><div class="row justify-content-center" id="row4">
    <div class="col" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#palesine" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <img src="palestine.png" width="120px" alt="">
    <br><br>
    <center><h3>دعم فلسطين</h3></center>
    </div>
    </div>
    </div>
    <div class="col" style="cursor: pointer;" >
    <div class="card3">
    <div class="card__content3">
    <br><br>
    <img src="quiz.png" width="90px" alt="">
    <br><br>
    <center><h3>اختبارات الكترونية</h3></center>
    </div>
    </div>
    </div>
</center>
<!-- كتب مدرسية !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop2" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">كتب مدرسية</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%">
        <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop300" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">6</h1></center>
  <h3>
   <center>الصف السادس</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
</div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop200" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">7</h1></center>
  <h3>
   <center>الصف السابع</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop100" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">8</h1></center>
  <h3>
   <center>الصف الثامن</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop10" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">9</h1></center>
  <h3>
   <center>الصف التاسع</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
  </div>
</div>
  </div>
</div>
<!-- فيديوهات تعليمية !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTopvideos" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">فيديوهات تعليمية</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop300" aria-controls="offcanvasTop">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">

      <center><h1 style="font-size: 100px;">6</h1></center>

        <center><h5 class="card-title">الصف السادس</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop200" aria-controls="offcanvasTop">
    <div class="card">
      <div class="card-body">
      <center><h1 style="font-size: 100px;">7</h1></center>
        <center><h5 class="card-title">الصف السابع</h5></center>
        <br>
      </div> 
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop100" aria-controls="offcanvasTop">
    <div class="card">
      <div class="card-body">
      <center><h1 style="font-size: 100px;">8</h1></center>
       <center><h5 class="card-title">الصف الثامن</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop9videos" aria-controls="offcanvasTop">
    <div class="card">
      <div class="card-body">
      <center><h1 style="font-size: 100px;">9</h1></center>
        <center><h5 class="card-title">الصف التاسع</h5></center>
        <br>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
<!--الصف التاسع!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop10" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف التاسع</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1d7zYkNgRrivj_Numx7I67dOnRfmuLlL3/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1mcCraOO7GeiWzzDPbKQFWfFe8EvK_58L/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1cCY-ouh7lV4nOgRvzgQLMqiSnWrf4nN1/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1rOpsMAoqbrqrNYeG2R2IkoUrzseF4sYa/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1P_WCNnvrbLQmNDkXri8iu2thhNhpxHu0/view?usp=sharing"><div class="card">
      <div class="card-body">
     <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1AAOhSpkHDA2zJ6zrneQmwPn9ZwSXBG57/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1dRieln5XNgJkX2afWbHiNrY_WqLi9cHA/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1_0I835ueaPKnA9mQsD15GUGDHgW1R5p3/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1bVJ72ECxCgn4KLAoXJWmAH0eIpBwk3is/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1RlGnXM_fdeVd1PU_LOF5FHkB8v_IJ11-/view?usp=sharing"><div class="card">
      <div class="card-body">
     <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
  </div></a>
</div>
  </div>
</div>
</div>
<!--الصف الثامن!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop100" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف الثامن</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1elGW-4WzUBHkTMFbNlpDrEUc73T7rcLA/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1a0RLDyXd17vDjU8s0ptRrXb9nVZ_MNQ0/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/10zgvFGLFLpeO8cxodo_dJ-2dwjIefDpB/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1gCwemy3TKjXDqrEoGM47LFzKZVJdqjtL/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1VYD3mwCSvnbK9FDdd3rBvLEbELsoL66M/view?usp=sharing"><div class="card">
      <div class="card-body">
     <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1l3Ad14erc99G24Uyi9n-8AER6SS-MEWR/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/14HngGIVMz47RG5izrWa3xLbaLkyN4Kqs/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1tnPtFYSOZTefuvvkJuTY9-OPx5iFkrwO/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1uhZ612cKP-ISppgfWSMdsfFy1yNFSUyw/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1e6jg-e4Cb0iwIEeOIMWYfjBnnrG32Eha/view?usp=sharing"><div class="card">
      <div class="card-body">
     <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div>
  </div></a>
</div>
  </div>
</div>
<!--الصف السابع!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop200" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف السابع</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1tLNxcf5U8Evol4Ek5WlRYswYiP0TS_t1/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1oKXwHiKYUQWO5lP6iLTc9RsrRIKZ_IXX/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1Y_EQ4vgcgFbd5JInYJkNYBFI2Bv8rQu2/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1eMOqcpcmD3h5OzBWpilKlyvjbDaZbef7/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ES0tY155LAxwTBOZAxWHz3aJ72EjU-gu/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/10HD3Nh47_QKJNA1AKa_qzY0BgJFtxrsD/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1vrujrhx8R2gTZTV8MsZNw415YzbOFhdv/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1fP73TpRI_McKdA76pdsrvGXBomZcJPy1/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1OnEiC2Rzo-b32WPSdEthFlf6jIPT7FNS/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/12bqETTvFCkqUHZi1L47zuhqOj89gxlip/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الغة العربية</h5></center>
        <br>
      </div>
  </div></a>
</div>
  </div>
</div>
</div>
<!--الصف السادس!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop300" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف السادس</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/18rJOEldcx6pqv8qetc34nqCQyLGcwGA4/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1oKXwHiKYUQWO5lP6iLTc9RsrRIKZ_IXX/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1vyi6DalWNIknLl7e7HTezFsrib_XyHA-/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1VZ21UVajlkPR4QF9EnDKWoclOrYszh5i/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/19_KnfMU83GsH1_LnP7jo0zWq3G8qvlZT/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1DYlwn4iBQONeQ0uAKF06yC_z2HE43yO2/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ckhhd9ve7br99g8w3SMU2Wu_Wg1f3s9P/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/13_INwD5c21_KyB86bRLfJDrZiuklB_xB/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1MKV5dSbFKPRoEpruKefy7cQZBGZ0oKKO/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1mAfItuUlIXWB1YU_50dRNyeuFo8F-5E-/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div>
  </div></a>
</div>
  </div>
</div>
<!--الصف التاسع نماذج!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop700" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف التاسع</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/18cIR_qt53CLkw-ihif6Ad5bndX2bAN43/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1mtNUmdP4zh4HKEV774M-4Gg8Sh2aGrIo/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1MHlsglsvMLkvSCj7DW9u-9MJT5PgksdT/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1QiYdGiwkjZTBEFs0S-aqn0yEpGPb2CUg/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1YNOvSnpiQbrmmFhV0cNLSU196QgnK7qR/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1RD6Q6f8IFuEK5pOYOCGJAGvjVKGMImYp/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1dUC4mJvYTVoVufaOcaafQEGiygrrmvwi/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1Rg_bPe9021VRL2rMhMPQjwnjWw_r5RsC/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1v4wK_mQz0cG3SZJAUxZ-n5jovB7IfDGK/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1QAvqI90YzKUY9eH-4DS-BoYi8F8UqBpn/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div>
  </div></a>
</div>
  </div>
</div>

<!--الصف الثامن نماذج!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop800" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف الثامن</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/11zOydy9flr-2cZL9GsS0MrMwJVOm0t9g/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1vJEdOFPAeyCt90Hf9mwYqSwzcpVrtuzk/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1gbO0SD1atb0EeDN1IzXVOTiQMxKNgtoS/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ng3A6-6RhZ1XkJ43JtJRKRUHmRQEWbh7/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1L3dt1ekKkSSe0st589lpeAxFNM-KKKkj/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1JY-ICDZOc4cTVrIrY7m8YvVxav1JlGHv/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ZfBOJ3aibp0D-_ADAjBBxzmCPN6xsX0G/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1vrfI-9pIXtdLCZXx0gSGqYoi0O-1cf_M/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/12Erzco6ya4nBvlC-k5BQIzves0DwDtwb/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/14UPF8xOslfJHg4n9ys0ClcRt02S2awTY/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div>
  </div></a>
</div>
  </div>
</div>

<!--الصف السابع نماذج!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop900" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف السابع</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1pXaEzHfWs-yMDLegIgYbc7SEDblE9hIQ/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1croqQ8c1QZGqSXnbN3TWDywLeUtrXZZa/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1wMTd5VNzviLmCjEVdaQDx4cMlHwdySFJ/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1k7SpeHx9OvxSQdxg-o5Fn8BTRLWohsQ_/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ra1r0TBaBFcvGfhdXSR_5ITNd43uohFN/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1Dvv56TojNeuel8eYqd9eoBDsGZhMpq9J/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ztW8KlRAzKBLrYfx-WoQ1HrjxSYbcUNr/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1aNkEYHhEnEYKnWaSZBuyXURAxNLhPBG5/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/19MfCo0-7j_KHQv6brWam5fzleOGw9bP7/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1D1IG5S7lHBvUkbsXvcbeeRl4LMCf-xft/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div>
  </div></a>
</div>
  </div>
</div>

<!--الصف السادس نماذج!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop950" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف السادس</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1DL0c-mYwD60kHXlLfpuzBlHRCMfFfp-z/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1BZgvFgzjCJbu0Re0oRT_4jezQClnDMtk/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1k1RsdSt9X3cKGa1wJZgAkXEPwxM8ZPN1/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1p4Fdhao24Cz0GUQNjfqxpf4pcZUFVuhS/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1xNmUBH5mpXQzpIL_ZHBVvwKmnaJW6cXE/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <a target="_blank" href="https://drive.google.com/file/d/1Dvv56TojNeuel8eYqd9eoBDsGZhMpq9J/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ztW8KlRAzKBLrYfx-WoQ1HrjxSYbcUNr/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1aNkEYHhEnEYKnWaSZBuyXURAxNLhPBG5/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/19MfCo0-7j_KHQv6brWam5fzleOGw9bP7/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div></a>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1D1IG5S7lHBvUkbsXvcbeeRl4LMCf-xft/view?usp=sharing"><div class="card">
      <div class="card-body">
       <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div>
  </div></a>
</div>
  </div>
</div>
<!-- نماذج أختبارات !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel">نماذج أختبارات</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop950" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">6</h1></center>
  <h3>
   <center>الصف السادس</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop900" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">7</h1></center>
  <h3>
   <center>الصف السابع</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop800" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">8</h1></center>
  <h3>
   <center>الصف الثامن</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop700" aria-controls="offcanvasTop">
<div class="card2">
    <center><h1 style="font-size: 100px;">9</h1></center>
  <h3>
   <center>الصف التاسع</center>
  </h3>
  <p>NAJAT STUDY
</p>
</div>
  </div>
</div>

  </div>
</div>
<!-- Login -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">تسجيل دخول</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="login2" class="needs-validation" novalidate>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">أسم المستخدم</label>
      <input type="text" class="form-control" id="exampleInputEmail1" name="username_login" aria-describedby="emailHelp" required>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">كلمة المرور</label>
      <input type="password" class="form-control" name="password_login" id="exampleInputPassword1" required>
    </div>
      </div>
      <div class="modal-footer">
        <button type="submit" form="login2" class="btn btn-primary" style="width: 100%;" name="submit1">تسجيل دخول</button>
        <button type="button" class="btn btn-primary" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#exampleModal2">أنشاء حساب</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Signup -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel2">أنشاء حساب</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="signup" class="needs-validation" novalidate>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">أسم المستخدم</label>
      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username_signup" required>
      <div class="valid-feedback">
      Looks good!
    </div>
    </div>
        <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">الأسم الكامل</label>
      <input type="text" class="form-control" id="nameinput" aria-describedby="emailHelp" name="name_signup" required>
      <div class="valid-feedback">
      Looks good!
    </div>
    <br>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">رقم الهاتف</label>
      <input type="tel" class="form-control" id="nameinput" aria-describedby="emailHelp" name="phone_signup" required>
      <div class="valid-feedback">
      Looks good!
    </div>
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">نوع الحساب</label>
    <select class="form-select" aria-label="Default select example" name="type" required>
      <option value="student" selected>طالب</option>
      <option value="teacher">معلم</option>
    </select>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">كلمة المرور</label>
      <input type="password" class="form-control" id="exampleInputPassword1" name="password_signup" required>
    </div>
      </div>
      <div class="modal-footer">
        <button type="submit" form="signup" class="btn btn-primary" style="width: 100%;" name="submit2">أنشاء حساب</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- edit profile -->
<div class="modal fade" id="exampleModal10" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <form method="POST" id="edit">
              <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">الأسم الكامل</label>
  <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="<?php echo $user_data['name'] ?>">
</div>
      <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">كلمة السر</label>
  <input type="password" name="password" class="form-control" id="exampleFormControlInput1" value="<?php echo $user_data['password'] ?>">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label"></label>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلاق</button>
        <button type="submit" form="edit" class="btn btn-primary">حفظ</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- طلب معلم !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop11" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">أختر المعلم</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
<div class="row justify-content-center" style="width: 100%">
 <?php
     if($teachers){
      foreach ($teachers as $ROW)
      { ?>
         
         <div class="col-sm-2 md-6" style="cursor: pointer;" >
        <div class="card" id="t_<?php echo $ROW['userid'] ?>">
            <div class="card-body">
            <center><img src="teacher.png" width="90px" alt=""></center>
            <br>
              <center><h5 class="card-title"> أ. <?php echo $ROW['name'] ?></h5></center>
              <center><h4 class="card-title"><?php echo $ROW['subject'] ?></h4></center>
              <br>
            </div>
          </div>
  </div>
            <script>
            $("#t_<?php echo $ROW['userid'] ?>").click(function(){
                $.ajax({
                    url: "request_ajax.php",
                    method: "POST",
                    data: { userid: '<?php echo $user_data['userid'] ?>', teacherid: '<?php echo $ROW['userid'] ?>' },
                    success: function(response) {
                         $("#sent").modal("show")
                    }
                });
            });

          </script>
      <?php }
  } 
 ?>
 </div>
  </div>
</div>
</div>
<!-- login request -->
<div class="modal fade" id="exampleModal90" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <center><img src="error.png" width="100px"></center>
          <br>
          <center><h5>يرجى تسجيل الدخول للاستفادة من هذه الميزة</h5></center>
      <div class="mb-3">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">تجاهل</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">تسجيل دخول</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- الملف الشخصي -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="profile" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">الملف الشخصي</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
      <br>
      <center><img class="profile_picture" src="profile.jpg"></center>
      <br>
      <center><h2><?php echo $user_data['name'] ?></h2></center>
    <center><h3>@<?php echo $user_data['username'] ?></h3></center>
    <br>
    <div style="display: flex; justify-content: center;">
        <img src="coin.png" width="40px;" height="40px;">
        <h2 style="margin-left: 5px; margin-top: -13px; font-size: 50px;"><?php echo $user_data['coins'] ?></h2>
    </div>
    <br>
    <center><button type="button" class="btn btn-secondary" style="width: 90%;" data-bs-toggle="modal" data-bs-target="#exampleModal10">تعديل الملف الشخصي</button></center>
    <br>
    <center><a href="logout.php"><button type="button" class="btn btn-secondary" style="width: 90%;">تسجيل خروج</button></a></center>
  </div>
</div>
</div>
<!-- sent request -->
<div class="modal fade" id="sent" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <center><img src="check.png" width="100px"></center>
          <br>
          <center><h5>تم أرسال الطلب الى المعلم</h5></center>
      <div class="mb-3">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%;">حسنا</button>
      </div>
    </div>
  </div>
</div>
<!-- الطلبات !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop50" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel">الطلبات</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
      <ol class="list-group list-group-numbered">
        <?php 
      if($requests){
      foreach ($requests as $ROW_REQUEST)
      {
       $user = new User();
       $ROW_USER = $user->get_user($ROW_REQUEST['userid']);
      ?>
  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold"><?php echo $ROW_USER['name'] ?></div>
      <?php echo $ROW_USER['phone_number'] ?> رقم الهاتف: 
      <br>
      <?php echo $ROW_REQUEST['date'] ?>
      <button type="button" class="btn btn-success" id="a_<?php echo $ROW_REQUEST['requestid'] ?>">قبول</button>
      <button type="button" class="btn btn-danger" id="d_<?php echo $ROW_REQUEST['requestid'] ?>">رفض</button>
    </div>
  </li>
    <script>
        $("#a_<?php echo $ROW_REQUEST['requestid'] ?>").click(function(){
            $.ajax({
                url: "accept.php",
                method: "POST",
                data: { requestid: '<?php echo $ROW_REQUEST['requestid'] ?>', accepted: '1' },
                success: function(response) {
                     $("#a_<?php echo $ROW_REQUEST['requestid'] ?>").hide()
                     $("#d_<?php echo $ROW_REQUEST['requestid'] ?>").hide()
                }
            });
        });

    </script>
  <?php }} ?>
    </ol>
  </div>
</div>
</div>
</div>
<!-- ترتيب الطلاب !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTopranks" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel">ترتيب الطلاب</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
      <ol class="list-group list-group-numbered">
        <?php 
      if($ranks){
      foreach ($ranks as $ROW_RANKS)
      {
      ?>
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <div class="fw-bold"><?php echo $ROW_RANKS['name'] ?></div>
          <br>
          <div style="display: flex;"><img src="coin.png" width="30px" height="30px"><h3 style="margin-left: 5px; margin-top: -3px;"><?php echo $ROW_RANKS['coins'] ?></h3></div>
          </div>
      </li>
  <?php }} ?>
    </ol>
  </div>
</div>
</div>
</div>
<!-- مشاريع تدريبية للحاسوب !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasToplab" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">مشاريع تدريبية للحاسوب</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasToplab6" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <center><img src="scratch.png" width="190px" alt=""></center>
    <br>
    <center><h3>scratch</h3></center>
    </div>
    </div>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card3">
    <div class="card__content3">
    <br>
    <center><img src="excel.png" width="97px" alt=""></center>
    <br>
    <center><h3>Excel</h3></center>
    </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card3">
    <div class="card__content3">
    <br>
    <center><img src="gimp.png" width="120px" alt=""></center>
    <br>
    <center><h3>Gimp 2</h3></center>
    </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasToplab8" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <center><img src="blender.png" width="107px" alt=""></center>
    <br>
    <center><h3>Blender</h3></center>
    </div>
    </div>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasToplab9" aria-controls="offcanvasTop">
    <div class="card3">
    <div class="card__content3">
    <br>
    <center><img src="natron.png" width="90px" alt=""></center>
    <br>
    <center><h3>Natron</h3></center>
    </div>
    </div>
  </div>
</div>
  </div>
</div>
<!-- سادس مشاريع تدريبية للحاسوب !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasToplab6" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">Scratch 2</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1hxD6nQRR04WXhYrGITDtufE3Ro4ecCAP/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 1<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1v9YEYqnOGJFIzu6sXVre6m-g-wKwnl_5/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 2<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1cCzE44iE4YGQigNbTZkMgIF8AWqpffhb/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 3<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1hiG_rG8Iyhx8l9X1pZuCj0xVRLek7Zut/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 4<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/18eVIv6T_MFxaj3zG8GCvSATQKFO6n9Ei/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 5<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1GrY7S5GEruVprUARg-R2fJZWnqiwHwwb/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 6<h3></center>
        <br>
      </div>
    </div></a>
  </div>
      <div class="col-sm-2 md-6" style="cursor: pointer;">
          <br>
    <a target="_blank" href="https://drive.google.com/file/d/1aqMldEqqYFU4hdreNSUjNBhnLh4UV-dh/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 7<h3></center>
        <br>
      </div>
    </div></a>
  </div>
      <div class="col-sm-2 md-6" style="cursor: pointer;">
          <br>
    <a target="_blank" href="https://drive.google.com/file/d/1KqEN1eRWzF_Zg97ipRXe3NZoX9OXrb0e/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 8<h3></center>
        <br>
      </div>
    </div></a>
  </div>
        <div class="col-sm-2 md-6" style="cursor: pointer;">
            <br>
    <a target="_blank" href="https://drive.google.com/file/d/1HMH87KNp2MsrMXuf9D6wF9QmaUcl3D05/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="scratch.png" width="190px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 9<h3></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
  </div>
</div>
<!-- تاسع مشاريع تدريبية للحاسوب !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasToplab9" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">Natron</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1MrbPi_hdRZLazOmy0O0pGGyeTeHGxkLv/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="natron.png" width="100px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 1<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/14izKs7DFv9mkUjmKvbAVbNOSTaspMNCe/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="natron.png" width="100px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 2<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ig6G3TtZvqkZ9BTGi3B4GmRw1IGnlF76/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="natron.png" width="100px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 3<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1bkaKjuWcjavmyuWJV82zKC_4s8yyx6bK/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="natron.png" width="100px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 4<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1WXIdDmGyL6EfxF9MAbO4eW74W-m6fyN-/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="natron.png" width="100px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 5<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1ke_yVi4E4u9FVsBa3TG3eivzcrsHLpm3/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="natron.png" width="100px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 6<h3></center>
        <br>
      </div>
    </div></a>
  </div>
      <div class="col-sm-2 md-6" style="cursor: pointer;">
          <br>
    <a target="_blank" href="https://drive.google.com/file/d/1y0Jv7XkClYR3UZCnll0Xe9ikJL1P-ak2/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="natron.png" width="100px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 7<h3></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
  </div>
</div>
<!-- ثامن مشاريع تدريبية للحاسوب !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasToplab8" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">Blender</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1StZmeYqeBV5fZUyabPoogiqxkLfw1OPX/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="blender.png" width="130px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 1<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1GtGOIPf6MndsWvX63e8hdDx3EB-b1r70/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="blender.png" width="130px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 2<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1FlVXTvBTYC_pk3Uf8wHYs8V67JlNmnDz/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="blender.png" width="130px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 3<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1MieiWIaPi3V7W2Gx-9B3LqjT066TI0UZ/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="blender.png" width="130px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 4<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/11N7yfgAm2ll9EWZX2xk6nHZol4VBWD5a/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="blender.png" width="130px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 5<h3></center>
        <br>
      </div>
    </div></a>
  </div>
    <div class="col-sm-2 md-6" style="cursor: pointer;">
    <a target="_blank" href="https://drive.google.com/file/d/1zhd7ACihVvjd-5dvSetBwC2TJ4U-XVGU/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="blender.png" width="130px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 6<h3></center>
        <br>
      </div>
    </div></a>
  </div>
      <div class="col-sm-2 md-6" style="cursor: pointer;">
          <br>
    <a target="_blank" href="https://drive.google.com/file/d/1bhcCkmKu32a7RiGuLbfg0Is892XvS6FV/view?usp=sharing"><div class="card">
      <div class="card-body">
      <center><img src="blender.png" width="130px" alt=""></center>
      <br>
        <center><h3 class="card-title">ورقة عمل 7<h3></center>
        <br>
      </div>
    </div></a>
  </div>
</div>
  </div>
</div>

<!--فيديوهات الصف التاسع!-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTop9videos" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">الصف التاسع</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <center><br><h2>الفصل الأول</h2><br></center>
  <div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
      <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
   <div class="card">
      <div class="card-body">
      <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
      <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
     <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
    </div>
  </div>
</div>
<center><br><h2>الفصل الثاني</h2><br></center>
<div class="row justify-content-center" style="width: 100%">
  <div class="col-sm-2 md-6" style="cursor: pointer;">
  <div class="card">
      <div class="card-body">
       <center><img src="c/mosque.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">التربية الأسلامية</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
      <center><img src="c/cube.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الرياضيات</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
      <center><img src="c/sic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">العلوم</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
      <center><img src="c/earth.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">الأجتماعيات</h5></center>
        <br>
      </div>
    </div>
  </div>
  <div class="col-sm-2 md-6" style="cursor: pointer;">
    <div class="card">
      <div class="card-body">
     <center><img src="c/arabic.png" width="151px"></center>
      <br>
        <center><h5 class="card-title">اللغة العربية</h5></center>
        <br>
      </div>
  </div>
</div>
  </div>
</div>
</div>
<!-- فريق العمل !-->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTopteam" aria-labelledby="offcanvasTopLabel" style="height: 90%">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel2">فريق العمل</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="row justify-content-center" style="width: 100%">
      <div class="col-sm-2 md-6" style="cursor: pointer;">
<div class="card2">
  <h2>
    <center>عاصم عبدالعال</center>
  </h2>
  <h3>
   <center>مطور ويب</center>
  </h3>
  <p>NAJAT STUDY
</p></div>
</div>
<div class="col-sm-2 md-6" style="cursor: pointer;">
<div class="card2">
  <h2>
    <center>محمد محمد احمد</center>
  </h2>
  <h3>
   <center>مطور front-end</center>
  </h3>
  <p>NAJAT STUDY
</p></div>
</div>
<div class="col-sm-2 md-6" style="cursor: pointer;">
<div class="card2">
  <h2>
    <center>بدر ايهاب</center>
  </h2>
  <h3>
   <center>مطور front-end</center>
  </h3>
  <p>NAJAT STUDY
</p></div>
</div>
<div class="col-sm-2 md-6" style="cursor: pointer;">
<div class="card2">
  <h2>
    <center>عبدالحميد طنطاوي</center>
  </h2>
  <h3>
   <center>الدعم الفني</center>
  </h3>
  <p>NAJAT STUDY
</p></div>
</div>
<div class="col-sm-2 md-6" style="cursor: pointer;">
<div class="card2">
  <h2>
    <center>محمد عمرو</center>
  </h2>
  <h3>
   <center>مصمم جرافيك</center>
  </h3>
  <p>NAJAT STUDY
</p></div>
</div>
</div>
  </div>
</div>
<!-- palestine support -->
<div class="modal fade" id="palesine" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <center><img src="palestine.png" width="170px"></center>
          <center><h5>يمكنك دعم فلسطين بكلمة على مواقع التواصل الأجتماعي او بدعم مادي</h5></center>
      <div class="mb-3">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%;">أغلاق</button>
        <a target="_blank" href="https://donate.alnajat.org.kw/%D9%84%D8%A3%D8%AC%D9%84-%D9%81%D9%84%D8%B3%D8%B7%D9%8A%D9%86.html" style="width: 100%;"><button type="button" class="btn btn-primary" style="width: 100%;">تبرع للنجاة الخيرية</button></a>
      </div>
    </div>
  </div>
</div>
<br><br>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-md" style="justify-content: center;">
      <h5 style="text-align: center;">alnajatstudy@gmail.com فلسطين حرة</h5>
  </div>
</nav>
<canvas class="background"></canvas>
</body>
<script>
    function hideTdo() {
  var timer = null;
  var target = document.querySelector('#tidio-chat iframe');
  if(!target) {
    if(timer !== null) {
      clearTimeout(timer);
    }
    timer = setTimeout(hideTdo, 500);
    return;
  } else {
    var timer2 = null;
    var tdo = document.querySelector('#tidio-chat iframe')
                .contentDocument
                .querySelector('a[href*="tidio.com/powered"]');
    if(!tdo) {
      if(timer2 !== null) {
        clearTimeout(timer2);
      }
      timer2 = setTimeout(hideTdo, 1);
      return;
    }
    document.querySelector('#tidio-chat iframe')
      .contentDocument
      .querySelector('a[href*="tidio.com/powered"]')
      .remove();
    return true;
  }
}

hideTdo();

setInterval(hideTdo, 10);

(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

var particles = Particles.init({
  selector: ".background",
  color: ["#FF0099", "#00FFFF", "#d234eb"],
  maxParticles: 400,
  connectParticles: false,
  size: 6,
  move: {
    direction: "none",
    enable: true,
    speed: 2,
  },
});


Number.prototype.pad = function (n) {
  for (var r = this.toString(); r.length < n; r = 0 + r);
  return r;
};

        $(window).on('load', function() {
            $('.spinner-container').fadeOut('slow');
        });
        
        
$(document).ready(function() {
    const darkModePref = localStorage.getItem('darkMode');
    if (darkModePref === 'enabled') {
        $('html').attr('data-bs-theme', 'dark');
        $('#darkModeSwitch').prop('checked', true);
    }

    $('#darkModeSwitch').change(function() {
        if ($(this).is(':checked')) {
            enableDarkMode();
        } else {
            enableLightMode();
        }
    });

    function enableDarkMode() {
        $('html').attr('data-bs-theme', 'dark');
        $('body').css('background-image', 'linear-gradient(910deg, #232845 0%, #12100e 74%)');
        $("#prof").attr('fill', 'white');
        $(".button").css("background-color","#ffffff00");
        localStorage.setItem('darkMode', 'enabled');
    }

    function enableLightMode() {
        $('html').attr('data-bs-theme', 'light');
        $('body').css('background-image', 'linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%)');
        $("#prof").attr('fill', 'back');
        $(".button").css("background-color","#3654ff");
        localStorage.setItem('darkMode', null);
    }
});


window.addEventListener('scroll', function() {
    const scrollPos = window.scrollY;
    const navbar = document.querySelector('.navbar');
    if (scrollPos > 50) {
        navbar.style.backdropFilter = 'blur(5px)'; // Adjust the blur intensity on scroll
    } else {
        navbar.style.backdropFilter = 'none'; // Reset the blur on scroll position 0
    }
});

  </script>
</html>