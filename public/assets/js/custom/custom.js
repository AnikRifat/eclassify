// @ts-nocheck


$(document).ready(function () {

    /// START :: ACTIVE MENU CODE
    $(".menu a").each(function () {
        let pageUrl = window.location.href.split(/[?#]/)[0];
        if (this.href == pageUrl) {
            $(this).parent().parent().addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
            $(this).parent().parent().parent().parent().addClass("active"); // add active class to an anchor
        }

        let subURL = $("a#subURL").attr("href");
        if (subURL != 'undefined') {
            if (this.href == subURL) {
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().addClass("active");
                $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
            }
        }
    });
    /// END :: ACTIVE MENU CODE
    if ($('.select2').length > 0) {
        $('.select2').select2();
    }

    $('.select2-selection__clear').hide();

    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType);

    if ($('.filepond').length > 0) {
        $('.filepond').filepond({
            credits: null,
            allowFileSizeValidation: "true",
            maxFileSize: '25MB',
            labelMaxFileSizeExceeded: 'File is too large',
            labelMaxFileSize: 'Maximum file size is {filesize}',
            allowFileTypeValidation: true,
            acceptedFileTypes: ['image/*'],
            labelFileTypeNotAllowed: 'File of invalid type',
            fileValidateTypeLabelExpectedTypes: 'Expects {allButLastType} or {lastType}',
            storeAsFile: true,
            allowPdfPreview: true,
            pdfPreviewHeight: 320,
            pdfComponentExtraParams: 'toolbar=0&navpanes=0&scrollbar=0&view=fitH',
            allowVideoPreview: true, // default true
            allowAudioPreview: true // default true
        });
    }

    //magnific popup
    $(document).on('click', '.image-popup-no-margins', function () {
        $(this).magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't forget to change the duration also in CSS
            },
            gallery: {
                enabled: true
            },
        }).magnificPopup('open');
        return false;
    });

    $('#table_list').on('load-success.bs.table', function () {
        if ($('.gallery').length > 0) {
            $('.gallery').each(function () { // the containers for all your galleries
                $(this).magnificPopup({
                    delegate: 'a', // the selector for gallery item
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
            });
        }
    })

    $(document).off('focusin');
});


/// START :: TinyMCE
document.addEventListener("DOMContentLoaded", () => {
    tinymce.init({
        selector: '#tinymce_editor',
        height: 400,
        menubar: true,
        plugins: [
            'advlist autolink lists link charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime table paste code help wordcount'
        ],

        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        setup: function (editor) {
            editor.on("change keyup", function () {
                //tinyMCE.triggerSave(); // updates all instances
                editor.save(); // updates this instance's textarea
                $(editor.getElement()).trigger('change'); // for garlic to detect change
            });
        }
    });
});

$('body').append('<div id="loader-container"><div class="loader"></div></div>');
$(window).on('load', function () {
    $('#loader-container').fadeOut('slow');
});

setTimeout(function () {
    $(".error-msg").fadeOut(1500)
}, 5000);

document.addEventListener('touchstart', event => {
    if (event.cancelable) {
        event.preventDefault();
    }
});

document.addEventListener('touchmove', event => {
    if (event.cancelable) {
        event.preventDefault();
    }
});

document.addEventListener('touchcancel', event => {
    if (event.cancelable) {
        event.preventDefault();
    }
});

$('.status-switch').on('change', function () {
    if ($(this).is(":checked")) {
        $(this).siblings('input[type="hidden"]').val(1);
    } else {
        $(this).siblings('input[type="hidden"]').val(0);
    }
})

$('input[type="radio"][name="duration_type"]').on('click', function () {
    if ($(this).hasClass('edit_duration_type')) {
        if ($(this).is(':checked')) {
            if ($(this).val() == 'limited') {
                $('#edit_limitation_for_duration').show();
                $('#edit_durationLimit').attr("required", "true").val("");
            } else {
                // Unlimited
                $('#edit_limitation_for_duration').hide();
                $('#edit_durationLimit').removeAttr("required").val("");
            }
        }
    } else {
        if ($(this).is(':checked')) {
            if ($(this).val() == 'limited') {
                $('#limitation_for_duration').show();
                $('#durationLimit').attr("required", "true").val("");
            } else {
                // Unlimited
                $('#limitation_for_duration').hide();
                $('#durationLimit').removeAttr("required").val("");
            }
        }
    }
});

