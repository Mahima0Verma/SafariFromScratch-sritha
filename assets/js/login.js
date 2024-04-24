document.querySelectorAll(".otp-input").forEach(function (input, index) {
  input.addEventListener("keyup", function (e) {
      const currentInput = input,
          nextInput = input.nextElementSibling,
          prevInput = input.previousElementSibling;

      if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
          nextInput.removeAttribute("disabled");
          nextInput.focus();
      }

      if (e.key === "Backspace") {
          document.querySelectorAll(".otp-input").forEach(function (input, index1) {
              if (index <= index1 && prevInput) {
                  input.setAttribute("disabled", true);
                  prevInput.focus();
                  prevInput.value = "";
              }
          });
      }
      if (!document.querySelectorAll(".otp-input")[5].disabled && document.querySelectorAll(".otp-input")[5].value !== "") {
          document.querySelectorAll(".otp-input")[5].blur();
      }
  });
});


var globalFormData;
let email = document.getElementById("email");
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("I am called");

    // Create FormData object
    globalFormData = new FormData(this);
    globalFormData.append("email", email.value);

    sendOtp(globalFormData);
});
function sendOtp() {
  console.log("I am called again");
    fetch('./assets/php/login.php', {
            method: 'POST',
            body: globalFormData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle successful response
            console.log(data);
            if (data.success) {
                console.log("OTP sent successfully");
                timer(); // Call the timer function
                document.getElementById("loginForm").classList.add('d-none');
                document.getElementById("otpForm").classList.remove('d-none');
                document.getElementById("emailValue").value = email.value;
            }
            
        })
        .catch(error => {
            // Handle error
            console.error('There was a problem with the fetch operation:', error);
            alert("Error: " + error.message); // Display error message to the user
        });
}

document.getElementById("otpVerificationForm").addEventListener("submit",function(event){
  event.preventDefault();
  
  var formData = new FormData(this);
 
  var otpInputs = document.querySelectorAll(".otp-input");
    var isFilled = true;
    var otp = "";
    // Check if any OTP input field is empty
    otpInputs.forEach(function(input) {
        otp += input.value;
    });
  console.log(otp);
    // If any OTP input field is empty, prevent form submission
    if (otp.length<6) {
       
        alert("Please fill in all OTP fields.");
    }else{
  
  console.log("I am called");
    fetch('./assets/php/submit_otp.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        console.log(response);
        return response.text();
      })
      .then(data => {
        // Handle successful response
        console.log(data);
        var message=document.getElementById("otpResponse");
        message.textContent=data;
      });
    }   

})

let resend = document.getElementById("resendOtp");
resend.addEventListener("click",function(){
      clearOTPFields();
      sendOtp();
})

function clearOTPFields() {
    document.querySelectorAll(".otp-input").forEach(function(input) {
        input.value = ""; // Clear the value of each OTP input field
        input.setAttribute("disabled", true); // Disable the input field
    });

    // Focus on the first OTP input field after clearing
    document.querySelector(".otp-input").removeAttribute("disabled");
    document.querySelector(".otp-input").focus();
}

// one minute timer
function timer(){
    console.log("timer fnction called");
    let initialTimer = 59;
    let otpTimer = setInterval(function(){
        if(initialTimer==1){
            clearInterval(otpTimer);
        }
        initialTimer-=1;
        let value=initialTimer>9?`00:${initialTimer}`:`00:0${initialTimer}`

        document.getElementById("timeLeft").textContent = value;
    },1000)
}