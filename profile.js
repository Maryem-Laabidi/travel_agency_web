// profile.js - FINAL UPDATED VERSION

document.addEventListener('DOMContentLoaded', function () {
  // Toggle profile dropdown visibility
  function toggleProfile() {
      const dropdown = document.getElementById('profileDropdown');
      if (!dropdown) {
          console.error('Profile dropdown element not found!');
          return;
      }

      // Toggle display
      dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
  }

  // Handle click on profile icon
  const profileIcon = document.querySelector('#l4 a');
  if (profileIcon) {
      profileIcon.addEventListener('click', function (e) {
          const dropdown = document.getElementById('profileDropdown');

          // Only toggle dropdown if user is logged in (dropdown exists)
          if (dropdown) {
              e.preventDefault(); // Prevent link navigation
              toggleProfile();
          }
          // If dropdown doesn't exist, do nothing — link will redirect normally to login.php
      });
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function (event) {
      const dropdown = document.getElementById('profileDropdown');
      if (!dropdown) return;

      const isClickInside = event.target.closest('#l4') ||
          event.target.closest('.profile-dropdown');

      if (!isClickInside && dropdown.style.display === 'block') {
          dropdown.style.display = 'none';
      }
  });
});
