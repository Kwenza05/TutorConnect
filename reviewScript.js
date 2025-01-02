  /* star rating section */
  document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('click', function() {
      const starContainer = this.parentElement; // Get the parent container of the stars
      const stars = starContainer.querySelectorAll('.star');
      const ratingDisplay = starContainer.nextElementSibling;
      const rating = this.getAttribute('data-value');
      
      // Reset all stars to inactive
      stars.forEach(s => s.classList.remove('active'));
      
      // Mark the clicked star and all preceding stars as active
      this.classList.add('active');
      let previous = this.previousElementSibling;
      while (previous) {
        previous.classList.add('active');
        previous = previous.previousElementSibling;
      }
  
      // Update the rating display
      ratingDisplay.innerText = `Rating: ${rating}`;
    });
  });
  