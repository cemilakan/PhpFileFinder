<?php
include './src/Finder.php';


//Define the path
$path = './controller/admin';
//Call Finder Class
$finder = new Finder($path);
//Select the extension that we want to find
$files = $finder->extension('php');
//You can check for last update date
$files = $finder->date(strtotime("-1 day"), '<');
//You can check for files that contain any word
$files = $finder->contain('View::skeleton');
//You can check for file names that you want
$files = $finder->include('dashboard.php');
//You can ignore files that contain this value
$files = $finder->exclude('dashboard.php');

$files = $finder->get();
echo json_encode($files, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);