<?php

class Onehourindexing_Options {

    private $general_plugin_options = 'general_plugin_options';
    private $onehourindexing_plugin_options = 'onehourindexing_plugin_options';
    private $Linklicious_plugin_options = 'Linklicious_plugin_options';
    private $Indexification_plugin_options = 'Indexification_plugin_options';
    private $Lindexed_plugin_options = 'Lindexed_plugin_options';
    private $Log_plugin_options = 'log_index_all';
    private $plugin_settings_tabs = array();

    function __construct() {
        add_action('init', array(&$this, 'load_settings'));
        add_action('admin_init', array(&$this, 'register_general_options'));
        add_action('admin_init', array(&$this, 'register_onehourindexing_options'));
        add_action('admin_init', array(&$this, 'register_Linklicious_options'));
        add_action('admin_init', array(&$this, 'register_Indexification_options'));
        add_action('admin_init', array(&$this, 'register_Lindexed_options'));
        add_action('admin_init', array(&$this, 'register_Log_options'));
        add_action('admin_menu', array(&$this, 'add_admin_menus'));
    }

    function load_settings() {
        $this->general_options = (array) get_option($this->general_plugin_options);
        $this->onehourindexing_options = (array) get_option($this->onehourindexing_plugin_options);
        $this->Linklicious_options = (array) get_option($this->Linklicious_plugin_options);
        $this->Indexification_options = (array) get_option($this->Indexification_plugin_options);
        $this->Lindexed_options = (array) get_option($this->Lindexed_plugin_options);
        $this->Log_options = (array) get_option($this->Log_plugin_options);
    }

    function register_general_options() {
        $this->plugin_settings_tabs[$this->general_plugin_options] = 'General options';

        register_setting($this->general_plugin_options, $this->general_plugin_options);
        add_settings_section('section_general', 'General options', array(&$this, 'general_desc'), $this->general_plugin_options);
        add_settings_field('', 'Submit new posts every :', array(&$this, 'general_field_frq'), $this->general_plugin_options, 'section_general');
    }

    function register_onehourindexing_options() {
        $this->plugin_settings_tabs[$this->onehourindexing_plugin_options] = 'OneHourIndexing.co';

        register_setting($this->onehourindexing_plugin_options, $this->onehourindexing_plugin_options);
        add_settings_section('asection_general', 'OneHourIndexing.co', array(&$this, 'onehourindexing_desc'), $this->onehourindexing_plugin_options);

        add_settings_field('', 'API key :', array(&$this, 'onehourindexing_field_api'), $this->onehourindexing_plugin_options, 'asection_general');
    }

    function register_Linklicious_options() {
        $this->plugin_settings_tabs[$this->Linklicious_plugin_options] = 'Linklicious.co';

        register_setting($this->Linklicious_plugin_options, $this->Linklicious_plugin_options);
        add_settings_section('section_general', 'Linklicious.co', array(&$this, 'Linklicious_general_desc'), $this->Linklicious_plugin_options);
        add_settings_field('', 'API key :', array(&$this, 'Linklicious_field_api'), $this->Linklicious_plugin_options, 'section_general');
    }

    function register_Indexification_options() {
        $this->plugin_settings_tabs[$this->Indexification_plugin_options] = 'Indexification.com';

        register_setting($this->Indexification_plugin_options, $this->Indexification_plugin_options);
        add_settings_section('section_general', 'Indexification.com', array(&$this, 'Indexification_general_desc'), $this->Indexification_plugin_options);
        add_settings_field('', 'API key :', array(&$this, 'Indexification_field_api'), $this->Indexification_plugin_options, 'section_general');
    }

    function register_Lindexed_options() {
        $this->plugin_settings_tabs[$this->Lindexed_plugin_options] = 'Lindexed.com';

        register_setting($this->Lindexed_plugin_options, $this->Lindexed_plugin_options);
        add_settings_section('section_general', 'Lindexed.com', array(&$this, 'Lindexed_general_desc'), $this->Lindexed_plugin_options);
        add_settings_field('', 'API key :', array(&$this, 'Lindexed_field_api'), $this->Lindexed_plugin_options, 'section_general');
    }

    function register_Log_options() {
        $this->plugin_settings_tabs[$this->Log_plugin_options] = 'Log';

        register_setting($this->Log_plugin_options, $this->Log_plugin_options);
        add_settings_section('section_general', 'Log', array(&$this, 'Log_general_desc'), $this->Log_plugin_options);
        add_settings_field('', '', array(&$this, 'Log_field'), $this->Log_plugin_options, 'section_general');
    }

    function general_desc() {
        echo 'change the frequency of submission to the indexations services.';
    }

    function onehourindexing_desc() {
        echo '<p>One Hour Indexing offers a unique solution to indexing and pinging your backlinks. 100% Google safe, and guaranteed results.</p>
        <p>You must have a Basic or above plan to use the API. Once logged in, you can find your API key under the My Account / Dashboard page.<br />
    <a target="_blank" href="http://onehourindexing.co/?utms=wp_indexify_pro&utmc=wp_indexify_pro&utmm=web">Register for an account at onehourindexing.co</a></p>';
    }

