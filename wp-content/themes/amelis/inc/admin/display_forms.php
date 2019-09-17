<?php

    function forms_admin_display() {
        add_menu_page ('Web Forms', 'Web Forms', 'edit_posts', 'web-forms', 'forms_admin_display_content', 'dashicons-groups', 1 );
        add_submenu_page( 'web-forms', 'APA Formulaire', 'APA Formulaire', 'edit_posts', 'apa-form', 'apa_form_admin_display_content');
        add_submenu_page( 'web-forms', 'APA Guide', 'APA Guide', 'edit_posts', 'apa-guide', 'apa_guide_admin_display_content');
        add_submenu_page( 'web-forms', 'PCH Formulaire', 'PCH Formulaire', 'edit_posts', 'pch-form', 'pch_form_admin_display_content');
        add_submenu_page( 'web-forms', 'PCH Guide', 'PCH Guide', 'edit_posts', 'pch-guide', 'pch_guide_admin_display_content');
        add_submenu_page( 'web-forms', 'ARDH Guide', 'ARDH Guide', 'edit_posts', 'ardh-guide', 'ardh_guide_admin_display_content');
        add_submenu_page ('web-forms', 'View lead', NULL, 'edit_posts', 'web-form-item', 'web_form_view_item_content' );
    }
    add_action( 'admin_menu', 'forms_admin_display' );

    function forms_admin_display_content() {
        echo '';
    }



    function apa_form_admin_display_content() {
        global $wpdb;

        // process delete all
        if ( $_POST )
            $feedback = web_forms_delete_selected($_POST);


        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadWebForm') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM forms where id=".$_POST['item_id'] );
            $wpdb->delete( 'forms', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

            $feedback['message'] = 'Lead <strong>"'.$lead_db[0]->name.'"</strong> was succesfully deleted!';
            $feedback['status'] = 'success';
        }

        $where = "";
        if ( isset($_GET['dateStart']) && !empty($_GET['dateStart']) )
            $where .= "AND date(time)>=date('".$_GET["dateStart"]."') ";
        
        if ( isset($_GET['dateEnd']) && !empty($_GET['dateEnd']) )
            $where .= "AND date(time)<=date('".$_GET["dateEnd"]."') ";
    
        $limit = "";
        if ( empty($where) )
            $limit = "LIMIT ".adminGetStartLimit().", ".NUMBER_OF_LEADS_PER_ADMIN_PAGE;

        $leads = $wpdb->get_results( "SELECT * FROM forms where type='APA Formulaire' ".$where." order by time desc ".$limit);

        ?>
        <div class="wrap">
            <h1>APA Formulaire</h1>

            <?php 
                $admin_page_name = 'apa-form'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                
                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Department', 'Newsletter', 'Contact', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'department', 'newsletter', 'contacte', 'ip']
                ];

                $json = select_json_fields($leads, $fields);
                display_json_to_csv_export_script($json , 'apa_form-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 

            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="apa_form_<?php echo date('Y-m-d-H:i'); ?>">
            <table class="wp-list-table widefat fixed striped posts excel-table">
            <thead>
                <tr>
                    <th id="cb" class="manage-column column-cb check-column ignore">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input style="margin-top: 20px; margin-left: 12px" id="cb-select-all-1" type="checkbox">
                    </th>
                    <th>ID</th>
                    <th scope="col"><span>Date</span></th>
                    <th scope="col"><span>Name</span></th>
                    <th scope="col"><span>Email</span></th>
                    <th scope="col"><span>Phone</span></th>
                    <th scope="col"><span>Agence</span></th>  
                    <th scope="col"><span>Code Postal</span></th>   
                    <th scope="col"><span>Department</span></th>   
                    <th scope="col"><span>Newsletter</span></th>    
                    <th scope="col"><span>Contact</span></th>     
                    <th scope="col"><span>Ip</span></th>    
                    <th scope="col" class="ignore">
                        <button type="button" id="downloadCSV" class="button">CSV</button>
                    </th>
                    <th scope="col" class="ignore">
                        <button type="button" class="button red" id="beforeDelete">Delete</button>
                        
                    </th>                  
                </tr>
            </thead>
            <?php if ( $leads ) : ?>
            <tbody>
                <?php foreach ( $leads as $lead ) : ?>
                    <tr>
                        <th class="check-column"><input id="form_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=apa_form"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><?php echo ($lead->department == 0) ? 'N/A' : $lead->department ; ?></td>
                        <td><strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><strong><?php echo ($lead->contacte == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=apa_form" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
            </table>
        </form>
            <?php echo (empty($limit)) ? "" : adminDisplayPagination('apa-form'); ?>
        </div>
        <?php 
    }

    function apa_guide_admin_display_content() {
       global $wpdb;

       // process delete all
       if ( $_POST )
           $feedback = web_forms_delete_selected($_POST);


       if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadWebForm') {
           
           $lead_db = $wpdb->get_results( "SELECT * FROM forms where id=".$_POST['item_id'] );
           $wpdb->delete( 'forms', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

           $feedback['message'] = 'Lead <strong>"'.$lead_db[0]->name.'"</strong> was succesfully deleted!';
           $feedback['status'] = 'success';
       }

        $where = "";
        if ( isset($_GET['dateStart']) && !empty($_GET['dateStart']) )
            $where .= "AND date(time)>=date('".$_GET["dateStart"]."') ";
        
        if ( isset($_GET['dateEnd']) && !empty($_GET['dateEnd']) )
            $where .= "AND date(time)<=date('".$_GET["dateEnd"]."') ";

        $limit = "";
        if ( empty($where) )
            $limit = "LIMIT ".adminGetStartLimit().", ".NUMBER_OF_LEADS_PER_ADMIN_PAGE;

        $leads = $wpdb->get_results( "SELECT * FROM forms where type='APA Guide' ".$where." order by time desc ".$limit );

        ?>
        <div class="wrap">
            <h1>APA Guide</h1>

            <?php 
                $admin_page_name = 'apa-guide'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Newsletter', 'Contact', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'newsletter', 'contacte', 'ip']
                ];

                $json = select_json_fields($leads, $fields);
                display_json_to_csv_export_script($json , 'apa_guide-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 

            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="apa_guide_<?php echo date('Y-m-d-H:i'); ?>">
            <table class="wp-list-table widefat fixed striped posts excel-table">
            <thead>
                <tr>
                    <th id="cb" class="manage-column column-cb check-column ignore">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input style="margin-top: 20px; margin-left: 12px" id="cb-select-all-1" type="checkbox">
                    </th>
                    <th>ID</th>
                    <th scope="col"><span>Date</span></th>
                    <th scope="col"><span>Name</span></th>
                    <th scope="col"><span>Email</span></th>
                    <th scope="col"><span>Phone</span></th>
                    <th scope="col"><span>Agence</span></th>  
                    <th scope="col"><span>Code Postal</span></th>   
                    <th scope="col"><span>Newsletter</span></th>    
                    <th scope="col"><span>Contact</span></th>     
                    <th scope="col"><span>Ip</span></th>
                    <th scope="col" class="ignore">
                        <button type="button" id="downloadCSV" class="button">CSV</button>
                    </th>    
                    <th scope="col" class="ignore">
                        <button type="button" class="button red" id="beforeDelete">Delete</button>
                        
                    </th>                
                </tr>
            </thead>
            <?php if ( $leads ) : ?>
            <tbody>
                <?php foreach ( $leads as $lead ) : ?>
                    <tr>
                        <th class="check-column"><input id="form_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=apa_guide"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><strong><?php echo ($lead->contacte == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=apa_guide" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
            </table>
        </form>
            <?php echo (empty($limit)) ? "" : adminDisplayPagination('apa-guide'); ?>
        </div>
        <?php 
    }

    function pch_form_admin_display_content() {
        global $wpdb;

        // process delete all
        if ( $_POST )
            $feedback = web_forms_delete_selected($_POST);


        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadWebForm') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM forms where id=".$_POST['item_id'] );
            $wpdb->delete( 'forms', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

            $feedback['message'] = 'Lead <strong>"'.$lead_db[0]->name.'"</strong> was succesfully deleted!';
            $feedback['status'] = 'success';
        }

        $where = "";
        if ( isset($_GET['dateStart']) && !empty($_GET['dateStart']) )
            $where .= "AND date(time)>=date('".$_GET["dateStart"]."') ";
        
        if ( isset($_GET['dateEnd']) && !empty($_GET['dateEnd']) )
            $where .= "AND date(time)<=date('".$_GET["dateEnd"]."') ";

        $limit = "";
        if ( empty($where) )
            $limit = "LIMIT ".adminGetStartLimit().", ".NUMBER_OF_LEADS_PER_ADMIN_PAGE;

        $leads = $wpdb->get_results( "SELECT * FROM forms where type='PCH Formulaire' ".$where." order by time desc ".$limit );

        ?>
        <div class="wrap">
            <h1>PCH Formulaire</h1>

            <?php 
                $admin_page_name = 'pch-form'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Newsletter', 'Contact', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'newsletter', 'contacte', 'ip']
                ];

                $json = select_json_fields($leads, $fields);
                display_json_to_csv_export_script($json , 'pch_form-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 

            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="pch_form_<?php echo date('Y-m-d-H:i'); ?>">
            <table class="wp-list-table widefat fixed striped posts excel-table">
            <thead>
                <tr>
                    <th id="cb" class="manage-column column-cb check-column ignore">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input style="margin-top: 20px; margin-left: 12px" id="cb-select-all-1" type="checkbox">
                    </th>
                    <th>ID</th>
                    <th scope="col"><span>Date</span></th>
                    <th scope="col"><span>Name</span></th>
                    <th scope="col"><span>Email</span></th>
                    <th scope="col"><span>Phone</span></th>
                    <th scope="col"><span>Agence</span></th>  
                    <th scope="col"><span>Code Postal</span></th>   
                    <th scope="col"><span>Newsletter</span></th>    
                    <th scope="col"><span>Contact</span></th>     
                    <th scope="col"><span>Ip</span></th>   
                    <th scope="col" class="ignore">
                        <button type="button" id="downloadCSV" class="button">CSV</button>
                    </th>    
                    <th scope="col" class="ignore">
                        <button type="button" class="button red" id="beforeDelete">Delete</button>
                        
                    </th>                
                </tr>
            </thead>
            <?php if ( $leads ) : ?>
            <tbody>
                <?php foreach ( $leads as $lead ) : ?>
                    <tr>
                        <th class="check-column"><input id="form_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=pch_form"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><strong><?php echo ($lead->contacte == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=pch_form" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
            </table>
        </form>
            <?php echo (empty($limit)) ? "" : adminDisplayPagination('pch-form'); ?>
        </div>
        <?php 
    }

    function pch_guide_admin_display_content() {
        global $wpdb;

        // process delete all
        if ( $_POST )
            $feedback = web_forms_delete_selected($_POST);


        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadWebForm') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM forms where id=".$_POST['item_id'] );
            $wpdb->delete( 'forms', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

            $feedback['message'] = 'Lead <strong>"'.$lead_db[0]->name.'"</strong> was succesfully deleted!';
            $feedback['status'] = 'success';
        }

        $where = "";
        if ( isset($_GET['dateStart']) && !empty($_GET['dateStart']) )
            $where .= "AND date(time)>=date('".$_GET["dateStart"]."') ";
        
        if ( isset($_GET['dateEnd']) && !empty($_GET['dateEnd']) )
            $where .= "AND date(time)<=date('".$_GET["dateEnd"]."') ";
    
        $limit = "";
        if ( empty($where) )
            $limit = "LIMIT ".adminGetStartLimit().", ".NUMBER_OF_LEADS_PER_ADMIN_PAGE;

        $leads = $wpdb->get_results( "SELECT * FROM forms where type='PCH Guide' ".$where." order by time desc ".$limit );

        ?>
        <div class="wrap">
            <h1>PCH Guide</h1>

            <?php 
                $admin_page_name = 'pch-guide'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Newsletter', 'Contact', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'newsletter', 'contacte', 'ip']
                ];

                $json = select_json_fields($leads, $fields);
                display_json_to_csv_export_script($json , 'pch_guide-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 

            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="pch_guide_<?php echo date('Y-m-d-H:i'); ?>">
            <table class="wp-list-table widefat fixed striped posts excel-table">
            <thead>
                <tr>
                    <th id="cb" class="manage-column column-cb check-column ignore">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input style="margin-top: 20px; margin-left: 12px" id="cb-select-all-1" type="checkbox">
                    </th>
                    <th>ID</th>
                    <th scope="col"><span>Date</span></th>
                    <th scope="col"><span>Name</span></th>
                    <th scope="col"><span>Email</span></th>
                    <th scope="col"><span>Phone</span></th>
                    <th scope="col"><span>Agence</span></th>  
                    <th scope="col"><span>Code Postal</span></th>   
                    <th scope="col"><span>Newsletter</span></th>    
                    <th scope="col"><span>Contact</span></th>     
                    <th scope="col"><span>Ip</span></th>    
                    <th scope="col" class="ignore">
                        <button type="button" id="downloadCSV" class="button">CSV</button>
                    </th>  
                    <th scope="col" class="ignore">
                        <button type="button" class="button red" id="beforeDelete">Delete</button>
                        
                    </th>                
                </tr>
            </thead>
            <?php if ( $leads ) : ?>
            <tbody>
                <?php foreach ( $leads as $lead ) : ?>
                    <tr>
                        <th class="check-column"><input id="form_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=pch_guide"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><strong><?php echo ($lead->contacte == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=pch_guide" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
            </table>
        </form>
            <?php echo (empty($limit)) ? "" : adminDisplayPagination('pch-guide'); ?>
        </div>
        <?php 
    }

    function ardh_guide_admin_display_content() {
        global $wpdb;

        // process delete all
        if ( $_POST )
            $feedback = web_forms_delete_selected($_POST);


        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadWebForm') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM forms where id=".$_POST['item_id'] );
            $wpdb->delete( 'forms', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

            $feedback['message'] = 'Lead <strong>"'.$lead_db[0]->name.'"</strong> was succesfully deleted!';
            $feedback['status'] = 'success';
        }

        $where = "";
        if ( isset($_GET['dateStart']) && !empty($_GET['dateStart']) )
            $where .= "AND date(time)>=date('".$_GET["dateStart"]."') ";
        
        if ( isset($_GET['dateEnd']) && !empty($_GET['dateEnd']) )
            $where .= "AND date(time)<=date('".$_GET["dateEnd"]."') ";
            
    
        $limit = "";
        if ( empty($where) )
            $limit = "LIMIT ".adminGetStartLimit().", ".NUMBER_OF_LEADS_PER_ADMIN_PAGE;

        $leads = $wpdb->get_results( "SELECT * FROM forms where type='ARDH' ".$where." order by time desc ".$limit);

        ?>
        <div class="wrap">
            <h1>ARDH Guide</h1>

            <?php 
                $admin_page_name = 'ardh-guide'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Newsletter', 'Contact', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'newsletter', 'contacte', 'ip']
                ];

                $json = select_json_fields($leads, $fields);
                display_json_to_csv_export_script($json , 'ardh_guide-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 


            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="ardh_guide_<?php echo date('Y-m-d-H:i'); ?>">
            <table class="wp-list-table widefat fixed striped posts excel-table">
            <thead>
                <tr>
                    <th id="cb" class="manage-column column-cb check-column ignore">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input style="margin-top: 20px; margin-left: 12px" id="cb-select-all-1" type="checkbox">
                    </th>
                    <th>ID</th>
                    <th scope="col"><span>Date</span></th>
                    <th scope="col"><span>Name</span></th>
                    <th scope="col"><span>Email</span></th>
                    <th scope="col"><span>Phone</span></th>
                    <th scope="col"><span>Agence</span></th>  
                    <th scope="col"><span>Code Postal</span></th>   
                    <th scope="col"><span>Newsletter</span></th>    
                    <th scope="col"><span>Contact</span></th>     
                    <th scope="col"><span>Ip</span></th>    
                    <th scope="col" class="ignore">
                        <button type="button" id="downloadCSV" class="button">CSV</button>
                    </th> 
                    <th scope="col" class="ignore">
                        <button type="button" class="button red" id="beforeDelete">Delete</button>
                        
                    </th>                
                </tr>
            </thead>
            <?php if ( $leads ) : ?>
            <tbody>
                <?php foreach ( $leads as $lead ) : ?>
                    <tr>
                        <th class="check-column"><input id="form_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=ardh_guide"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><strong><?php echo ($lead->contacte == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=web-form-item&item_id=<?php echo $lead->id; ?>&type=ardh_guide" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
            </table>
        </form>
            <?php echo (empty($limit)) ? "" : adminDisplayPagination('ardh-guide'); ?>
        </div>
        <?php 
    }
    

    function web_form_view_item_content() {
        global $wpdb;

        $types = [
            'apa_form' => 'APA Formulaire',
            'apa_guide' => 'APA Guide',
            'pch_form' => 'PCH Formulaire',
            'pch_guide' => 'PCH Guide',
            'ardh_guide' => 'ARDH',
        ];

        $pages = [
            'apa_form' => 'apa-form',
            'apa_guide' => 'apa-guide',
            'pch_form' => 'pch-form',
            'pch_guide' => 'pch-guide',
            'ardh_guide' => 'ardh-guide',
        ];

        if ( !is_numeric($_GET['item_id']) )
            die();
        
        $lead_db = $wpdb->get_results( "SELECT * FROM forms where id=".$_GET['item_id']." AND type='".$types[$_GET['type']]."'" );

        if ( count($lead_db) > 0 ) :
            $lead = $lead_db[0];

            ?>
            <div class="wrap">
                <div class="admin-content-box">
                    <h1><?php echo $lead->name; ?> - <span style="color: #999">Agence <?php echo $lead->agence; ?></span></h1>

                    <p><?php echo date('d/m/Y H:i', strtotime($lead->time)); ?></p>
                    <p><?php echo $lead->phone; ?></p>
                    <p><?php echo $lead->email; ?></p>
                    <p><?php echo $lead->zipcode; ?></p>
                    <p>Newsletter - <strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></p>
                    <p>Contact - <strong><?php echo ($lead->contacte == 0) ? 'No' : 'Yes' ; ?></strong></p>

                    <p><?php echo $lead->ip; ?></p>

                    <?php if ( !empty($lead->department) ) : ?>
                    <hr>
                    <p>Department <strong><?php echo $lead->department; ?></strong></p>
                    <?php endif; ?>

                    <hr>
                    <form method="POST" action="<?php echo admin_url( '/admin.php?page='.$pages[$_GET['type']]); ?>" style="padding: 10px 0;">
                        <input type="hidden" name="action" value="deleteLeadWebForm">
                        <input type="hidden" name="item_id" value="<?php echo $lead->id; ?>">
                        <button type="submit" class="button red button-xl">Delete Lead</button>
                    </form>
                </div>
            </div>
            <?php
        endif;
    }

    
    function web_forms_delete_selected($data) {
        global $wpdb;

        // process delete all
        if ( $data ) {
            if ( !empty($data['action']) && $data['action'] == 'deleteMultipleLeads' ) {
                $leads = $data['lead_id'];
                $leads_count = count($leads);

                $ids = implode( ',', array_map( 'absint', $leads ) );
                
                $wpdb->query( "DELETE FROM forms WHERE id IN($ids)" ); 

                $feedback['message'] = 'There were '.$leads_count.' leads succesfully deleted!';
                $feedback['status'] = 'success';

                return $feedback;
            }
        }
    }