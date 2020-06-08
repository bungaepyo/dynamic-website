<?php
include("includes/init.php");
$title = $_GET['description'];
$extension = $_GET['file_extension'];
$name = $_GET["file_name"];

//Select item information
$sql_1 = "SELECT * FROM images WHERE (description = :title);";
$param_1 = array(
    ":title" => $title
);
$item = exec_sql_query($db,$sql_1,$param_1)->fetchAll(PDO::FETCH_ASSOC);
$item_desc = $item[0]["description"];
$item_id = $item[0]["id"];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["delete_image"])){

    //Delete from tables
    $sql_2 = "DELETE FROM images WHERE (description = :item_desc);";
    $param_2 = array(
        ":item_desc" => $item_desc
    );
    $result = exec_sql_query($db,$sql_2,$param_2);

    $sql_3 = "DELETE FROM image_tags WHERE (image_id = :item_id);";
    $param_3 = array(
        ":item_id" => $item_id
    );
    $result = exec_sql_query($db,$sql_3,$param_3);

    //Delete file from folder
    if ($result){
        $filename = 'uploads/images/'. strval($item_id) .'.'. strval($extension);
        unlink($filename);
    } else {
        echo "Failed to delete";
    }

}

if (isset($_POST["submit_add_tag"])){
    $img_id = $item_id;
    $tag_name = filter_input(INPUT_POST, 'add_tag', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM tags WHERE tag_name = :tag_name";
    $params = array(
        ":tag_name" => $tag_name
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();
    $tag_id = $result[0]['id'];

    $sql = "INSERT INTO image_tags (image_id, tag_id) VALUES (:img_id, :tag_id)";
    $params = array(
        ":img_id" => $img_id,
        ":tag_id" => $tag_id
    );
    $result = exec_sql_query($db, $sql, $params);
}

if (isset($_POST["submit_delete_tag"])){
    $img_id = $item_id;
    $tag_name = filter_input(INPUT_POST, 'delete_tag', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM tags WHERE tag_name = :tag_name";
    $params = array(
        ":tag_name" => $tag_name
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();
    $tag_id = $result[0]['id'];

    $sql = "DELETE FROM image_tags WHERE image_id = :img_id AND tag_id = :tag_id";
    $params = array(
        ":img_id" => $img_id,
        ":tag_id" => $tag_id
    );
    $result = exec_sql_query($db, $sql, $params);
}

if (isset($_POST["submit_new_tag"])){
    $tag_name = strtolower(filter_input(INPUT_POST, 'tag_name', FILTER_SANITIZE_STRING));

    $sql = "SELECT * FROM tags WHERE tag_name = :tag_name";
    $params = array(
        ":tag_name" => $tag_name
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();

    if (empty($result)){
        $sql = "INSERT INTO tags (tag_name, tag_description) VALUES (:tag_name, :tag_name)";
        $params = array(
            ":tag_name" => $tag_name
        );
        $result = exec_sql_query($db, $sql, $params);

        $img_id = $item_id;
        $tag_id = $db->lastInsertId("tag_id");
        $sql = "INSERT INTO image_tags (image_id, tag_id) VALUES (:img_id, :tag_id)";
        $params = array(
            ":img_id" => $img_id,
            ":tag_id" => $tag_id
        );
        $result = exec_sql_query($db, $sql, $params);
    } else {
        echo "<p>failed</p>";
    }
}

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cornell Dairy Ice Cream</title>
        <link rel="stylesheet" type="text/css" href="styles/theme.css" media="all"/>
    </head>
    <body>

        <?php include("includes/header.php"); ?>
            <blockquote>
                <h2> <?php echo $title ?> </h2>
                    <ul>

                    <?php
                    //image
                    $file_name = $_GET['file_name'];
                    $sql_4 = "SELECT * FROM images WHERE (file_name = :file_name);";
                    $param_4 = array(
                        ":file_name" => $file_name
                    );
                    $images = exec_sql_query($db,$sql_4,$param_4)->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($images as $image) {
                        echo "<div class=\"detail_image\"><img src=\"uploads/images/" . $image["id"] . "." . $image["file_extension"] . "\"></div>";
                    }
                    ?>

                    <div class="image_details">
                    <!-- <form id="tag_form" action="gallery.php" method="post" enctype="multipart/form-data" novalidate> -->
                    <?php
                    //flavor information
                    $sql_5 = "SELECT flavors.main_flavor, flavors.allergen, flavors.calories FROM flavors INNER JOIN images ON images.description = flavors.name WHERE (flavors.name = :title);";
                    $param_5 = array(
                        ":title" => $title
                    );
                    $flavor_infos = exec_sql_query($db,$sql_5,$param_5)->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($flavor_infos as $flavor_info){
                        echo "Main flavor : " . $flavor_info['main_flavor'] . "";
                        echo "<br>";
                        echo "Allergen : " . $flavor_info['allergen'] . "";
                        echo "<br>";
                        echo "Calories : " . $flavor_info['calories'] . "";
                    }

                    //tags
                    $sql_6 = "SELECT DISTINCT tags.tag_name FROM tags INNER JOIN image_tags ON image_tags.tag_id = tags.id INNER JOIN images ON images.id = image_tags.image_id WHERE (images.file_name = :file_name);";
                    $param_6 = array(
                        ":file_name" => $file_name
                    );
                    $tag_infos = exec_sql_query($db,$sql_6,$param_6)->fetchAll(PDO::FETCH_ASSOC);
                    echo "<br>";
                    echo "Tags: ";
                    foreach ($tag_infos as $tag_info){
                        echo " " .$tag_info["tag_name"] . " / ";
                        }
                    ?>

                    <!-- add tags -->
                    <form id="add_tag" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="POST">
                        <select name="add_tag">
                            <?php
                            $sql_7 = "SELECT tags.tag_name FROM tags WHERE tags.tag_name NOT IN (SELECT tags.tag_name FROM tags INNER JOIN image_tags ON image_tags.tag_id = tags.id INNER JOIN images ON image_tags.image_id = images.id WHERE (images.file_name = :file_name));";
                            $param_7 = array(
                                ":file_name" => $file_name
                            );
                            $add_tag_infos = exec_sql_query($db,$sql_7,$param_7)->fetchAll(PDO::FETCH_ASSOC);
                            echo "<br>";
                            echo "Add: ";
                            foreach ($add_tag_infos as $add_tag_info){
                                echo "<option value=\"".htmlspecialchars($add_tag_info['tag_name'])."\">". htmlspecialchars($add_tag_info['tag_name']) . "</option>";
                                }
                            ?>
                        </select>
                        <input type="submit" name="submit_add_tag" value="Add Tag">
                    </form>

                    <!-- delete tags -->
                    <form id="delete_tag" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="POST">
                        <select name="delete_tag">
                            <?php
                            $del_tag_infos = exec_sql_query($db,$sql_6,$param_6)->fetchAll(PDO::FETCH_ASSOC);
                            echo "<br>";
                            echo "Delete: ";
                            foreach ($del_tag_infos as $del_tag_info){
                                echo "<option value=\"".htmlspecialchars($del_tag_info['tag_name'])."\">". htmlspecialchars($del_tag_info['tag_name']) . "</option>";
                                }
                            ?>
                        </select>
                        <input type="submit" name="submit_delete_tag" value="Delete Tag">
                    </form>

                    <!-- add new tag -->
                    <form id="new_tag" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="POST">
                        <ul>
                            <li id="list">
                                <input type="text" name="tag_name" maxlength="10" placeholder="Create New Tag" required>
                                <input type="submit" name="submit_new_tag" value="Add New Tag">
                            </li>
                        </ul>
                    </form>

                    </div>
                    </ul>

                    <div>
                        <form id="delete_form" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="POST">
                            <input type="submit" name="delete_image" value="Delete Image">
                        </form>
                    </div>
            </blockquote>

        <?php include("includes/footer.php"); ?>
    </body>
</html>
