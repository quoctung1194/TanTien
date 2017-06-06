$(function () {
    var idsModule = getModuleInfo();

    if (idsModule) {
        // get name controller
        var moduleController = idsModule.attr('controller');
        // render search view
        searchData(moduleController);
        // init event for search form
        autoSearchData(moduleController);
    }

    loadDatepicker();

    $(document).ajaxComplete(function () {
        applyMainPagingAjax(moduleController);
        showAddForm();
        removeRow();
        showEditForm();
        removeHtmlDialogWhenClose(moduleController);
        showDeleteConfirmBox();
        runDelete();
    });
});

/**
 * Apply paging Ajax
 * @param controller
 */
function applyMainPagingAjax(controller)
{
    $('.paginator a').off('click').on('click', function () {
        if ($(this).attr('href') == undefined || $(this).attr('href') == '') {
            return false;
        }

        var data = $("#searchForm").serialize();
        $("#" + controller + "DataList").load($(this).attr('href')+'&keep_sorted=1', function (res, err, xhr) {
            handleError(xhr);
        });

        return false;
    });
}

/**
 * Loading date picker
 */
function loadDatepicker()
{
    $( ".datepicker" ).datepicker({
        dateFormat: "dd/mm/yy"
    });
}