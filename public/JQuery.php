<!doctype html>

<html>
<head>
<meta charset="UTF-8">
    <title>Nothing</title>
    <style>
        body {
            text-align:center;
        }
        .page{
            display: inline-block;
            width: 800px;
            text-align: left;
        }
        table, th, td {
            border: 1px solid black;
        }
        tr:hover {background-color: #ddd;}
        table {
            width: 100%;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Parent</th>
        <th>Go in</th>
    </tr>
    <?php
    $ROOT_PATH ='/';

    if (is_dir($ROOT_PATH)){
        if ($open = opendir($ROOT_PATH)){
            while (($read = readdir($open)) !== false) {
                if($read == '.' || $read == '..') {
                    continue;
                }
                print_r("<tr><td>" . $read . "</td>"."<td>".filetype($ROOT_PATH .$read)."</td>"."<td>".
                    dirname($ROOT_PATH)/*works from the right to the left*/."</td>.<td> <button id='buton'>Browse</button></td></tr>");
            }
            closedir($open);
        }
    }
    ?>
</table>
</body>
</html>


