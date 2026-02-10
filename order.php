<?php
include 'includes/header.php';
include 'includes/conn.php';

// Fetch all events for the dropdown
$sql = "SELECT event_name, price FROM events";
$result = $conn->query($sql);
$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Pre-select event if passed via URL
$selectedEvent = isset($_GET['event']) ? $_GET['event'] : '';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h1 class="text-center mb-4">Place Order</h1>
                        <p class="text-center text-muted">Hello, <span class="fw-bold"><?= htmlspecialchars($_SESSION['name']) ?></span></p>
                        
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger py-2 text-center">
                                <?php 
                                    if ($_GET['error'] == 'invalid_amount') echo "Please enter a valid quantity.";
                                    if ($_GET['error'] == 'order_failed') echo "Something went wrong. Please try again.";
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="alert alert-info text-center py-3">
                            <h4 class="mb-0">Price: <span class="fw-bold" id="priceDisplay">-- EUR</span> <small class="text-muted">/ ticket</small></h4>
                        </div>

                        <form action="order_process.php" method="post" class="mt-4">
                            <div class="mb-3">
                                <label for="event" class="form-label fw-semibold">Select Event</label>
                                <select class="form-select form-select-lg" name="event_name" id="event" required>
                                    <option value="" disabled <?= $selectedEvent === '' ? 'selected' : '' ?>>-- Choose an event --</option>
                                    <?php foreach ($events as $event): ?>
                                        <option value="<?= htmlspecialchars($event['event_name']) ?>" 
                                                data-price="<?= htmlspecialchars($event['price']) ?>"
                                                <?= $selectedEvent === $event['event_name'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($event['event_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control form-control-lg" name="amount" id="amount" min="1" value="1" required>
                            </div>

                            <p class="small text-muted italic">
                                <span class="text-danger fw-bold">Note:</span> Tickets are <span class="text-danger">not refundable</span>. Please use common sense.
                            </p>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">Confirm Order</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    const eventSelect = document.getElementById('event');
                    const priceDisplay = document.getElementById('priceDisplay');

                    function updatePrice() {
                        const selected = eventSelect.options[eventSelect.selectedIndex];
                        if (selected && selected.dataset.price) {
                            priceDisplay.textContent = selected.dataset.price + ' EUR';
                        } else {
                            priceDisplay.textContent = '-- EUR';
                        }
                    }

                    eventSelect.addEventListener('change', updatePrice);
                    // Set price on page load if event is pre-selected
                    updatePrice();
                </script>

            <?php else: ?>
                <div class="card border-danger shadow-sm mt-5">
                    <div class="card-body text-center p-5">
                        <h2 class="text-danger fw-bold">Access Denied</h2>
                        <p class="lead">You must be logged in to order tickets.</p>
                        <hr>
                        <a href="login.php" class="btn btn-outline-primary">Go to Login</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>