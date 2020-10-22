var streaming = false,
    video        = document.querySelector('#video'),
    canvas       = document.querySelector('#canvas'),
    startbutton  = document.querySelector('#startbutton'),
    uploadbutton = document.querySelector('#fileupload'),
    // finishbutton = document.querySelector('#finish'),
    canvasData   = null,
    photoData = null,
    width = 960,
    height = 720;


navigator.getMedia = ( navigator.getUserMedia ||
                   navigator.webkitGetUserMedia ||
                   navigator.mozGetUserMedia ||
                   navigator.msGetUserMedia);

navigator.getMedia(
    {
        video: true,
        audio: false
    },
    function(stream) {
        if (navigator.mozGetUserMedia) {
            video.mozSrcObject = stream;
        } else {
            var vendorURL = window.URL || window.webkitURL;
            video.src = vendorURL.createObjectURL(stream);
        }
        video.play();
    },
    function(err) {
        console.log("An error occured! " + err);
    }
);


video.addEventListener('canplay', function(ev){
    if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        photo.setAttribute('width', width);
        photo.setAttribute('height', height);
        streaming = true;
    }
}, false);

uploadbutton.addEventListener('change', handleFiles);

function handleFiles(e) {
    canvas.width = width;
    canvas.height = height;
    var img = new Image;
    img.src = URL.createObjectURL(e.target.files[0]);
    img.onload = function() {
        canvas.getContext('2d').drawImage(img, 0, 0, width, height);
        canvasData = canvas.toDataURL("image/png");
    };
}

function takePicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    canvasData = canvas.toDataURL("image/png");
}

function uploadPicture() {
    if (!canvasData) {
        document.getElementById("message").innerHTML = "Please take a picture !";
    }
    else {
        var param = {
            "data" : canvasData,
            "sticker" : photoData
        };
        var singleParam = createParam(param);
        var xmlhttp = new XMLHttpRequest();
        /* AJAX WITHOUT JQUERY */
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
                if (xmlhttp.status == 200 || xmlhttp.status == 201) {
                    var data = xmlhttp.responseText;
                    if (data == 'Success') {
                        document.getElementById("message").innerHTML = "Pix uploaded in the gallery";
                    }
                    else {
                        document.getElementById("message").innerHTML = "Fail";
                    }
                }
                else {
                    alert('Something Went Wrong - webcam');
                }
            }
        };
        xmlhttp.open("POST", "testSave.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(singleParam);
        /* AJAX WITHOUT JQUERY */
    }
}

/* PUT EVERYTHING ON A SINGLE PARAM FOR POST WITHOUT JQUERY */
function createParam(param) {
    var parameterString = "";
    var isFirst = true;
    for(var index in param) {
        if(!isFirst) {
            parameterString += "&";
        }
        parameterString += encodeURIComponent(index) + "=" + encodeURIComponent(param[index]);
        isFirst = false;
    }
    return (parameterString);
}