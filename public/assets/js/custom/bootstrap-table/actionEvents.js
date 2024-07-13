window.languageEvents = {
    'click .edit_btn': function (e, value, row) {
        $('.filepond').filepond('removeFile')
        $("#edit_name").val(row.name);
        $("#edit_name_in_english").val(row.name_in_english);
        $("#edit_code").val(row.code);
        $("#edit_rtl_switch").prop('checked', row.rtl);
        $("#edit_rtl").val(row.rtl ? 1 : 0);
    }
};
window.customFieldValueEvents = {
    'click .edit_btn': function (e, value, row) {
        $("#new_custom_field_value").val(row.value);
        $("#old_custom_field_value").val(row.value);
    }
}


window.itemEvents = {
    'click .editdata': function (e, value, row) {
        let html = `<table class="table">
            <tr>
                <th width="10%">${trans("No.")}</th>
                <th width="25%" class="text-center">${trans("Image")}</th>
                <th width="25%">${trans("Name")}</th>
                <th width="40%">${trans("Value")}</th>
            </tr>`;
        $.each(row.custom_fields, function (key, value) {
            html += `<tr class="mb-2">
                <td>${key + 1}</td>
                <td class="text-center">
                <a class="image-popup-no-margins" href="${value.image}" >
                <img src=${value.image} height="30px" width="30px" style="border-radius:8px;" alt="" onerror="onErrorImage(event)">
                </a>
                </td>
                <td>${value.name}</td>`;

            if (value.type == "fileinput") {
                if (value.value != undefined) {
                    if (value.value?.value.match(/\.(jpg|jpeg|png|svg)$/i)) {
                        html += `<td><img src="${value.value?.value}" alt="Custom Field Files" class="w-25" onerror="onErrorImage(event)"></td>`
                    } else {
                        html += `<td><a target="_blank" href="${value.value?.value}">View File</a></td>`
                    }

                } else {
                    html += `<td></td>`
                }
            } else {
                html += `<td class="text-break">${value.value?.value || ''}</td>`
            }

            html += `</tr>`;
        });

        html += "</table>";
        $('#custom_fields').html(html)
    },

    'click .edit-status': function (e, value, row) {
        $('#status').val(row.status).trigger('change');
        $('#rejected_reason').val(row.rejected_reason);
    }
}

window.packageEvents = {
    'click .edit_btn': function (e, value, row) {
        $('#edit_price').val(row.price);
        $('#edit_discount_in_percentage').val(row.discount_in_percentage);
        $('#edit_final_price').val(row.final_price);
        $('#edit_name').val(row.name);
        $('#edit_description').val(row.description);
        $('#edit_ios_product_id').val(row.ios_product_id);

        // Assuming 'id' is a variable containing the ID you are working with
        if (row.duration.toLowerCase() === "unlimited") {
            // "Unlimited" value, set unlimited duration
            // $('input[type="radio"][name="duration_type"][value="unlimited"]').prop('checked', true);
            $('#edit_duration_type_unlimited').prop('checked', true);
            $('#edit_durationLimit').val();
            $('#edit_limitation_for_duration').hide();
        } else {
            // Numeric value, set limited duration
            // $('input[type="radio"][name="duration_type"][value="limited"]').prop('checked', true);
            $('#edit_duration_type_limited').prop('checked', true);
            $('#edit_limitation_for_duration').show();
            $('#edit_durationLimit').val(row.duration);
        }


        if (row.item_limit.toLowerCase() === "unlimited") {
            // "Unlimited" value, set unlimited duration
            // $('input[type="radio"][name="item_limit_type"][value="unlimited"]').prop('checked', true);
            $('#edit_item_limit_type_unlimited').prop('checked', true);
            $('#edit_ForLimit').val();
            $('#edit_limitation_for_limit').hide();
        } else {
            // Numeric value, set limited duration
            // $('input[type="radio"][name="item_limit_type"][value="limited"]').prop('checked', true);
            $('#edit_item_limit_type_limited').prop('checked', true);
            $('#edit_limitation_for_limit').show();
            $('#edit_ForLimit').val(row.item_limit);
        }
    }
};

window.advertisementPackageEvents = {
    'click .edit_btn': function (e, value, row) {
        $('#edit_name').val(row.name);
        $('#edit_price').val(row.price);
        $('#edit_discount_in_percentage').val(row.discount_in_percentage);
        $('#edit_final_price').val(row.final_price);
        $("#edit_duration").val(row.duration);
        $('#edit_durationLimit').val(row.duration);
        $('#edit_ForLimit').val(row.item_limit);
        $('#edit_description').val(row.description);
        $('#edit_ios_product_id').val(row.ios_product_id);
    }
};

window.reportReasonEvents = {
    'click .edit_btn': function (e, value, row) {
        $("#edit_reason").val(row.reason);
    }
}

window.featuredSectionEvents = {
    'click .edit_btn': function (e, value, row) {
        $('#edit_title').val(row.title);
        $('#edit_slug').val(row.slug);
        $('#edit_filter').val(row.filter).trigger('change');
        $('input[name="edit_style_app"][value="' + row.style + '"]').prop('checked', true);

        if (row.filter === "price_criteria") {
            $('.price_criteria').show();
            $('#edit_min_price').val(row.min_price);
            $('#edit_max_price').val(row.max_price);
        } else {
            $('.price_criteria').hide();
            $('#edit_min_price').val();
            $('#edit_max_price').val();
        }

        if (row.filter == "category_criteria") {
            $('.category_criteria').show();
            if (row.value != '') {
                $('#edit_category_id').val(row.value.split(',')).trigger('change');
            } else {
                $('#edit_category_id').val('').trigger('change');
            }
        } else {
            $('.category_criteria').hide();
            $('#edit_category_id').val('').trigger('change');
        }

        $('input[name="style"]').attr('checked', false);
        $('input[name="style"][value="' + row.style + '"]').attr('checked', true);
    }
};

window.staffEvents = {
    'click .edit_btn': function (e, value, row) {
        $('#edit_role').val(row.roles[0].id);
        $('#edit_name').val(row.name);
        $('#edit_email').val(row.email);
    }
}

window.userEvents = {
    'click .assign_package': function (e, value, row) {
        $("#user_id").val(row.id);
        $('.package_type').prop('checked', false);

        $('#item-listing-package-div').hide();
        $('#advertisement-package-div').hide();

        $('#advertisement-package').attr('required', false);
        $('#item-listing-package').attr('required', false);

        $('#package_details').hide();
        $('.payment').hide();
        $('.cheque').hide();
    }
}

window.faqEvents = {
    'click .edit_btn': function (e, value, row) {
        $('#edit_question').val(row.question);
        $('#edit_answer').val(row.answer);
    }
}
window.areaEvents = {
    'click .edit_btn': function (e, value, row) {
        $('#edit_name').val(row.name);
    }
}
