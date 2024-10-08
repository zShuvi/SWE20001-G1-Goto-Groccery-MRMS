const body = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar"),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");

// Check sessionStorage for saved dark mode preference
if (sessionStorage.getItem('darkMode') === 'enabled') {
    body.classList.add("dark");
    modeText.innerText = "Light Mode"; // Adjust text if dark mode is enabled
}

// Toggle sidebar visibility
toggle.addEventListener("click", () =>{
    sidebar.classList.toggle("close");
});

// Open sidebar when search is clicked
searchBtn.addEventListener("click", () =>{
    sidebar.classList.remove("close");
});

// Toggle dark mode and save the preference
modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");

    if (body.classList.contains("dark")) {
        modeText.innerText = "Light Mode";
        sessionStorage.setItem('darkMode', 'enabled'); // Save dark mode preference
    } else {
        modeText.innerText = "Dark Mode";
        sessionStorage.setItem('darkMode', 'disabled'); // Save light mode preference
    }
});
