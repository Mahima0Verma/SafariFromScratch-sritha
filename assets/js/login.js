document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("I am called");
    
    var formData = new FormData(this);
    
    fetch('./assets/php/login.php', {
        method: 'POST',
        body: formData
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
      })
      .catch(error => {
        // Handle error
        console.error('There was a problem with the fetch operation:', error);
      });
      
});
