<?php
function renderLayoutAdmin($viewPath, $data = [], $title = "")
{
    extract($data);

    ob_start();
    include "./views/$viewPath";
    $content = ob_get_clean();

    include "./views/layouts/layoutAdmin.php";
}
// function renderLayoutGuide($viewPath, $data = [], $active = "", $title = "")
// {
//     extract($data);

//     ob_start();
//     include "./views/$viewPath";
//     $content = ob_get_clean();

//     include "./views/layouts/layoutAdmin.php";
// }
?>