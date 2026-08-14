/* global jQuery, vs_bqp_admin */
(function ($) {
    'use strict';

    var $modal;
    var $input;
    var $status;
    var $applyButton;
    var requestRunning = false;

    function openModal() {
        if (!$modal || !$modal.length) return;
        $status.text('').removeClass('is-error is-success');
        $input.val(vs_bqp_admin.default_units || '');
        $modal.removeAttr('hidden').attr('aria-hidden', 'false');
        $('body').addClass('vs-bqp-modal-open');
        window.setTimeout(function () { $input.trigger('focus').trigger('select'); }, 50);
    }

    function closeModal() {
        if (requestRunning || !$modal || !$modal.length) return;
        $modal.attr('hidden', 'hidden').attr('aria-hidden', 'true');
        $('body').removeClass('vs-bqp-modal-open');
    }

    function setBusy(isBusy) {
        requestRunning = isBusy;
        $applyButton.prop('disabled', isBusy);
        $modal.find('[data-vs-bqp-close], [data-vs-bqp-inherit]').prop('disabled', isBusy);
    }

    function submitBulkValue(value) {
        setBusy(true);
        $status.text(vs_bqp_admin.saving_message).removeClass('is-error is-success');
        $.post(vs_bqp_admin.ajax_url, {
            action: 'vs_bqp_bulk_set_units_per_box',
            nonce: vs_bqp_admin.nonce,
            product_id: vs_bqp_admin.product_id,
            value: value
        }).done(function (response) {
            if (!response || !response.success) {
                var message = response && response.data && response.data.message ? response.data.message : vs_bqp_admin.error_message;
                $status.text(message).addClass('is-error');
                return;
            }
            $status.text(response.data.message).addClass('is-success');
            window.setTimeout(function () {
                requestRunning = false;
                closeModal();
                $('#variable_product_options').trigger('reload');
            }, 450);
        }).fail(function () {
            $status.text(vs_bqp_admin.error_message).addClass('is-error');
        }).always(function () {
            if ($status.hasClass('is-error')) setBusy(false);
        });
    }

    $(function () {
        $modal = $('#vs-bqp-bulk-modal');
        $input = $('#vs-bqp-bulk-units');
        $status = $('#vs-bqp-bulk-status');
        $applyButton = $('#vs-bqp-bulk-apply');

        $(document).on('change', 'select.variation_actions', function (event) {
            var $select = $(this);
            if ('vs_bqp_set_units_per_box' !== $select.val()) return;
            event.preventDefault();
            event.stopImmediatePropagation();
            $select.val('bulk_actions');
            openModal();
            return false;
        });

        $modal.on('click', '[data-vs-bqp-close], .vs-bqp-modal__backdrop', closeModal);
        $modal.on('click', '[data-vs-bqp-inherit]', function () { submitBulkValue(''); });
        $applyButton.on('click', function () {
            var value = $.trim($input.val());
            if (!/^\d+$/.test(value) || parseInt(value, 10) < 1) {
                $status.text(vs_bqp_admin.invalid_units_message).addClass('is-error').removeClass('is-success');
                $input.trigger('focus');
                return;
            }
            submitBulkValue(value);
        });
        $input.on('keydown', function (event) {
            if (13 === event.keyCode) { event.preventDefault(); $applyButton.trigger('click'); }
        });
        $(document).on('keydown', function (event) {
            if (27 === event.keyCode && $modal.length && !$modal.is('[hidden]')) closeModal();
        });
    });
})(jQuery);
