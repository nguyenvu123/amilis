<?php

    function devis_gratuit_admin_display(){
        add_menu_page ('Devis Gratuit', 'Devis Gratuit', 'edit_posts', 'devis-gratuit', 'devis_gratuit_admin_display_content', 'dashicons-groups', 1 );
    }

    function devis_gratuit_admin_display_content() {
        global $wpdb;

        // process delete all
        if ( $_POST ) {
            if ( !empty($_POST['action']) && $_POST['action'] == 'deleteMultipleLeads' ) {
                $leads = $_POST['lead_id'];
                $leads_count = count($leads);

                $ids = implode( ',', array_map( 'absint', $leads ) );
                
                $wpdb->query( "DELETE FROM devis_gratuit WHERE id IN($ids)" ); 

                $feedback['message'] = 'There were '.$leads_count.' leads succesfully deleted!';
                $feedback['status'] = 'success';
            }
        }


        // process delete single lead
        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadDevisGratuit') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM devis_gratuit where id=".$_POST['item_id'] );
            $wpdb->delete( 'devis_gratuit', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

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

        $leads = $wpdb->get_results( "SELECT * FROM devis_gratuit WHERE id>0 ".$where." order by time desc ".$limit );


        ?>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script type="text/javascript">
            jQuery(function($) {
                $(document).ready(function() {

                    $(".datePicker").flatpickr({
                        dateFormat: 'Y-m-d'
                    });
                    

                    $('.button.reset').on('click', function(e) {
                        e.preventDefault();

                        $('.datePicker').removeAttr('readonly').val('');
                        $('#datePickerForm').submit();
                    })
                });
            });
        </script>


        <div class="wrap">
                <h1>Devis Gratuit</h1>

                <?php
                    if ( !empty($feedback) )
                        echo '<div class="alert alert-'.$feedback['status'].'">'.$feedback['message'].'</div>';
                ?>

                <?php 
                    $fields = [
                        'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Aide pour', 'Services nécessaires', 'Jours par semaine', 'Newsletter', 'Contact', 'Ip'],
                        'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'search_for', 'frequency', 'services', 'newsletter', 'contacte', 'ip']
                    ];

                    $json = select_json_fields($leads, $fields);
                    display_json_to_csv_export_script($json , 'devis_gratuit-'.date('Y-m-d-H-i-s'));

                    echo '<pre id="csv" style="display: none"></pre>';
                ?>
                

                <div style="padding: 5px; margin: 10px auto; background: #fff;">
                    <form method="GET" id="datePickerForm">
                        <input type="hidden" name="page" value="devis-gratuit">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <label style="display: block" for="dateStart">Date Start</label>
                                        <input type="text" class="datePicker" id="dateStart" name="dateStart" <?php echo (isset($_GET['dateStart'])) ? 'value="'.$_GET['dateStart'].'"' : "" ; ?>>
                                    </td>
                                    <td>
                                        <label style="display: block" for="dateStart">Date End</label>
                                        <input type="text" class="datePicker" id="dateEnd" name="dateEnd" <?php echo (isset($_GET['dateEnd'])) ? 'value="'.$_GET['dateEnd'].'"' : "" ; ?>>
                                    </td>
                                    <td>
                                        <label style="display: block">&nbsp;</label>
                                        <button type="submit" class="button blue">Filter</button>
                                        <button type="reset" class="button red reset">Reset</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>

            <form action="" method="POST">
                <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="devis_gratuit_<?php echo date('Y-m-d-H:i'); ?>">
                <table id="excelTableDevis" tableexport-key="excelTableDevis" class="wp-list-table widefat fixed striped posts excel-table">
                    <thead>
                        <tr>
                            <th id="cb" class="manage-column column-cb check-column ignore">
                                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                                <input style="margin-top: 20px; margin-left: 12px" id="cb-select-all-1" type="checkbox">
                            </th>
                            <th style="width: 50px">ID</th>
                            <th scope="col"><span>Date</span></th>
                            <th scope="col"><span>Name</span></th>
                            <th scope="col"><span>Email</span></th>
                            <th scope="col"><span>Phone</span></th>
                            <th scope="col"><span>Code Postal</span></th>   
                            <th scope="col"><span>Agence</span></th>   
                            <th scope="col" style="display: none"><span>Aide pour</span></th>   
                            <th scope="col" style="display: none"><span>Services nécessaires</span></th>   
                            <th scope="col" style="display: none"><span>Jours par semaine</span></th>   
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
                    <tbody>
                        <?php foreach ( $leads as $lead ) : ?>
                            <tr>
                                <th class="check-column"><input id="devis_row_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                                <td><?php echo $lead->id; ?></td>
                                <td><?php echo $lead->time; ?></td>
                                <td><a href="admin.php?page=devis-gratuit-item&item_id=<?php echo $lead->id; ?>"><?php echo $lead->name; ?></a></td>
                                <td><?php echo $lead->email; ?></td>
                                <td><?php echo $lead->phone; ?></td>
                                <td><?php echo $lead->zipcode; ?></td>
                                <td><?php echo $lead->agence; ?></td>
                                <td style="display: none"><?php echo $lead->search_for; ?></td>
                                <td style="display: none"><?php echo $lead->frequency; ?></td>
                                <td style="display: none"><?php echo $lead->services; ?></td>
                                <td><strong><?php echo ($lead->newsletter == 0) ? 'Non' : 'Oui' ; ?></strong></td>
                                <td><strong><?php echo ($lead->contacte == 0) ? 'Non' : 'Oui' ; ?></strong></td>
                                <td><?php echo $lead->ip; ?></td>
                                <td></td>
                                <td><a href="admin.php?page=devis-gratuit-item&item_id=<?php echo $lead->id; ?>" class="button button-primary button-large">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table style="display: none">
                    <thead>
                        <tr>
                            <th style="width: 50px">ID</th>
                            <th scope="col"><span>Date</span></th>
                            <th scope="col"><span>Name</span></th>
                            <th scope="col"><span>Email</span></th>
                            <th scope="col"><span>Phone</span></th>
                            <th scope="col"><span>Code Postal</span></th>   
                            <th scope="col"><span>Agence</span></th>   
                            <th scope="col"><span>Newsletter</span></th>   
                            <th scope="col"><span>Contact</span></th>   
                            <th scope="col"><span>Ip</span></th>                
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $leads as $lead ) : ?>
                            <tr>
                                <td><?php echo $lead->id; ?></td>
                                <td><?php echo $lead->time; ?></td>
                                <td><?php echo $lead->name; ?></td>
                                <td><?php echo $lead->email; ?></td>
                                <td><?php echo $lead->phone; ?></td>
                                <td><?php echo $lead->zipcode; ?></td>
                                <td><?php echo $lead->agence; ?></td>
                                <td><strong><?php echo ($lead->newsletter == 0) ? 'Non' : 'Oui' ; ?></strong></td>
                                <td><strong><?php echo ($lead->contacte == 0) ? 'Non' : 'Oui' ; ?></strong></td>
                                <td><?php echo $lead->ip; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>

            <?php echo (empty($limit)) ? "" : adminDisplayPagination('devis-gratuit'); ?>
        </div>
        <?php 
    }
    add_action( 'admin_menu', 'devis_gratuit_admin_display' );



    function devis_gratuit_view_item() {
        add_submenu_page ('devis-gratuit', 'View lead', NULL, 'edit_posts', 'devis-gratuit-item', 'devis_gratuit_view_item_content' );
    }
    add_action( 'admin_menu', 'devis_gratuit_view_item' );


    function devis_gratuit_view_item_content() {
        global $wpdb;

        if ( !is_numeric($_GET['item_id']) )
            die();
        
        $lead_db = $wpdb->get_results( "SELECT * FROM devis_gratuit where id=".$_GET['item_id'] );

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
                    <p>Newsletter - <strong><?php echo ($lead->newsletter == 0) ? 'Non' : 'Oui' ; ?></strong></p>
                    <p>Contact - <strong><?php echo ($lead->contacte == 0) ? 'Non' : 'Oui' ; ?></strong></p>

                    <p><?php echo $lead->ip; ?></p>
                    <hr>
                    <p>Aide pour <strong><?php echo $lead->search_for; ?></strong></p>
                    <p>Services nécessaires <strong><?php echo str_replace(',', ', ', $lead->services); ?></strong></p>
                    <p>Jours par semaine <strong><?php echo str_replace(',', ', ', $lead->frequency); ?></strong></p>
                    <hr>
                    <form method="POST" action="<?php echo admin_url( '/admin.php?page=devis-gratuit'); ?>" style="padding: 10px 0;">
                        <input type="hidden" name="action" value="deleteLeadDevisGratuit">
                        <input type="hidden" name="item_id" value="<?php echo $lead->id; ?>">
                        <button type="submit" class="button red button-xl">Delete Lead</button>
                    </form>
                </div>
            </div>
            <?php
        endif;
    }