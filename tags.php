<?php
include("includes/init.php");
$title = "Image Gallery By Tags";

//Constant for maximum upload file size (1MB)
const maximum_file_size = 1000000;

$show_image_add_form = TRUE;
$show_name_feedback = FALSE;
$show_main_flavor_feedback = FALSE;
$show_allergen_feedback = FALSE;
$show_calories_feedback = FALSE;

//Uploading Images
if (isset($_POST["upload_submit"])) {

  $is_form_valid = TRUE;

  $upload_file = $_FILES["upload_file"];
  if($upload_file['size']==0){
    $is_form_valid = FALSE;
    $show_file_feedback = TRUE;
  }

  $main_flavor = filter_input(INPUT_POST, 'main_flavor', FILTER_SANITIZE_STRING);
  if(!isset($main_flavor)){
    $is_form_valid = FALSE;
    $show_main_flavor_feedback = TRUE;
  }

  $allergen = filter_input(INPUT_POST, 'allergen', FILTER_SANITIZE_STRING);
  if(!isset($allergen)){
    $is_form_valid = FALSE;
    $show_allergen_feedback = TRUE;
  }

  $calories = filter_input(INPUT_POST, 'calories', FILTER_SANITIZE_STRING);
  if(empty($calories)){
    $is_form_valid = FALSE;
    $show_calories_feedback = TRUE;
  }

  $name = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $upload_desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  if(empty($upload_desc)){
    $is_form_valid = FALSE;
    $show_desc_feedback = TRUE;
  }

  $show_image_add_form = !$is_form_valid;
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
                <h2>View By:</h2>
                <?php
                $tag_names = exec_sql_query($db,"SELECT tags.tag_name FROM tags")->fetchAll(PDO::FETCH_ASSOC);
                foreach($tag_names as $tag_name){
                    $array = array(
                        'tag' => $tag_name
                    );
                    $build_query = http_build_query($tag_name);
                    echo "<li class=\"tag_buttons\" ><a href=\"tags.php?" . $build_query . "\">" . $tag_name['tag_name'] . "</a></li>";
                }
                ?>

                <div class='divider'></div>

                <h2> Gallery </h2>
                    <ul>
                    <?php
                    $tag_name = $_GET['tag_name'];
                    $sql = "SELECT images.id, images.file_name, images.file_extension, images.description FROM images INNER JOIN image_tags ON images.id = image_tags.image_id INNER JOIN tags ON image_tags.tag_id = tags.id WHERE (tags.tag_name = :tag_name);";
                    $params= array(
                        ":tag_name" => $tag_name
                    );
                    $images = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($images as $image) {
                        $array = array(
                            'file_name' => $image['file_name'],
                            'description' => $image['description']
                        );
                        $build_query = http_build_query($array);
                        echo "<div class=\"gallery_images\"><a href=\"details.php?".$build_query."\"><img src=\"uploads/images/" . $image["id"] . "." . $image["file_extension"] . "\"></a></div>";
                    }
                    ?>
                    </ul>
            </blockquote>

            <blockquote>
            <?php if ($show_image_add_form) {?>
                <h2> Add New Image! </h2>
                <form id="image_add_form" action="gallery.php" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name ="maximum_file_size" value="<?php echo maximum_file_size; ?>"/>

                    <p class="feedback <?php echo ($show_file_feedback) ? "":"hidden"; ?>"> Please upload a file.</p>

                    <div class="upload_input">
                        <label for="upload_file">Upload: </label>
                        <input id="upload_file" type="file" name="upload_file" value="upload_file"/>
                    </div>

                    <p class="feedback <?php echo ($show_desc_feedback) ? "":"hidden"; ?>"> Please provide a name.</p>

                    <div class="upload_input">
                        <label id="upload_desc" for="upload_desc">Name:</label>
                        <input type='text' id="upload_desc" name="description"/>
                    </div>

                    <p class="feedback <?php echo ($show_main_flavor_feedback) ? "":"hidden"; ?>"> Please select a main flavor.</p>

                    <div class="upload_input">
                        <label>Main Flavor:
                        </label>
                        <select id="main_flavor" name="main_flavor">
                            <option disabled selected value>--select one--</option>
                            <option value="Vanilla" <?php if($main_flavor=="Vanilla") echo 'selected'; ?>>Vanilla</option>
                            <option value="Chocolate" <?php if($main_flavor=="Chocolate") echo 'selected'; ?>>Chocolate</option>
                            <option value="Strawberry" <?php if($main_flavor=="Strawberry") echo 'selected'; ?>>Strawberry</option>
                            <option value="Coffee" <?php if($main_flavor=="Coffee") echo 'selected'; ?>>Coffee</option>
                        </select>
                    </div>

                    <p class="feedback <?php echo ($show_allergen_feedback) ? "":"hidden"; ?>"> Please select an allergen.</p>

                    <div class="upload_input">
                        <label>Allergen:
                        </label>
                        <select id="allergen" name="allergen">
                            <option disabled selected value>----select one----</option>
                            <option value="Milk" <?php if($allergen=="Milk") echo 'selected'; ?>>Milk</option>
                            <option value="Eggs" <?php if($allergen=="Eggs") echo 'selected'; ?>>Eggs</option>
                            <option value="Coconut" <?php if($allergen=="Coconut") echo 'selected'; ?>>Coconut</option>
                            <option value="Peanut" <?php if($allergen=="Peanut") echo 'selected'; ?>>Peanut</option>
                            <option value="Apple" <?php if($allergen=="Apple") echo 'selected'; ?>>Apple</option>
                            <option value="Banana" <?php if($allergen=="Banana") echo 'selected'; ?>>Banana</option>
                        </select>
                    </div>

                    <p class="feedback <?php echo ($show_calories_feedback) ? "":"hidden"; ?>"> Please enter calories per serving.</p>

                    <div class="upload_input">
                        <label>Calories:</label>
                        <input id='calories' type="number" name="calories" min='0' max='500' step='10'/>
                    </div>

                    <br>

                    <div class="upload_input">
                        <span></span>
                        <button id='upload_submit' name="upload_submit" type="submit">Upload</button>
                    </div>

                </form>
            <?php } else { ?>
                <h2> Image Added. Please refresh the page.</h2>

                <?php
                $sql_1 = "INSERT INTO flavors (name, main_flavor, allergen, calories) VALUES(:name, :main_flavor, :allergen, :calories);";
                $parameters = array(
                    ":name" => $name,
                    ":main_flavor" => $main_flavor,
                    ":allergen" => $allergen,
                    ":calories" => $calories
                );
                $result = exec_sql_query($db, $sql_1, $parameters);

                //check if there is no error in the upload
                if($upload_file["error"] == UPLOAD_ERR_OK){

                    $file_name = basename($upload_file["name"]);
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                    //execute sql query to store upload informaiton in the database
                    $sql_2 =  "INSERT INTO images (file_name, file_extension, description) VALUES(:file_name, :file_extension, :description);";
                    $params = array(
                        ":file_name" => $file_name,
                        ":file_extension" => $file_ext,
                        ":description" => $upload_desc
                    );
                    exec_sql_query($db, $sql_2, $params);

                    //move file into new path directory
                    $id = $db -> lastInsertId("id");
                    $new_path = "uploads/images/$id.$file_ext";
                    move_uploaded_file($_FILES["upload_file"]["tmp_name"], $new_path);
                } else {
                    throw new Exception("File did not upload");
                }
                ?>

                <ul>
                    <li>Name: <?php echo htmlspecialchars($name); ?></li>
                    <li>Main Flavor: <?php echo htmlspecialchars($main_flavor); ?></li>
                    <li>Allergen: <?php echo htmlspecialchars($allergen); ?></li>
                    <li>Calories: <?php echo htmlspecialchars($calories); ?></li>
                </ul>
                <p><a href="gallery.php">Back to Home</a></p>
            <?php } ?>
            </blockquote>

        <?php include("includes/footer.php"); ?>
    </body>
</html>
