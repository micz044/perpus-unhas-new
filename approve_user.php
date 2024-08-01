<?php
include 'db_connection.php';

$id = intval($_GET['id']);

$sql_get_user = "SELECT * FROM pending_users WHERE id = $id";
$result_get_user = $conn->query($sql_get_user);

if ($result_get_user->num_rows > 0) {
    $user = $result_get_user->fetch_assoc();
    
    $sql_insert_user = "INSERT INTO users (username, password) VALUES ('" . $user['username'] . "', '" . $user['password'] . "')";
    $sql_insert_user_register = "INSERT INTO users_register (nama_lengkap, nip, jabatan, email, username, password) VALUES ('" . $user['nama_lengkap'] . "', '" . $user['nip'] . "', '" . $user['jabatan'] . "', '" . $user['email'] . "', '" . $user['username'] . "', '" . $user['password'] . "')";
    
    if ($conn->query($sql_insert_user) === TRUE && $conn->query($sql_insert_user_register) === TRUE) {
        $sql_delete_pending_user = "DELETE FROM pending_users WHERE id = $id";
        $conn->query($sql_delete_pending_user);
        header("Location: verify_user.php?success=approved");
    } else {
        header("Location: verify_user.php?error=approve_failed");
    }
} else {
    header("Location: verify_user.php?error=user_not_found");
}

$conn->close();
?>