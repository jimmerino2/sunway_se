<?php include 'components/menuItemDetails.php'; ?>
<?php include 'components/toast.html'; ?>
<script src="../js/common.js"></script>
<script src="components/ItemMenu.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Get table number from URL
    if (!localStorage.getItem('table_no')) {
        const urlParams = new URLSearchParams(window.location.search);
        const tableNumber = urlParams.get('table_no') ?? 1; 
        localStorage.setItem('table_no', tableNumber);   
        const newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    } 
    
    (async () => {
        const categoryResponse = await getApiResponse('http://localhost/software_engineering/backend/category');
        const categoryData = categoryResponse.data;
    
        // Genre Selection
        const selectGenre = document.getElementById('select-genre');
        const genreDefaultOption = document.createElement("option");
        genreDefaultOption.value = "";
        genreDefaultOption.textContent = "All";
        selectGenre.appendChild(genreDefaultOption);
        categoryData.forEach(category => {
            const option = document.createElement("option");
            option.value = category.id;
            option.textContent = category.name;
            selectGenre.appendChild(option);
        });

        selectGenre.addEventListener('change', async (event) => { 
            const selectedGenreId = event.target.value;
            let filteredUrl = 'http://localhost/software_engineering/backend/item'
            if(selectedGenreId != '') {
                filteredUrl += "?category_id=" + selectedGenreId; 
            } 
            itemResponse = await getApiResponse(filteredUrl);
            itemData = itemResponse.data;
            generateItems(itemData);
        });

        // Product Generation
        const containerItem = document.getElementById('container-item');
        function generateItems (itemData) {
            containerItem.innerHTML = "";
            itemData.forEach(item => {
                const itemDiv = ItemMenu(item);
                containerItem.appendChild(itemDiv);
            });
        }
        let itemResponse = await getApiResponse('http://localhost/software_engineering/backend/item');
        let itemData = itemResponse.data
        generateItems(itemData);
    })();
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Cakeaway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> 
    <link href="../css/customer.css" rel="stylesheet"> 
</head>
<body>
    <?php include 'components/header.html'?>

    <!-- Header -->
    <header class="bg-dark text-white text-center">
        <div class="container px-4 px-lg-5 my-5">
            <h1 class="display-5 fw-bolder">Welcome to Cakeaway</h1>
            <p class="lead fw-normal text-white-50 mb-0">Delicious Cakes & Refreshing Drinks Await</p>
        </div>
    </header>
    
    <!-- Genre Dropdown -->
    <section class="py-4">
        <div class="container px-4 px-lg-5 d-flex justify-content-start">
            <form method="GET" class="d-flex align-items-center">
                <label for="genre" class="me-2 fw-bold fs-5">Genre:</label>
                <select id="select-genre" name="genre" id="genre" class="form-select">
                </select>
            </form>
        </div>
    </section>

    <!-- Product Section -->
    <section class="py-2" style="flex-grow:1;">
        <div class="container px-3 px-lg-4">
            <div id="container-item" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"></div>
        </div>
    </section>

    <?php include 'components/footer.html'?>
</body>
</html>
