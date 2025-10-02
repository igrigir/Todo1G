<?php // views/layout/header.php ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>To-Do (PHP PDO)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= e(base_url('assets/css/app.css')) ?>?v=1" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-dark" style="background:#0b1220;border-bottom:1px solid #1f2a44;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= e(base_url()) ?>">✅ To-Do</a>
  </div>
</nav>
<main class="container-fluid py-4">
