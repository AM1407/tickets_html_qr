<?php
class Order {
    private $db;
    private $table = "orders";

    public function __construct($db_conn) {
        $this->db = $db_conn;
    }

    public function createOrder($user_id, $quantity, $event_name = '') {
        // Look up price from the events table
        $price_per_ticket = 0;
        if (!empty($event_name)) {
            $lookup = mysqli_prepare($this->db, "SELECT price FROM events WHERE event_name = ? LIMIT 1");
            mysqli_stmt_bind_param($lookup, 's', $event_name);
            mysqli_stmt_execute($lookup);
            $res = mysqli_stmt_get_result($lookup);
            if ($row = mysqli_fetch_assoc($res)) {
                $price_per_ticket = (float)$row['price'];
            }
            mysqli_stmt_close($lookup);
        }
        $total_amount = $quantity * $price_per_ticket;
        $status = 'paid';

        // Using Prepared Statements for security
        $sql = "INSERT INTO " . $this->table . " (user_id, total_amount, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);

        if ($stmt) {
            // i = integer, d = double (decimal), s = string
            // Inside classes/Order.php
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                return true;
            } else {
                // This will print the EXACT reason the DB rejected the order
                die("Execution failed: " . mysqli_stmt_error($stmt));
            }
        }
        return false;
    }
}
?>