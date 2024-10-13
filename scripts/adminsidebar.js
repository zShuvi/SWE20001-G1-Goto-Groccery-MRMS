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

// Check sessionStorage for sidebar state
if (sessionStorage.getItem('sidebar_closed') === 'enabled') {
    sidebar.classList.add("close");
} else {
    sidebar.classList.remove("close"); // Make sure to remove 'close' class if it's not enabled
}

// Toggle sidebar visibility
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");

    // Update sessionStorage based on the sidebar's state
    if (sidebar.classList.contains("close")) {
        sessionStorage.setItem('sidebar_closed', 'enabled');
    } else {
        sessionStorage.setItem('sidebar_closed', 'disabled');
    }
});

// Open sidebar when search is clicked
searchBtn.addEventListener("click", () =>{
    sidebar.classList.remove("close");
    sessionStorage.setItem('sidebar_closed', 'disabled');
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
