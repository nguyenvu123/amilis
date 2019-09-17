<?php 

if ( !empty($feedback) )
echo '<div class="alert alert-'.$feedback['status'].'">'.$feedback['message'].'</div>';
?>

<?php 
$json = select_json_fields($leads, ['id', 'time', 'name', 'email', 'phone', 'zipcode', 'agence', 'newsletter', 'contacte', 'ip']);
display_json_to_csv_export_script($json , $file_prefix.'-'.date('Y-m-d-H-i-s')); 
?>

<pre id="csv" style="display: none"></pre>

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


<div style="padding: 5px; margin: 10px auto; background: #fff;">
<form method="GET" id="datePickerForm">
<input type="hidden" name="page" value="<?php echo $admin_page_name; ?>">
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