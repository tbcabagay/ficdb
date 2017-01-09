(function($) {
    'use strict';

    var util = {
        modalTitle: 'Window',
        modalClass: '.modal',
        modalBody: '.modal-body',
        modalHeaderClass: '.modal-header-content',
        pjaxContainer: '#app-pjax-container',
        displayModal: function() {
            var content = $(this).attr('href');

            $(util.modalHeaderClass).text(util.modalTitle);
            $(util.modalClass).modal('show').find(util.modalBody).load(content);

            return false;
        },
        closeModal: function() {
            $(document).find(util.modalClass).modal('hide');
        },
        reloadPjax: function() {
            $.pjax.reload({ container: util.pjaxContainer });
        },
    };

    var form = {
        submitModal: function() {
            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(response) {
                    util.closeModal();

                    if (response.result == 'success') {
                        util.reloadPjax();
                    }
                },
            });

            return false;
        },
    };

    $(document).on('beforeSubmit', '#app-form', form.submitModal);
    $(document).on('click', '.btn-modal', util.displayModal);
})(jQuery);

/*var myApp = {
    modalClick : function() {
        jQuery("body").on("click", ".btn-modal", function() {
            var content = jQuery(this).attr("href");
            jQuery("#helper-modal").modal("show").find(".modal-body").load(content);
            return false;
        });
    },
    modalForm : function(form = null, pjaxContainer = null, modalContainer = null) {
        if (modalContainer == null) {
            modalContainer = "#helper-modal";
        }
        jQuery(document).on("beforeSubmit", form, function(e) {
            var f = jQuery(this);
            jQuery.ajax({
                url: f.attr("action"),
                type: "post",
                data: f.serialize(),
                success: function(r){
                    if (r.status) {
                        jQuery(document).find(modalContainer).modal("hide");
                        jQuery.pjax.reload({ container: pjaxContainer });
                    }
                }
            });
            return false;
        });
    },
}*/