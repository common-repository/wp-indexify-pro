<?php

function add_dashboard_widgets() {

    wp_add_dashboard_widget(
            'onehourindexing', 'WP Indexify PRO 2.0', 'onehourindexing_function'
    );
}

add_action('wp_dashboard_setup', 'add_dashboard_widgets');

function onehourindexing_function() {

    $nl = array();
    $ohi_total_numbers_indexed = (int) get_option('ohi_total_numbers_indexed', 0);
    $linklicious_total_numbers_indexed = (int) get_option('Linklicious_total_numbers_indexed', 0);
    $indexification_total_numbers_indexed = (int) get_option('indexification_total_numbers_indexed', 0);
    $lindexed_total_numbers_indexed = (int) get_option('Lindexed_total_numbers_indexed', 0);
    $ohi_last_Submited = get_option('ohi_last_Submited', 'Never');
    $Linklicious_last_Submited = get_option('Linklicious_last_Submited', 'Never');
    $Indexification_last_Submited = get_option('Indexification_last_Submited', 'Never');
    $Lindexed_last_Submited = get_option('Lindexed_last_Submited', 'Never');

    $fatal_error = get_option('fatal_error', '');
    $ohi_error = get_option('ohi_error', '');
    $Linklicious_error = get_option('Linklicious_error', '');
    $Indexification_error = get_option('Indexification_error', '');
    $Lindexed_error = get_option('Lindexed_error', '');
    $index_all = get_option('log_index_all', $nl);
    ?>
    <style>

        .ohi_error {
            color: #D8000C;
            background-color: #FFBABA;
            background-image: url('<?php echo plugins_url('png/error.png', __FILE__) ?>');
        }   

    </style>
    <h4>
        <?php if ($fatal_error == '') { ?>
            <style>
                #table_log {
                    font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
                    font-size: 12px;


                    text-align: center;
                    border-collapse: collapse;
                }
                #table_log th {
                    font-weight: bold;
                    background: #eff2ff;
                    color: #039;
                    border-bottom: 1px dashed #69c;
                }
                #table_log td {
                    padding: 0px 15px;
                    color: #669;
                    border: 1px solid #e8edff;
                }
                .oce-first {
                    background: #d0dafd;
                    border-right: 10px solid transparent;
                    border-left: 10px solid transparent;
                }
                #table_log tr:hover td {
                    color: #339;
                    background: #eff2ff;
                }
            </style>
            <table id="table_log">
                <tr><th>service</th><th>links</th><th>last submit</th><th>status</th></tr>
                <tr><td class="titl_log">onehourindexing.co</td><td><?php echo $ohi_total_numbers_indexed; ?></td><td><?php echo $ohi_last_Submited; ?></td>   <td><?php if ($ohi_error != '') { ?> <img title="<?php echo $ohi_error; ?>" src="<?php echo plugins_url('png/error.png', __FILE__) ?>" > <?php } else { ?><img title="success" src="<?php echo plugins_url('png/success.png', __FILE__) ?>"><?php } ?></td></tr>
                <tr><td class="titl_log">linklicious.co</td><td><?php echo $linklicious_total_numbers_indexed; ?></td><td><?php echo $Linklicious_last_Submited; ?></td>     <td><?php if ($Linklicious_error != '') { ?> <img title="<?php echo $Linklicious_error; ?>" src="<?php echo plugins_url('png/error.png', __FILE__) ?>" ><?php } else { ?><img title="success" src="<?php echo plugins_url('png/success.png', __FILE__) ?>"><?php } ?></td></tr>
                <tr><td class="titl_log">indexification.com</td><td><?php echo $indexification_total_numbers_indexed; ?></td><td><?php echo $Indexification_last_Submited; ?></td>     <td><?php if ($Indexification_error != '') { ?> <img title="<?php echo $Indexification_error; ?>" src="<?php echo plugins_url('png/error.png', __FILE__) ?>" > <?php } else { ?><img title="success" src="<?php echo plugins_url('png/success.png', __FILE__) ?>"><?php } ?></td></tr>
                <tr><td class="titl_log">lindexed.com</td><td><?php echo $lindexed_total_numbers_indexed; ?></td><td><?php echo $Lindexed_last_Submited; ?></td>    <td><?php if ($Lindexed_error != '') { ?> <img title="<?php echo $Lindexed_error; ?>" src="<?php echo plugins_url('png/error.png', __FILE__) ?>" ><?php } else { ?><img title="success" src="<?php echo plugins_url('png/success.png', __FILE__) ?>"><?php } ?></td></tr>
            </table>
            <h4 style="font-weight:bold;margin-top: 10px;">Recent Activities : </h4>
            <table id="table_log" >
                <tr><th>date</th> <th>message</th></tr>
                    <?php
                    $show_log = array_reverse($index_all);
                    for ($index = 0; $index < 10 && $index < sizeof($show_log); $index++) {
                        ?>
                <tr>
                    <td> 
                        <?php echo $show_log[$index]['date']; ?>
                    </td>
                    <td>
                        <?php echo $show_log [$index]['message']; ?>
                    </td>
                </tr>
        <?php } ?>
            </table>




        <?php if (sizeof($show_log) > 10) { ?>
                </br>
                <a href ="options-general.php?page=&tab=log_index_all">Show more log entries</a>
            <?php }
        } else { ?>
            <div class="ohi_error">
            <?php echo $fatal_error; ?>
            </div>
            <?php
        }
        ?>
    </h4> 


<?php } ?>