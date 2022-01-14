<?php

session_start();
unset($_SESSION['users']);
unset($_SESSION['id']);
unset($_SESSION['username']);
echo "<script>alert('Anda telah keluar '); window.location = 'index.php'</script>";