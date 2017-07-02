/**
 * Add new row in standard table
 */
 function addNewStandard()
 {
    let tbody = $('#addStandard > tbody');
    let defaultRow = $('#defaultTable > tbody > tr').clone();

    // append to table
    defaultRow.appendTo(tbody);

    var ar = new Array();
    $('#addStandard > tbody > tr').each(
        function (index) {
            // get id number into array
            ar.push (
                parseInt($(this).attr('id').replace('addStandard-', ''))
            );
        }
    );

    // get index
    var maxIdx = Math.max.apply(Math, ar);
    var index = maxIdx + 1;

     // assign attribute for input
    defaultRow.children().eq(0).find('select').attr('name', 'standard[' + index + '][unit_id]');
    defaultRow.children().eq(1).find('input').attr('name', 'standard[' + index + '][quantity]');
    defaultRow.children().eq(2).find('select').attr('name', 'standard[' + index + '][ref_unit_id]');

    // set Id for current row
    let id = 'addStandard-' + index;
    defaultRow.attr('id', id);
}


/**
 * Add new row in special price table
 */
 function addNewSpecialPrice()
 {
    let tbody = $('#addSpecial > tbody');
    let defaultRow = $('#defaultSpecialTable > tbody > tr').clone();

    // append to table
    defaultRow.appendTo(tbody);

    var ar = new Array();
    $('#addSpecial > tbody > tr').each(
        function (index) {
            // get id number into array
            ar.push (
                parseInt($(this).attr('id').replace('addSpecial-', ''))
            );
        }
    );

    // get index
    var maxIdx = Math.max.apply(Math, ar);
    var index = maxIdx + 1;

     // assign attribute for input
    defaultRow.children().eq(0).find('input').attr('name', 'special[' + index + '][quantity]');
    defaultRow.children().eq(1).find('select').attr('name', 'special[' + index + '][unit_id]');
    defaultRow.children().eq(2).find('input').attr('name', 'special[' + index + '][price]');

    // set Id for current row
    let id = 'addSpecial-' + index;
    defaultRow.attr('id', id);

    removeRow();
}

/**
 * Remove row in standard table
 */
function removeStandard()
{
    if(confirm('Sẽ xóa hết toàn bộ quy cách, bạn chắc không')) {
        let tbody = $('#addStandard > tbody');
        tbody.html('');
    }
}