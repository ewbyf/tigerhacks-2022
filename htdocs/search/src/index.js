function createCountdown(date){
  var x = setInterval(function() {
    var now = new Date().getTime();
    var datetime = new Date(date).getTime() * 1000 + (3 * 1000 * 60 * 60);

    var distance = datetime - now;
    
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("clock").textContent = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

    if (distance < 0) {
      clearInterval(x);
      document.getElementById("clock").textContent = "EXPIRED You must pay a fee.";

    }
  }, 1000);
}