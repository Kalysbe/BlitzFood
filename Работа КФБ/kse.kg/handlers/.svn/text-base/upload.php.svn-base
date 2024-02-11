<?php
//Array ( [type] => Images [CKEditor] => mBlogText [CKEditorFuncNum] => 1 [langCode] => ru )

print_r($_FILES);
if ((isset($_GET["type"]))&&($_GET["type"] == "Images")) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/image.class.php");

    $image = new ImageResizer();
    $image->load($_FILES['upload']['tmp_name']);
    $image->save($_SERVER["DOCUMENT_ROOT"] . "/media/images/uploads/" . $_FILES['upload']['name']);
    echo "100%";
}


?>
