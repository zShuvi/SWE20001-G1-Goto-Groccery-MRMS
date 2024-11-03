// FOR PASSWORD CHECKING
var myInput = document.getElementById("psw");
var length = document.getElementById("length");


// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}


// FOR DATE CHECKING
const currentDate = new Date();
const targetDate = new Date();
targetDate.setFullYear(currentDate.getFullYear() - 3);

// Format the date to YYYY-MM-DD
const formattedDate = targetDate.toISOString().split('T')[0];

document.getElementById("date_input").max = formattedDate;

