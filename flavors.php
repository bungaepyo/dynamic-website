<?php
include("includes/init.php");
$title = "Flavors";

$show_add_form = TRUE;
$show_search_form = TRUE;

$show_search_feedback = FALSE;

$show_name_feedback = FALSE;
$show_main_flavor_feedback = FALSE;
$show_allergen_feedback = FALSE;
$show_calories_feedback = FALSE;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_submit'])) {

    $is_form_valid = TRUE;

    $search_keyword = filter_input(INPUT_POST, 'search_keyword', FILTER_SANITIZE_STRING);
    if (empty($search_keyword)) {
      $is_form_valid = FALSE;
      $show_search_feedback = TRUE;
    }

    $show_search_form = !$is_form_valid;
  }


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_submit'])) {

  $is_form_valid = TRUE;

  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  if (empty($name)) {
    $is_form_valid = FALSE;
    $show_name_feedback = TRUE;
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

  $show_add_form = !$is_form_valid;
}

function print_flavors($flavor)
{
?>
  <tr>
    <td><?php echo htmlspecialchars($flavor["name"]); ?></td>
    <td><?php echo htmlspecialchars($flavor["main_flavor"]); ?></td>
    <td><?php echo htmlspecialchars($flavor["allergen"]); ?></td>
    <td><?php echo htmlspecialchars($flavor["calories"]); ?></td>
  </tr>
<?php
}

function print_table($flavors)
{
?>
    <table>
    <tr>
        <th>Name</th>
        <th>Main Flavor</th>
        <th>Allergen</th>
        <th>Calories</th>
    </tr>

    <?php
    foreach ($flavors as $flavor){
        print_flavors($flavor);
    }
    ?>
    </table>
<?php
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
            <?php if ($show_search_form) { ?>
                <h2>Search Flavors</h2>
                <form id='search_form' action="flavors.php" method="post">
                    <p class="feedback <?php echo ($show_search_feedback) ? '' : 'hidden'; ?>"> Please enter a keyword.</p>
                    <div>
                        <label>What's in your mind? </label>
                        <input type="text" name="search_keyword"/>
                        <input id='search_submit' type="submit" name="search_submit" value="Search"/>
                    </div>
                </form>
            <?php } else { ?>
                <h2>Your Flavor</h2>
                    <?php
                    $sql = "SELECT * FROM flavors WHERE (name LIKE '%'||:search_keyword||'%' OR main_flavor LIKE '%'||:search_keyword||'%' OR allergen LIKE '%'||:search_keyword||'%' OR calories LIKE '%'||:search_keyword||'%');";
                    $parameters = array(
                        ":search_keyword" => $search_keyword
                    );
                    $result = exec_sql_query($db, $sql, $parameters);
                    $flavors = $result->fetchAll(PDO::FETCH_BOTH);
                    if (count($flavors) > 0) { ?>

                        <form id="able_form" action="flavors.php" method="post">
                            <?php
                            print_table($flavors);
                            ?>
                            <input id="return_button_1" type="submit" name="return" value="Return"/>
                        </form>

                    <?php } else { ?>

                        <form id="unable_form" action="flavors.php" method="post">
                            <p>Unable to find the flavor: <?php echo htmlspecialchars($search_keyword); ?></p>
                            <input id="return_button_2" type="submit" name="return" value="Return"/>
                        </form>

                    <?php }?>

            <?php } ?>

            <div class='divider'></div>

            <?php
                $sql = "SELECT * FROM flavors;";
                $result = exec_sql_query($db, $sql);
                $flavors = $result->fetchAll(PDO::FETCH_BOTH);
            ?>

            <h2>Catalog</h2>
            <?php
            print_table($flavors);
            ?>
        </blockquote>

        <blockquote>
            <?php if ($show_add_form) { ?>
                <h2> Add New Flavor </h2>
                <form id="add_form" method="post" action="flavors.php" novalidate>

                    <p class="feedback <?php echo ($show_name_feedback) ? '' : 'hidden'; ?>"> Please enter a name.</p>
                    <div>
                        <label>Name: </label>
                        <input type="text" name="name"/>
                    </div>

                    <p class="feedback <?php echo ($show_main_flavor_feedback) ? "":"hidden"; ?>"> Please select a main flavor.</p>

                    <div>
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

                    <div>
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

                    <div>
                        <label>Calories:</label>
                        <input id='calories' type="number" name="calories" maxlength="1" min='0' max='500' step='10'/>
                    </div>

                    <div>
                        <input id='add_submit' type="submit" name='add_submit' value="Submit"/>
                    </div>
                </form>
            <?php } else { ?>
                <h2> Flavor Added. Thank you!</h2>

                <?php
                $sql = "INSERT INTO flavors (name, main_flavor, allergen, calories) VALUES(:name, :main_flavor, :allergen, :calories);";
                $parameters = array(
                    ":name" => $name,
                    ":main_flavor" => $main_flavor,
                    ":allergen" => $allergen,
                    ":calories" => $calories
                );
                $result = exec_sql_query($db, $sql, $parameters);
                ?>

                <ul>
                    <li>Name: <?php echo htmlspecialchars($name); ?></li>
                    <li>Main Flavor: <?php echo htmlspecialchars($main_flavor); ?></li>
                    <li>Allergen: <?php echo htmlspecialchars($allergen); ?></li>
                    <li>Calories: <?php echo htmlspecialchars($calories); ?></li>
                </ul>
                <p><a href="flavors.php">Back to Home</a></p>
            <?php } ?>
        </blockquote>

        <?php include("includes/footer.php"); ?>
    </body>
</html>