    function Linklicious_general_desc() {
        echo '<p>We tested and retested indexing strategies for over a year and developed a recipe for getting <span class="text-error">Google, AHREFs, and Majestic</span> to not only crawl but to also index your links.<br /> 
	If you need proof and want to see results, we\'re the ONLY crawling and indexing service to offer this capability.</p>
    <p>You must have a Basic or above plan to use the API. Once logged in, you can find your API key under the My Account / Dashboard page.<br />
	<a target="_blank" href="http://linklicious.co/?utms=wp_indexify_pro&utmc=wp_indexify_pro&utmm=web">Register for an account at linklicious.co</a></p>';
    }

    function Indexification_general_desc() {
        echo '<p>Get your Indexification API key from the members section of the site.<br />
    <a target="_blank" href="http://lts2.me/l/94c59fe2">Register for an account at Indexification.com</a></p>';
    }

    function Lindexed_general_desc() {
        echo '<p>You can find your Lindexed API key under the API tab once you are logged in.<br />
    <a target="_blank" href="http://www.lindexed.com/">Register for an account at lindexed.com</a></p>';
    }

    function Log_general_desc() {
        echo 'WP Indexify PRO 2.0 activity  log:';
    }

    function general_field_frq() { ?>
        <select name='general_plugin_options[api_frq]' >
            <?php for ($index = 24; $index >= 1; $index--) {?>
            <option value="<?php echo $index; ?>" <?php if ($this->general_options['api_frq'] == $index) echo "selected='selected'"; ?> > <?php echo $index; ?> hour<?php if ($index > 1) echo "s"; ?></option>
            <?php } ?>
        </select>
    <?php }

        function onehourindexing_field_api() {
            echo "<input style='width: 300px;' name='onehourindexing_plugin_options[ohi_api_key]' type='text' value='{$this->onehourindexing_options['ohi_api_key']}'/>";
        }

        function Linklicious_field_api() {
            echo "<input style='width: 300px;' name='Linklicious_plugin_options[Linklicious_api_key]' type='text' value='{$this->Linklicious_options['Linklicious_api_key']}'/>";
        }

        function Indexification_field_api() {
            echo "<input style='width: 300px;' name='Indexification_plugin_options[Indexification_api_key]' type='text' value='{$this->Indexification_options['Indexification_api_key']}'/>";
        }

        function Lindexed_field_api() {
            echo "<input style='width: 300px;' name='Lindexed_plugin_options[Lindexed_api_key]' type='text' value='{$this->Lindexed_options['Lindexed_api_key']}'/>";
        }

        function Log_field() {
            $start_from = @intval($_GET['page_log']) * 30;
            $sizelog = sizeof($this->Log_options);

            if ($sizelog > 30) {
                $rest_sizelog = $sizelog;
                $index = 0;
                echo '<div class="nav-tab-wrapper" >';
                while ($rest_sizelog > 0) {
                    $class = 'nav-tab';
                    if ($index == @intval($_GET['page_log'])) {
                        $class.=" nav-tab-active ";
                    }
                    echo "<a class='" . $class . "' href ='options-general.php?page=&tab=log_index_all&page_log=" . $index . "'> " . ($index + 1) . "</a>";
                    $rest_sizelog -=30;
                    $index++;
                }
                echo '</div>';
            }
            ?>
        <style>
			#submit
			{
			display:none;
			}
            #table_log
            {
                font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
                font-size: 12px;


                text-align: center;
                border-collapse: collapse;
            }


            #table_log_head
            {
                font-weight: bold;
                background: #eff2ff;
                color: #039;
                border-bottom: 1px dashed grey;
                  font-size: 14px;
            }
            #table_log td
            {
                padding: 0px 15px;
                color: #669;
                border: 1px solid grey;
            }
            .oce-first
            {
                background: #d0dafd;
                border-right: 10px solid transparent;
                border-left: 10px solid transparent;
            }
            #table_log tr:hover td
            {
                color: #339;
                background: #eff2ff;
            }

        </style>        
        
        <table id="table_log" >
            <tr><td id="table_log_head" >date</td> <td id="table_log_head" >message</td></tr>
        <?php
        $show_log = array_reverse($this->Log_options);
        for ($index = $start_from; $index < $start_from + 30 && $index < $sizelog; $index++) { ?>
            <tr><td><?php echo $show_log[$index]['date']; ?></td><td><?php echo $show_log [$index]['message']; ?></td></tr>
        <?php } ?>
        </table>

        <?php
    }

    function add_admin_menus() {
        add_options_page('WP Indexify PRO 2.0', 'WP Indexify PRO 2.0', 'manage_options', $this->plugin_options_key, array(&$this, 'plugin_options_page'));
    }

    function plugin_options_page() {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : $this->general_plugin_options;
        ?>
        <div class="wrap">
        <?php $this->plugin_options_tabs(); ?>
            <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>
            <?php settings_fields($tab); ?>
        <?php do_settings_sections($tab); ?>
        <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    function plugin_options_tabs() {
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : $this->general_plugin_options;

        screen_icon();
        echo '<H2>WP Indexify PRO 2.0</h2>
                    <h2 class="nav-tab-wrapper">';
        foreach ($this->plugin_settings_tabs as $tab_key => $tab_caption) {
            $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
            echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
        }
        echo '</h2>';
    }

} ?>