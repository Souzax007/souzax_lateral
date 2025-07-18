<?php
session_start();
session_destroy();
header("Location:../index.php"); // ou outra página inicial
exit;
