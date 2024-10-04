<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="style.css">
    <title>Easy Hire</title>
</head>
<?php 
    include("title_bar.php");
?>
<body>
    <div class="cont-body">
        <div class="categories">
            <div class="category-item">Photographer</div>
            <div class="category-item">Handyman</div>
            <div class="category-item">Tutor</div>
            <div class="category-item">Car Mechanic</div>
            <div class="category-item">Plumber</div>
            <div class="category-item">Tow Truck</div>
            <div class="category-item">Electrician</div>
            <div class="category-item">House Cleaner</div>
            <div class="category-item">Painter</div>
            <div class="category-item">Landscaper</div>
            <div class="category-item">Personal Trainer</div>
            <div class="category-item">Massage Therapist</div>
            <div class="category-item">Makeup Artist</div>
            <div class="category-item">Hairstylist</div>
            <div class="category-item">Event Planner</div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', function() {
                const category = this.innerHTML.trim();
                window.location.href = `search.php?q=${encodeURIComponent(category)}`;
            });
        });
    </script>
</body>
</html>
