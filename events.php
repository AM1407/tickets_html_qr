<?php
include 'includes/header.php';
include 'includes/conn.php';

// Fetch events from database
$sql = "SELECT event_name, price, event_date FROM events LIMIT 6";
$result = $conn->query($sql);
$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>

<style>
    body {
        overflow: hidden;
    }

    .events-container {
        height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        padding: 0 2rem;
    }

    .events-title {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .events-title h1 {
        font-weight: 800;
        font-size: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.25rem;
    }

    .events-title p {
        color: #6c757d;
        font-size: 0.95rem;
        margin: 0;
    }

    .events-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 1.25rem;
        flex: 1;
        min-height: 0;
    }

    .event-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(118, 75, 162, 0.15);
    }

    .event-card-img {
        flex: 1;
        min-height: 0;
        background: linear-gradient(135deg, #e0e7ff 0%, #ede9fe 50%, #fce7f3 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .event-card-img i {
        font-size: 2.5rem;
        color: rgba(118, 75, 162, 0.3);
    }

    .event-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-card-body {
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 2px solid rgba(102, 126, 234, 0.1);
    }

    .event-info h5 {
        font-weight: 700;
        font-size: 0.95rem;
        color: #212529;
        margin: 0 0 0.15rem 0;
    }

    .event-info .event-date {
        font-size: 0.75rem;
        color: #6c757d;
        margin: 0;
    }

    .event-price {
        font-weight: 800;
        font-size: 1.1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        white-space: nowrap;
        margin-right: 0.75rem;
    }

    .btn-order {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        padding: 0.4rem 1.1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        transition: 0.3s;
        white-space: nowrap;
    }

    .btn-order:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: scale(1.05);
        color: #fff;
    }

    .event-right {
        display: flex;
        align-items: center;
    }
</style>

<div class="container-fluid events-container smooth-entrance">
    <div class="events-title">
        <h1><i class="bi bi-calendar-event me-2"></i>Upcoming Events</h1>
        <p>Grab your tickets before they sell out!</p>
    </div>

    <div class="events-grid">

        <?php foreach ($events as $event): ?>
        <div class="event-card">
            <div class="event-card-img">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="event-card-body">
                <div class="event-info">
                    <h5><?= htmlspecialchars($event['event_name']) ?></h5>
                    <p class="event-date"><i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($event['event_date'])) ?></p>
                </div>
                <div class="event-right">
                    <span class="event-price">&euro;<?= htmlspecialchars($event['price']) ?></span>
                    <a href="order.php?event=<?= urlencode($event['event_name']) ?>" class="btn-order">Order</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

</body>
</html>
