<?php

function send_to_ohi($links, $witch) {
    global $options;
    switch ($witch) {
        case 1: {
                $sendto = "http://www.onehourindexing.co/api/uploadlinks";
                $pluginApi = "360f73d2-3898-4b1b-8a4a-92eaf56cf722";
                $name = str_replace(" ", "%20", date('Y-m-d h:i:s ') . get_option('blogname'));
                $url = $sendto . "?AppId=" . $pluginApi . "&ApiKey=" . $options['ohi_api_key'] . "&LinksPerDay=0&BatchName=" . $name;
                $params = array('http' => array(
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "User-Agent:MyAgent/1.0\r\n",
                        'method' => 'POST',
                        'content' => $links,
                ));
            }
            break;
        case 2: {
                $sendto = "http://linklicious.co/api/uploadlinks";
                $pluginApi = "025eef7f-ea76-4d23-9696-ca1b57b74d78";
                $name = str_replace(" ", "%20", date('Y-m-d h:i:s ') . get_option('blogname'));
                $url = $sendto . "?AppId=" . $pluginApi . "&ApiKey=" . $options['Linklicious_api_key'] . "&LinksPerDay=0&BatchName=" . $name;
                $params = array('http' => array(
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "User-Agent:MyAgent/1.0\r\n",
                        'method' => 'POST',
                        'content' => $links,
                ));
            }
            break;
        case 3: {
                $url = "http://www.indexification.com/api.php";

                $params = array('http' => array(
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "User-Agent:MyAgent/1.0\r\n",
                        'method' => 'POST',
                        'content' => 'apikey=' . $options['Indexification_api_key'] . '&urls=' . rawurlencode($links) . '"&dripfeed=disabled&campaign=' . str_replace(" ", "%20", date('Y-m-d h:i:s ') . get_option('blogname')),
                ));
            }
            break;
        case 4: {
                $url = 'http://www.lindexed.com/api/api.php?apikey=' . $options['Lindexed_api_key'] . '&urls=' . rawurlencode($links) . '"&serviceid=' . str_replace(" ", "%20", date('Y-m-d h:i:s ') . get_option('blogname'));

                $params = array('http' => array(
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "User-Agent:MyAgent/1.0\r\n",
                        'method' => 'GET'
                ));
            }
            break;
    }



    $ctx = @stream_context_create($params);

    $fp = @fopen($url, 'rb', false, $ctx);
    if (!$fp) {
        update_option('fatal_error', "Problem with sending Data , contact your system administrator");
    }
    $response = @stream_get_contents($fp);
    if ($response === false) {
        update_option('fatal_error', "Problem reading data  , contact your system administrator");
    }




    return $response;
}

function log_it($message) {
    $nl = array();

    $log = get_option('log_index_all', $nl);
    $max = 200;
    if (sizeof($log) > $max) {
        array_splice($log, 0, sizeof($log) - $max);
    }

    $log[sizeof($log)] = array(
        "date" => date('Y-m-d h:i:s '),
        "message" => $message
    );



    update_option('log_index_all', $log);
}

