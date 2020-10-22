var photo = document.querySelector('#photo'),
    stickerCtx = photo.getContext('2d'),
    stickerX = 480,
    stickerY = 360,
    stickerImg = null;

function useSticker(){
  if (sticker) {
    resetSticker();
    stickerCtx.drawImage(stickerImg, stickerX - 100, stickerY - 100, 200, 200);
  }
}

  function resetSticker() {
    stickerCtx.clearRect(0, 0, width, height);
  }

  function reset_canvas(){
    canvas.getContext('2d').clearRect(0, 0, width, height);
    canvasData = null;
    uploadbutton.value = "";
  }

  function myDown(e){
  if (e.pageX < stickerX + 100 + photo.offsetLeft && e.pageX > stickerX - 100 +
    photo.offsetLeft && e.pageY < stickerY + 100 + photo.offsetTop &&
  e.pageY > stickerY - 100 + photo.offsetTop){
    stickerX = e.pageX - photo.offsetLeft;
    stickerY = e.pageY - photo.offsetTop;
    dragok = true;
    photo.onmousemove = myMove;
    }
  }

  function myMove(e){
   if (dragok){
    stickerX = e.pageX - photo.offsetLeft;
    stickerY = e.pageY - photo.offsetTop;
   }
  }

  function myUp(){
  dragok = false;
  canvas.onmousemove = null;
  }

var rfrsh =   setInterval(useSticker, 10);
photo.onmousedown = myDown;
photo.onmouseup = myUp;
