// Run when the page is loaded
window.onload = () => {
  // Show only the description at first
  showParagraph("description");
  highlightActiveLink("description");

  // Initialize the booking calculator
  initializeBookingCalculator();

  // If editing, calculate immediately if dates exist
  if (document.querySelector('input[name="trip_id"]')) {
    const checkInInput = document.getElementById("d1");
    const checkOutInput = document.getElementById("d2");
    if (checkInInput.value && checkOutInput.value) {
      calculateTotal();
    }
  }
};

// Paragraph switching functionality
const links = document.querySelectorAll("#part2 ul li a");
links.forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    const targetId = this.getAttribute("data-target");
    showParagraph(targetId);
    highlightActiveLink(targetId);
  });
});

function showParagraph(idToShow) {
  const paragraphs = document.querySelectorAll("#change p");
  paragraphs.forEach((p) => {
    p.classList.toggle("active", p.id === idToShow);
    p.classList.toggle("hidden", p.id !== idToShow);
  });
}

function highlightActiveLink(idToHighlight) {
  const links = document.querySelectorAll("#part2 ul li a");
  links.forEach((link) => {
    link.classList.toggle("active-link", link.getAttribute("data-target") === idToHighlight);
  });
}

// FAQ section toggle
const titles = document.querySelectorAll("#fleche .titre");
titles.forEach((title) => {
  title.addEventListener("click", () => {
    const container = title.parentElement;
    const paragraph = container.querySelector("p");
    paragraph.classList.toggle("hidden");
    paragraph.classList.toggle("active");

    const arrow = title.querySelector(".arrow");
    const question = title.querySelector(".t1");
    arrow.classList.toggle("rotated");
    arrow.classList.toggle("active-toggle");
    question.classList.toggle("active-toggle");
  });
});

// Booking Calculator Functionality
function initializeBookingCalculator() {
  // Constants
  const BASE_PRICE = 200;
  const SERVICE_FEE = 15;
  const EXTRA_FEE_ADULTE = 15;
  const PET_FEE = 10;
  const PARKING_FEE = 10;
  const PILLOW_FEE = 2;
  const CHILD_FEE = 150;
  const BABY_FEE = 50;

  // DOM Elements
  const checkInInput = document.getElementById("d1");
  const checkOutInput = document.getElementById("d2");
  const travelerSelect = document.querySelector("#guest select");
  const petCheckbox = document.querySelector('#extra input[name="pet"]');
  const parkingCheckbox = document.querySelector('#extra input[name="parking"]');
  const pillowCheckbox = document.querySelector('#extra input[name="pillow"]');
  const nightsElement = document.getElementById("number");
  const discountElement = document.getElementById("discount");
  const totalElement = document.getElementById("totale");
  const nightsHiddenInput = document.getElementById("nights-hidden");
  const checkInHidden = document.getElementById("check_in_hidden");
  const checkOutHidden = document.getElementById("check_out_hidden");

  // Calculate nights between dates
  function getNights(start, end) {
    const oneDay = 1000 * 60 * 60 * 24;
    const startDate = new Date(start);
    const endDate = new Date(end);
    const diffTime = Math.max(0, endDate - startDate);
    return Math.ceil(diffTime / oneDay);
  }

  // Main calculation function
  function calculateTotal() {
    const checkInDate = checkInInput.value;
    const checkOutDate = checkOutInput.value;

    if (!checkInDate || !checkOutDate) return;

    const nights = getNights(checkInDate, checkOutDate);
    const basePrice = BASE_PRICE * nights;
    const discount = basePrice * 0.2;
    let total = basePrice - discount + SERVICE_FEE;

    // Calculate traveler costs
    const travelerOption = travelerSelect.value;
    if (travelerOption.includes("2 Adultes")) {
      total += EXTRA_FEE_ADULTE * 2;
      if (travelerOption.includes("1 bébé")) total += BABY_FEE;
      if (travelerOption.includes("1 enfant")) total += CHILD_FEE;
    } else {
      total += EXTRA_FEE_ADULTE;
    }

    // Add extra features
    if (petCheckbox.checked) total += PET_FEE;
    if (parkingCheckbox.checked) total += PARKING_FEE;
    if (pillowCheckbox.checked) total += PILLOW_FEE;

    // Update displays
    nightsElement.textContent = `${basePrice}$`;
    discountElement.textContent = `${discount.toFixed(2)}$`;
    totalElement.textContent = `${total.toFixed(2)}$`;

    // Update hidden fields
    if (nightsHiddenInput) nightsHiddenInput.value = nights;
    if (checkInHidden) checkInHidden.value = checkInDate;
    if (checkOutHidden) checkOutHidden.value = checkOutDate;
    
    // Update the total price hidden field
    const totalHidden = document.getElementById("total_price_hidden");
    if (totalHidden) {
        totalHidden.value = total.toFixed(2);
    }
  }

  // Set up event listeners
  const elementsToWatch = [
    checkInInput, 
    checkOutInput, 
    travelerSelect, 
    petCheckbox, 
    parkingCheckbox, 
    pillowCheckbox
  ];
  
  elementsToWatch.forEach((el) => {
    if (el) el.addEventListener("change", calculateTotal);
  });

  // Date validation
  if (checkInInput && checkOutInput) {
    const today = new Date().toISOString().split("T")[0];
    checkInInput.setAttribute("min", today);

    checkInInput.addEventListener("change", () => {
      if (checkInInput.value) {
        checkOutInput.setAttribute("min", checkInInput.value);
        if (checkOutInput.value && checkOutInput.value <= checkInInput.value) {
          alert("Check-out date must be after check-in date.");
          checkOutInput.value = "";
        }
        calculateTotal();
      }
    });

    checkOutInput.addEventListener("change", () => {
      if (checkInInput.value && checkOutInput.value <= checkInInput.value) {
        alert("Check-out date must be after check-in date.");
        checkOutInput.value = "";
      }
      calculateTotal();
    });

    // Initialize calculation if dates exist (for edit mode)
    if (checkInInput.value && checkOutInput.value) {
      calculateTotal();
    }
  }
}

// Form submission handler
document.addEventListener("DOMContentLoaded", () => {
  const bookForm = document.getElementById("booking-form");
  if (bookForm) {
    bookForm.addEventListener("submit", (e) => {
      const checkInInput = document.getElementById("d1");
      const checkOutInput = document.getElementById("d2");
      
      if (!checkInInput.value || !checkOutInput.value) {
        e.preventDefault();
        alert("Please select both check-in and check-out dates");
        return;
      }

      const checkInDate = new Date(checkInInput.value);
      const checkOutDate = new Date(checkOutInput.value);
      
      if (checkOutDate <= checkInDate) {
        e.preventDefault();
        alert("Check-out date must be after check-in date");
      }
    });
  }
});