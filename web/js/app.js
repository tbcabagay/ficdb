(function($) {
    'use strict';

    var util = {
        modalTitle: 'Window',
        modalClass: '.modal',
        modalBody: '.modal-body',
        modalHeaderClass: '.modal-header-content',
        pjaxContainer: '#app-pjax-container',
        addEducationalBgId: '#add-faculty-educational-bg',
        addFacultyCourseId: '#add-faculty-course',
        addNoticeId: '#add-notice',
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
        gridRowClick: function(e) {
            var id = $(this).closest('tr').data('id');
            if (e.target == this && id) {
                util.addEducationalBg(id);
                util.addFacultyCourse(id);
                util.addNotice(id);
            }
        },
        facultyButtonClick: function(button) {
            var button = $(this);
            if (button.is(':enabled')) {
                location.href = button.val();
            }
        },
        setFacultyLink: function(button, id) {
            var button = button;
            var href = button.data('value');
            var link = href + '?faculty_id=' + id;
            button.val(link);
            button.prop('disabled', false);
            button.on('click', util.facultyButtonClick);
        },
        addEducationalBg: function(id) {
            var button = $(util.addEducationalBgId);
            util.setFacultyLink(button, id);
        },
        addFacultyCourse: function(id) {
            var button = $(util.addFacultyCourseId);
            util.setFacultyLink(button, id);
        },
        addNotice: function(id) {
            var button = $(util.addNoticeId);
            util.setFacultyLink(button, id);
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
    $(document).on('click', '#app-grid-faculty td', util.gridRowClick);
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