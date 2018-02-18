

<div class="wrap">
    <h1> Adult Video Settings </h1>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Manage Settings</a> </li>
        <li><a href="#tab-2">Custom Settings</a> </li>
        <li><a href="#tab-3">Update</a> </li>
        <li><a href="#tab-4">About</a> </li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <form method="post" action="options.php">
                <?php
                settings_fields('rza_managers_settings');
                do_settings_sections('rza_settings_managers');
                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-2" class="tab-pane">
            <form method="post" action="options.php">
                <?php
                settings_fields('rza_options_group');
                do_settings_sections('rza_settings');
                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-3" class="tab-pane">
            <h3>update</h3>
        </div>

        <div id="tab-4" class="tab-pane">
            <h3>updasdasdasate</h3>
        </div>
    </div>


