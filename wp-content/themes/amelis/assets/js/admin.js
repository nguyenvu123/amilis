
jQuery(function($) {

    $(document).ready(function(){

    
        // Admin Delete button
        $('#beforeDelete').on('click', function(e) {
            e.preventDefault();

            var checksForDelete = 0;

            checksForDelete = $('.check-column input:checked').length;

            if(confirm("Are you sure you want to delete " + checksForDelete + " rows?")) {
                $(this).closest('form').submit();
            }
            else {
                return false;
            }

        });


        // on load
        var ignoredRows = selectCheckedTableRows();
        var ignoredCols = selectIgnoredTableColumns();

        var tableExport = jQuery(".excel-table").tableExport({
            formats: ["xlsx", "csv"],
            ignoreCols: ignoredCols,
            ignoreRows: ignoredRows,
            filename: jQuery('#ExcelExportFilename').val(),
            sheetname: 'leads',
            exportButtons: true,
            position: 'top'
        });


        // after checkboxes are updated
        $('.excel-table tbody th.check-column input').click(function() {
            var ignoredRows = selectCheckedTableRows();
            var ignoredCols = selectIgnoredTableColumns();
    
            tableExport.remove();

            tableExport = jQuery(".excel-table").tableExport({
                formats: ["xlsx", "csv"],
                ignoreCols: ignoredCols,
                ignoreRows: ignoredRows,
                filename: jQuery('#ExcelExportFilename').val(),
                sheetname: 'leads',
                exportButtons: true,
                position: 'top'
            });
        })


        function selectCheckedTableRows() {
            var ignoreRows = [];

            if ( $('.check-column input:checked').length > 0 ) {
                $('.excel-table tbody th.check-column').each(function(index) {
                    if ( !$(this).find('input').prop('checked') ) {
                        ignoreRows.push( index );
                    }
                })
            }

            return ignoreRows;
        }

        function selectIgnoredTableColumns() {
            var ignoredCols = [];

            if ( $('.excel-table').length > 0 ) {
                $('.excel-table thead th').each(function(index) {
                    if ($(this).hasClass('ignore'))
                        ignoredCols.push( index );
                })
            }

            return ignoredCols;
        }

    
    });

});