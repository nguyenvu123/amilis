function FilterInput(event) {
    var keyCode = ('which' in event) ? event.which : event.keyCode;

    // e , . = - (numpad also)
    isNotWanted = (keyCode == 69 || keyCode == 188 || keyCode == 190 || keyCode == 187 || keyCode == 189 || keyCode == 107 || keyCode == 109  || keyCode == 110 || keyCode == 229 || keyCode == 35 || keyCode == 42 || keyCode == 59);
    return !isNotWanted;
};
function handlePaste (e) {
    var clipboardData, pastedData;

    // Get pasted data via clipboard API
    clipboardData = e.clipboardData || window.clipboardData;
    pastedData = clipboardData.getData('Text').toUpperCase();

    if(pastedData.indexOf('E')>-1) {
        //alert('found an E');
        e.stopPropagation();
        e.preventDefault();
    }
};