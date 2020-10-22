var sticker = null,
    stickers = document.querySelector('#stickers'),
    resetButton = document.querySelector("#reset"),
    finishButton = document.querySelector("#reset"),
    stickerList = document.querySelector('#stickers').getElementsByTagName('img');


// startbutton.addEventListener('click', function(ev){
//   if (sticker != null) {
//     takePicture();
//     ev.preventDefault();
//   }
//   else {
//     alert("THERE ARE NO STICKERS");
//   }
// }, false);

resetButton.addEventListener('click', function(ev){
  resetSticker();
  sticker = null;
  reset_canvas();
}, false);

finishButton.addEventListener('click', function(ev){
  if (sticker != null) {
    photoData = photo.toDataURL("image/png");
    uploadPicture();
    ev.preventDefault();
  }
  else {
    alert("THERE ARE NO STICKERS");
  }
}, false);

stickers.addEventListener('click', function(e){
if (e.target.id != "stickers") {
  if (sticker != null) {
    sticker.style.border = "none";
  }
  if (e.target == sticker) {
    sticker = null;
    resetSticker();
  }
  else {
    e.target.style.border = "5px solid black";
    sticker = e.target
    photo.width = canvas.width;
    photo.height = canvas.height;
    stickerImg = new Image();
    stickerImg.src = sticker.src;
    useSticker();
  }
}
});

// function reloadgallery(){
//   var xmlhttp = new XMLHttpRequest();
//   /* AJAX WITHOUT JQUERY */
//   xmlhttp.onreadystatechange = function() {
//     if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
//         if (xmlhttp.status == 200 || xmlhttp.status == 201) {
//             var data = xmlhttp.responseText;
//             document.getElementById("mini_gallery").innerHTML = data;
//         }
//         else {
//           alert('Something Went Wrong - Select');
//         }
//     }
//   };
//   xmlhttp.open("POST", "gallery/mini_gallery.php", true);
//   xmlhttp.send();
//   /* AJAX WITHOUT JQUERY */
// }

var refresh2 = setInterval(reloadgallery, 3000);