$('input[type="radio"][name="item_limit_type"]').on('click', function () {
    if ($(this).hasClass('edit_item_limit_type')) {
        if ($(this).is(':checked')) {
            if ($(this).val() == 'limited') {
                $('#edit_limitation_for_limit').show();
                $('#edit_ForLimit').attr("required", "true");
            } else {
                // Unlimited
                $('#edit_limitation_for_limit').hide();
                $('#edit_ForLimit').val('');
                $('#edit_ForLimit').removeAttr("required");
            }
        }
    } else {
        if ($(this).is(':checked')) {
            if ($(this).val() == 'limited') {
                $('#limitation_for_limit').show();
                $('#durationForLimit').attr("required", "true");
            } else {
                // Unlimited
                $('#limitation_for_limit').hide();
                $('#durationForLimit').removeAttr("required");
            }
        }
    }
});

$('#filter').change(function () {
    let selectedValue = $(this).val();
    // Hide all criteria elements initially
    $('#category_criteria, #price_criteria').hide();
    // Show the relevant criteria based on the selected option
    if (selectedValue === "category_criteria") {
        $('#category_criteria').show();
    } else if (selectedValue === "price_criteria") {
        $('#price_criteria').show();
    }
});

$('#edit_filter').change(function () {
    let selectedValue = $(this).val();
    $('#edit_min_price').val("");
    $('#edit_max_price').val("");
    // Hide all criteria elements initially
    $('#edit_category_criteria, #edit_price_criteria').hide();
    // Show the relevant criteria based on the selected option
    if (selectedValue === "category_criteria") {
        $('#edit_category_criteria').show();
    } else if (selectedValue === "price_criteria") {
        $('#edit_price_criteria').show();
    }
});

$("#include_image").change(function () {
    if (this.checked) {
        $('#show_image').show('fast');
        $('#file').attr('required', 'required');
    } else {
        $('#file').val('');
        $('#file').removeAttr('required');
        $('#show_image').hide('fast');
    }
});


$('#user_notification_list').on('check.bs.table  uncheck.bs.table', function () {
    let user_list = [];
    let data = $("#user_notification_list").bootstrapTable('getSelections');
    data.forEach(function (value) {
        if (value.id != "") {
            user_list.push(value.id);
        }
    })
    $('textarea#user_id').text(user_list);
});

$('#delete_multiple').on('click', function (e) {
    e.preventDefault();
    let table = $('#table_list');
    let selected = table.bootstrapTable('getSelections');
    let ids = "";

    $.each(selected, function (i, e) {
        ids += e.id + ",";
    });
    ids = ids.slice(0, -1);
    if (ids == "") {
        showErrorToast(trans('Please Select Notification First'));
    } else {
        showDeletePopupModal($(this).attr('href'), {
            data: {
                id: ids
            }, successCallBack: function () {
                $('#table_list').bootstrapTable('refresh');
            }
        })
    }
});


$(".checkbox-toggle-switch").on('change', function () {
    let inputValue = $(this).is(':checked') ? 1 : 0;
    $(this).siblings(".checkbox-toggle-switch-input").val(inputValue);
});

$('.toggle-button').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.category-header').next('.subcategories').slideToggle();
});

let length = $('#sub_category_count').val();

for (let i = 1; i <= length; i++) {
    $('.child_category_list' + i).hide();
    $('#sub_category' + i).change(function () {
        $('#child_category' + i).prop("checked", $(this).is(":checked"));
    });

    $('#category_arrow' + i).on('click', function () {
        $('.child_category_list' + i).toggle();
    });
}

$('#type').on('change', function () {
    if ($.inArray($(this).val(), ['checkbox', 'radio', 'dropdown']) > -1) {
        $('#field-values-div').slideDown(500);
        $('.min-max-fields').slideUp(500);
    } else {
        $('#field-values-div').slideUp(500);
        $('.min-max-fields').slideDown(500);
    }
});

