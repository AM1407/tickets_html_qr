<?php
class User {
    private $db;
    private $table = "users";

    public function __construct($db_conn) {
        $this->db = $db_conn;
    }

    // Move the login/check routine here
public function login($email, $password) {
    $email = mysqli_real_escape_string($this->db, $email);
    // This SELECT * pulls the 'role' column you see in TablePlus
    $sql = "SELECT * FROM " . $this->table . " WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($this->db, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            return $user; // This now contains $user['role']
        }
    }
    return false;
}

    // Optional: Register routine
    public function register($name, $email, $password, $doc_id = null) {
        $name = mysqli_real_escape_string($this->db, $name);
        $email = mysqli_real_escape_string($this->db, $email);
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_pw')";
        
        return mysqli_query($this->db, $sql);
    }
}
?>