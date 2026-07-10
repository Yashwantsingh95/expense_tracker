<?php
require_once 'db.php';
$query = "SELECT * FROM expenses ORDER BY expense_date DESC, id DESC";
$result = mysqli_query($conn, $query);

$total_query = "SELECT SUM(amount) AS total FROM expenses";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_spent = $total_row['total'] ? $total_row['total'] : 0.00;

$total_items = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="container">
        <header>
            <h1><i class="fa-solid fa-wallet"></i> Expense Tracker</h1>
            <p>Apne daily expenses ko easily track karein.</p>
        </header>
        <div class="dashboard">
            <div class="card total-balance">
                <h3>Total Spent</h3>
                <div class="amount">₹<?php echo number_format($total_spent, 2); ?></div>
            </div>
            <div class="card income">
                <h3>Total Items</h3>
                <div class="amount"><?php echo $total_items; ?></div>
            </div>
        </div>
        <div class="main-content">
            <div class="form-section">
                <h2 class="section-title"><i class="fa-solid fa-plus-circle"></i> Add Expense</h2>
                
                <form id="expense-form" action="add_expense.php" method="POST">
                    
                    <div class="form-group">
                        <label for="title">Expense Title / Name</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="e.g., Lunch, Petrol, Rent" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (₹)</label>
                        <input type="number" id="amount" name="amount" step="0.01" class="form-control" placeholder="e.g., 250" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="Food">Food</option>
                            <option value="Bills">Bills & Utilities</option>
                            <option value="Shopping">Shopping</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Save Expense
                    </button>
                </form>
            </div>
            <div class="list-section">
                <h2 class="section-title"><i class="fa-solid fa-list-ul"></i> Expense History</h2>

                <div class="table-container">
                    <?php if ($total_items > 0): ?>
                        <table class="expense-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): 
                                    $cat_class = "badge-" . strtolower($row['category']);
                                ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                        <td><span class="badge <?php echo $cat_class; ?>"><?php echo htmlspecialchars($row['category']); ?></span></td>
                                        <td style="color: var(--text-muted); font-size: 0.85rem;">
                                            <?php echo date('d M, Y', strtotime($row['expense_date'])); ?>
                                        </td>
                                        <td class="amount-val">₹<?php echo number_format($row['amount'], 2); ?></td>
                                        <td>
                                            <a href="delete_expense.php?id=<?php echo $row['id']; ?>" class="btn-delete" title="Delete Expense">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-solid fa-receipt"></i>
                            <p>Koi expenses nahi hain. Naya expense add karein!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script src="app.js"></script>
</body>
</html>
