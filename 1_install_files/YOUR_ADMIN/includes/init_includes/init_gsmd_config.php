<?php
//$messageStack->add('Google Snippets with Microdata v1.4 install started','success');

    $gsmd_menu_title = 'Google Snippets with Microdata';
    $gsmd_menu_text = 'Settings for Google Snippets with Microdata';

    /* find if Google Snippets with Microdata Configuration Group Exists */
    $sql = "SELECT * FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title = '".$gsmd_menu_title."'";
    $original_config = $db->Execute($sql);

    if($original_config->RecordCount())
    {
        // if exists updating the existing Google Snippets with Microdata configuration group entry
        $sql = "UPDATE ".TABLE_CONFIGURATION_GROUP." SET
                configuration_group_description = '".$gsmd_menu_text."'
                WHERE configuration_group_title = '".gsmd_menu_title."'";
        $db->Execute($sql);
        $sort = $original_config->fields['sort_order'];

    }else{
        /* Find max sort order in the configuation group table -- add 2 to this value to create the Google Snippets with Microdata configuration group ID */
        $sql = "SELECT (MAX(sort_order)+2) as sort FROM ".TABLE_CONFIGURATION_GROUP;
        $result = $db->Execute($sql);
        $sort = $result->fields['sort'];

        /* Create Google Snippets with Microdata configuration group */
        $sql = "INSERT INTO ".TABLE_CONFIGURATION_GROUP." (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (NULL, '".$gsmd_menu_title."', '".$gsmd_menu_text."', ".$sort.", '1')";
        $db->Execute($sql);
   }

    /* Find configuation group ID of Google Snippets with Microdata */
    $sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='".$gsmd_menu_title."' LIMIT 1";
    $result = $db->Execute($sql);
        $gsmd_configuration_id = $result->fields['configuration_group_id'];

    /* Remove Google Snippets with Microdata items from the configuration table */
    $sql = "DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id ='".$gsmd_configuration_id."'";
        $db->Execute($sql);

