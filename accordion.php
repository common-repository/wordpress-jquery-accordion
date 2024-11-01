<?php
/*
  Plugin Name: Accordion Gllery
  Plugin URI: http://wp.flcomponents.net/?page_id=2
  Description: JQuery UI Accordion plugin displays images in an accordion layout. You can navigate through the images by rolling over them or by click (depend on configuration). The accordion can display multiple sets of images. Just move your mouse to expand accordion slice. For each image you can set a vertical title and description. The JQuery UI Accordion is fully customizable. JQuery UI Accordion can be configured thru external XML file or can be deifined inside Web Page.
  Author: JQFiles
  Version: 0.99
  Author URI: http://flcomponents.net/UserProfile/JQFiles
  Copyright 2011,
  Licensed under the flcomponents.net license

 */
error_reporting(E_ALL);

$current_folder = dirname(__FILE__) . "\\";
$current_folder_arry= split("\\\\", $current_folder);

//$current_folder_acc=$current_folder_arry[sizeof($current_folder_arry)-2];

//actionser
add_action('admin_menu', 'create_flc_accordion_menu');

$pluginFolder =   plugin_basename(__FILE__);
$accPluginName = str_ireplace("/accordion.php", "", $pluginFolder);
//$imageFolder = $accPluginName . "/images/";

add_option('flc_plugin_name', $accPluginName);
update_option('flc_plugin_name', $accPluginName);

add_option('folder', "/wp-content/plugins");
add_filter('the_content', 'flc_accordion_content_filter');

$current_folder = dirname(__FILE__) . "\\";
$imageFolder = $current_folder . "images\\";

//echo $imageFolder;





function create_flc_accordion_menu() {
    add_menu_page('FLC Accordion', 'FLC Accordion', 'administrator', __FILE__, 'accordion_settings_page');
    add_action('admin_init', 'register_mysettings');
}

//register our settings
function register_mysettings() {
    register_setting('acc-settings-group', 'acc_gallery_width');
    register_setting('acc-settings-group', 'acc_gallery_height');
    register_setting('acc-settings-group', 'acc_slide_width');
    register_setting('acc-settings-group', 'acc_accordion_bg_color');
    register_setting('acc-settings-group', 'acc_accordion_slidesopacity');
    register_setting('acc-settings-group', 'acc_accordion_bottomtextopacity');
    register_setting('acc-settings-group', 'acc_accordion_left_bg_color');
    register_setting('acc-settings-group', 'acc_accordion_bottom_bg_color');
    register_setting('acc-settings-group', 'acc_accordion_border_color');
    register_setting('acc-settings-group', 'acc_show_bottom_text');
    register_setting('acc-settings-group', 'acc_accordion_showleft');
    register_setting('acc-settings-group', 'acc_accordion_animation_duration');
    register_setting('acc-settings-group', 'acc_accordion_autoplay');
    register_setting('acc-settings-group', 'acc_accordion_show_icon');
    register_setting('acc-settings-group', 'acc_accordion_switchtime');
    register_setting('acc-settings-group', 'acc_accordion_switch_direction');
    register_setting('acc-settings-group', 'acc_accordion_event_type');


    if (get_option('acc_gallery_width') == "")
        update_option('acc_gallery_width', 600);

    if (get_option('acc_gallery_height') == "")
        update_option('acc_gallery_height', 400);

    if (get_option('acc_slide_width') == "")
        update_option('acc_slide_width', 450);

    if (get_option('acc_accordion_bg_color') == "")
        update_option('acc_accordion_bg_color', "000000");

    if (get_option('acc_accordion_left_bg_color') == "")
        update_option('acc_accordion_left_bg_color', "ff0000");

    if (get_option('acc_accordion_bottom_bg_color') == "")
        update_option('acc_accordion_bottom_bg_color', "000000");

    if (get_option('acc_accordion_border_color') == "")
        update_option('acc_accordion_border_color', "ffffff");

    if (get_option('acc_accordion_slidesopacity') == "")
        update_option('acc_accordion_slidesopacity', "0.5");

    if (get_option('acc_accordion_bottomtextopacity') == "")
        update_option('acc_accordion_bottomtextopacity', "0.7");

    if (get_option('acc_show_bottom_text') == "")
        update_option('acc_show_bottom_text', 'true');

    if (get_option('acc_accordion_showleft') == "")
        update_option('acc_accordion_showleft', "true");

    if (get_option('acc_accordion_animation_duration') == "")
        update_option('acc_accordion_animation_duration', "600");

    if (get_option('acc_accordion_autoplay') == "")
        update_option('acc_accordion_autoplay', "false");

    if (get_option('acc_accordion_switch_direction') == "")
        update_option('acc_accordion_switch_direction', "LTR");

    if (get_option('acc_accordion_event_type') == "")
        update_option('acc_accordion_event_type', "over");

    if (get_option('acc_accordion_switchtime') == "")
        update_option('acc_accordion_switchtime', "1");
}

