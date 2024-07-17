<?php
require_once("includes/classes/header.php");

$preview = new PreviewProvider($con,$userLoggedIn);
echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($con,$userLoggedIn);
echo $containers->showAllCategories();

?>

