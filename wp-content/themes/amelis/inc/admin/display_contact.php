<?php

    function contact_admin_display(){
        add_menu_page ('Contact', 'Contact', 'edit_posts', 'contact-form', 'contact_admin_display_content', 'dashicons-groups', 1 );
        add_submenu_page ('contact-form', 'View lead', NULL, 'edit_posts', 'contact-item', 'contact_view_item_content' );
    }
    add_action( 'admin_menu', 'contact_admin_display' );

    function contact_admin_display_content() {
        global $wpdb;

        // process delete all
        if ( $_POST ) {
            if ( !empty($_POST['action']) && $_POST['action'] == 'deleteMultipleLeads' ) {
                $leads = $_POST['lead_id'];
                $leads_count = count($leads);

                $ids = implode( ',', array_map( 'absint', $leads ) );
                
                $wpdb->query( "DELETE FROM contact WHERE id IN($ids)" ); 

                $feedback['message'] = 'There were '.$leads_count.' leads succesfully deleted!';
                $feedback['status'] = 'success';
            }
        }



        $where = "";
        if ( isset($_GET['dateStart']) && !empty($_GET['dateStart']) )
            $where .= "AND date(time)>=date('".$_GET["dateStart"]."') ";
        
        if ( isset($_GET['dateEnd']) && !empty($_GET['dateEnd']) )
            $where .= "AND date(time)<=date('".$_GET["dateEnd"]."') ";
    
        $limit = "";
        if ( empty($where) )
            $limit = "LIMIT ".adminGetStartLimit().", ".NUMBER_OF_LEADS_PER_ADMIN_PAGE;

        $leads = $wpdb->get_results( "SELECT * FROM contact WHERE id>0 ".$where." order by time desc ".$limit );


        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadContact') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM contact where id=".$_POST['item_id'] );
            $wpdb->delete( 'contact', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

            $feedback['message'] = 'Lead <strong>"'.$lead_db[0]->name.'"</strong> was succesfully deleted!';
            $feedback['status'] = 'success';
        }

        ?>
        <div class="wrap">
            <h1>Contact</h1>

            <?php 
                $admin_page_name = 'contact-form'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Agence', "L'objet de demande", 'Newsletter', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'agence', 'subject', 'newsletter','ip']
                ];

                $json = select_json_fields($leads, $fields);
                display_json_to_csv_export_script($json , 'contact-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 

            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="contact_<?php echo date('Y-m-d-H:i'); ?>">
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
                    <th scope="col"><span>Newsletter</span></th>   
                    <th scope="col"><span>Subject</span></th>   
                    <th scope="col"><span>Ip</span></th>        
                    <th scope="col" class="ignore">
                        <button type="button" id="downloadCSV" class="button">CSV</button>
                    </th>  
                    <th scope="col" class="ignore">
                        <button type="button" class="button red" id="beforeDelete">Delete</button>
                        
                    </th>                
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $leads as $lead ) : ?>
                    <tr>
                        <th class="check-column"><input id="contact_row_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=contact-item&item_id=<?php echo $lead->id; ?>"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><?php echo $lead->subject; ?></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=contact-item&item_id=<?php echo $lead->id; ?>" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </form>
            <?php echo (empty($limit)) ? "" : adminDisplayPagination('contact-form'); ?>
        </div>
        <?php 
    }


    function contact_view_item_content() {
        global $wpdb;

        if ( !is_numeric($_GET['item_id']) )
            die();
        
        $lead_db = $wpdb->get_results( "SELECT * FROM contact where id=".$_GET['item_id'] );

        if ( count($lead_db) > 0 ) :
            $lead = $lead_db[0];

            ?>
            <div class="wrap">
                <div class="admin-content-box">
                    <h1><?php echo $lead->name; ?> - <span style="color: #999">Agence <?php echo $lead->agence; ?></span></h1>

                    <p><?php echo date('d/m/Y H:i', strtotime($lead->time)); ?></p>
                    <p><?php echo $lead->phone; ?></p>
                    <p><?php echo $lead->email; ?></p>
                    <p>Subject <strong><?php echo $lead->subject; ?></strong></p>

                    <p>Newsletter - <strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></p>

                    <p><?php echo $lead->ip; ?></p>

                    <hr>
                    <form method="POST" action="<?php echo admin_url( '/admin.php?page=contact-form'); ?>" style="padding: 10px 0;">
                        <input type="hidden" name="action" value="deleteLeadContact">
                        <input type="hidden" name="item_id" value="<?php echo $lead->id; ?>">
                        <button type="submit" class="button red button-xl">Delete Lead</button>
                    </form>
                </div>
            </div>
            <?php
        endif;
    }