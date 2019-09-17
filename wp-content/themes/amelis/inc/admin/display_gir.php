<?php

    function gir_admin_display(){
        add_menu_page ('Gir', 'Gir', 'edit_posts', 'gir', 'gir_admin_display_content', 'dashicons-groups', 1 );
    }

    function gir_admin_display_content() {
        global $wpdb;

        

        // process delete all
        if ( $_POST ) {
            if ( !empty($_POST['action']) && $_POST['action'] == 'deleteMultipleLeads' ) {
                $leads = $_POST['lead_id'];
                $leads_count = count($leads);

                $ids = implode( ',', array_map( 'absint', $leads ) );
                
                $wpdb->query( "DELETE FROM gir WHERE id IN($ids)" ); 

                $feedback['message'] = 'There were '.$leads_count.' leads succesfully deleted!';
                $feedback['status'] = 'success';
            }
        }


        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadGir') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM gir where id=".$_POST['item_id'] );
            $wpdb->delete( 'gir', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

            $feedback['message'] = 'Lead <strong>"'.$lead_db[0]->name.'"</strong> was succesfully deleted!';
            $feedback['status'] = 'success';
        }

        $leads = array();
        $where = "";
        if ( isset($_GET['dateStart']) && !empty($_GET['dateStart']) )
            $where .= "AND date(time)>=date('".$_GET["dateStart"]."') ";
        
        if ( isset($_GET['dateEnd']) && !empty($_GET['dateEnd']) )
            $where .= "AND date(time)<=date('".$_GET["dateEnd"]."') ";
    
        $limit = "";
        if ( empty($where) )
            $limit = "LIMIT ".adminGetStartLimit().", ".NUMBER_OF_LEADS_PER_ADMIN_PAGE;


        $leads = $wpdb->get_results( "SELECT * FROM gir WHERE id>0 ".$where." order by time desc ".$limit );

        $test_brief_results = array (
            1 => 'Dépendance totale',
            2 => 'Grande dépendance',
            3 => 'Dépendance corporelle',
            4 => 'Dépendance corporelle partielle',
            5 => 'Dépendance corporelle légère',
            6 => 'Pas de dépendance notable',
        );

        ?>
        <div class="wrap">
            <h1>Gir</h1>

            <?php 
                $admin_page_name = 'gir'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $test_brief_results = array (
                    1 => 'Dépendance totale',
                    2 => 'Grande dépendance',
                    3 => 'Dépendance corporelle',
                    4 => 'Dépendance corporelle partielle',
                    5 => 'Dépendance corporelle légère',
                    6 => 'Pas de dépendance notable',
                );

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Score', 'Newsletter', 'Contact', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'score', 'newsletter', 'contacte', 'ip']
                ];

                $json = select_json_fields($leads, $fields);

                $data = json_decode($json, true);
                $new_data = array();

                foreach ( $data as $d) {
                    $d['score'] = $d['score'].' - '.$test_brief_results[$d['score']];
                    array_push($new_data, $d);
                }

                display_json_to_csv_export_script(json_encode($new_data) , 'gir-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 

            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="gir_<?php echo date('Y-m-d-H:i'); ?>">
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
                    <th scope="col"><span>Score</span></th>     
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
                        <th class="check-column"><input id="gir_row_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=gir-item&item_id=<?php echo $lead->id; ?>"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><?php echo $test_brief_results[$lead->score]; ?></td>
                        <td><strong><?php echo ($lead->newsletter == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><strong><?php echo ($lead->contacte == 0) ? 'No' : 'Yes' ; ?></strong></td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=gir-item&item_id=<?php echo $lead->id; ?>" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
            </table>
            </form>
            <?php echo (empty($limit)) ? "" : adminDisplayPagination('gir'); ?>
        </div>
        <?php 
    }
    add_action( 'admin_menu', 'gir_admin_display' );



    function gir_view_item() {
        add_submenu_page (NULL, 'View lead', NULL, 'edit_posts', 'gir-item', 'gir_view_item_content' );
    }
    add_action( 'admin_menu', 'gir_view_item' );


    function gir_view_item_content() {
        if ( !is_numeric($_GET['item_id']) )
            die();

        global $wpdb;
        
        $lead_db = $wpdb->get_results( "SELECT * FROM gir where id=".$_GET['item_id'] );
        $lead = $lead_db[0];

        

        $test_brief_results = array (
            1 => 'Dépendance totale',
            2 => 'Grande dépendance',
            3 => 'Dépendance corporelle',
            4 => 'Dépendance corporelle partielle',
            5 => 'Dépendance corporelle légère',
            6 => 'Pas de dépendance notable',
        );


        ?>
        <div class="wrap">
            <div class="admin-content-box">
                <h1><?php echo $lead->name; ?> - <span style="color: #999">Agence <?php echo $lead->agence; ?></span></h1>
                <p><?php echo $lead->time; ?></p>
                <p><?php echo $lead->phone; ?></p>
                <p><?php echo $lead->email; ?></p>
                <p><?php echo $lead->zipcode; ?></p>
                <p><?php echo $lead->ip; ?></p>

                <p>
                    <strong>GIR score</strong><br>
                    <?php echo $lead->score.' - '.$test_brief_results[$lead->score]; ?>
                </p>

                <hr>
                <form method="POST" action="<?php echo admin_url( '/admin.php?page=gir' ); ?>" style="padding: 10px 0;">
                    <input type="hidden" name="action" value="deleteLeadGir">
                    <input type="hidden" name="item_id" value="<?php echo $lead->id; ?>">
                    <button type="submit" class="button red button-xl">Delete Lead</button>
                </form>
            </div>
        </div>
        <?php
    }