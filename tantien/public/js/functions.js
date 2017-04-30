/**
 * Get current module information
 */
function getModuleInfo() {
    var module = $("#moduleInfo");
    if (module.length > 0) {
        return $("#moduleInfo");
    }
    else {
        return false;
    }
}

/**
 * Search and render view
 */
function searchData(controller, keepSorted) {
    $('#searchForm').submit(function (e) {
        e.preventDefault();
        return false;
    });
    // serialize data of form
    var data = $("#searchForm").serialize();
    // making uri
    var uriData = base_url + "/" + controller + "/search?" + data;
    // get search div
    var listElement = $("#" + controller + "DataList");
    // render search view
    listElement.load(uriData, function (res, err, xhr) {
        handleError(xhr);
    });
}

/**
 * Go to login page when the session end
 */
function handleError(xhr, modalData, controller) {
    if (xhr.status == 200 && modalData != undefined){
        modalData.modal();
    } else if (xhr.status == 403) {
        alert(logoutAlert);
        location.reload();
    } else if (xhr.status == 404){
        alert(notFoundAlert);
    }

}