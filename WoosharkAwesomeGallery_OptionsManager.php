<?php
/*
    "WordPress Plugin Template" Copyright (C) 2020 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

class WoosharkAwesomeGallery_OptionsManager
{

    public function getOptionNamePrefix()
    {
        return get_class($this) . '_';
    }


    /**
     * Define your options meta data here as an array, where each element in the array
     * @return array of key=>display-name and/or key=>array(display-name, choice1, choice2, ...)
     * key: an option name for the key (this name will be given a prefix when stored in
     * the database to ensure it does not conflict with other plugin options)
     * value: can be one of two things:
     *   (1) string display name for displaying the name of the option to the user on a web page
     *   (2) array where the first element is a display name (as above) and the rest of
     *       the elements are choices of values that the user can select
     * e.g.
     * array(
     *   'item' => 'Item:',             // key => display-name
     *   'rating' => array(             // key => array ( display-name, choice1, choice2, ...)
     *       'CanDoOperationX' => array('Can do Operation X', 'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber'),
     *       'Rating:', 'Excellent', 'Good', 'Fair', 'Poor')
     */
    public function getOptionMetaData()
    {
        return array();
    }

    /**
     * @return array of string name of options
     */
    public function getOptionNames()
    {
        return array_keys($this->getOptionMetaData());
    }

    /**
     * Override this method to initialize options to default values and save to the database with add_option
     * @return void
     */
    protected function initOptions()
    { }

    /**
     * Cleanup: remove all options from the DB
     * @return void
     */
    protected function deleteSavedOptions()
    {
        $optionMetaData = $this->getOptionMetaData();
        if (is_array($optionMetaData)) {
            foreach ($optionMetaData as $aOptionKey => $aOptionMeta) {
                $prefixedOptionName = $this->prefix($aOptionKey); // how it is stored in DB
                delete_option($prefixedOptionName);
            }
        }
    }

    /**
     * @return string display name of the plugin to show as a name/title in HTML.
     * Just returns the class name. Override this method to return something more readable
     */
    public function getPluginDisplayName()
    {
        return get_class($this);
    }

    /**
     * Get the prefixed version input $name suitable for storing in WP options
     * Idempotent: if $optionName is already prefixed, it is not prefixed again, it is returned without change
     * @param  $name string option name to prefix. Defined in settings.php and set as keys of $this->optionMetaData
     * @return string
     */
    public function prefix($name)
    {
        $optionNamePrefix = $this->getOptionNamePrefix();
        if (strpos($name, $optionNamePrefix) === 0) { // 0 but not false
            return $name; // already prefixed
        }
        return $optionNamePrefix . $name;
    }

    /**
     * Remove the prefix from the input $name.
     * Idempotent: If no prefix found, just returns what was input.
     * @param  $name string
     * @return string $optionName without the prefix.
     */
    public function &unPrefix($name)
    {
        $optionNamePrefix = $this->getOptionNamePrefix();
        if (strpos($name, $optionNamePrefix) === 0) {
            return substr($name, strlen($optionNamePrefix));
        }
        return $name;
    }

    /**
     * A wrapper function delegating to WP get_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param $default string default value to return if the option is not set
     * @return string the value from delegated call to get_option(), or optional default value
     * if option is not set.
     */
    public function getOption($optionName, $default = null)
    {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        $retVal = get_option($prefixedOptionName);
        if (!$retVal && $default) {
            $retVal = $default;
        }
        return $retVal;
    }

    /**
     * A wrapper function delegating to WP delete_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @return bool from delegated call to delete_option()
     */
    public function deleteOption($optionName)
    {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return delete_option($prefixedOptionName);
    }

    /**
     * A wrapper function delegating to WP add_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param  $value mixed the new value
     * @return null from delegated call to delete_option()
     */
    public function addOption($optionName, $value)
    {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return add_option($prefixedOptionName, $value);
    }

    /**
     * A wrapper function delegating to WP add_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param  $value mixed the new value
     * @return null from delegated call to delete_option()
     */
    public function updateOption($optionName, $value)
    {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return update_option($prefixedOptionName, $value);
    }

    /**
     * A Role Option is an option defined in getOptionMetaData() as a choice of WP standard roles, e.g.
     * 'CanDoOperationX' => array('Can do Operation X', 'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber')
     * The idea is use an option to indicate what role level a user must minimally have in order to do some operation.
     * So if a Role Option 'CanDoOperationX' is set to 'Editor' then users which role 'Editor' or above should be
     * able to do Operation X.
     * Also see: canUserDoRoleOption()
     * @param  $optionName
     * @return string role name
     */
    public function getRoleOption($optionName)
    {
        $roleAllowed = $this->getOption($optionName);
        if (!$roleAllowed || $roleAllowed == '') {
            $roleAllowed = 'Administrator';
        }
        return $roleAllowed;
    }

    /**
     * Given a WP role name, return a WP capability which only that role and roles above it have
     * http://codex.wordpress.org/Roles_and_Capabilities
     * @param  $roleName
     * @return string a WP capability or '' if unknown input role
     */
    protected function roleToCapability($roleName)
    {
        switch ($roleName) {
            case 'Super Admin':
                return 'manage_options';
            case 'Administrator':
                return 'manage_options';
            case 'Editor':
                return 'publish_pages';
            case 'Author':
                return 'publish_posts';
            case 'Contributor':
                return 'edit_posts';
            case 'Subscriber':
                return 'read';
            case 'Anyone':
                return 'read';
        }
        return '';
    }

    /**
     * @param $roleName string a standard WP role name like 'Administrator'
     * @return bool
     */
    public function isUserRoleEqualOrBetterThan($roleName)
    {
        if ('Anyone' == $roleName) {
            return true;
        }
        $capability = $this->roleToCapability($roleName);
        return current_user_can($capability);
    }

    /**
     * @param  $optionName string name of a Role option (see comments in getRoleOption())
     * @return bool indicates if the user has adequate permissions
     */
    public function canUserDoRoleOption($optionName)
    {
        $roleAllowed = $this->getRoleOption($optionName);
        if ('Anyone' == $roleAllowed) {
            return true;
        }
        return $this->isUserRoleEqualOrBetterThan($roleAllowed);
    }

    /**
     * see: http://codex.wordpress.org/Creating_Options_Pages
     * @return void
     */
    public function createSettingsMenu()
    {
        $pluginName = $this->getPluginDisplayName();
        //create new top-level menu
        add_menu_page(
            $pluginName . ' Plugin Settings',
            $pluginName,
            'administrator',
            get_class($this),
            array(&$this, 'settingsPage')
            /*,plugins_url('/images/icon.png', __FILE__)*/
        ); // if you call 'plugins_url; be sure to "require_once" it

        //call register settings function
        add_action('admin_init', array(&$this, 'registerSettings'));
    }

    public function registerSettings()
    {
        $settingsGroup = get_class($this) . '-settings-group';
        $optionMetaData = $this->getOptionMetaData();
        foreach ($optionMetaData as $aOptionKey => $aOptionMeta) {
            register_setting($settingsGroup, $aOptionMeta);
        }
    }

    /**
     * Creates HTML for the Administration page to set options for this plugin.
     * Override this method to create a customized page.
     * @return void
     */
    public function settingsPage()
    





        {
            add_action('wp_enqueue_scripts', 'jquery_add_to_contact');
            // wp_enqueue_script('underscore', plugin_dir_url(__FILE__) . 'js/underscore.js', array('jquery'), NULL, false);
            wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), NULL, false);
            wp_enqueue_script('toast', plugin_dir_url(__FILE__) . 'js/jquery.toast.min.js', array('jquery'), NULL, false);
            wp_enqueue_style('bootstrapCss', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css');
            wp_enqueue_style('toastCss', plugin_dir_url(__FILE__) . 'css/jquery.toast.min.css');
            wp_enqueue_style('custom', plugin_dir_url(__FILE__) . 'css/main.css');
            wp_enqueue_script('quill', plugin_dir_url(__FILE__) . 'js/quill.js', array('jquery'), NULL, false);
            wp_enqueue_style('quillCss', plugin_dir_url(__FILE__) . 'css/quill.css');
            wp_enqueue_script('math', plugin_dir_url(__FILE__) . 'js/math.js', array('jquery'), NULL, false);
            wp_enqueue_script('sync', plugin_dir_url(__FILE__) . 'js/sync.js', array('jquery'), NULL, false);
            wp_enqueue_script('startup', plugin_dir_url(__FILE__) . 'js/startup.js', array('jquery', 'math', 'toast'), NULL, false);
    
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.', 'wooshark-aliexpress-importer'));
            }
    
            wp_localize_script(
                'startup',
                'wooshark_params',
                array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('ajax-nonce')
                )
            );
    
    
    
            // HTML for the page
            $settingsGroup = get_class($this) . '-settings-group';
            ?>
                <script src="https://kit.fontawesome.com/45abdd2158.js" crossorigin="anonymous"></script>
    
    
    
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="padding-top:50px">
                    <li class="nav-item active">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Wish import</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" id="pills-connect-products" data-toggle="pill" href="#pills-products" role="tab" aria-controls="pills-connect" aria-selected="false">Products - wooshark <i class="fa fa-refresh"> </i> </a>
                    </li>
    
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="go-pro-tab" data-toggle="pill" href="#go-pro" role="tab" aria-controls="go-pro" aria-selected="true">Go Pro</a>
                    </li>
                    -->
    
                </ul>
    
    
    
    
    
                <!-- ///////////////////////////////////////////// -->
                <div class="tab-content" id="pills-tabContent">
    
    
    
                    <div class="tab-pane active in" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    
                        <div class="wrap">
                            <!-- <div style="margin-top:20px; margin-top: 20px;border: 1px solid rgba(1, 4, 12, 0.38);padding: 13px;border-radius: 5px;"> -->
                                <!-- <h3> Import products From AliExpress to store</h3> -->
    
    
                                <div class="loader2" style="display:none">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
    
    
                                <div class="loader3" style="display:none">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
    
    
                                <!-- <label for="productSku"> Insert by Sku :</label>
                                <div style="display:flex">
                                    <div style="flex:4 1 80%; margin-right:10px">
                                        <input class="form-control" type="number" id="productSku" placeholder="paste AliExpress product Sku" />
                                    </div>
                                    <div style="flex: 1 1 20%">
                                        <button class="btn btn-primary" style="width:100%" id="importProductToShopBySky"> Import</button>
    
                                    </div>
                                </div>
    
    
                                <div style="height:30px">
                                </div>
    
                                <label for="productUrl"> Insert by Url :</label>
                                <div style="display:flex">
                                    <div style="flex: 4 1 80%; margin-right:10px">
    
                                        <input class="form-control" type="text" id="productUrl" placeholder="paste AliExpress product url" />
                                    </div>
                                    <div style="flex: 1 1 20%">
    
                                        <button class="btn btn-primary" style="width:100%" id="importProductToShopByUrl"> Import</button>
                                    </div>
                                </div> -->
    
    
    
    
                            <!-- </div> -->
    
                            <div class="search-form" style="border: rgba(1, 4, 12, 0.38) solid 1px;padding: 17px;border-radius: 5px;margin-bottom: 25px;">
                                <label>Search by keyword</label><input placeholder='Search keyword example, shoes, smartphones, etc..' type='text' class="form-control" id="searchKeyword">
                                <button style="margin-top:10px" class="btn btn-success" id="WishseachProductsButton"> Search Products</button>
    
                                
                                <!-- <label style="padding:10px; margin-top:10px; width:100%; background-color:beige; border-radius: 5px;">
                                    Price sorting
                                </label>
                                <div style="padding:10px; margin-top:10px"> <input type="radio" name="sort" value="orignalPriceUp" > Price ascending<br></div>
                                 <div style="padding:10px; margin-top:10px"><input type="radio" name="sort" value="orignalPriceDown"> Price descending<br></div>
    
    
                                 <label style="padding:10px; width:100%; background-color:beige; border-radius: 5px;">
                                    Preferences
                                </label>
    
                                <label style="padding:10px; width:100%; background-color:beige; border-radius: 5px;">
                                    Current selected language: English, current select currency USD, Other languages and currencies are available on the premuim version
                                </label> -->
    
    
    <!-- 
                            <div class="checkbox">
                                <label><input style="padding:10px; margin-top:10px" id="highQualityItems"  type="checkbox" />  only high quality Items </label>
                            </div>
     -->
    
    
    
    
    
                            </div>
    
                            <div style="border: rgba(1, 4, 12, 0.38) solid 1px;padding: 17px;border-radius: 5px;margin-bottom: 25px;">
                                <div class="form-check">
                                </div>
    
                                <button disabled id="importAllProductOnThisPage" class="btn btn-warning" style="width:100%; magin-top: 10px"> Import all products on this page </button>
    
                                <!-- <label class="currencyDetails" style="margin-top:10px; padding:10px; width:100%; background-color:beige; border-radius: 5px;">
                                   
                                </label> -->
    
    
                            </div>
    
                            <div id="product-search-container" style="display:flex; -justify-content: space-between;flex-wrap:wrap; border: 1px solid rgba(1, 4, 12, 0.38);border-radius: 8px;">
    
                            </div>
    
                            <nav aria-label="pagination" style="text-align:center;">
                                <ul id="pagination" class="pagination pagination-lg justify-content-center">
                                </ul>
                            </nav>
    
    
    
    
                            <hr>
                            <div style="display:flex">
                            </div>
    
    
    
                        </div>
    
    
    
    
                    </div>
    
    
    
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
                    <!-- ///////////////////////////////////////////// -->
    
    
    
    
                    <div class="tab-pane fade" id="pills-products" role="tabpanel" aria-labelledby="pills-products-products">
    
                        <div class="loader2" style="display:none; z-index:9999">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
    
    
                        <!-- <div><label style="background-color:beige;border-radius: 5px; padding:15px; width:98%"> Search product<label></div> -->
    
    
    
                        <!-- <div class="input-group">
                            <input type="text" style="width:99%" class="form-control" id="skusearchValue" placeholder='Search by sku' />
    
                            <span class="input-group-btn">
                                <button style="  margin-bottom:20px" class="btn btn-primary" id="searchBySku">Search by Sku</button>
                            </span>
                        </div>
                        <button disabled style="width:100%; margin-top:20px; margin-bottom:20px" class="btn btn-warning" id="updateCurrentPage">Update Stock and price on current page</button> -->
    
                        <!-- <div class="log-sync-product" style="background-color:black; padding:5px; max-height:500px; overflow-y:scroll">
    
                        </div> -->
    
                        <table id="products-wooshark" class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">image</th>
                                    <th width="10%">sku</th>
                                    <th width="10%">id</th>
                                    <th width="25%">title</th>
                                    <th width="15%">link to original page</th>
                                    <th width="15%">Update product price and quantity</th>
                                    <th width="14%">Import Reviews and rating</th>
    
                                </tr>
                            </thead>
    
                        </table>
    
    
                        <div class="loader2" style="display:none">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
    
    
    
                        <nav aria-label="product-pagination" style="text-align:center;">
                            <ul id="product-pagination" class="pagination pagination-lg justify-content-center">
                            </ul>
                        </nav>
    
    
    
                    </div>
    
    
                    <!-- <div class="tab-pane fade" id="go-pro" role="tabpanel" aria-labelledby="go-pro-products">
    
                    <label style="padding:10px; width:100%; background-color:beige; border-radius: 5px;">
                                    Free version
                        </label>
    
                        <div>
                        1- Unlimited import
                        </div>
                        <div>
                        2- Import images (main image + 1 additional image)
                        </div>
                        <div>
                        3- Import variations (price, sale price and quantity)
                        </div>
                        <div>
                        4- Import description
                        </div>
                        <div>
                        4- Open original product url
                        </div>
                        <div>
                        5- Import by sku, by url or from the list
                        </div>
    
    
    
                        <label style="padding:10px; width:100%; background-color:beige; border-radius: 5px;">
                                    Go pro and Enjoy all our advanced features that make dropshipping easier for 
                        </label>
                        <div>
                        1- chrome extension + wordpress plugin
                        </div>
                        <div>
                        2- Multi stores support
                        </div>
                        <div>
                        3- Markup price formula (calculate automatic price according to formula)
                        </div>
                        <div>
                        4- import reviews (content, images, rating, date, email and reviewer)
                        </div>
                        <div>
                        5- Add reviews to existing products
                        </div>
                        <div>
                        6- link to visit original product url
                        </div>
                        <div>
                        7- Save preference and configuration of import and update
                        </div>
                        <div>
                        8- Bulk import with global import configuration
                        </div>
                        <div>
                        9- import all images
                        </div>
                        <div>
                        10- import product specification
                        </div>
                        <div>
                        11- single & Bulk  update stock, price and sale price (with saved preferences)
                        </div>
                        <div>
                        12- support almost all aliexpress languages and currencies automatically
                        </div>
                        <div>
                        13- apply charm pricing
                        </div>
                        <div>
                        14- import variations images
                        </div>
                        <div>
                        15- edit varitions price, quantity, etc..
                        </div>
                        <div>
                        16- import, add and edit specifications
                        </div>
                        <div>
                        17- Place order automatically on AliExpress
                        </div>
                        <div>
                        18- edit description, remove images, remove text, add text, format text, etc .. 
                        </div>
                        <div>
                        19- Edit images, crop, resize, add border using lunapic editor
                        </div>
                        <div>
                        20- Flexibility to add new features
                        </div>
                        <div>
                        21- Unlimited import
                        </div>
                        <div>
                        22- Differentiate already imported products
                        </div>
    
                       <button class="btn btn-primary" ><a  style="color:white" href="https://wooshark.com/aliexpress" target="_blank"> Get you License from here</a> </button>
                    </div> -->
                   
                    
                    
                    
                    <?php

                }

                /**
                 * Helper-function outputs the correct form element (input tag, select tag) for the given item
                 * @param  $aOptionKey string name of the option (un-prefixed)
                 * @param  $aOptionMeta mixed meta-data for $aOptionKey (either a string display-name or an array(display-name, option1, imagePreference, ...)
                 * @param  $savedOptionValue string current value for $aOptionKey
                 * @return void
                 */
                protected function createFormControl($aOptionKey, $aOptionMeta, $savedOptionValue)
                {
                    if (is_array($aOptionMeta) && count($aOptionMeta) >= 2) { // Drop-down list
                        $choices = array_slice($aOptionMeta, 1);
                        ?>
                <p><select name="<?php echo $aOptionKey ?>" id="<?php echo $aOptionKey ?>">
                        <?php
                                    foreach ($choices as $aChoice) {
                                        $selected = ($aChoice == $savedOptionValue) ? 'selected' : '';
                                        ?>
                            <option value="<?php echo $aChoice ?>" <?php echo $selected ?>><?php echo $this->getOptionValueI18nString($aChoice) ?></option>
                        <?php
                                    }
                                    ?>
                    </select></p>
            <?php

                    } else { // Simple input field
                        ?>
                <p><input type="text" name="<?php echo $aOptionKey ?>" id="<?php echo $aOptionKey ?>" value="<?php echo esc_attr($savedOptionValue) ?>" size="50" /></p>
        <?php

                }
            }

            /**
             * Override this method and follow its format.
             * The purpose of this method is to provide i18n display strings for the values of options.
             * For example, you may create a options with values 'true' or 'false'.
             * In the options page, this will show as a drop down list with these choices.
             * But when the the language is not English, you would like to display different strings
             * for 'true' and 'false' while still keeping the value of that option that is actually saved in
             * the DB as 'true' or 'false'.
             * To do this, follow the convention of defining option values in getOptionMetaData() as canonical names
             * (what you want them to literally be, like 'true') and then add each one to the switch statement in this
             * function, returning the "__()" i18n name of that string.
             * @param  $optionValue string
             * @return string __($optionValue) if it is listed in this method, otherwise just returns $optionValue
             */
            protected function getOptionValueI18nString($optionValue)
            {
                switch ($optionValue) {
                    case 'true':
                        return __('true', 'wooshark-awesome-gallery');
                    case 'false':
                        return __('false', 'wooshark-awesome-gallery');

                    case 'Administrator':
                        return __('Administrator', 'wooshark-awesome-gallery');
                    case 'Editor':
                        return __('Editor', 'wooshark-awesome-gallery');
                    case 'Author':
                        return __('Author', 'wooshark-awesome-gallery');
                    case 'Contributor':
                        return __('Contributor', 'wooshark-awesome-gallery');
                    case 'Subscriber':
                        return __('Subscriber', 'wooshark-awesome-gallery');
                    case 'Anyone':
                        return __('Anyone', 'wooshark-awesome-gallery');
                }
                return $optionValue;
            }

            /**
             * Query MySQL DB for its version
             * @return string|false
             */
            protected function getMySqlVersion()
            {
                global $wpdb;
                $rows = $wpdb->get_results('select version() as mysqlversion');
                if (!empty($rows)) {
                    return $rows[0]->mysqlversion;
                }
                return false;
            }

            /**
             * If you want to generate an email address like "no-reply@your-site.com" then
             * you can use this to get the domain name part.
             * E.g.  'no-reply@' . $this->getEmailDomain();
             * This code was stolen from the wp_mail function, where it generates a default
             * from "wordpress@your-site.com"
             * @return string domain name
             */
            public function getEmailDomain()
            {
                // Get the site domain and get rid of www.
                $sitename = strtolower($_SERVER['SERVER_NAME']);
                if (substr($sitename, 0, 4) == 'www.') {
                    $sitename = substr($sitename, 4);
                }
                return $sitename;
            }
        }
