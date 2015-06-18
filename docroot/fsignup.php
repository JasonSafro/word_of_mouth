<?php
session_start();
$code = $_REQUEST["code"];
 
if (isset($_REQUEST["code"]) && $code != "") {
    ?>
    <script>
         window.location.href="flogin/fsignup/<?php echo $code ?>";
     </script>
    <?php
} else {
    if (isset($_REQUEST["error_description"]) != false || $_REQUEST["error_description"] != "") {
        $error_description = $_REQUEST["error_description"];
        ?>
        <script>
            alert('<?php echo $error_description; ?>');
            window.close();
        </script>
        <?php
    } else {
        ?>
        <script>
            window.close();
        </script>
        <?php
    }
}
