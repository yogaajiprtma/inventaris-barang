// preview image-------------------------------------------------------------------

let uploadButton = document.getElementById("upload-button");
let chosenImage = document.getElementById("chosen-image");
let fileName = document.getElementById("file-name");

uploadButton.onchange = () => {
  let reader = new FileReader();
  reader.readAsDataURL(uploadButton.files[0]);
  console.log(uploadButton.files[0]);
  reader.onload = () => {
    chosenImage.setAttribute("src",reader.result);
  }
  fileName.textContent = uploadButton.files[0].name;
}

function hilangPreview() {
  var j = document.getElementById("myPreview");
  j.style.display = "none";
}

function showPreview() {
  var j = document.getElementById("myPreview");
  j.style.display = "block";
}

// end preview image---------------------------------------------------------------

// show password--------------------------------------------------------------------

function showPasswordLama(p) {
  var pass = document.getElementById("password-lama");
  pass.setAttribute('type', 'text');
  p.innerHTML = '<i class="bi bi-eye-slash"></i>';
}

function hidePasswordLama(p) {
  var pass = document.getElementById("password-lama");
  pass.setAttribute('type', 'password');
  p.innerHTML = '<i class="bi bi-eye"></i>';
}

function showPasswordBaru(p) {
  var pass = document.getElementById("password-baru");
  pass.setAttribute('type', 'text');
  p.innerHTML = '<i class="bi bi-eye-slash"></i>';
}

function hidePasswordBaru(p) {
  var pass = document.getElementById("password-baru");
  pass.setAttribute('type', 'password');
  p.innerHTML = '<i class="bi bi-eye"></i>';
}

function showPasswordKonf(p) {
  var pass = document.getElementById("konfirmasi-password");
  pass.setAttribute('type', 'text');
  p.innerHTML = '<i class="bi bi-eye-slash"></i>';
}

function hidePasswordKonf(p) {
  var pass = document.getElementById("konfirmasi-password");
  pass.setAttribute('type', 'password');
  p.innerHTML = '<i class="bi bi-eye"></i>';
}

// end show password--------------------------------------------------------------

// avatar preview-----------------------------------------------------------------

function getPics() {}
const imgs = document.querySelectorAll('#myAvatar img');
const fullimage = document.querySelector('#fullimage');

imgs.forEach(img => {
  img.addEventListener('click', function () {
    fullimage.style.backgroundImage = 'url(' + img.src + ')';
    fullimage.style.display = 'block';
  });
});

// end avatar preview-------------------------------------------------------------