<?php
function renderLayoutAdmin($viewPath, $data = [], $active = "", $title = "")
{
    extract($data);

    ob_start();
    include "./views/$viewPath";
    $content = ob_get_clean();

    include "./views/layoutAdmin.php";
}
function renderLayoutGuide($viewPath, $data = [], $active = "", $title = "")
{
    extract($data);

    ob_start();
    include "./views/$viewPath";
    $content = ob_get_clean();

    include "./views/layoutGuide.php";
}
?>