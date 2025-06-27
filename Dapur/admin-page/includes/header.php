<?php
include 'auth.php';
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: #fff;
      padding-top: 20px;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .content {
      flex-grow: 1;
      padding: 20px;
    }
  </style>
</head>
<body>
