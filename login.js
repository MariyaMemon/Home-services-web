document.getElementById("loginLink").addEventListener("click", function(e) {
    e.preventDefault(); 
  
    document.getElementById("loginModal").style.display = "block";
  });
  
  document.getElementById("closeButton").addEventListener("click", function() {
    document.getElementById("loginModal").style.display = "none";
  });
  
  window.addEventListener("click", function(event) {
    if (event.target == document.getElementById("loginModal")) {
      document.getElementById("loginModal").style.display = "none";
    }
  })

  document.getElementById("signup").addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById("loginModal").style.display = "none";
  });

document.getElementById("signup").addEventListener("click",function(e){
  e.preventDefault();

  document.getElementById("signupModal").style.display = "block";
})
 
document.getElementById("closeSignupbtn").addEventListener("click", function(){
  document.getElementById("signupModal").style.display = "none";
})
window.addEventListener("click", function(event) {
  if (event.target == document.getElementById("signupModal")) {
    document.getElementById("signupModal").style.display = "none";
  }
}) 








  












