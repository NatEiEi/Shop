<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Filter List Item</title>
<style>
    /* CSS for Navbar */
    .navbar {
        background-color: #333;
        overflow: hidden;
    }

    .navbar a {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
    }

    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }

    .active {
        background-color: #4CAF50;
    }

    /* CSS for List Item */
    .list {
        padding: 20px;
    }

    .item {
        margin-bottom: 10px;
    }
</style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="#" class="navbtn" onclick="filterItems('home')">Home</a>
    <a href="#" class="navbtn active" onclick="filterItems('all')">All Items</a>
    <a href="#" class="navbtn" onclick="filterItems('electronic')">Electronic</a>
    <a href="#" class="navbtn" onclick="filterItems('food')">Food</a>
    <a href="#" class="navbtn" onclick="filterItems('water')">Water</a>
</div>

<!-- List Item -->
<div class="list" id="itemList">
    <div class="item electronic">Electronic Item 1</div>
    <div class="item food">Food Item 1</div>
    <div class="item water">Water Item 1</div>
    <div class="item electronic">Electronic Item 2</div>
    <div class="item food">Food Item 2</div>
    <div class="item water">Water Item 2</div>
    <div class="item electronic">Electronic Item 3</div>
    <div class="item food">Food Item 3</div>
    <div class="item water">Water Item 3</div>
</div>

<script>
function filterItems(category) {
    var navbtns = document.getElementsByClassName('navbtn');
    for (var i = 0; i < navbtns.length; i++) {
        navbtns[i].classList.remove('active');
    }
    event.target.classList.add('active');

    var items = document.getElementsByClassName('item');

    if (category === 'all') {
        // Show all items
        for (var i = 0; i < items.length; i++) {
            items[i].style.display = 'block';
        }
    } else {
        // Hide all items
        for (var i = 0; i < items.length; i++) {
            items[i].style.display = 'none';
        }
        // Show items with selected category
        var filteredItems = document.getElementsByClassName(category);
        for (var i = 0; i < filteredItems.length; i++) {
            filteredItems[i].style.display = 'block';
        }
    }
}
</script>

</body>
</html>
