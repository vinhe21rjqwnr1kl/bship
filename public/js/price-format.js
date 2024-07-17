function formatToNative(n) {
    return n.replace(/[^\d.-]/g, "");
}

var CurrencyInputHandler = (function() {
    function formatNumber(n) {
        var isNegative = n.startsWith('-');
        var absNumber = n.replace(/^-/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return isNegative ? '-' + absNumber : absNumber;
    }

    function formatCurrency(input) {
        var input_val = input.val();
        if (input_val === "") { return; }
        var isNegative = input_val.startsWith('-');

        if (input_val.indexOf(".") >= 0) {
            var decimal_pos = input_val.indexOf(".");
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            left_side = formatNumber(left_side);
            right_side = formatNumber(right_side);
            right_side = right_side.substring(0, 2);
            input_val = (isNegative ? '-' : '') + left_side + "." + right_side;
        } else {
            input_val = formatNumber(input_val);
        }
        input.val(input_val);

        var hiddenInputId = input.data('hidden');
        if (hiddenInputId) {
            var hiddenInput = $(hiddenInputId);
            if (hiddenInput.length > 0) {
                hiddenInput.val(formatToNative(input_val));
            }
        }
    }

    function handleInputChange() {
        $("input[data-type='currency']").on({
            input: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this));
            }
        });
    }

    function formatAllCurrencyInputs() {
        $("input[data-type='currency']").each(function() {
            formatCurrency($(this));
        });
    }

    return {
        handleInputChange: handleInputChange,
        formatAllCurrencyInputs: formatAllCurrencyInputs

    };

})();

$(document).ready(function() {
    CurrencyInputHandler.handleInputChange();
    CurrencyInputHandler.formatAllCurrencyInputs(); // Format all currency inputs on page load

    $("input[data-type='currency']").on({
        input: function () {
            var input_val = $(this).val();
            var hiddenInputId = $(this).data('hidden');
            if (hiddenInputId) {
                var hiddenInput = $(hiddenInputId);
                if (hiddenInput.length > 0) {
                    hiddenInput.val(formatToNative(input_val));
                }
            }
        },
        blur: function () {
            var input_val = $(this).val();
            var hiddenInputId = $(this).data('hidden');
            if (hiddenInputId) {
                var hiddenInput = $(hiddenInputId);
                if (hiddenInput.length > 0) {
                    hiddenInput.val(formatToNative(input_val));
                }
            }
        }
    });
});
