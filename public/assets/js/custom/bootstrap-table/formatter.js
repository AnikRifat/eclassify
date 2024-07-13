function imageFormatter(value) {
    if (value) {
        return '<a class="image-popup-no-margins one-image" href="' + value + '">' +
            '<img class="rounded avatar-md shadow img-fluid " alt="" src="' + value + '" width="55" onerror="onErrorImage(event)">' +
            '</a>'
    } else {
        return '-'
    }
}

function galleryImageFormatter(value) {
    if (value) {
        let html = '<div class="gallery">';
        $.each(value, function (index, data) {
            html += '<a href="' + data.image + '"><img class="rounded avatar-md shadow img-fluid m-1" alt="" src="' + data.image + '" width="55" onerror="onErrorImage(event)"></a>';
        })
        html += "</div>"
        return html;
    } else {
        return '-'
    }
}

function subCategoryFormatter(value, row) {
    let url = `/category/${row.id}/subcategories`;
    return '<a href="' + url + '"> <div class="category_count">' + value + ' Sub Categories</div></a>';
}

function customFieldFormatter(value, row) {
    let url = `/category/${row.id}/custom-fields`;
    return '<a href="' + url + '"> <div class="category_count">' + value + ' Custom Fields</div></a>';

}

function statusSwitchFormatter(value, row) {
    return `<div class="form-check form-switch">
        <input class = "form-check-input switch1 update-status" id="${row.id}" type = "checkbox" role = "switch${status}" ${value ? 'checked' : ''}>
    </div>`
}

function itemStatusSwitchFormatter(value, row) {
    return `<div class="form-check form-switch">
        <input class = "form-check-input switch1 update-item-status" id="${row.item_id}" type = "checkbox" role = "switch${status}" ${value ? 'checked' : ''}>
    </div>`
}

function userStatusSwitchFormatter(value, row) {
    return `<div class="form-check form-switch">
        <input class = "form-check-input switch1 update-user-status" id="${row.user_id}" type = "checkbox" role = "switch${status}" ${value ? 'checked' : ''}>
    </div>`
}


function itemStatusFormatter(value) {
    let badgeClass, badgeText;
    if (value == "review") {
        badgeClass = 'primary';
        badgeText = 'Under Review';
    } else if (value == "approved") {
        badgeClass = 'success';
        badgeText = 'Approved';
    } else if (value == "rejected") {
        badgeClass = 'danger';
        badgeText = 'Rejected';
    } else if (value == "sold out") {
        badgeClass = 'warning';
        badgeText = 'Sold Out';
    } else if (value == "featured") {
        badgeClass = 'black';
        badgeText = 'Featured';
    } else if (value == "inactive") {
        badgeClass = 'danger';
        badgeText = 'Inactive';
    }
    return '<span class="badge rounded-pill bg-' + badgeClass + '">' + badgeText + '</span>';
}

function status_badge(value, row) {
    let badgeClass, badgeText;
    if (value == '0') {
        badgeClass = 'danger';
        badgeText = 'OFF';
    } else {
        badgeClass = 'success';
        badgeText = 'ON';
    }
    return '<span class="badge rounded-pill bg-' + badgeClass + '">' + badgeText + '</span>';
}

function userStatusBadgeFormatter(value, row) {
    let badgeClass, badgeText;
    if (value == '0') {
        badgeClass = 'danger';
        badgeText = 'Inactive';
    } else {
        badgeClass = 'success';
        badgeText = 'Active';
    }
    return '<span class="badge rounded-pill bg-' + badgeClass + +'">' + badgeText + '</span>';
}

function styleImageFormatter(value, row) {
    return '<a class="image-popup-no-margins" href="images/app_styles/' + value + '.png"><img src="images/app_styles/' + value + '.png" alt="style_4"  height="60" width="60" class="rounded avatar-md shadow img-fluid"></a>';
}

function filterTextFormatter(value) {
    let filter;
    if (value == "most_liked") {
        filter = "Most Liked";
    } else if (value == "price_criteria") {
        filter = "Price Criteria";
    } else if (value == "category_criteria") {
        filter = "Category Criteria";
    } else if (value == "most_viewed") {
        filter = "Most Viewed";
    }
    return filter;
}

function adminFile(value, row) {
    return "<a href='languages/" + row.code + ".json ' )+' > View File < /a>";
}

function appFile(value, row) {
    return "<a href='lang/" + row.code + ".json ' )+' > View File < /a>";
}

function textReadableFormatter(value, row) {
    let string = value.replace("_", " ");
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function unlimitedBadgeFormatter(value) {
    if (!value) {
        return 'Unlimited';
    }
    return value;
}

function detailFormatter(index, row) {
    let html = []
    $.each(row.translations, function (key, value) {
        html.push('<p><b>' + value.language.name + ':</b> ' + value.description + '</p>')
    })
    return html.join('')
}
