<?php
require_once('src/functions.php');

ob_start();

/**
 * Task 1
 */

echo "<div class='task-wrapper'>";
echo '<h2>Задание 1</h2>';

task1();

echo '</div>';

/**
 * Task 2
 */

echo "<div class='task-wrapper'>";
echo '<h2>Задание 2</h2>';

task2();

echo '</div>';

/**
 * Task 3
 */

echo "<div class='task-wrapper'>";
echo '<h2>Задание 3</h2>';

task3();

echo '</div>';

$content = ob_get_contents();
ob_end_clean();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./src/css/styles.css">
    <title>Третье домашнее задание от loftschool.com</title>
</head>
<body>
<div class="container">
    <h1 class="title">Третье домашнее задание</h1>
    <?= $content ?>
</div>
</body>
</html>
