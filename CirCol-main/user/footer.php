<!DOCTYPE html>
<html lang="en">
<head>
  <title>Footer Design</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

  <style>
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
	body{
		line-height: 1.5;
		font-family: 'Poppins', sans-serif;
	}
	*{
		margin:0;
		padding:0;
		box-sizing: border-box;
	}
	.container{
		max-width: 1350px;
		margin:auto;
	}
	.row{
		display: flex;
		flex-wrap: wrap;
	}
	ul{
		list-style: none;
	}
	.footer{
		background-color: #24262b;
        margin-top: 150px;
	}
	.footer-col{
		width: 25%;
		padding: 0 15px;
	}
	.footer-col h4{
		font-size: 18px;
		color: #ffffff;
		text-transform: capitalize;
		margin-bottom: 35px;
		font-weight: 500;
		position: relative;
	}
	.footer-col h4::before{
		content: '';
		position: absolute;
		left:0;
		bottom: -10px;
		background-color: #e91e63;
		height: 2px;
		box-sizing: border-box;
		width: 50px;
	}
	.footer-col ul li:not(:last-child){
		margin-bottom: 10px;
	}
	.footer-col ul li a{
		font-size: 16px;
		text-transform: capitalize;
		color: #ffffff;
		text-decoration: none;
		font-weight: 300;
		color: #bbbbbb;
		display: block;
		transition: all 0.3s ease;
        text-align: left;
	}
	.footer-col ul li a:hover{
		color: #ffffff;
		padding-left: 8px;
	}
	.footer-col .social-links a{
		display: inline-block;
		height: 40px;
		width: 40px;
		background-color: rgba(255,255,255,0.2);
		margin:0 10px 10px 0;
		text-align: center;
		line-height: 40px;
		border-radius: 50%;
		color: #ffffff;
		transition: all 0.5s ease;
	}
	.footer-col .social-links a:hover{
		color: #24262b;
		background-color: #ffffff;
	}

	/*responsive*/
	@media(max-width: 767px){
		.footer-col{
			width: 50%;
			margin-bottom: 30px;
		}
	}
	@media(max-width: 574px){
		.footer-col{
			width: 100%;
		}
	}
    .foot-p{
        color: #f5780f;
        font-weight: 600;
    }
  </style>
</head>
<body>
  <footer class="footer">
  	 <div class="container">
  	 	<div class="row">
  	 		<div class="footer-col">
  	 			<h4>CirCol</h4>
  	 			<ul>
  	 				<li><a href="about.php"><p class="foot-p">about us</p></a></li>
                    <li><a href="#">A Centralized Ecommerce Platform for  Bicol University UBO’s, CBO’s, and DBO’s Merchandise</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>GET HELP</h4>
  	 			<ul>
  	 				<li><a href="contactus.php"><p class="foot-p">Contact Us</p></a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>SHOPS</h4>
  	 			<ul>
  	 				<li><a href="#"><p class="foot-p">View Shops</p></a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>follow us</h4>
  	 			<div class="social-links">
  	 				<a href="#"><i class="fab fa-facebook-f"></i></a>
  	 				<a href="#"><i class="fab fa-twitter"></i></a>
  	 				<a href="#"><i class="fab fa-instagram"></i></a>
  	 				<a href="#"><i class="fab fa-linkedin-in"></i></a>
  	 			</div>
  	 		</div>
  	 	</div>
  	 </div>
  </footer>

</body>
</html>
