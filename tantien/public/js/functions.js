/**
 * Get current module information
 */
function getModuleInfo()
{
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
function searchData(controller, keepSorted)
{
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
 * Init event for search form
 */
function autoSearchData(controller)
{
    $("#searchForm #" + controller + "_btn_search").on("click", function () {
        searchData(controller);
    });
    $("#" + controller + "resetBtn").on("click", function () {
        $("#searchForm").find("input").each(function () {
            var type = $(this).attr('type');
            if(type=='text') {
                $(this).val("");
            }

        });

        searchData(controller);
    });
}

/**
 * Show add new form base on the clicked button
 */
function showAddForm()
{
    $('.add-action').off('click').on('click', function (e) {
        var controller = $(this).attr('data-object');
        var addUri = base_url + '/' + controller + '/add';

        $('#add' + controller + 'Modal').load(addUri, function (res, err, xhr) {
            handleError(xhr);
        });
    });
}

/**
 * Add new row in drugOrder table
 */
 function addNewDrugOrderRow()
 {
    let tbody = $('#addDrug > tbody');
    let defaultRow = $('#defaultTable > tbody > tr').clone();

    // append to table
    defaultRow.appendTo(tbody);

    var ar = new Array();
    $('#addDrug > tbody > tr').each(
        function (index) {
            // remake order number
            $(this).children().eq(0).html(++index);
            // get id number into array
            ar.push (
                parseInt($(this).attr('id').replace('addDrug-', ''))
            );
        }
    );

    // get index
    var maxIdx = Math.max.apply(Math, ar);
    var index = maxIdx + 1;

     // assign attribute for input
    defaultRow.children().eq(1).find('select').attr('class', 'form-control drug-select2');
    defaultRow.children().eq(1).find('select').attr('name', 'drugDetail[' + index + '][drug_id]');
    defaultRow.children().eq(1).find('select').attr('data-target', index);
    defaultRow.children().eq(2).find('select').attr('name', 'drugDetail[' + index + '][unit_id]');
    defaultRow.children().eq(2).find('select').attr('data-target', index);
    defaultRow.children().eq(3).find('input').attr('name', 'drugDetail[' + index + '][quantity]');
    defaultRow.children().eq(3).find('input').attr('data-target', index);
    defaultRow.children().eq(4).find('label').attr('name', 'drugDetail[' + index + '][sum]');

    // set Id for current row
    let id = 'addDrug-' + index;
    defaultRow.attr('id', id);
    // set event for button remove
    removeRow();
    // set select2 for combobox
    loadDrugCombobox('#' + id);
 }

 /**
  * Remove current row
  */
function removeRow()
{
    $('.removeRow').off('click').on('click', function () {
       $(this).parent().parent().remove();

        // remake order number
        $('#addDrug > tbody > tr').each(
            function (index) {
                $(this).children().eq(0).html(++index);
            }
        );
    }) 
}

function formatRepoSelection(repo)
{
    return repo.name || repo.text;
}

function formatRepo(repo)
{
    if (repo.loading) return repo.text;

    display = repo.name || repo.text;

    var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'>" + display + "</div>";
    return markup;
}

/**
 * Load drug combobox
 */
function loadDrugCombobox($parent)
{
    // route
    let url = $('#DO-getDrugList').val();

    // config
    let config = {
        ajax: {
            url: url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term,
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.items,
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        allowClear: false,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    };

    $($parent + " .drug-select2")
        .select2(config)
        .on('change', function (e) {
            let value = $(this).val();

            let selectName = "drugDetail[";
            selectName = selectName.concat($(this).attr('data-target'));
            selectName = selectName.concat("][unit_id]");
            target = '[name="' + selectName + '"]';
            let quantityTarget = target.replace('unit_id', 'quantity');

            loadUnitCombobox(value, target, '');
            // reset other remain input
            $(".unit-select2" + target).val('').trigger('change');
            $(".quantity" + quantityTarget)
                .val('1')
                .off('change')
                .on('change', function (e) {
                    getSumOfDrug($(this).attr('data-target'));
                });
            $("[name='drugDetail["+$(this).attr('data-target')+"][sum]']").html('0 VND');
    });
}

/**
 * Load Unit
 */
function loadUnitCombobox(drugId, target, value)
{
    // route
    let url = $('#DO-getUnitList').val() + '/' + drugId;

    // config
    let config = {
        ajax: {
            url: url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term,
                };
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.items, function(item) {
                        return { id: item.unit_id, text: item.unit.name };
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        allowClear: false,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    };

    $(".unit-select2" + target)
        .select2(config)
        .on('change', function (e) {
            getSumOfDrug($(this).attr('data-target'));
        });
}

/**
 *  get sum of each row
 */
function getSumOfDrug(target)
{
    let drugId = $("[name='drugDetail[" + target + "][drug_id]']").val();
    let unitId = $("[name='drugDetail[" + target + "][unit_id]']").val();
    let quantity = $("[name='drugDetail[" + target + "][quantity]'").val();
    // route
    let url = $('#DO-getSum').val() + '/' + drugId;

    // check informations
    if(drugId && unitId && (quantity && quantity > 0)) {
       $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            dataType: 'json',
            url: $('#DO-getSum').val() + '/' + drugId,
            data: {
                unitId: unitId,
                quantity: quantity,
            },
            success: function (data) {
                let sum = data.sum;

                $("[name='drugDetail[" + target + "][sum]'").html(sum);
            },
            error: function (result) {
                handleError(result);
            }
        })
    } else {
        $("[name='drugDetail[" + target + "][sum]']").html('0 VND');
    }
}

/**
 * Validate and run add data form for module
 * @param controller
 */

function runSaveDataForm(controller, action) {
    var $form = $("#" + action + controller + "ModalForm");
    $form.validate({
        errorPlacement: function(error, element) {
            if(element.is('select') == true && element.next().is('span')) {
                error.insertAfter(element.next());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function () {
            if ($form.valid()) {
                if ($('#' + action + controller + 'Modal').find('.error:visible').length > 0) {
                    $('#' + action + controller + 'Modal').find('.error input[type=text]').focus();
                } else {
                    saveItem(controller, action);
                }
            }

            return false;
        }
    });
}

/**
 * Save item to module
 * @param controller
 */
function saveItem(controller, action) {
    $.ajax({
        url: base_url + "/" + controller + "/" + action,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        dataType: 'json',
        data: $('#' + action + controller + 'ModalForm').serialize(),
        success: function (result) {
            if (result) {
                try
                {    
                    if (result.status) {
                        $('#' + action + controller + 'Modal').modal('hide');

                        if(action == 'add') {
                            //showEditFormAfterAddSuccess(controller, result.id, message);
                        }

                        if(result.isReloadAll === undefined) {
                            searchData(controller, true);
                        }
                    }
                    else {
                        var error = result.error;
                        if (error.msg) {
                            displayErrorMessageOnModal('#' + action + controller + 'Modal', error.msg);
                        }
                    }
                }
                catch (e)
                {
                    console.log(e);
                }
            }
        },
        error: function (result) {
            handleError(result);
        }
    });
}

function displayErrorMessageOnModal(modalId, message)
{
    $(modalId).find('.alert-danger.on-modal').remove();

    var errorMsgBlock ='<div class="alert alert-danger on-modal" id="common-alert-danger"><p id="common-message_danger">'+message+'</p></div>';
    $(modalId).find('.modal-header.first-header').after(errorMsgBlock);
    $(modalId).scrollTop(0);
    $(".alert.alert-danger.on-modal").fadeTo(3000, 500).slideUp(500, function(){
        $(".alert.on-modal").slideUp(500);
    });
}

/**
 * Go to login page when the session end
 */
function handleError(xhr, modalData, controller)
{
    if (xhr.status == 200 && modalData != undefined){
        modalData.modal();
    } else if (xhr.status == 403) {
        alert(logoutAlert);
        location.reload();
    } else if (xhr.status == 404) {
        alert(notFoundAlert);
    } else if (xhr.status == 500) {
        alert('Lỗi hệ thống, vui lòng liên hệ IT');
    }

}