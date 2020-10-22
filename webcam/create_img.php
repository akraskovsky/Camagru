<?php
  include '../config/db_connection.php';
//   include 'gallery/gallery.php';

//   create_db();
  session_start();
//   if (!$_SESSION["username"])
//     header('Location: ../login/login.php');
?>

<html>
<head>
	<title> Camagru </title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta charset="UTF-8">
</head>
<body>
	<header>
		<div class="logo">CAMAGRU</div>
    	<div class="username">
			<?php 
                if (isset($_SESSION['name'])) {
                    echo ('<div><a href="../login/edit_account.php"><img src="../pics/avatar-white.png" height=24></a></div>');
                    echo ('<div><a href="../login/edit_account.php">' . $_SESSION['name'] . '</a></div>');
                    echo ('<div id="newpic_btn"><a href="../index.php">See Gallery</a></div>');
                }
                else {
                    echo ('<a href="login/login.php">LogIn</a>');
                }
            ?>
        </div>
	</header>
    <div id="message"></div>

  	<div class="composer">
		<div id="camera">
			<video id="video">Video stream not available</video>
			<canvas id="canvas">Please Use a html5 compatible Browser</canvas>
		</div>
		<div class="output">
			<img id="photo" alt="Capture">
		</div>
	</div>

	<button id="startbutton">Take a picture</button>
	<input type="file" id="fileupload" accept="image/*" />
	<button id="reset">reset</button>
	<button id="finish">finish</button>
	<div id="stickers">
		<img id="sticker4" src="../pics/stickers/balloons.png" draggable="true"></img>
		<img id="sticker1" src="../pics/stickers/wanted.png" draggable="true"></img>
		<img id="sticker2" src="../pics/stickers/monster.png" draggable="true"></img>
		<img id="sticker3" src="../pics/stickers/fireborder.png" draggable="true"></img>
	</div>

	<div class="footer">
		<p>camagru by fprovolo</p>
	</div>

	<script type="text/javascript" src="webcam.js"></script>
	<!-- <script type="text/javascript" src="select.js"></script> -->
	<!-- <script type="text/javascript" src="sticker.js"></script> -->
</body>
</html>