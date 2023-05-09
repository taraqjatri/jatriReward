var DateTimePickers = function() {
    const _componentDaterange = function() {
        if (!$().daterangepicker) {
            console.warn('Warning - daterangepicker.js is not loaded.');
            return;
        }

        $('.daterange-basic').daterangepicker({
            parentEl: '.content-inner',
            autoUpdateInput: false,
        });

        $('.daterange-buttons').daterangepicker({
            parentEl: '.content-inner',
            applyClass: 'btn-success',
            cancelClass: 'btn-danger'
        });

        $('.daterange-time').daterangepicker({
            parentEl: '.content-inner',
            timePicker: true,
            locale: {
                format: 'DD/MM/YYYY h:mm a'
            }
        });

        $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
    }

    return {
        init: function() {
            _componentDaterange();
            // _componentDatepicker();
        }
    }
}();
document.addEventListener('DOMContentLoaded', function() {
    DateTimePickers.init();
});