$('.image').on('change', function () {
    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    const fileInput = this;
    const [file] = fileInput.files;
    if (!file) {
        return; // No file selected
    }

    if (!allowedExtensions.exec(file.name)) {
        $('.img_error').text('Invalid file type. Please choose an image file.');
        fileInput.value = '';
        return;
    }

    const maxFileSize = 2 * 1024 * 1024; // 5MB (adjust as needed)
    if (file.size > maxFileSize) {
        $('.img_error').text('File size exceeds the maximum allowed size (2MB).');
        fileInput.value = '';
    }
    if (file) {
        $(this).siblings('.preview-image').attr('src', URL.createObjectURL(file))
    }
});

$('.img_input').on('click', function () {
    $(this).siblings('.image').click();
});

$(".toggle-password").on('click', function () {
    $(this).toggleClass("bi bi-eye bi-eye-slash");
    let input = $(this).parent().siblings("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

$('#price,#discount_in_percentage').on('input', function () {
    let price = $('#price').val();
    let discount = $('#discount_in_percentage').val();
    let final_price = calculateDiscountedAmount(price, discount);
    $('#final_price').val(final_price);
})

$('#final_price').on('input', function () {
    let discountedPrice = $(this).val();
    let price = $('#price').val();
    let discount = calculateDiscount(price, discountedPrice);
    $('#discount_in_percentage').val(discount);
})


$('#edit_price,#edit_discount_in_percentage').on('input', function () {
    let price = $('#edit_price').val();
    let discount = $('#edit_discount_in_percentage').val();
    let final_price = calculateDiscountedAmount(price, discount);
    $('#edit_final_price').val(final_price);
})

$('#edit_final_price').on('input', function () {
    let discountedPrice = $(this).val();
    let price = $('#edit_price').val();
    let discount = calculateDiscount(price, discountedPrice);
    $('#edit_discount_in_percentage').val(discount);
})
$('#slug').bind('keyup blur', function () {
    $(this).val($(this).val().replace(/[^A-Za-z0-9-]/g, ''))
});

function toggleRejectedReasonVisibility() {
    var status = $('#status').val();
    var rejectedReasonContainer = $('#rejected_reason_container');
    if (status === 'rejected') {
        rejectedReasonContainer.show();
    } else {
        rejectedReasonContainer.hide();
    }
}

$('.editdata, #status').on('click change', function () {
    toggleRejectedReasonVisibility();
});

$(document).on('change', '.update-item-status', function () {
    let url = window.baseurl + "common/change-status";
    ajaxRequest('PUT', url, {
        id: $(this).attr('id'),
        table: "items",
        column: "deleted_at",
        status: $(this).is(':checked') ? 1 : 0
    }, null, function (response) {
        showSuccessToast(response.message);
    }, function (error) {
        showErrorToast(error.message);
    })
})

$(document).on('change', '.update-user-status', function () {
    let url = window.baseurl + "common/change-status";
    ajaxRequest('PUT', url, {
        id: $(this).attr('id'),
        table: "users",
        column: "deleted_at",
        status: $(this).is(':checked') ? 1 : 0
    }, null, function (response) {
        showSuccessToast(response.message);
    }, function (error) {
        showErrorToast(error.message);
    })
})

$('#switch_banner_ad_status').on('change', function () {
    $('#banner_ad_id_android').attr('required', $(this).is(':checked'));
    $('#banner_ad_id_ios').attr('required', $(this).is(':checked'));
})

$('.package_type').on('change', function () {
    if ($(this).val() == 'item_listing') {
        $('#item-listing-package-div').show();
        $('#advertisement-package-div').hide();

        $('#item-listing-package').attr('required', true);
        $('#advertisement-package').attr('required', false);
    } else if ($(this).val() == 'advertisement') {
        $('#item-listing-package-div').hide();
        $('#advertisement-package-div').show();

        $('#advertisement-package').attr('required', true);
        $('#item-listing-package').attr('required', false);
    }
});

$('.package').on('change', function () {
    let package_detail = $(this).find('option:selected').data('details');
    if (package_detail != null) {
        $('#package_details').show();
        $('.payment').show();
    } else {
        $('#package_details').hide();
        $('.payment').hide();
        $('.cheque').hide();
    }
    $("#package_name").text(package_detail?.name);
    $("#package_price").text(package_detail?.price);
    $("#package_final_price").text(package_detail?.final_price);
    $("#package_duration").text(package_detail?.duration);
});
$('.payment_gateway').change(function () {
    if ($(this).val() == 'cheque') {
        $('.cheque').show();
    } else {
        $('.cheque').hide();
    }

    $('.payment').val('').trigger('change');
});


$('#switch_interstitial_ad_status').on('change', function () {
    $('#interstitial_ad_id_android').attr('required', $(this).is(':checked'));
    $('#interstitial_ad_id_ios').attr('required', $(this).is(':checked'));
})

$('#country').on('change', function () {
    let countryId = $(this).val();
    let url = window.baseurl + 'states/search?country_id=' + countryId;
    ajaxRequest('GET', url, null, null, function (response) {
        $('#state').html("<option value=''>" + window.trans("--Select State--") + "</option>")
        $.each(response.data, function (key, value) {
            $('#state').append($('<option>', {
                value: value.id,
                text: value.name
            }));
        });
    })
});

$('#state').on('change', function () {
    let stateId = $(this).val();
    let url = window.baseurl + 'cities/search?state_id=' + stateId;
    ajaxRequest('GET', url, null, null, function (response) {
        $('#city').html("<option value=''>" + window.trans("--Select City--") + "</option>")
        $.each(response.data, function (key, value) {
            $('#city').append($('<option>', {
                value: value.id,
                text: value.name
            }));
        });
    })
});

$('#filter_country').on('change', function () {
    let countryId = $(this).val();
    let url = window.baseurl + 'states/search?country_id=' + countryId;
    ajaxRequest('GET', url, null, null, function (response) {
        $('#filter_state').html("<option value=''>" + window.trans("All") + "</option>")
        $.each(response.data, function (key, value) {
            $('#filter_state').append($('<option>', {
                value: value.id,
                text: value.name
            }));
        });
    })
});

$('#filter_state').on('change', function () {
    let stateId = $(this).val();
    let url = window.baseurl + 'cities/search?state_id=' + stateId;
    ajaxRequest('GET', url, null, null, function (response) {
        $('#filter_city').html("<option value=''>" + window.trans("All") + "</option>")
        $.each(response.data, function (key, value) {
            $('#filter_city').append($('<option>', {
                value: value.id,
                text: value.name
            }));
        });
    })
});

$(document).ready(function () {
    const $addAreaButton = $('#add-area-button');
    const $areasContainer = $('#areas-container');

    $addAreaButton.on('click', function () {
        const $newAreaInputGroup = $(`
            <div class="area-input-group col-md-12">
                <label for="name" class="mandatory form-label mt-2"> Area Name</label>
                <div class="d-flex">
                    <input type="text" name="name[]" class="form-control me-2" placeholder="Enter Area name">
                    <button type="button" class="btn btn-danger remove-area-button ">-</button>
                </div>
            </div>
        `);
        $areasContainer.append($newAreaInputGroup);
    });

    // Event delegation to handle dynamically added remove buttons
    $areasContainer.on('click', '.remove-area-button', function () {
        $(this).closest('.area-input-group').remove();
    });
});

$('#switch_stripe_gateway').on('change', function () {
    let status = $(this).prop('checked');
    $('[name^="gateway[Stripe]"]').each(function () {
        $(this).prop('required', status);
    });
});

$('#switch_razorpay_gateway').on('change', function () {
    let status = $(this).prop('checked');
    $('[name^="gateway[Razorpay]"]').each(function () {
        $(this).prop('required', status);
    });
});

$('#switch_paystack_gateway').on('change', function () {
    let status = $(this).prop('checked');
    $('[name^="gateway[Paystack]"]').each(function () {
        $(this).prop('required', status);
    });
});

$('#google_map_iframe_link').on('input', function () {
    try {
        let element = $(this).val();
        let src = $(element).attr('src');
        $(this).val(src);
    } catch (err) {
        $(this).val("");
        showErrorToast("Please enter a valid map iframe")
    }

});
$('#category_name').on('input', function () {
    let slug = generateSlug($(this).val())
    $('#category_slug').val(slug);
});

$('.feature-section-name').on('input', function () {
    let slug = generateSlug($(this).val());
    $('.feature-section-slug').val(slug);
});

$('.edit-feature-section-name').on('input', function () {
    let slug = generateSlug($(this).val());
    $('.edit-feature-section-slug').val(slug);
});
