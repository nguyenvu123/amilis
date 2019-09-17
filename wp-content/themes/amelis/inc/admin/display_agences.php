<?php

    function agences_cp_admin_display(){
        add_menu_page ('Agences CP', 'Agences CP', 'edit_posts', 'agences_cp', 'agences_cp_admin_display_content', 'dashicons-location', '1.5' );
    }

    function agences_cp_admin_display_content() {
        global $wpdb;

        $agences = array();
        $agences = $wpdb->get_results( "SELECT count(id) as total, agence, agence_tag, agence_id FROM agences group by agence order by agence asc" );

        $total_postal_codes = 0;
        ?>
        <div class="wrap">
            <h1>Agences</h1>

            <table class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                    <th scope="col"><span>Name</span></th>
                    <th scope="col"><span>Total Postal Codes</span></th>
                    <th scope="col"><span>Actions</span></th>                 
                </tr>
            </thead>
            <?php if ( $agences ) : ?>
            <tbody>
                <?php foreach ( $agences as $a ) : ?>
                    <tr>
                        <td></td>
                        <td><?php echo $a->agence; ?></td>
                        <td><?php echo $a->total; ?></td>
                        <td><a href="admin.php?page=agence-item&item_id=<?php echo strtolower($a->agence_id); ?>" class="button button-primary button-large">View</a></td>
                    </tr>
                <?php 
                    $total_postal_codes += $a->total;
                    endforeach; 
                ?>
            </tbody>
            <tfoot>
                <td></td>
                <td></td>
                <td><?php echo $total_postal_codes; ?></td>
                <td></td>
            </tfoot>
            <?php endif; ?>
            </table>
        </div>
        <?php 
    }
    add_action( 'admin_menu', 'agences_cp_admin_display' );

    function agence_cp_view_item() {
        add_submenu_page (NULL, 'View agence', NULL, 'edit_posts', 'agence-item', 'agence_cp_view_item_content' );
    }


    function agence_cp_view_item_content() {
        if ( !is_numeric($_GET['item_id']) )
            die();

        global $wpdb;

        $agence = get_post($_GET['item_id']);
        
        $postal_codes = $wpdb->get_results( "SELECT * FROM agences where agence_id=".$_GET['item_id'] );

        $emploi_postal_codes = $wpdb->get_results( "SELECT * FROM agences_work where agence_id=".$_GET['item_id'] );


        ?>
        <div class="wrap">
                <h1><?php echo $agence->post_title; ?></h1>

                <div class="admin-content-box">

                    <?php 
                        // Devis Gratuit
                        $postal_codes_string = '';
                        foreach ($postal_codes as $p) :
                            $postal_codes_string .= $p->postal_code.', ';
                        endforeach; 

                        $postal_codes_string = substr($postal_codes_string, 0, -2);

                        // Emploi
                        $emploi_postal_codes_string = '';
                        foreach ($emploi_postal_codes as $p) :
                            $emploi_postal_codes_string .= $p->postal_code.', ';
                        endforeach; 

                        $emploi_postal_codes_string = substr($emploi_postal_codes_string, 0, -2);
                    ?>

                    <form method="POST">
                        <input type="hidden" name="action" value="saveAgencePostalCodes">
                        <input type="hidden" name="agence_id" value="<?php echo $agence->ID; ?>">

                        <h2 class="hndle">Assigned postal codes for "<em style="color: #999">devis gratuit</em>" in <?php echo $agence->post_title; ?>  - <span style="color: #999">(<?php echo count($postal_codes); ?> postal codes)</span></h2>
                        <textarea name="postal_codes" id="postal_codes" rows="10" style="width: 100%; max-width: 900px"><?php echo $postal_codes_string; ?></textarea>
                        <br>
                    
                        <button type="submit" class="button button-primary button-large">Save</button>
                    </form>

                    <hr>

                    <form method="POST">
                        <input type="hidden" name="action" value="saveEmploiPostalCodes">
                        <input type="hidden" name="agence_id" value="<?php echo $agence->ID; ?>">

                        <h2 class="hndle">Assigned postal codes for "<em style="color: #999">emploi</em>" in <?php echo $agence->post_title; ?>  - <span style="color: #999">(<?php echo count($emploi_postal_codes); ?> postal codes)</span></h2>
                        <textarea name="emploi_postal_codes" id="emploi_postal_codes" rows="10" style="width: 100%; max-width: 900px"><?php echo $emploi_postal_codes_string; ?></textarea>
                        <br>

                        <button type="submit" class="button button-primary button-large">Save</button>
                    </form>

            </div>
        </div>
        <?php
    }
    add_action( 'admin_menu', 'agence_cp_view_item' );

    if ( !empty($_POST['action']) ) :
        if ( $_POST['action'] == 'saveAgencePostalCodes') :
            $agence_id = $_POST['agence_id'];

            $agence = get_post($agence_id);

            $new_postal_codes = explode(', ', $_POST['postal_codes']);

            // Delete existing postal codes
            $wpdb->query( 
                $wpdb->prepare("DELETE FROM agences WHERE id > 0 AND agence_id = %s ", $agence->ID)
            );

            // Insert all zipcodes
            foreach ($new_postal_codes as $np) :
                $wpdb->insert( 
                    'agences', 
                    array( 
                        'postal_code' => $np, 
                        'agence' => $agence->post_title,
                        'agence_id' => $agence->ID,
                        'agence_tag' => $agence->post_name
                    ), 
                    array( 
                        '%d',
                        '%s', 
                        '%d',
                        '%s'
                    ) 
                );
            endforeach;
        endif; // Save new postal codes for devis gratuit

        
        if ( $_POST['action'] == 'saveEmploiPostalCodes') :
            $agence_id = $_POST['agence_id'];

            $agence = get_post($agence_id);

            $new_postal_codes = explode(', ', $_POST['emploi_postal_codes']);

            // Delete existing postal codes
            $wpdb->query( 
                $wpdb->prepare("DELETE FROM agences_work WHERE id > 0 AND agence_id = %s ", $agence->ID)
            );

            // Insert all zipcodes
            foreach ($new_postal_codes as $np) :
                $wpdb->insert( 
                    'agences_work', 
                    array( 
                        'postal_code' => $np, 
                        'agence' => $agence->post_title,
                        'agence_id' => $agence->ID,
                        'agence_tag' => sanitize_title($agence->post_title)
                    ), 
                    array( 
                        '%d',
                        '%s', 
                        '%d',
                        '%s'
                    ) 
                );
            endforeach;
        endif; // Save new postal codes for emploi
    endif;