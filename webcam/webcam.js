
var video = null,
	canvas = null,
	photo = null,
	startbutton = null,
	uploadbutton = null,
	resetbutton = null,
	streaming = false,
	canvasData = null,
	photoData = null,
	width = 400,
	height = 0;

function startup() {
	video        = document.querySelector('#video');
	canvas       = document.querySelector('#canvas');
	photo        = document.querySelector('#photo');
	startbutton  = document.getElementById('startbutton');
	uploadbutton = document.querySelector('#fileupload');
	resetbutton  = document.querySelector('#reset');

	navigator.mediaDevices.getUserMedia({video: true, audio: false})
	.then(function(stream) {
		video.srcObject = stream;
		video.play();
	})
	.catch(function(err) {
		console.log("An error occured: " + err);
	});

	video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
		
			if (isNaN(height)) {
				height = width / (4/3);
			}
		
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			photo.setAttribute('width', width);
			photo.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	startbutton.addEventListener('click', function(ev){
		takePicture();
		ev.preventDefault();
	}, false);

	clearphoto();
}

function clearphoto() {
	var context = canvas.getContext('2d');
	context.fillStyle = "#AAA";
	context.fillRect(0, 0, canvas.width, canvas.height);

	var data = canvas.toDataURL('image/png');
	photo.setAttribute('src', data);
}

function takePicture() {
	var context = canvas.getContext('2d');
	if (width && height) {
		canvas.width = width;
		canvas.height = height;
		context.drawImage(video, 0, 0, width, height);
	
		// var data = canvas.toDataURL('image/png');
		// photo.setAttribute('src', data);
	} else {
		clearphoto();
	}
}

window.addEventListener('load', startup, false);
 
// navigator.getMedia = ( navigator.getUserMedia ||
//                    navigator.webkitGetUserMedia ||
//                    navigator.mozGetUserMedia ||
//                    navigator.msGetUserMedia);

// navigator.getMedia(
//     {
//         video: true,
//         audio: false
//     },
//     function(stream) {
//         if (navigator.mozGetUserMedia) {
//             video.mozSrcObject = stream;
//         } else {
//             var vendorURL = window.URL || window.webkitURL;
//             video.src = vendorURL.createObjectURL(stream);
//         }
//         video.play();
//     },
//     function(err) {
//         console.log("An error occured! " + err);
//     }
// );


// video.addEventListener('canplay', function(ev){
//     if (!streaming) {
//         height = video.videoHeight / (video.videoWidth/width);
//         video.setAttribute('width', width);
//         video.setAttribute('height', height);
//         canvas.setAttribute('width', width);
//         canvas.setAttribute('height', height);
//         photo.setAttribute('width', width);
//         photo.setAttribute('height', height);
//         streaming = true;
//     }
// }, false);

// resetbutton.addEventListener('click', handleFiles);
uploadbutton.addEventListener('change', handleFiles);

function handleFiles(e) {
    canvas.width = width;
    canvas.height = height;
    // var img = new Image;
    var img = new Image();
    // img.src = URL.createObjectURL(e.target.files[0]);
    img.src = "C:\MAMP\htdocs\Camagru\Camagru\pics\photo\landscape.png";
    img.onload = function() {
        canvas.getContext('2d').drawImage(img, 0, 0, width, height);
        canvasData = canvas.toDataURL("image/png");
    };
}

// function takePicture() {
//     canvas.width = width;
//     canvas.height = height;
//     canvas.getContext('2d').drawImage(video, 0, 0, width, height);
//     canvasData = canvas.toDataURL("image/png");
// }

// function uploadPicture() {
//     if (!canvasData) {
//         document.getElementById("message").innerHTML = "Please take a picture !";
//     }
//     else {
//         var param = {
//             "data" : canvasData,
//             "sticker" : stickerData
//         };
//         var singleParam = createParam(param);
//         var xmlhttp = new XMLHttpRequest();
//         /* AJAX WITHOUT JQUERY */
//         xmlhttp.onreadystatechange = function() {
//             if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
//                 if (xmlhttp.status == 200 || xmlhttp.status == 201) {
//                     var data = xmlhttp.responseText;
//                     if (data == 'Success') {
//                         document.getElementById("message").innerHTML = "Pix uploaded in the gallery";
//                     }
//                     else {
//                         document.getElementById("message").innerHTML = "Fail";
//                     }
//                 }
//                 else {
//                     alert('Something Went Wrong - webcam');
//                 }
//             }
//         };
//         xmlhttp.open("POST", "testSave.php", true);
//         xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//         xmlhttp.send(singleParam);
//         /* AJAX WITHOUT JQUERY */
//     }
// }

/* PUT EVERYTHING ON A SINGLE PARAM FOR POST WITHOUT JQUERY */
// function createParam(param) {
//     var parameterString = "";
//     var isFirst = true;
//     for(var index in param) {
//         if(!isFirst) {
//             parameterString += "&";
//         }
//         parameterString += encodeURIComponent(index) + "=" + encodeURIComponent(param[index]);
//         isFirst = false;
//     }
//     return (parameterString);
// }