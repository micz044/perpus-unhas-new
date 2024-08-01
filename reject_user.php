<?php
include 'db_connection.php';

$id = intval($_GET['id']);

$sql_delete_pending_user = "DELETE FROM pending_users WHERE id = $id";

if ($conn->query($sql_delete_pending_user) === TRUE) {
    header("Location: verify_user.php?success=rejected");
} else {
    header("Location: verify_user.php?error=reject_failed");
}

$conn->close();
?>