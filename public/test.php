<html>
<head>
    <title></title>
    <style>
        body {
            text-align:center;
        }
        .page{
            display: inline-block;
            width: 800px;
            text-align: left;
        }
        h2{
            border-bottom: solid black 1px;
        }
        li,ul{
            margin: 0px;
            padding: 3px;

        }
        li:hover{
            background: #f0f0f0;
            border-bottom: solid silver 1px;
        }
        .browse{
            display: inline-block; float: right;margin-left: 50px;
        }

        .dir{
            font-weight: bold;
        }
        .file .browse{
            display: none;
        }



    </style>
</head>
<body>



<?php
$basePath = __DIR__;

$self = dirname(__FILE__);

$currentRelPath = $_SERVER["REQUEST_URI"];
list($base,$relPath) = explode($self,$currentRelPath);
$selfPath = $base.$self;
//echo "<p>".$self."</p>";
//echo "<p>".$currentRelPath."</p>";
//echo "<p>".$base."</p>";
echo "<p>".$relPath."</p>";
if(substr($relPath,strlen($relPath)-1)!=="/"){}
    $relPath = $relPath."/";

$path = $basePath.$relPath;

$dp = opendir($path);

$entries = [];
while($entry = readdir($dp)) {
    $entries[] = $entry;
}
sort($entries);
?>
<div class='page'>
    <h2><?=$path?></h2>
    <ul >
        <?php
        foreach($entries as $entry):
            ?>
            <li class='<?=is_dir($path."/".$entry)?'dir':'file'?>'>
                <a href="<?= $relPath.$entry ?>"><?= $entry ?></a>
                <a href="<?= $selfPath.$relPath.$entry ?>" class="browse">[Browse]</a>
            </li>
        <?php
        endforeach;
        ?>
    </ul>
</div>
</body>
</html>