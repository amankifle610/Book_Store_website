<?php
session_start();
include_once('class/connection.php');
$con=new Connect;
$conn2=$con->getConnection();

$sql1 = "SELECT * FROM account";
$result1 = $conn2->query($sql1);
$USER = [];
while($row = $result1->fetch_assoc()) {
  $USER[] = $row; 
}
$userJSON = json_encode($USER);

if(isset($_POST['Signup']))
{
$fname=$_POST['first_name'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$password=$_POST['password'];
$type="user";
$sql="insert into account(Email,password,Type)values('$email','$password','$type')";
$res=$conn2->query($sql);
if(!$res){
die('connection error'.$conn2->connect_error);
}
else{
     $sql = "SELECT id FROM account WHERE Email='$email'";
    $result = $conn2->query($sql);
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    $sql="insert into user(First_name,Last_name,Account_no)values('$fname','$lname','$user_id')";
    $res=$conn2->query($sql);
    if(!$res){
        die('connection error'.$conn2->connect_error);
    }
    else{
        array_push($USER,$user);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $fname;
    }
}
}
if(isset($_POST['Login']))
{
$emailLogin=$_POST['emailLogin'];
$passwordLogin=$_POST['passwordLogin'];
$sql = "SELECT id,type FROM account WHERE Email='$emailLogin'";
$result = $conn2->query($sql);
$user = $result->fetch_assoc();
$user_id = $user['id'];
$type = $user['type'];
if($type=='user'){
    $sql = "SELECT First_name FROM user WHERE Account_no ='$user_id'";
$result = $conn2->query($sql);
$user = $result->fetch_assoc();
    $fname = $user['First_name'];
  $_SESSION['user_id'] = $user_id;
  $_SESSION['user_name'] = $fname;
}
else if($type=='admin'){
    header('location: admin.php');
}



}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookHub</title>
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
</head>

<!-- login html start -->
<div class="loginMain1">
        <i class="fa fas fa-times" style="font-size: 30px;"></i>
        <div class="loginMain">
            <div class="loginh1">Login now</div>
            <div class="loginh2">Hi! Welcome back &#128075;</div>
            <div class="loginh3">--------------------Login with email--------------------</div>
            <form action="" method="post" class="search3">
                <label for="emailLogin" class="email">Email <span class="erroremaillogin" style='font-size: 12px; color: red; display: none;'>&nbsp;Account not found!</span></label>
                <input type="email" class="email1" placeholder="Enter your email" required name="emailLogin">
                <label for="passwordLogin" class="password">Password<span class="errorpasslogin" style='font-size: 12px; color: red; display: none;'>&nbsp;password incorrect</span></label>
                <div class="password1">
                <input type="password" class="pass" placeholder="Enter password" required name="passwordLogin"><i class="fa far fa-eye"></i>
                <a href="" class="forgetpass">Forget password?</a>
                </div>
                <input type="submit" value="Login" name="Login" class="submit">
            </form>
            <p class="dontHaveAccount">Don't have an account?<span class="signupopen"> Sign up</span></p>
        </div>
    </div>
    <!-- login html end-->
    <!-- search html start-->
    <div class="searchMain1">
        <i class="fa fas fa-times" style="font-size: 30px;"></i>
        <form action="" class="Search">
        <input type="search" name="searchBox" id="searchBox" placeholder="Search  for books by keyword / Title / author">
        <label for="searchBox" class="searchicon"><i class="fa fa-solid fa-search" style="margin-left: 5px; color: white;"></i></label>
        </form>
    </div>
    <!--Search html start -->
    <!--Sign up html start -->

    <div class="signupMain1">
        <i class="fa fas fa-times" style="font-size: 30px;"></i>
        <div class="signupMain">
            <div class="signuph1">Sign up form</div>
            <form action="" method="post" class="search3Signup">
                <div class="name">
                <div class="firstname"><label for="first_name" class="fname">First Name <span class="star">*</span></label>
                    <input type="text" class="fname1" placeholder="Enter your First Name" required name="first_name"></div>
                <div class="lastname">
                    <label for="lname" class="lname">Last Name <span class="star">*</span></label>
                <input type="text" class="lname1" placeholder="Enter your Last Name" required name="lname">
                </div>
                </div>
                <label for="email" class="email">Email <span class="star">*<span class="erroremail" style='font-size: 12px; display: none;'>&nbsp;Email already in use</span></span></label>
                <input type="email" autocomplete="off" class="email1Sign" placeholder="Enter your email" required name="email">
                <label for="password" class="password">Password <span class="star">*<span class="errorpass" style='font-size: 12px; display: none;'>&nbsp;Password must be at least 8 characters long</span></span></label>
                <div class="password1">
                    <input type="password" class="passsign" placeholder="Enter password" required name="password"><i class="fa far fa-eye"></i>
                </div>
                <label for="confirmPassword" class="password">Confirm Password <span class="star">*<span class="errorconfpass" style='font-size: 12px; display: none;'>&nbsp;Password don't match</span></span></label>
                <div class="password1">
                    <input type="password" class="pass passconf" placeholder="Confirm password" required name="confirmPassword"><i class="fa far fa-eye"></i>
                </div>
                <div class="check">
                <input type="checkbox" class="checkbox" required name="checkbox" style="font-size: 1.3em">
                <span>I have read and agreed to your <a href="About.html" class="term">Terms and conditions</a>and<a href="About.html" class="term">Privacy Policy</a> </span>
                </div>
                <input type="submit" value="Signup" name="Signup" class="submitsignup">
            </form>
        </div>
    </div>
    <!--Sign up html start -->


<body>
    <div class="wrapper">
        <header>
            <div class="header1" style="height: 6em">
                <a href="" class="logo"><img src="img/logo.png" alt="" class="logo1"></a>
                <form action="" class="search">
                    <input type="search" name="search-Box" id="search-Box" placeholder="Search  for books by keyword / Title / author">
                    <label for="search-Box" class="search-icon"><i class="fa fa-solid fa-search"></i></label>
                </form>
                <div class="header2">
                    <i class="fa fa-solid fa-search" style="font-size: 30px; display: none;"></i>
                    <?php
                    if(isset($_SESSION['user_id'])){
                        $fname=$_SESSION['user_name'];
                        echo "<a href='userinfo.php'><img class='UserImg' src='img/userimg.jpg' alt=''></a>";
                        echo "<span style='margin-right: 0em; font-size: 1.2em;' class='login_name'>Login as<div>$fname</div></span>";
                    }
                    else{
                        echo " <i class='fa fa-solid fa-user' style='font-size: 400%;'></i>";
                        echo "<span class='log' style='margin-right: 5px; font-size: 200%;'>Login</span>";    
                    }
                    ?>
                </div>
            </div>
            <div class="nav1">
            <i class="fa fa-solid fa-bars"></i>
                <ul class="ul">
                    <li class="homeLI"><a href="HomePage.php" class="home HOME">HOME</a></li>
                    <li class="booksLI"><a href="Book.php" class="books">BOOKS</a></li>
                    <li class="newReleaseLI"><a href="About.php" class="aboutus">ABOUT US</a></li>
                    <li class="bestSellingLI"><a href="" class="bestSelling">CONTACT US</a></li>    
                </ul>
            </div>
        </header>
<script>
    //user input validation for signup and login
var customers = <?php echo $userJSON; ?>;

var search3Signup=document.querySelector(".search3Signup");
var search=document.querySelector(".search-icon");
var searchBox=document.querySelector("#search-Box");
search.addEventListener('click',e=>{
    if(searchBox.value){
        window.location.href = 'book.php?text='+searchBox.value;
    }
})
searchBox.addEventListener('keypress',e=>{   
    if(e.key === "Enter"){
    e.preventDefault();
    search.click();
    }
})
var search1=document.querySelector(".searchicon");
var searchBox1=document.querySelector("#searchBox");
search1.addEventListener('click',e=>{
    if(searchBox1.value){
        window.location.href = 'book.php?text='+searchBox1.value;
    }
})
search3Signup.addEventListener('submit',e=>{
var erroremail=document.querySelector('.erroremail')
var errorpass=document.querySelector('.errorpass')
var errorconfpass=document.querySelector('.errorconfpass')
    var passsign=document.querySelector('.passsign')
    var pass=document.querySelector('.passconf')
  var email1Sign=document.querySelector('.email1Sign')
  var fname1=document.querySelector('.fname1')
  erroremail.style.display='none'
  errorpass.style.display='none'
  errorconfpass.style.display='none'
  passsign.style.border='2px solid black'
  passsign.style.outline='none'
  pass.style.border='2px solid black'
    pass.style.outline='none'
    email1Sign.style.border='2px solid black'
    email1Sign.style.outline='none' 
  var valid=true
  for(let i=0;i<customers.length;i++){
    if(email1Sign.value==customers[i].Email){
      valid=false
    }
  }
  var p=pass.value
  var p1=passsign.value
  if(p1.length<8){
    e.preventDefault();
    passsign.style.border='none'
    passsign.style.outline='2px solid red'
    errorpass.style.display='flex'
  }
  else if(p1!=p){
    e.preventDefault();
    pass.style.border='none'
    pass.style.outline='2px solid red'
    errorconfpass.style.display='flex'
  }

    if(!valid){
        e.preventDefault();
        email1Sign.style.border='none'
        email1Sign.style.outline='2px solid red'
        erroremail.style.display='flex'
    }
    else{
    
    }
    
})
var email1=document.querySelector('.email1')
  var pass=document.querySelector('.pass')
var search3=document.querySelector(".search3");
search3.addEventListener('submit',e=>{
var email1=document.querySelector('.email1')
  var pass=document.querySelector('.pass')
    var erroremaillogin=document.querySelector('.erroremaillogin')
    var errorpasslogin=document.querySelector('.errorpasslogin') 
    erroremaillogin.style.display='none'
    errorpasslogin.style.display='none'
    email1.style.border='2px solid black'
    email1.style.outline='none'
    pass.style.border='2px solid black'
    pass.style.outline='none'
  var valid=false,email=false;
   for(let i=0;i<customers.length;i++){
    if(email1.value==customers[i].Email&&pass.value==customers[i].password){
      valid=true
    }
    else if(email1.value!=customers[i].Email){
        email=true
    }
  }
    if(valid){
      loginMain1.style.display='none'
    }
    else{
        if(email){
            email1.style.border='none'
            email1.style.outline='2px solid red'
            erroremaillogin.style.display='flex'
            e.preventDefault();
        }
        else{
            pass.style.border='none'
            pass.style.outline='2px solid red'
            errorpasslogin.style.display='flex'
            e.preventDefault();
        }
    
    }
    
})
var ul=document.querySelector('.ul')
var nav=document.querySelector('.nav1')
window.addEventListener('scroll', ()=>{
    if(window.scrollY>94){
    nav.style.position='fixed'
    nav.style.top=0
    nav.style.margin=0
    ul.style.top='2.5em'
}
else{
    nav.style.position='static'
    nav.style.marginTop= '15px';
    ul.style.top='9.5em'
}
})
var log=document.querySelector('.log')
var login=document.querySelector('.fa-user')
var loginMain1=document.querySelector('.loginMain1')
var loginMain=document.querySelector('.loginMain')
if(login&&log){
    log.addEventListener('click' ,()=>{
    loginMain1.style.display='flex'
    loginMain1.style.visibility='visible'
})
    login.addEventListener('click' ,()=>{
    loginMain1.style.display='flex'
    loginMain1.style.visibility='visible'
})
var times=document.querySelector('.fa-times')
times.addEventListener('click',()=>{
    loginMain1.style.display='none'
    signupMain1.style.display='none'
})
loginMain1.addEventListener('click',(e)=>{
    loginMain1.style.display='none'
})
loginMain.addEventListener('click',(e)=>{
    loginMain1.style.display='flex'
    e.stopPropagation()
})
}

var signupopen=document.querySelector('.signupopen')
var signupMain1=document.querySelector('.signupMain1')
var signupMain=document.querySelector('.signupMain')
signupopen.addEventListener('click' ,()=>{
    loginMain1.style.visibility='hidden'
    signupMain1.style.display='flex'
})
signupMain1.addEventListener('click',(e)=>{
    signupMain1.style.display='none'
})
signupMain.addEventListener('click',(e)=>{
    signupMain1.style.display='flex'
    e.stopPropagation()
})
var search1=document.querySelector('.header2 .fa-search')
var searchMain1=document.querySelector('.searchMain1')
var search11=document.querySelector('.Search')
search1.addEventListener('click' ,()=>{
    searchMain1.style.display='flex'
    search11.style.display='flex'
})
searchMain1.addEventListener('click',(e)=>{
    searchMain1.style.display='none'
})
search11.addEventListener('click',(e)=>{
    search11.style.display='flex'
    e.stopPropagation()
})
var eye=document.querySelectorAll('.fa-eye')
var eye1=Array.from(eye)
eye1.forEach(e=>{
    e.addEventListener('click',()=>{
        var pass=e.parentElement.firstElementChild
        if(!e.classList.contains('fa-eye-slash')&&pass.type === "password"){
            e.classList.add('fa-eye-slash')
            pass.type = "text";
        }
        else{
            e.classList.remove('fa-eye-slash')
            pass.type = "password";
        }
    })
})
if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href)
}
</script>