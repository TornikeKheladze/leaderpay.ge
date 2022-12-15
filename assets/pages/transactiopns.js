var TableAjax = function () {

    var initPickers = function () {}

    var handleRecords = function () {

        var grid = new Datatable();

        var p = 0;
        var page = p * 10;

        grid.init({
            src: $("#datatable_ajax"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load
                // console.log(grid);
            },
            loadingMessage: 'მოითმინეთ...',

            dataTable: {
                "bStateSave": false,
                "lengthMenu": [
                    [20, 50, 100, 150],
                    [20, 50, 100, 150]
                ],
                "pageLength": 20,
                "ajax": {
                    "url": "loads/transactions.php",
                },
                "order": [
                    [0, "desc"]
                ],
                'displayStart': page,

            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {

            } else if (grid.getSelectedRowsCount() === 0) {

            }
        });
    }

    return {

        //main function to initiate the module
        init: function () {

            initPickers();
            handleRecords();
        }

    };

}();
