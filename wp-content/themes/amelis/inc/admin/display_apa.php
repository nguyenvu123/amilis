<?php

    function apa_admin_display(){
        add_menu_page ('Apa', 'Apa', 'edit_posts', 'apa', 'apa_admin_display_content', 'dashicons-groups', 1 );
    }

    function apa_admin_display_content() {
        global $wpdb;

        $leads = array();
        $leads = $wpdb->get_results( "SELECT * FROM apa order by time desc LIMIT 0, 20" );

        ?>
        <div class="wrap">
            <h1>Apa</h1>

            <table class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                    <th scope="col"><span>Date</span></th>
                    <th scope="col"><span>Name</span></th>
                    <th scope="col"><span>Email</span></th>
                    <th scope="col"><span>Phone</span></th>
                    <th scope="col"><span>Code Postal</span></th>   
                    <th scope="col"><span>Type</span></th>     
                    <th scope="col"><span>Department</span></th>    
                    <th scope="col"><span>Ip</span></th>    
                    <th scope="col"><span>Actions</span></th>                 
                </tr>
            </thead>
            <?php if ( $leads ) : ?>
            <tbody>
                <?php foreach ( $leads as $lead ) : ?>
                    <tr>
                        <td></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=apa-item&item_id=<?php echo $lead->id; ?>"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><?php echo ucfirst($lead->type); ?></td>
                        <td><?php echo ($lead->department == 0) ? 'N/A' : $lead->department ; ?></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td><a href="admin.php?page=apa-item&item_id=<?php echo $lead->id; ?>" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
            </table>
        </div>
        <?php 
    }
    add_action( 'admin_menu', 'apa_admin_display' );



    function apa_view_item() {
        add_submenu_page (NULL, 'View lead', NULL, 'edit_posts', 'apa-item', 'apa_view_item_content' );
    }
    add_action( 'admin_menu', 'apa_view_item' );


    function apa_view_item_content() {
        if ( !is_numeric($_GET['item_id']) )
            die();

        global $wpdb;
        
        $lead_db = $wpdb->get_results( "SELECT * FROM apa where id=".$_GET['item_id'] );
        $lead = $lead_db[0];


        ?>
        <div class="wrap">
            <div class="admin-content-box">
                <h1><?php echo $lead->name; ?> - <span style="color: #999">Agence <?php echo $lead->agence; ?></span></h1>
                <p><?php echo $lead->time; ?></p>
                <p><?php echo $lead->phone; ?></p>
                <p><?php echo $lead->email; ?></p>
                <p><?php echo $lead->zipcode; ?></p>
                <p><?php echo $lead->ip; ?></p>
            </div>
        </div>
        <?php
    }