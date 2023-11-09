<?php
include_once 'header.php';
?>


<!DOCTYPE html>
<html>
<head>
  
  <title>uyaTRAVEL</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway:600,900" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
  .gallery-image {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
  }

  .img-box {
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease; 
  }

  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }

  .coming-soon {
    font-size: 24px;
    font-weight: bold;
    color: #ff7f50;
    animation: pulse 1s infinite;
  }

  .img-box img {
    width: 100%;
    height: auto;
  }

  .img-box:hover img {
    color: white;
    transform: scale(1.05);
  }

  /* Apply hover effect as default on smaller screens */
  @media (max-width: 767px) {
    .img-box img {
      transform: scale(1.05);
    }

    .img-box:hover img {
      transform: scale(1.05);
    }
  }

  .caption p {
    color: white;
    font-weight: 90%;
  }
</style>


</head>
<body>
  <br><br><br><br>
  <center><h2>OUR DEALS</h2></center><br>
  <center><p>Here are some of our deals in partnership with Travel Bella</p></center><br>
  <hr>
  <div class="gallery-image">
  <a href="description.php">
      <div class="img-box">
        <img src="images/IMG-20230825-WA0000.jpg" alt=""  />
        <div class="transparent-box">
          <div class="caption" >
            <p>BELLA CRUISE</p>
            <p class="opacity-low">MSC CRUISE</p>
          </div>
        </div> 
      </div>
    </a>
    <!-- Add more img-box elements here -->
    
    <!-- Example img-box element -->
    <a href="description 2.php">
      <div class="img-box">
        <img src="images/IMG-20230825-WA0001.jpg" alt=""  />
        <div class="transparent-box">
          <div class="caption" >
            <p>BELLA CRUISE</p>
            <p class="opacity-low">MSC CRUISE</p>
          </div>
        </div> 
      </div>
    </a>

    <a href="description 3.php">
      <div class="img-box">
        <img src="images/IMG-20230825-WA0002.jpg" alt=""  />
        <div class="transparent-box">
          <div class="caption" >
            <p>BELLA CRUISE</p>
            <p class="opacity-low">MSC CRUISE</p>
          </div>
        </div> 
      </div>
    </a>

    <a href="description 4.php">
      <div class="img-box">
        <img src="images/IMG-20230825-WA0003.jpg" alt="" />
        <div class="transparent-box">
          <div class="caption">
            <p>BELLA CRUISE</p>
            <p class="opacity-low">MSC CRUISE</p>
          </div>
        </div>
      </div>
    </a>
  </div>

  <br>
  <center>
    <h2>Other Deals:</h2><br><hr><br><br><br><br>
    
    <h2 class="coming-soon">Coming Soon!</h2>
    <h2 >We currently do not have international deals at the momment. You're welcome to sign up for our newsletter.</h2>
    
    <br><br><br><br>
  </center>
</body>
<footer>
  <?php
  require 'includes/footer.php';
  ?> 
</footer>
</html>