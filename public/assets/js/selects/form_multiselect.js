var BootstrapMultiselect = function() {
    var _componentMultiselect = function() {
        if (!$().multiselect) {
            console.warn('Warning - bootstrap-multiselect.js is not loaded.');
            return;
        }

        $('.multiselect').multiselect();
    };

    return {
        init: function() {
            _componentMultiselect();
        }
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    BootstrapMultiselect.init();
});
