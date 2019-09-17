<?php

function display_json_to_csv_export_script($json, $filename) {
echo '<script type="text/javascript">
        // JSON to CSV Converter
            function ConvertToCSV(objArray) {
                var array = typeof objArray != "object" ? JSON.parse(objArray) : objArray;
                var str = "";
    
                for (var i = 0; i < array.length; i++) {
                    var line = "";
                    for (var index in array[i]) {
                        if (line != "") line += ","
    
                        line += array[i][index];
                    }
    
                    str += line + "\r\n";
                }
    
                return str;
            }
        
    jQuery(function($) {
        // Example
        $(document).ready(function () {

            $("#downloadCSV").on("click", function() {

                // Create Object
                var items = '.$json.' ;
    
                // Convert Object to JSON
                var jsonObject = JSON.stringify(items);
    
                var exportedFilenmae = "'.$filename.'.csv";
    
                // Convert JSON to CSV & Display CSV
                $("#csv").text(ConvertToCSV(jsonObject));

                var csv_data = helperConvertJSONToCSV(jsonObject);

                var csv = "\ufeff" + csv_data;

                var blob = new Blob([csv], { type: "text/csv; charset=ISO-8859-1;" });

                if (navigator.msSaveBlob) { // IE 10+
                    navigator.msSaveBlob(blob, exportedFilenmae);
                } else {
                    var link = document.createElement("a");
                    if (link.download !== undefined) { // feature detection
                        // Browsers that support HTML5 download attribute
                        var url = URL.createObjectURL(blob);
                        link.setAttribute("href", url);
                        link.setAttribute("download", exportedFilenmae);
                        link.style.visibility = "hidden";
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                }

                function helperConvertJSONToCSV(objArray) {
                    var array = typeof objArray != "object" ? JSON.parse(objArray) : objArray;
                    var str = "";
                
                    for (var i = 0; i < array.length; i++) {
                        var line = "";
                        for (var index in array[i]) {
                            if (line != "") line += ","
                
                            line += array[i][index];
                        }
                
                        str += line + "\r\n";
                    }
                
                    return str;
                }

            });

        }); 
    })

        </script>';
}

function select_json_fields($items, $fields) {

    $return = [];

    array_push($return, $fields['head']);

    foreach ( $items as $item ) {
        $new_item = [];


        foreach ( $fields['db'] as $f) {

            if ( $f != 'structures' ) {
                $new_value = str_replace(',', ' ', $item->$f);

                if ( $new_value == '0' ) $new_value = 'Non';
                if ( $new_value == '1' ) $new_value = 'Oui';

                $new_item[$f] = $new_value;
            } else {
                $new_item[$f] = $item->$f;
            }
        }
    
        array_push($return, $new_item);
    }

    return json_encode($return);
}


function adminGetCurrentPage() {
    $page = 1;

    if ( isset($_GET['page_number']) && !empty($_GET['page_number']) ) {
        $page = $_GET['page_number'];
    }

    return $page;
}


function adminGetStartLimit() {
    $start = 0;
    $page = adminGetCurrentPage();

    $start = ($page - 1) * NUMBER_OF_LEADS_PER_ADMIN_PAGE;

    return $start;
}

function adminGetNextPage($total) {
    $current_page = adminGetCurrentPage();
    $total_pages = adminGetTotalPages($total);

    $next_page = 1;

    if ( $total_pages > $current_page) {
        $next_page = $current_page + 1;
    } else {
        $next_page = $current_page;
    }

    return $next_page;
}

function adminGetPrevPage() {
    $current_page = adminGetCurrentPage();
    $prev_page = 1;

    if ( $current_page > 1) {
        $prev_page = $current_page - 1;
    }

    return $prev_page;
}

function adminGetTotalPages($total_items) {
    $total_pages = ceil( $total_items / NUMBER_OF_LEADS_PER_ADMIN_PAGE );
    return $total_pages;
}


function adminDisplayPagination($page) {
    global $wpdb;


    switch ($page) {
        case 'devis-gratuit':
        $total = $wpdb->get_var( "SELECT COUNT(*) FROM devis_gratuit" );    
            break;

        case 'apa-guide': 
                $total = $wpdb->get_var( "SELECT COUNT(*) FROM forms where type='APA Guide'" ); 
            break;

        case 'apa-form': 
                $total = $wpdb->get_var( "SELECT COUNT(*) FROM forms where type='APA Formulaire'" ); 
            break;

        case 'pch-guide': 
                $total = $wpdb->get_var( "SELECT COUNT(*) FROM forms where type='PCH Guide'" ); 
            break;

        case 'pch-form': 
                $total = $wpdb->get_var( "SELECT COUNT(*) FROM forms where type='PCH Formulaire'" ); 
            break;

        case 'ardh-guide': 
                $total = $wpdb->get_var( "SELECT COUNT(*) FROM forms where type='ARDH'" ); 
            break;

        case 'auxiliaires-de-vie':
            $total = $wpdb->get_var( "SELECT COUNT(*) FROM emploi where type='auxiliaire'" );    

            break;

        case 'administratif':
            $total = $wpdb->get_var( "SELECT COUNT(*) FROM emploi where type='administratif'" );    

            break;

        case 'gir':
            $total = $wpdb->get_var( "SELECT COUNT(*) FROM gir" );    
            break;

        case 'contact-form':
            $total = $wpdb->get_var( "SELECT COUNT(*) FROM contact" );    

            break;
    }

    $current_page = adminGetCurrentPage();
    $total_pages = adminGetTotalPages($total);
    $next_page = adminGetNextPage($total);
    $prev_page = adminGetPrevPage();

    $pagination = '<div class="tablenav bottom">
                <div class="tablenav-pages"><span class="displaying-num">'.$total.' items</span>
                    <span class="pagination-links">';


    if ( $current_page > 1) :
        $pagination .= '<a class="first-page" href="/wp-admin/admin.php?page='.$page.'&page_number=1"><span aria-hidden="true">«</span></a>
                        <a class="prev-page" href="/wp-admin/admin.php?page='.$page.'&page_number='.$prev_page.'"><span aria-hidden="true">‹</span></a>';
    else :
        $pagination .= '<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
                 <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>';
    endif;
                        
        $pagination .= '<span id="table-paging" class="paging-input"><span class="tablenav-paging-text">'.adminGetCurrentPage().' of <span class="total-pages">'.$total_pages.'</span></span></span>';

    
    if ( $current_page >= $total_pages ) :
        $pagination .= '<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
                        <span class="tablenav-pages-navspan" aria-hidden="true">»</span>';
    else :
        $pagination .= '<a class="next-page" href="/wp-admin/admin.php?page='.$page.'&page_number='.$next_page.'"><span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>
        <a class="last-page" href="/wp-admin/admin.php?page='.$page.'&page_number='.$total_pages.'"><span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a>';
    endif;

    $pagination .= '</span>
                </div>
                <br class="clear">
            </div>';

    echo $pagination;
}