function toggleForm(type, event) {
  if (event) event.preventDefault();

  const form = document.getElementById("authForm");
  const button = document.getElementById("formButton");
  const text = document.getElementById("formText");

  const nameField = document.getElementById("nameField");
  const nameErr = document.getElementById("nameErr");
  const rememberField = document.getElementById("rememberField");

  if (type === "signup") {
    form.setAttribute("action", "process/signup_process.php");
    button.textContent = "Sign Up";

    nameField.style.display = "block";
    nameErr.style.display = "block";
    rememberField.style.display = "none";

    text.innerHTML = `Already have an account? 
        <a href="#" onclick="toggleForm('login', event)">Login</a>`;
  } else {
    form.setAttribute("action", "process/login_process.php");
    button.textContent = "Login";

    nameField.style.display = "none";
    nameErr.style.display = "none";
    rememberField.style.display = "flex";

    text.innerHTML = `Doesn't have an account? 
        <a href="#" onclick="toggleForm('signup', event)">Sign up</a>`;
  }
}


const slider = document.querySelector(".slider");
const images = document.querySelectorAll(".slider img");
const prevBtn = document.querySelector(".back-navigation");
const nextBtn = document.querySelector(".next-navigation");
const indexContainer = document.querySelector(".slider-index");

const passwordField = document.querySelector("#passwordField");

togglePassword.addEventListener("click", () => {
const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
passwordField.setAttribute("type", type);

togglePassword.classList.toggle("fa-eye-slash"); // ganti ikon kalau diklik
});

let currentIndex = 0;
const totalSlides = images.length;
let autoSlide;

// Generate index dots
images.forEach((_, i) => {
  const dot = document.createElement("div");
  dot.classList.add("dot");
  if (i === 0) dot.classList.add("active");
  dot.addEventListener("click", () => goToSlide(i));
  indexContainer.appendChild(dot);
});
const dots = document.querySelectorAll(".slider-index .dot");

function updateSlide() {
  slider.style.transform = `translateX(-${currentIndex * 100}%)`;
  dots.forEach((dot) => dot.classList.remove("active"));
  dots[currentIndex].classList.add("active");
}

function goToSlide(index) {
  currentIndex = index;
  updateSlide();
  resetAutoSlide();
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % totalSlides;
  updateSlide();
}

function prevSlide() {
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  updateSlide();
}

nextBtn.addEventListener("click", nextSlide);
prevBtn.addEventListener("click", prevSlide);

function startAutoSlide() {
  autoSlide = setInterval(nextSlide, 8000);
}

function resetAutoSlide() {
  clearInterval(autoSlide);
  startAutoSlide();
}

startAutoSlide();