function onehourindexing_scheduled_send() {

    global $post, $options;
    $nl = array();

    $ids = array();
    $linksa = '';
    $linksb = '';


    $ohi_last_id_indexed = (int) get_option('ohi_last_id_indexed', 0);
    $ohi_total_numbers_indexed = (int) get_option('ohi_total_numbers_indexed', 0);

    $Indexification_last_id_indexed = (int) get_option('Indexification_last_id_indexed', 0);
    $Indexification_total_numbers_indexed = (int) get_option('Indexification_total_numbers_indexed', 0);

    $Linklicious_last_id_indexed = (int) get_option('Linklicious_last_id_indexed', 0);
    $Linklicious_total_numbers_indexed = (int) get_option('Linklicious_total_numbers_indexed', 0);

    $Lindexed_last_id_indexed = (int) get_option('Lindexed_last_id_indexed', 0);
    $Lindexed_total_numbers_indexed = (int) get_option('Lindexed_total_numbers_indexed', 0);

    $recent_posts = wp_get_recent_posts(array('numberposts' => '1'));
    $theLastPostID = (int) $recent_posts[0]['ID'];
    update_option('fatal_error', '');
    update_option("ohi_error", '');
    update_option("Indexification_error", '');
    update_option("Linklicious_error", '');
    update_option("Lindexed_error", '');


    if (ini_get('allow_url_fopen')) {
/////////////////////////////////////////////////////////////////////////////////////////////////
        if ($ohi_last_id_indexed != $theLastPostID) {
            for ($index = $ohi_last_id_indexed; $index <= $theLastPostID; $index++) {
                array_push($ids, $index);
            }

            $tmp_post = $post;
            $args = array('numberposts' => ($theLastPostID + 1), 'post__in' => $ids, 'post_status' => 'publish');

            $posts = get_posts($args);

            if (sizeof($posts) >= 10) {
                foreach ($posts as $post) :

                    $linksa .= (get_permalink($post->ID)) . "
";

                endforeach;
                $post = $tmp_post;

                //send a
                if ($options['ohi_api_key'] != '') {

                    $response = send_to_ohi($linksa, 1);
                    $result = json_decode($response, TRUE);
                    if (@array_key_exists("LinksAdded", $result)) {
                        $ohi_total_numbers_indexed +=$result['LinksAdded'];
                        update_option('ohi_total_numbers_indexed', $ohi_total_numbers_indexed);
                        update_option('ohi_last_Submited', date('Y-m-d h:i:s '));
                        update_option("ohi_last_id_indexed", $theLastPostID);
                        $message = "onehourindexing.co : " . $result['LinksAdded'] . " links submited   ";
                    } else if (@array_key_exists("Error", $result)) {
                        update_option("ohi_error", $result['ErrorMessage']);
                        $message = "onehourindexing.co : " . $result['ErrorMessage'];
                    }

                    log_it($message);
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////       
        if ($Linklicious_last_id_indexed != $theLastPostID) {
            for ($index = $Linklicious_last_id_indexed; $index <= $theLastPostID; $index++) {
                array_push($ids, $index);
            }
            $tmp_post = $post;
            $args = array('numberposts' => ($theLastPostID + 1), 'post__in' => $ids, 'post_status' => 'publish');

            $posts = get_posts($args);

            foreach ($posts as $post) :

                $linksa .= (get_permalink($post->ID)) . "
";

            endforeach;
            $post = $tmp_post;


            if ($options['Linklicious_api_key'] != '') {

                $response = send_to_ohi($linksa, 2);
                $result = json_decode($response, TRUE);
                if (@array_key_exists("LinksAdded", $result)) {
                    $Linklicious_total_numbers_indexed +=$result['LinksAdded'];
                    update_option('Linklicious_total_numbers_indexed', $Linklicious_total_numbers_indexed);
                    update_option('Linklicious_last_Submited', date('Y-m-d h:i:s '));
                    update_option("Linklicious_last_id_indexed", $theLastPostID);
                    $message = "linklicious.co : " . $result['LinksAdded'] . " links submited   ";
                } else if (@array_key_exists("Error", $result)) {
                    update_option("Linklicious_error", $result['ErrorMessage']);
                    $message = "linklicious.co : " . $result['ErrorMessage'];
                }

                log_it($message);
            }
        }








        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    




        if ($Indexification_last_id_indexed != $theLastPostID) {
            for ($index = $Indexification_last_id_indexed; $index <= $theLastPostID; $index++) {
                array_push($ids, $index);
            }
            $tmp_post = $post;
            $args = array('numberposts' => ($theLastPostID + 1), 'post__in' => $ids, 'post_status' => 'publish');

            $posts = get_posts($args);

            foreach ($posts as $post) :
                $linksb.= (get_permalink($post->ID)) . "|";
            endforeach;
            $post = $tmp_post;


            if ($options['Indexification_api_key'] != '') {

                $result = send_to_ohi($linksb, 3);

                if ($result == "OK") {
                    $Indexification_total_numbers_indexed += count($posts);
                    update_option('Indexification_total_numbers_indexed', $Indexification_total_numbers_indexed);
                    update_option('Indexification_last_Submited', date('Y-m-d h:i:s '));
                    update_option("Indexification_last_id_indexed", $theLastPostID);
                    $message = "indexification.com : links submited   ";
                } else {

                    $message = "indexification.com : " . $result;
                    update_option("Indexification_error", $result);
                }

                log_it($message);
            }
        }




        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    




        if ($Lindexed_last_id_indexed != $theLastPostID) {
            for ($index = $Lindexed_last_id_indexed; $index <= $theLastPostID; $index++) {
                array_push($ids, $index);
            }
            $tmp_post = $post;
            $args = array('numberposts' => ($theLastPostID + 1), 'post__in' => $ids, 'post_status' => 'publish');

            $posts = get_posts($args);

            foreach ($posts as $post) :
                $linksb.= (get_permalink($post->ID)) . "|";
            endforeach;
            $post = $tmp_post;


            if ($options['Lindexed_api_key'] != '') {

                $result = send_to_ohi($linksb, 4);

                if (strpos($result, "Finished creating the campaign")) {
                    $Lindexed_total_numbers_indexed += count($posts);
                    update_option('Lindexed_total_numbers_indexed', $Lindexed_total_numbers_indexed);
                    update_option('Lindexed_last_Submited', date('Y-m-d h:i:s '));
                    update_option('Lindexed_last_id_indexed', $theLastPostID);
                    $message = "lindexed.com : links submited   ";
                } else {

                    $message = "lindexed.com : " . $result;
                    update_option('Lindexed_error', $result);
                }
                log_it($message);
            }
        }
    } else {
        update_option('fatal_error', "outgoing connection is not allowed , contact your system administrator");
    }
}

?>