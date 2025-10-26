<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicLink</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
      *{
        margin: 0px;
        padding: 0px;
      }
    ul{
      
    }
    div{
      display:inline;
    }
    .navbar {
            background-color: #fbfbfb;
            padding: 5px 20px;
            border-bottom: 1px solid #e7e7e7;
            box-shadow:5px 3px 2px #ebf0f0;
    }

    .nav-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            overflow:none;
    }
    .navbar-nav{
      font-size:10px;
      font-family:Helvetica;
      color:#3e6ba6;
      font-weight:520;
      display:flex;
      flex-direction:row;
      gap: 25px;
    }
    li{
      list-style:none;
      display:inline;
    }
    #item-id:hover{
      border-bottom:2px solid #0d6efd;
    }
    #item-id{
      font-size:1.05rem;
      align-content:center;
      list-style: none;
      margin: 0px 40px 0px 10px;
    }
    #navbar-logo{
      width: 50px;
      height:50px;
      margin-right:5px;
      margin-left:10px;
      margin-top:0px;
      margin-bottom:0px;
    }
    a{
      text-decoration:none;
      color:#3e6ba6;
      font-style:bold;
    }
    .brand-text{
    color:#3e6ba6;
    font-family:Helvetica;
    font-size: 1.25rem;
    font-weight: 520;
    }
    .navbar-brand{
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #333;
    }
    .navbar-brand img{
      margin-right:5px;
    }
    .navbar-right-icons{
      width:5%;
      display:flex;
      justify-content:space-around;
    }
    .tagline{
      font-family:Helvetica;
      font-size: 0.35rem;
      color:#3e6ba6;
      display: block;
      line-height: 1;
    }

    @media (max-width: 768px) {
     .mobilemenu{
        display:flex;
      }
      .navbar{
        box-shadow:none;
      }
      
      
    .navbar-nav{
      background-color: #fbfbfb;
      position:absolute;
      flex-direction:column;
      text-align:center;
      width:100%;
      gap:10px;
      right:0px;
      top:6%;
      box-shadow:5px 3px 2px #ebf0f0;
    }
    .navbar-nav li{
      padding:15px 0;
      width:100%;
    }
    .navbar a{
      margin-right:5px;
    }
    }
      
    #navbar-logo{
      width: 30px;
      height:30px;
      margin-right:5px;
      margin-left:10px;
      margin-top:0px;
      margin-bottom:0px;
    }
    #search{
      display:none;
    }
    .mobilemenu{
      display:flex;
      flex-direction:column;
      cursor:pointer;
    }
    .mobilemenu .bar{
      height:3px;
      width:25px;
      background-color: #3e6ba6;
      margin:4px 0;
      transition:0.4s;
    }
      
    
    </style>

</head>
<body>
  <nav class="navbar">
    <div id="nav_container" class="nav-container">
      <a class="navbar-brand" href="#">
                <!-- Placeholder for Logo Image -->
                <img src="../images/logo_wbg.png" width="40px" height="40px"  alt="CivicLink Logo">
                <div>
                  <!-- <img src="../images/logo_slogan_wbg.png" width="80px" height="50px"  alt="CivicLink Logo"> -->
                    <span class="brand-text">CivicLink</span>
                    <span class="tagline">Connecting Communities, Solving Issues</span>
                </div>
        </a>
       <div class="mobilemenu" id="mobileMenu">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
      </div>
    <ul class="navbar-nav">
        <span class="itemid"><a href="#"><li id="item-id">Home</li></a></span> 
        <span class="itemid"><a href="#"><li id="item-id">Discover</li></a></span>
        <span class="itemid"><a href="#"><li id="item-id">Submit</li></a></span>
        <!-- <li></li>
        <li></li> -->
    </ul>
    <div class="navbar-right-icons">
    <input type="search" name="search" id="search">
    <a href="#"><i class="fas fa-search"></i></a>
    <a href="#" class="profile-icon-circle">
    <i class="fas fa-user"></i>
    </a>
    </div>
    
  </div>


    </div>
  </div>
  </nav>
</body>
<script>
  let btn=document.getElementByid("mobileMenu");
  btn.addEventListener(onclick->{
    btn.classList.toggle()
  })
  </scirpt>
</html>