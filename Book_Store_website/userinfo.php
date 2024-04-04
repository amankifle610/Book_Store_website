<?php
session_start();
include_once('class/connection.php');
$con=new Connect;
$conn2=$con->getConnection();
$user_id=$_SESSION['user_id'];
$USER=[];
if(isset($user_id)){
    $sql = "SELECT * FROM account a JOIN user u ON a.id = u.Account_no WHERE a.id = '$user_id'";
    $result = $conn2->query($sql);
    $combined = $result->fetch_assoc();
    $accountJSON = json_encode($combined);
}
if(isset($_POST['delete']))
{
    $sql = "DELETE FROM user WHERE Account_no = '$user_id'";
    $conn2->query($sql);
    $sql = "DELETE FROM account WHERE id = '$user_id'";
    $conn2->query($sql);
    header('location: logout.php');
}
if(isset($_POST['update']))
{
    $fname=$_POST['first_name'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $sql = "UPDATE user SET First_name='$fname',Last_name='$lname' WHERE Account_no ='$user_id'";
    $conn2->query($sql);
    $sql = "UPDATE account SET Email='$email',password='$password' WHERE id ='$user_id'";
    $conn2->query($sql);
    header('location: userinfo.php');
}
?>
<head>
<link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<div class="container">

    <div class="row">
    <div class="cardbody">
        <div class="card-header">Profile Picture</div>
            <div class="card-body">
                <img class="img-account-profile" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                <div class="">JPG or PNG no larger than 5 MB</div>
                <i class="fa fa-sharp fa-solid fa-plus"></i>
            </div>
            <form action="" style="display: inline-block;" method="post" class="search3">
            <button id="deleteAccountBtn" name="delete">Delete Account</button>
            </form>
            <button><a href="logout.php">Logout</a></button>
        </div>

            <div class="card">
                <div class="card-header cardheader">Account Details</div>
                <div class="cardbody1">
                <form action="" method="post" class="search3Signup">
                <div class="name">
                <div class="firstname"><label for="first_name" class="fname">First Name</label>
                    <input type="text" class="fname1" placeholder="Enter your First Name" required name="first_name"></div>
                <div class="lastname">
                    <label for="lname" class="lname">Last Name </label>
                <input type="text" class="lname1" placeholder="Enter your Last Name" required name="lname">
                </div>
                </div>
                <label for="email" class="email">Email <span class="erroremail" style='font-size: 12px; display: none;'>&nbsp;Email already in use</span></label>
                <input type="email" autocomplete="off" class="email1Sign" placeholder="Enter your email" required name="email">
                <label for="password" class="password">Password <span class="errorpass" style='font-size: 12px; display: none;'>&nbsp;Password must be at least 8 characters long</span></label>
                <div class="password1">
                    <input type="password" class="passsign" placeholder="Enter password" required name="password"><i class="fa far fa-eye"></i>
                </div>
                <label for="confirmPassword" class="password">Confirm Password <span class="errorconfpass" style='font-size: 12px; display: none;'>&nbsp;Password don't match</span></label>
                <div class="password1">
                    <input type="password" class="pass passconf" placeholder="Confirm password" required name="confirmPassword"><i class="fa far fa-eye"></i>
                </div>
                <input type="submit" value="update" name="update" class="submitsignup" disabled=true>
            </form>
                </div>
            </div>
    </div>
</div>

<script>
const userId = <?php echo $user_id; ?>; 
const deleteBtn = document.getElementById('deleteAccountBtn');
deleteBtn.addEventListener('click', (e) => {
    if(!confirm('Are you sure you want to delete your account?')) {
        e.preventDefault();
}
});
var disable=true;
var account = <?php echo $accountJSON; ?>;
var submitsignup=document.querySelector('.submitsignup')
var passsign=document.querySelector('.passsign')
var pass=document.querySelector('.passconf')
var email1Sign=document.querySelector('.email1Sign')
var fname1=document.querySelector('.fname1')
var lname1=document.querySelector('.lname1')
passsign.value=account.password;
email1Sign.value=account.Email;
fname1.value=account.First_name;
lname1.value=account.Last_name;
passsign.addEventListener('change',()=>{
    submitsignup.disabled=false;
})
email1Sign.addEventListener('change',()=>{
    submitsignup.disabled=false;
})
fname1.addEventListener('change',()=>{
    submitsignup.disabled=false;
})
lname1.addEventListener('change',()=>{
    submitsignup.disabled=false;
})
submitsignup.addEventListener('click', (e) => {
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
  var c=0;
  var valid=true;
  for(let i=0;i<account.length;i++){
    if(email1Sign.value==account[i].Email){
      c++;
    }
  }
  var faplus=document.querySelector('.fa-plus')
  var p=pass.value
  var p1=passsign.value
    if(c>1){
        e.preventDefault();
        email1Sign.style.border='none'
        email1Sign.style.outline='2px solid red'
        erroremail.style.display='flex'
        erroremail.style.color='red'
        valid=false
    }
    else if(p1.length<8){
    e.preventDefault();
    passsign.style.border='none'
    passsign.style.outline='2px solid red'
    errorpass.style.display='flex'
    errorpass.style.color='red'
    valid=false
    }
    else if(p1!=p){
    e.preventDefault();
    pass.style.border='none'
    pass.style.outline='2px solid red'
    errorconfpass.style.display='flex'
    errorconfpass.style.color='red'
    valid=false
    }
    else{
        if(valid){
            if(!confirm('Are you sure you want to Update your account info?')) {
            e.preventDefault();
            }
        }

    }


});
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
