function queryParams(p) {
    return p;
}

function reportReasonQueryParams(p) {
    return {
        ...p,
        "status": $('#filter_status').val(),
    };
}

function userListQueryParams(p) {
    return {
        ...p,
        "status": $('#filter_status').val(),
    };
}

function notificationUserList(p) {
    return {
        ...p,
        notification_list: 1
    };
}
