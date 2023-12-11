<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="staff_index.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="categories.php">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inventory.php">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="items.php">Items</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="accounts.php">Accounts</a>
                        </li>
                    </ul>
                    <div class="navbar-text me-2">
                        <a class="nav-link" href="login.php">Logout</a>
                    </div>
                </div>       
            </div>
        </nav>
        <!-- Inventory Table -->
        <div class="container mt-5">
            <h2 class="pb-3">Inventory</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Inventory ID</th>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Item Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                // Include the database connection file
                include 'db_connection.php';

                // Fetching data from categories table
                $sql = "SELECT inventory.inventory_id, inventory.item_id, items.item_name, inventory.item_stock 
                        FROM inventory 
                        INNER JOIN items ON inventory.item_id = items.item_id";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["inventory_id"] . "</td>";
                        echo "<td>" . $row["item_id"] . "</td>";
                        echo "<td>" . $row["item_name"] . "</td>";
                        echo "<td>" . $row["item_stock"] . "</td>";
                        echo "<td>
                            <a href='edit_inventory.php?id=" . $row["inventory_id"] . "' class='btn btn-primary btn-sm'>Edit</a>
                            <a href='delete_inventory.php?id=" . $row["inventory_id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No inventory items found</td></tr>";
                }
                $conn->close();
                ?>

                </tbody>
            </table>
            <div class="mb-3">
                <a href="add_inventory.php" class="btn btn-success">Add Item</a>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
    </body>
</html>