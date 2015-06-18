<?php
if (!isset($legend_options))
    $legend_options = array();

$attr['align'] = 'absmiddle';
?>

<?php if (count($legend_options) > 0) { ?>
    <table width="100%" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td>
                <div class="manageFooter manage_cont">

                    <strong>
                        Legend:
                    </strong>&nbsp;&nbsp;
                    <?php
                    foreach ($legend_options as $option_key => $option)
                        echo image_asset($option_key, '', $attr) . ': ' . $option . '&nbsp;&nbsp;&nbsp;&nbsp;';
                    ?>
                </div>
            </td>
        </tr>
    </table>
<?php } ?>