//-- ADD VALUES TO GOOGLE SNIPPETS WITH MICRODATA CONFIGURATION GROUP (Admin > Configuration > Google Snippets with Microdata) --
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Product Condition', 'MICRODATA_PRODUCT_CONDITION', '<span itemprop=\"condition\" content=\"new\">New</span>', 'Using Rich Snippets to identify product condition. Any text may be specified. If the <code>condition</code> attribute is used, the value of the <code>content</code> attribute must be one of the following recognized values:<ul><li><code>new</code></li><li><code>used</code></li><li><code>refurbished</code></li></ul><p>For example:</p><pre>&lt;span itemprop=\"condition\" content=\"new\"&gt;Brand new!&lt;/span&gt;</pre><br /><br />Default value is: <span itemprop=\"condition\" content=\"new\">New</span>.', '".$gsmd_configuration_id."', 5, now(), now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Product Price Currency', 'MICRODATA_CURRENCY', 'USD', 'Using Rich Snippets to identify the product currency.<br /><br />The currency used to describe the product price, in <a href=\"http://www.iso.org/iso/support/faqs/faqs_widely_used_standards/widely_used_standards_other/currency_codes.htm\" target=\"_blank\">three-letter ISO</a> format.', '".$gsmd_configuration_id."', 10, now(), now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Product Identifier', 'MICRODATA_IDENTIFIER', 'mpn:', '<p>The product identifier. Google recommends including <code>brand</code> and at least one <code>identifier</code> for each product.</p><p>Recognized types include:</p><ul><li><code>asin</code></li><li><code>isbn</code></li><li><code>mpn</code></li><li><code>sku</code></li><li><code>upc</code></li></ul><p>You MUST include a colon (:) at the end of the identifier. e.g. <strong>mpn:</strong></p>', '".$gsmd_configuration_id."', 15, now(), now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Payments Accepted', 'MICRODATA_PAYMENTS_ACCEPTED', '<span itemprop=\"http://purl.org/goodrelations/v1#acceptedPaymentMethods\" href=\"http://purl.org/goodrelations/v1#PayPal\" />PayPal</span>, <span itemprop=\"http://purl.org/goodrelations/v1#acceptedPaymentMethods\" href=\"http://purl.org/goodrelations/v1#VISA\" />Visa</span>, <span itemprop=\"http://purl.org/goodrelations/v1#acceptedPaymentMethods\" href=\"http://purl.org/goodrelations/v1#MasterCard\" />MasterCard</span>, <span itemprop=\"http://purl.org/goodrelations/v1#acceptedPaymentMethods\" href=\"http://purl.org/goodrelations/v1#Discover\" />Discover</span>', 'Using Rich Snippets to identify the payment methods you accept. The syntax provided is for Visa, MasterCard, Discover and PayPal.<br /><br />Other methods can be found here (<a href=\"http://www.heppnetz.de/ontologies/goodrelations/v1#PaymentMethod\" target=\"_blank\">http://www.heppnetz.de/ontologies/goodrelations/v1#PaymentMethod</a>)', '".$gsmd_configuration_id."', 20, now(), now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Delivery Lead Time', 'MICRODATA_DELIVERY_LEADTIME', '21', 'Using Rich Snippets to identify the general delivery lead time (in days) for your products', '".$gsmd_configuration_id."', 25, now(), now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Shipping Region(s)', 'MICRODATA_SHIPPING_REGIONS', '<span itemprop=\"eligibleRegion\" content=\"US\">United States</span> &amp; <span itemprop=\"eligibleRegion\" content=\"CA\">Canada</span>', 'Using Rich Snippets to identify the shipping region(s) for your products.<br /><br />Note that the proper 2 letter country code must be used for the content=\"\", but the text following can be express however you like.', '".$gsmd_configuration_id."', 30, now(), now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Enable Availability?', 'MICRODATA_PRODUCT_AVAILABILITY_YN', 'False', 'Enable availability',  '".$gsmd_configuration_id."', 35, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
     VALUES (NULL, 'Enable Product Conditions?', 'MICRODATA_PRODUCT_CONDITION_YN', 'False', 'Enable conditions',  '".$gsmd_configuration_id."', 40, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Enable Product Category?', 'MICRODATA_PRODUCT_CATEGORY_YN', 'False', 'Enable Category.<br /><br />You can include multiple categories. Any value is accepted, but Google recognizes the categories described <a href=\"http://www.google.com/support/merchants/bin/answer.py?answer=160081\" target=\"_blank\">in this article</a>',  '".$gsmd_configuration_id."', 45, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Enable Payments Accepted?', 'MICRODATA_PRODUCT_PAYMENTS_YN', 'False', 'Enable payments',  '".$gsmd_configuration_id."', 50, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Enable Delivery Lead Time?', 'MICRODATA_PRODUCT_DELIVERY_YN', 'False', 'Enable delivery lead time',  '".$gsmd_configuration_id."', 55, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Enable Shipping Region(s)?', 'MICRODATA_PRODUCT_SHIPTO_YN', 'False', 'Enable shipping region(s)',  '".$gsmd_configuration_id."', 60, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
    $db->Execute($sql);
//-- GOOGLE SNIPPETS WITH MICRODATA VERSION
    $sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
      VALUES (NULL, 'Google Snippets with Microdata Version', 'GSMD_VERSION', '1.4', 'Google Snippets with Microdata Version', '".$gsmd_configuration_id."', 999, NULL, now(), NULL, NULL)";
    $db->Execute($sql);


   if(file_exists(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.gsmd.php'))
    {
        if(!unlink(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.gsmd.php'))
	{
		$messageStack->add('The auto-loader file '.DIR_FS_ADMIN.'includes/auto_loaders/config.gsmd.php has not been deleted. For this module to work you must delete the '.DIR_FS_ADMIN.'includes/auto_loaders/config.gsmd.php file manually.  Before you post on the Zen Cart forum to ask, YES you are REALLY supposed to follow these instructions and delete the '.DIR_FS_ADMIN.'includes/auto_loaders/config.gsmd.php file.','error');
	};
    }

       $messageStack->add('Google Snippets with Microdata v1.4 install completed!','success');

    // find next sort order in admin_pages table
    $sql = "SELECT (MAX(sort_order)+2) as sort FROM ".TABLE_ADMIN_PAGES;
    $result = $db->Execute($sql);
    $admin_page_sort = $result->fields['sort'];

    // now register the admin pages
    // Admin Menu for Google Snippets with Microdata Configuration Menu
    zen_deregister_admin_pages('configMicrodata');
    zen_register_admin_page('configMicrodata',
        'BOX_CONFIGURATION_MICRODATA', 'FILENAME_CONFIGURATION',
        'gID=' . $gsmd_configuration_id, 'configuration', 'Y',
        $admin_page_sort);
