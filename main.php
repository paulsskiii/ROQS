<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
        <script src="main.js"></script>
        <!-- Header -->
        <h1 class="text-center py-3">Menu</h1>
        <?php
            // Include the database connection file
            include 'db_connection.php';

            // Fetch data from the database
            $sql = "SELECT customer_id, customer_name FROM customers";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<h2 class='m-3'>Hello " . $row["customer_name"] . "<br></h2>";
                }
            }
        ?>
        <!-- Search Bar-->
        <div class="input-group mb-3 px-3">
            <input type="text" class="form-control" placeholder="Search" oninput="searchItems()">
            <button type="button" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
        <!-- Filters -->
        <div class="mx-2 pb-3 overflow-auto d-flex flex-nowrap">
            <input type="radio" class="btn-check" name="options-outlined" id="1" onclick="filterItems('All')" checked>
            <label class="btn btn-outline-secondary mx-1" for="1">All</label>

            <input type="radio" class="btn-check" name="options-outlined" id="2" onclick="filterItems('appetizer')">
            <label class="btn btn-outline-secondary mx-1" for="2">Appetizers</label>

            <input type="radio" class="btn-check" name="options-outlined" id="3" onclick="filterItems('entrees')">
            <label class="btn btn-outline-secondary mx-1" for="3">Entrees</label>

            <input type="radio" class="btn-check" name="options-outlined" id="4" onclick="filterItems('sides')">
            <label class="btn btn-outline-secondary mx-1" for="4">Sides</label>

            <input type="radio" class="btn-check" name="options-outlined" id="5" onclick="filterItems('desserts')">
            <label class="btn btn-outline-secondary mx-1" for="5">Desserts</label>

            <input type="radio" class="btn-check" name="options-outlined" id="6" onclick="filterItems('beverages')">
            <label class="btn btn-outline-secondary mx-1" for="6">Beverages</label>
        </div>
        <!-- Items -->
        <div class="container p-3 overflow-auto d-flex flex-nowrap" role="group">
            <?php
            // Include the database connection file
            include 'db_connection.php';

            // Fetch data from the database
            $sql = "SELECT p.product_id, p.product_name, p.category_id, p.product_desc, p.price, p.product_image, c.category_name 
            FROM product p
            INNER JOIN category c
            ON p.category_id = c.category_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="flex-column pb-5">
                            <div class="card mx-2 shadow-sm" style="width: 18rem; min-height: 530px;">
                                <img src="' . $row["product_image"] . '" class="card-img-top">
                                <div class="card-body">
                                    <h1 class="card-title">' . $row["product_name"] . '</h1>
                                    <h5 class="card-title">' . $row["category_name"] . '</h5>
                                    <p class="card-text">' . $row["product_desc"] . '</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <h1>₱ ' . $row["price"] . '</h1>
                                    <button type="button" class="btn btn-primary order-btn" data-bs-toggle="modal" data-bs-target="#orderModal"
                                        data-item-id="' . $row["product_id"] . '"
                                        data-item-image="' . $row["product_image"] . '"
                                        data-item-name="' . $row["product_name"] . '"
                                        data-item-price="' . $row["price"] . '"
                                    >Order</button>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
        <!-- Order Modal -->
        <div class="modal fade" id="orderModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Order Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modalItemId" class="visually-hidden"></p>
                        <h1 class="modal-title pt-2" id="modalItemName"></h1>
                        <div class="input-group px-4 py-2 w-50 mx-auto">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-number" id="decrement">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </span>
                            <input type="text" class="form-control input-number" value="1" min="1" id="amount">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-number" id="increment">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </span>
                        </div>
                        <div class="form-floating my-3">
                            <textarea class="form-control" id="itemRequests" style="height: 100px"></textarea>
                            <label>Additional requests</label>
                        </div>
                        <h1 id="modalItemPrice"></h1>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" onclick="placeOrder()">Place Order</button>
                    </div>
                    <?php
                        // Include the database connection file
                        include 'db_connection.php';

                        // Fetch data from the database
                        $sql = "SELECT customer_id, customer_name FROM customers";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                // Store customer_id in a variable
                                $customer_id = $row['customer_id'];
            
                                // Output a hidden input with customer_id
                                echo '<input type="hidden" id="customerId" value="' . $customer_id . '">';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- Nav Bar -->
        <nav class="navbar bg-primary fixed-bottom p-2">
            <div class="container">
                <a href="main.php" class="btn btn-primary" role="button">
                    <i class="fa-solid fa-house mx-3" style="color: #ffffff;"></i>
                </a>
                <a href="cart.php" class="btn btn-primary" role="button">
                    <i class="fa-solid fa-cart-shopping mx-3" style="color: #ffffff;"></i>
                    <span class="position-relative">
                        <span class="badge bg-danger rounded position-absolute top-0 start-100 translate-middle">
                            <?php
                                // Include the database connection file
                                include 'db_connection.php';

                                // Query to count rows
                                $sql = "SELECT COUNT(customer_id) AS row_count FROM cart";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $count = $row["row_count"];
                                    // Display the badge with the dynamic count
                                    echo $count;
                                } else {
                                    echo "0 rows";
                                }
                            ?>
                        </span>
                    </span>
                </a>
            </div>
        </nav>
    </body>
</html>