function accordion_settings_page() {
    echo '<div class="wrap">';
    echo '<h2>Accordion gallery</h2>';
    echo '<h4>To use the plugin paste following code somewhere into your content:  <span style="color:red;">[FLCAccordion]</span></h4>';

    $plugin_dir_path = dirname(__FILE__);
?>

    <form method="post" action="options.php">
        
    <?php settings_fields( 'acc-settings-group' ); ?>


    <table class="form-table">
        <tr>
            <td width="50%" align="left">
                <p><span style="display:inline-block; width:140px;">Gallery width:</span> <input  style="width: 50px;" maxlength="10" type="text" value="<?php echo get_option('acc_gallery_width'); ?>" name="acc_gallery_width" id="acc_gallery_width" />(Number value)</p>
                <p><span style="display:inline-block; width:140px;">Gallery height:</span> <input  style="width: 50px;" maxlength="10" type="text" value="<?php echo get_option('acc_gallery_height'); ?>" name="acc_gallery_height" id="acc_gallery_height" />(Number value)</p>
                <p><span style="display:inline-block; width:140px;">Slide width:</span> <input  style="width: 50px;" maxlength="10" type="text" value="<?php echo get_option('acc_slide_width'); ?>" name="acc_slide_width" id="acc_slide_width" />(Number value)</p>
                <p><span style="display:inline-block; width:140px;">Background color:</span> <input  style="width: 100px;" maxlength="100" type="text" value="<?php echo get_option('acc_accordion_bg_color'); ?>" name="acc_accordion_bg_color" id="acc_accordion_bg_color" />(ie. #FFCC11 - valid hexadecimal color)</p>
                <p><span style="display:inline-block; width:140px;">Left text bg color:</span> <input  style="width: 100px;" maxlength="100" type="text" value="<?php echo get_option('acc_accordion_left_bg_color'); ?>" name="acc_accordion_left_bg_color" id="acc_accordion_left_bg_color" />(ie. #FFCC11 - valid hexadecimal color)</p>
                <p><span style="display:inline-block; width:140px;">Bottom text bg color:</span> <input  style="width: 100px;" maxlength="100" type="text" value="<?php echo get_option('acc_accordion_bottom_bg_color'); ?>" name="acc_accordion_bottom_bg_color" id="acc_accordion_bottom_bg_color" />(ie. #FFCC11 - valid hexadecimal color)</p>
                <p><span style="display:inline-block; width:140px;">Border  color:</span> <input  style="width: 100px;" maxlength="100" type="text" value="<?php echo get_option('acc_accordion_border_color'); ?>" name="acc_accordion_border_color" id="acc_accordion_border_color" />(ie. #FFCC11 - valid hexadecimal color)</p>
                <p><span style="display:inline-block; width:140px;">Slides opacity:</span> <input  style="width: 100px;" maxlength="100" type="text" value="<?php echo get_option('acc_accordion_slidesopacity'); ?>" name="acc_accordion_slidesopacity" id="acc_accordion_slidesopacity" />(values range from 0-1)</p>
                <p><span style="display:inline-block; width:140px;">Bottom text opacity:</span> <input  style="width: 100px;" maxlength="100" type="text" value="<?php echo get_option('acc_accordion_bottomtextopacity'); ?>" name="acc_accordion_bottomtextopacity" id="acc_accordion_bottomtextopacity" />(values range from 0-1)</p>
            </td>
            <td width="50%" align="left" valign="top">
                <p><span style="display:inline-block; width:140px;">Show bottom text:</span> <input type="checkbox"   id="acc_show_bottom_text"   name="acc_show_bottom_text" <?php checked('0', get_option('acc_show_bottom_text')); ?> value="0"/></p>
                <p><span style="display:inline-block; width:140px;">Show left text:</span> <input type="checkbox"   id="acc_accordion_showleft"   name="acc_accordion_showleft" <?php checked('0', get_option('acc_accordion_showleft')); ?> value="0"/></p>
                <p><span style="display:inline-block; width:140px;">Animation duration:</span> <input  style="width: 50px;" maxlength="10" type="text" value="<?php echo get_option('acc_accordion_animation_duration'); ?>" name="acc_accordion_animation_duration" id="acc_accordion_animation_duration" />(Number value)</p>
                <p><span style="display:inline-block; width:140px;">Auto play:</span> <input type="checkbox"   id="acc_accordion_autoplay"   name="acc_accordion_autoplay" <?php checked('0', get_option('acc_accordion_autoplay')); ?> value="0"/></p>
                <p><span style="display:inline-block; width:140px;">Show icon:</span> <input type="checkbox"   id="acc_accordion_show_icon"   name="acc_accordion_show_icon" <?php checked('0', get_option('acc_accordion_show_icon')); ?> value="0"/></p>
                <p><span style="display:inline-block; width:140px;">Switch time:</span> <input  style="width: 50px;" maxlength="10" type="text" value="<?php echo get_option('acc_accordion_switchtime'); ?>" name="acc_accordion_switchtime" id="flc_accordion_switchtime" />(Number value)</p>
                <p><span style="display:inline-block; width:140px;">Switch direction:</span>
                    <select style="width: 100px;"  id="acc_accordion_switch_direction" name="acc_accordion_switch_direction">
                        <option <?php echo (get_option('acc_accordion_switch_direction') == 'ltr') ? 'selected="true"' : 'false'; ?>  value="ltr">ltr</option>
                        <option <?php echo (get_option('acc_accordion_switch_direction') == 'rtl') ? 'selected="true"' : 'false'; ?>  value="rtl">rtl</option>
                    </select></p>
                <p><span style="display:inline-block; width:140px;">Event type:</span>
                    <select style="width: 100px;"  id="acc_accordion_event_type" name="acc_accordion_event_type">
                        <option <?php echo (get_option('acc_accordion_event_type') == 'over') ? 'selected="true"' : 'false'; ?>  value="over">Over</option>
                        <option <?php echo (get_option('acc_accordion_event_type') == 'click') ? 'selected="true"' : 'false'; ?>  value="click">Click</option>
                    </select></p>
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" class="button-primary" value="Save Changes" />
    </p>

</form>

<h3>Manage Accordion images</h3>
<form action="" method="post" enctype="multipart/form-data">
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file" />
    <input type="submit" name="submit" value="Submit" />

</form>

<?php


    //remove selected image
    if (isset($_POST['flc_accordion_remove_image']))
    {
        $current_folder = dirname(__FILE__) . "\\";
        $imageFolder = $current_folder . "images\\";
        $remFile= $imageFolder.$_POST['flc_accordion_remove_image'];
        unlink($remFile);
    }

    if (isset($_FILES['file'])) {
        
        //$imageFolder = WP_PLUGIN_DIR ."/". get_option("flc_plugin_name") . "/images/";
        $imageFolder = ABSPATH . 'wp-content/plugins/' .get_option("flc_plugin_name") . '/images/';

        if ($_FILES["file"] != null) {
            if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 20000000)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Error: " . $_FILES["file"]["error"] . "<br />";
                } else {
                    if (file_exists($imageFolder . $_FILES["file"]["name"])) {
                        echo "<p style='color:red;'>" . $_FILES["file"]["name"] . " already exists. </p>";
                    } else {
                        move_uploaded_file($_FILES["file"]["tmp_name"], $imageFolder . $_FILES["file"]["name"]);
                        echo "<p style='color:green;'>File successfully uploaded</p>";
                    }
                }
            } else {
                echo "<p style='color:red;'>Invalid file type</p>";
            }
        }
    }
?>
    <form action="" method="post" enctype="multipart/form-data">
        <select style="width: 400px;"  id="flc_accordion_remove_image" name="flc_accordion_remove_image">
<?php
    $files = flc_get_images();

    for ($i = 0; $i < count($files); $i++) {
        $fileName = $files[$i];
        $finalName = substr($fileName, strrpos($fileName, '/') + 1, strlen($fileName) - strrpos($fileName, '/'));

        echo '<option value="' . $finalName . '">' . $finalName . '</option>';
        //echo
    }
?>
    </select>
    <input type="submit" name="submit" value="Remove selected" />
</form>
<?php
    $acc_items_array = array();
    $acc_data_item = array(
        "leftText" => "<span style=color:blue;>Example left text</span>",
        "bottomText" => "Example bottom text",
        "imagePath" => "1.JPEG");

    array_push($acc_items_array, $acc_data_item);

    add_option('acc_data_options', $acc_items_array);
    $acc_items_array = get_option("acc_data_options");

    //remove last
    if (isset($_POST['remove_last_elem_button'])) {
        array_pop($acc_items_array);
        update_option('acc_data_options', $acc_items_array);
        echo "removed";
    }


    //add new item
    if (isset($_POST['acc_add_data_item_button'])) {
        array_push($acc_items_array, $acc_data_item);
        update_option('acc_data_options', $acc_items_array);
    }

    //updte data
    if (isset($_POST['acc_save_data_item_button'])) {
        $itemCounter = 0;
        $acc_items_array_save = array();
        while (isset($_POST["acc_left_text" . $itemCounter])) {

            $acc_data_item_save = array(
                "leftText" => $_POST["acc_left_text" . $itemCounter],
                "bottomText" => $_POST["acc_bottom_text" . $itemCounter],
                "imagePath" => $_POST["flc_accordion_image" . $itemCounter]);

            array_push($acc_items_array_save, $acc_data_item_save);

            $itemCounter++;
        }
        update_option('acc_data_options', $acc_items_array_save);
        $acc_items_array = $acc_items_array_save;
    }

    echo '<form name="acc_save_data" method="post" action="">';
    echo "<h3>Accordion data</h3>";
    echo "<table>";


    for ($i = 0; $i < count($acc_items_array); $i++) {
        if (get_option("acc_data_options") == "") {
            return;
        }
        $files = flc_get_images();
        $lText = $acc_items_array[$i]['leftText'];
        $bText = $acc_items_array[$i]['bottomText'];
        $imValue = $acc_items_array[$i]['imagePath'];
        echo "<tr>";
        echo '<td style="border:1px solid #858585; padding:5px 5px 5px 5px;">';
        echo 'Left text: <input  style="width: 500px;" maxlength="1000" type="text" value="' . $lText . '" name="acc_left_text' . $i . '" id="acc_left_text' . $i . '" /><br/>';
        echo 'Right text: <input  style="width: 500px;" maxlength="1000" type="text" value="' . $bText . '" name="acc_bottom_text' . $i . '" id="acc_bottom_text' . $i . '" /><br/>';
        echo 'Image: <select style="width: 200px;"  id="flc_accordion_image' . $i . '" name="flc_accordion_image' . $i . '">';


        for ($a = 0; $a < count($files); $a++) {
            $fileName = $files[$a];
            $name = substr($fileName, strrpos($fileName, '/') + 1, strlen($fileName) - strrpos($fileName, '/'));

            if ($imValue != $name) {
                echo '<option value="' . $name . '">' . $name . '</option>';
            } else {
                echo '<option selected="true" value="' . $name . '">' . $name . '</option>';
            }
        }

        add_option("acc_url_address", $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        echo '</select>';
        echo '</td>';
        echo '</tr>';
    }

    echo "</table>";


   echo '<input type="submit" class="button-primary" id="acc_save_data_item_button" name="acc_save_data_item_button" value="Save item" />';
   echo '<input type="submit" class="button-primary" id="acc_add_data_item_button" name="acc_add_data_item_button" value="Add item" />';
   echo '<input type="submit" class="button-primary" id="remove_last_elem_button" name="remove_last_elem_button" value="Remove last" />';

    echo "</form>";
    echo "</div>";
}


If (!file_exists($imageFolder)) {
    mkdir($imageFolder);
}

function flc_get_images() {
    return glob("../" . get_option('folder') . "/" . get_option("flc_plugin_name") . "/images/*.*");
}

function ad_js_scripts_method() {
    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
    wp_enqueue_script('jquery');


    wp_register_script('accordion_plugin', plugins_url('/AccordionGallery.js', __FILE__));
    wp_enqueue_script('accordion_plugin');
}

add_action('wp_enqueue_scripts', 'ad_js_scripts_method');

function flc_accordion_content_filter($content) {

    if (get_option("acc_data_options") != "") {

        $acc_items_array = get_option("acc_data_options");
        $returnString = "";

        $returnString = '<script type="text/javascript"> ' .
                ' $=jQuery; ' .
                'jQuery(document).ready(function($) {' .
                'jQuery("#flc_accordion").FLCAccordion({' .
                'galleryWidth:' . get_option('acc_gallery_width') . ',' .
                'pictureWidth:' . get_option('acc_slide_width') . ',' .
                'galleryHeight: ' . get_option('acc_gallery_height') . ',' .
                'htmlConfig:true,' .
                'backgroundColor:"#' . get_option('acc_accordion_bg_color') . '",' .
                'borderColor:"#' . get_option('acc_accordion_border_color') . '",' .
                'imagesOpacity:' . get_option('acc_accordion_slidesopacity') . ',' .
                'bottomTextOpacity:' . get_option('acc_accordion_bottomtextopacity') . ',' .
                'eventType: "' . get_option('acc_accordion_event_type') . '",' .
                'showLeftText: ' . parse_bool_acc(get_option('acc_accordion_showleft')) . ',' .
                'showBottomText: ' . parse_bool_acc(get_option('acc_show_bottom_text')) . ',' .
                'leftTextBgColor:"#' . get_option('acc_accordion_left_bg_color') . '",' .
                'bottomTextBgColor:"#' . get_option('acc_accordion_bottom_bg_color') . '",' .
                'animationTime: ' . get_option('acc_accordion_animation_duration') . ',' .
                'code:"code_marker",' .
                'autoPlay: ' . parse_bool_acc(get_option('acc_accordion_autoplay')) . ',' .
                'switchTime: ' . get_option('acc_accordion_switchtime') . ',' .
                'iconPath:"' . plugins_url('/assets/arr.png', __FILE__) . '",' .
                'switchOrder:"' . get_option('acc_accordion_switch_direction') . '"' .
                
                '});' .
                '})' .
                '</script>  ';

        $returnString = $returnString . '<div id="flc_accordion" style="padding-left:auto; padding-left:auto; margin: 0 auto 0 auto; width:' . get_option('acc_gallery_width') . ';">';
        $returnString = $returnString . ' <ul style="display:block;">';

        for ($a = 0; $a < count($acc_items_array); $a++) {
            $files = flc_get_images();
            $lText = $acc_items_array[$a]['leftText'];
            $bText = $acc_items_array[$a]['bottomText'];
            $imValue = $acc_items_array[$a]['imagePath'];
            $im = plugins_url('/images/' . $imValue, __FILE__);

            $returnString = $returnString . '<li>';
            $returnString = $returnString . '<img src="' . $im . '"/>';
            $returnString = $returnString . '<p title="left">';

            $returnString = $returnString . $lText;
            $returnString = $returnString . '</p>';
            $returnString = $returnString . '<p title="bottom">';
            $returnString = $returnString . $bText;
            $returnString = $returnString . '</p>';
            $returnString = $returnString . '<a href=""></a>';
            $returnString = $returnString . '</li>';
        }

        $returnString = $returnString . '</ul>';
        $returnString = $returnString . '</div>';
    }

    $content = str_ireplace("[FLCAccordion]", $returnString, $content);
    return $content;
}

function parse_bool_acc($val) {
    if ($val == "0")
        return "true";

    if ($val == "true")
        return "false";

    if ($val == "false")
        return "false";

    if ($val == "")
        return "false";
}

function my_plugin_admin_styles() {
    wp_enqueue_script('myPluginScript');
}
?>