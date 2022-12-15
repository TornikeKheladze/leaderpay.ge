
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css?<?=time() ?>"/>

<div class="title clear-after"><?=$lang['transactions'] ?></div>
<table id="datatable_ajax" class="table" cellspacing="0" width="min-width: 800px;">
    <thead>
        <tr>
            <th><?=$lang['date'] ?></th>
            <th><?=$lang['name'] ?></th>
            <th><?=$lang['money'] ?></th>
            <th><?=$lang['balance'] ?></th>
        </tr>
        <tr role="row" class="filter">
            <form id="myform">
                <td style="width: 25%;">
                    <div style="width: 45%; float: left">
                        <input type="text" class="form-control form-filter input-sm date-input" name="from_date" autocomplete="off" placeholder="დან">
                    </div>
                    <div style="width: 45%; float: right">
                        <input type="text" class="form-control form-filter input-sm date-input" name="to_date" autocomplete="off" placeholder="მდე">
                    </div>
                </td>
                <td></td>
                <td style="width: 20%;">
                    <div style="width: 45%; float: left">
                        <input type="text" class="form-control form-filter input-sm" name="from_amount" autocomplete="off" placeholder="დან">
                    </div>
                    <div style="width: 45%; float: right">
                        <input type="text" class="form-control form-filter input-sm" name="to_amount" autocomplete="off" placeholder="მდე">
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-sm filter-submit" id="filter-submit"><i class="fa fa-search"></i></button>
                </td>
            </form>
        </tr>
    </thead>
</table>

<!-- datatable-->
<script type="text/javascript" src="assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="assets/plugins/datatables/datatable.js?<?=time() ?>"></script>
<script src="assets/pages/transactiopns.js?<?=time() ?>"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        TableAjax.init();
        $('.form-filter').blur(function() {
            $('#filter-submit').trigger('click');
        });
        $('.form-filter').change(function() {
            $('#filter-submit').trigger('click');
        });
    });
</script>
