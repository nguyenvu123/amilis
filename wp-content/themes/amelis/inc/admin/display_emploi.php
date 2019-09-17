<?php

    function emploi_admin_display(){
        add_menu_page ('Emploi', 'Emploi', 'edit_posts', 'emploi', 'emploi_admin_display_content', 'dashicons-groups', 1 );
        add_submenu_page( 'emploi', 'Auxiliaires de vie', 'Auxiliaires de vie', 'edit_posts', 'auxiliaires-de-vie', 'auxiliaires_admin_display_content');
        add_submenu_page( 'emploi', 'Administratif', 'Administratif', 'edit_posts', 'administratif', 'administratif_admin_display_content');
    }

    add_action( 'admin_menu', 'emploi_admin_display' );
    
    function emploi_admin_display_content() {
        echo '';
    }

        
    function auxiliaires_admin_display_content() {
        global $wpdb;

        

        // process delete all
        if ( $_POST ) {
            if ( !empty($_POST['action']) && $_POST['action'] == 'deleteMultipleLeads' ) {
                $leads = $_POST['lead_id'];
                $leads_count = count($leads);

                $ids = implode( ',', array_map( 'absint', $leads ) );
                
                $wpdb->query( "DELETE FROM emploi WHERE id IN($ids)" ); 

                $feedback['message'] = 'There were '.$leads_count.' leads succesfully deleted!';
                $feedback['status'] = 'success';
            }
        }


        // process delete one
        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadEmploi') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM emploi where id=".$_POST['item_id'] );
            $wpdb->delete( 'emploi', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

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

        $leads = $wpdb->get_results( "SELECT * FROM emploi where type='auxiliaire' ".$where." order by time desc ".$limit );

        ?>
        <div class="wrap">
            <h1>Emploi Auxiliaires de vie</h1>

            <?php 
                $admin_page_name = 'auxiliaires-de-vie'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone', 'Postal Code', 'Agence', 'Experience', 'Diplome du sector social', 'Structures', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'experience', 'diplome', 'structures', 'ip']
                ];

                $json = select_json_fields($leads, $fields);
                $data = json_decode($json, true);
                $new_data = array();

                foreach ( $data as $d) {
                    if ( !empty($d['structures']) ){

                        $structures = json_decode($d['structures'], true);

                        $new_value = '';
                        foreach ($structures as $s) {
                            $new_value .= $s['structure'].': '.$s['duree'].' ans - ';
                        }
                        $new_value = rtrim($new_value, '- ');
                        $d['structures'] = $new_value;
                    }
                    array_push($new_data, $d);
                }

                display_json_to_csv_export_script(json_encode($new_data) , 'emploi_auxiliaire-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 


            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="emploi_auxiliaires_<?php echo date('Y-m-d-H:i'); ?>">
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
                    <th scope="col"><span>Code Postal</span></th>   
                    <th scope="col"><span>Agence</span></th>   
                    <th scope="col"><span>Experience</span></th>     
                    <th scope="col" style="display: none"><span>Diplome du sector social</span></th>     
                    <th scope="col" style="display: none"><span>Structures</span></th>     
                    <th scope="col"><span>CV</span></th>  
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
                    <?php
                        $structures = json_decode($lead->structures, true);

                        $new_value = '';
                        foreach ($structures as $s) {
                            $new_value .= $s['structure'].': '.$s['duree'].' ans - ';
                        }
                        $new_value = rtrim($new_value, '- ');
                        $structures_new_value = $new_value;
                    ?>
                    <tr>
                        <th class="check-column"><input id="emploi_row_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=emploi-item&item_id=<?php echo $lead->id; ?>&from-page=<?php echo $_GET['page']; ?>"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->zipcode; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><strong><?php echo ($lead->experience == 0) ? 'Non' : 'Oui' ; ?></strong></td>

                        <td style="display: none"><?php echo $lead->diplome; ?></td>
                        <td style="display: none"><?php echo $structures_new_value; ?></td>
                        <td>
                            <?php 
                                if ($lead->resume_uploaded )
                                    echo 'Oui';
                                else
                                    echo 'Non';
                            ?>
                        </td>

                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=emploi-item&item_id=<?php echo $lead->id; ?>&from-page=<?php echo $_GET['page']; ?>" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            </form>

            <?php echo (empty($limit)) ? "" : adminDisplayPagination('auxiliaires-de-vie'); ?>
        </div>
        <?php 
    }

    function administratif_admin_display_content() {

        global $wpdb;

        // process delete all
        if ( $_POST ) {
            if ( !empty($_POST['action']) && $_POST['action'] == 'deleteMultipleLeads' ) {
                $leads = $_POST['lead_id'];
                $leads_count = count($leads);

                $ids = implode( ',', array_map( 'absint', $leads ) );
                
                $wpdb->query( "DELETE FROM emploi WHERE id IN($ids)" ); 

                $feedback['message'] = 'There were '.$leads_count.' leads succesfully deleted!';
                $feedback['status'] = 'success';
            }
        }


        // process delete one
        if (!empty($_POST['action']) && $_POST['action'] == 'deleteLeadEmploi') {
            
            $lead_db = $wpdb->get_results( "SELECT * FROM emploi where id=".$_POST['item_id'] );


            $filename = explode('/', $lead_db->resume_uploaded);

            $deleted_file = unlink(WP_CONTENT_DIR.'/uploads/resumes/'.$lead_db->resume_uploaded);

            if (is_dir(WP_CONTENT_DIR.'/uploads/resumes/'.$filename[0]))
                rmdir(WP_CONTENT_DIR.'/uploads/resumes/'.$filename[0]);

            $wpdb->delete( 'emploi', array( 'id' => $_POST['item_id'] ), array( '%d' ) );

            $file_status = ($deleted_file) ? 'succesfully' : 'not';

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

        $leads = $wpdb->get_results( "SELECT * FROM emploi where type='administratif' ".$where." order by time desc ".$limit );


        ?>
        <div class="wrap">
            <h1>Emploi Administratif</h1>

            <?php 
                $admin_page_name = 'administratif'; 
                $file_prefix = $admin_page_name;
                include( locate_template( 'inc/template-parts/admin-table-top.php', false, false ) ); 

                $fields = [
                    'head' => ['ID', 'Date', 'Nom', 'Email', 'Telephone','Agence', 'Poste souhaité', 'Linkedin', 'Ip'],
                    'db' => ['id', 'time', 'name', 'email', 'phone', 'agence', 'position', 'linkedin', 'ip']
                ];

                $json = select_json_fields($leads, $fields);
                display_json_to_csv_export_script($json , 'emploi_administratif-'.date('Y-m-d-H-i-s'));
                echo '<pre id="csv" style="display: none"></pre>';
            ?> 

            <form action="" method="POST">
            <input type="hidden" name="action" value="deleteMultipleLeads">
                <input type="hidden" id="ExcelExportFilename" name="ExcelExportFilename" value="emploi_administratif_<?php echo date('Y-m-d-H:i'); ?>">
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
                    <th scope="col"><span>Linkedin</span></th>   
                    <th scope="col"><span>Position</span></th>  
                    <th scope="col"><span>CV</span></th>  
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
                        <th class="check-column"><input id="emploi_row_<?php echo $lead->id; ?>" name="lead_id[]" value="<?php echo $lead->id; ?>" type="checkbox"></th>
                        <td><?php echo $lead->id; ?></td>
                        <td><?php echo $lead->time; ?></td>
                        <td><a href="admin.php?page=emploi-item&item_id=<?php echo $lead->id; ?>&from-page=<?php echo $position; ?>"><?php echo $lead->name; ?></a></td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->phone; ?></td>
                        <td><?php echo $lead->agence; ?></td>
                        <td><?php echo ($lead->linkedin) ? '<a href="'.$lead->linkedin.'">'.$lead->linkedin.'</a>' : '-' ; ?></td>
                        <td><?php echo $lead->position; ?></td>
                        <td>
                            <?php 
                                if ($lead->resume_uploaded )
                                    echo 'Oui';
                                else
                                    echo 'Non';
                            ?>
                        </td>
                        <td><?php echo $lead->ip; ?></td>
                        <td></td>
                        <td><a href="admin.php?page=emploi-item&item_id=<?php echo $lead->id; ?>&from-page=administratif" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            </form>

            <?php echo (empty($limit)) ? "" : adminDisplayPagination('administratif'); ?>
        </div>
        <?php 
    }


    function emploi_view_item() {
        add_submenu_page ('emploi', 'View lead', NULL, 'edit_posts', 'emploi-item', 'emploi_view_item_content' );
    }
    add_action( 'admin_menu', 'emploi_view_item' );


    function emploi_view_item_content() {
        if ( !is_numeric($_GET['item_id']) )
            die();

        global $wpdb;
        
        $lead_db = $wpdb->get_results( "SELECT * FROM emploi where id=".$_GET['item_id'] );
        $lead = $lead_db[0];

        ?>
        <div class="wrap">
            <div class="admin-content-box">
                <h1><?php echo $lead->name; ?> - <span style="color: #999">Agence <?php echo $lead->agence; ?></span></h1>
                <p><?php echo $lead->time; ?></p>
                <p><?php echo $lead->phone; ?></p>
                <p><?php echo $lead->email; ?></p>
                
                <?php if ($lead->zipcode != '00000' ) : ?>
                    <p><?php echo $lead->zipcode; ?></p>
                <?php endif; ?>

                <p><?php echo $lead->ip; ?></p>
                
                <?php if ($lead->type ) : ?>
                    <p>
                        <strong>Job type</strong><br>
                        <?php echo ucfirst($lead->type); ?>
                    </p>
                <?php endif; ?>
                
                <?php if ($lead->position ) : ?>
                    <p>
                        <strong>Job position</strong><br>
                        <?php echo $lead->position; ?>
                    </p>
                <?php endif; ?>
                
                <?php if ($lead->linkedin ) : ?>
                    <p>
                        <strong>Linkedin profile</strong><br>
                        <a href="<?php echo $lead->linkedin; ?>"><?php echo $lead->linkedin; ?></a>
                    </p>
                <?php endif; ?>
                
                <?php if ($lead->resume_uploaded ) : ?>
                    <p>
                        <strong>Resume</strong><br>
                        <a href="<?php echo WP_CONTENT_URL.'/uploads/resumes/'.$lead->resume_uploaded; ?>"><?php echo $lead->resume_uploaded; ?></a>
                    </p>
                <?php endif; ?>


                <?php if (  $lead->type != 'administratif' ) : ?>
                    <p>
                        <strong>3 ans d’experience professionnelle dans le secteur social</strong><br>
                        <?php echo ($lead->experience == 0) ? 'No' : 'Yes' ; ?>

                        <?php if ($lead->experience == 1) :
                                $structures = json_decode($lead->structures, true);
                                echo '<ol>';
                                foreach ( $structures as $s) : ?>
                                    <li><?php echo $s['structure'].' - '.$s['duree'].' ans'; ?></li>
                        <?php 
                                endforeach;
                                echo '</ol>';
                            endif; 
                        ?>
                    </p>
                <?php endif; ?>
                
                <?php if ($lead->diplome) : ?>
                    <p>
                        <strong>Diplome du sector social</strong><br>
                        <?php echo $lead->diplome; ?>
                    </p>
                <?php endif; ?>

                    <hr>
                    <form method="POST" action="<?php echo admin_url( '/admin.php?page='.$_GET['from-page']); ?>" style="padding: 10px 0;">
                        <input type="hidden" name="action" value="deleteLeadEmploi">
                        <input type="hidden" name="item_id" value="<?php echo $lead->id; ?>">
                        <button type="submit" class="button red button-xl">Delete Lead</button>
                    </form>
            </div>
        </div>
        <?php
    }