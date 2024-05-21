<?php
require 'db.php';
$statsData = getLanguageStats();

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Statistics</h1>
    <table>
        <tr>
            <th>Язык программирования</th>
            <th>Количество использований</th>
        </tr>
        <?php foreach ($statsData as $row): ?>
            <tr>
                <td><?php echo $row->language; ?></td>
                <td><?php echo $row->usage_count; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
