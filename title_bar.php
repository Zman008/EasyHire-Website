<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="style.css">
    <title>Easy Hire</title>
</head>
<body>
    <nav class="nav-bar">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">
                    <span class="logo-easy">Easy</span><span class="logo-hire">Hire</span>
                </a>
            </div>
            
            <div class="search-bar">
                <span class="search-icon material-symbols-outlined">search</span>
                <form action="search.php" method="get" style="width: 100%;">
                    <input class="search-input" type="search" name="q" placeholder="Search Here">
                </form>
            </div>

            <div class="nav-side-buttons">
                <div id="location-button" class="location-button">
                    Select Location
                </div>

                <div class="dropdown-content" id="dropdown">
                    <div data-location="All">All</div>
                    <div data-location="Badda">Badda</div>
                    <div data-location="Banani">Banani</div>
                    <div data-location="Baridhara">Baridhara</div>
                    <div data-location="Bashundhara">Bashundhara</div>
                    <div data-location="Dhanmondi">Dhanmondi</div>
                    <div data-location="Gulshan">Gulshan</div>
                    <div data-location="Khilgaon">Khilgaon</div>
                    <div data-location="Mirpur">Mirpur</div>
                    <div data-location="Mohammadpur">Mohammadpur</div>
                    <div data-location="Rampura">Rampura</div>
                    <div data-location="Uttara">Uttara</div>
                </div>

                <a href="check_login.php">
                    <div class="login-button">
                        <img src="img/account.png" alt="Login">
                    </div>
                </a>
            </div>
        </div>
    </nav>
    
    <script>
        // JavaScript to show/hide dropdown menu
        const locationButton = document.getElementById("location-button");
        const dropdown = document.getElementById("dropdown");

        locationButton.addEventListener("click", function () {
            // Toggle the display property of the dropdown menu
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";

            // Position the dropdown right below the location button
            const rect = locationButton.getBoundingClientRect();
            dropdown.style.top = `${rect.bottom + window.scrollY}px`;
            dropdown.style.left = `${rect.left + window.scrollX}px`;
        });

        // Close the dropdown if the user clicks outside of it
        window.addEventListener("click", function (event) {
            if (!locationButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });

        // JavaScript to handle location selection and store it in session
        const locationLinks = document.querySelectorAll('.dropdown-content div');
        locationLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const location = this.getAttribute('data-location');
                document.cookie = "region=" + location + "; path=/";
                alert('Location set to ' + location);
                dropdown.style.display = "none";
                window.location.reload();
            });
        });
    </script>
</body>
</html>