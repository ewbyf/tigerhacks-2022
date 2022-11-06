function toggleForm() {
  document.getElementsByClassName("blur")[0].classList.toggle("toggle");
}

function checkin(license, state) {
  return true;
}

function remove(license, state) {
  let text;
  text = "removed" + license + state;
  document.getElementById("rem").innerHTML = text;

}
