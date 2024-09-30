

window.onload = function() {
    document.getElementById('cantidad').value = 1;
}

var slides = document.querySelectorAll('#slides .slide');
var currentSlide = 0;
function nextSlide() {
    slides[currentSlide].className = 'slide';
    currentSlide = (currentSlide+1)%slides.length;
    slides[currentSlide].className = 'slide showing';
}

function previousSlide(){
slides[currentSlide].className = 'slide';
    currentSlide = (currentSlide+slides.length-1)%slides.length;
    slides[currentSlide].className = 'slide showing';
}

document.getElementById("left").onclick = function(){
previousSlide();
};
document.getElementById("right").onclick = function(){
nextSlide();
};


function atras() {

    window.location.href = '/';
}

function redirigir() {

    window.location.href= '/producto';


}





