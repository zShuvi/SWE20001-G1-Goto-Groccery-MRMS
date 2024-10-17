
function searchStock() {
    var searchQuery = document.getElementById('search').value;

    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    
    // Define the callback function to update search results
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('search-results').innerHTML = xhr.responseText;
        }
    };

    // Send the AJAX request with the search query to the same page (AdminProduct.php)
    xhr.open("GET", "AdminProduct.php?search=" + searchQuery, true);
    xhr.send();
}
