$.extend(window.Parsley.options, {
    focus: "first",
    excluded:
        "input[type=button], input[type=submit], input[type=reset], .search, .ignore",
    triggerAfterFailure: "change blur",
    errorsContainer: function (element) {
    },
    trigger: "change",
    successClass: "is-valid",
    errorClass: "is-invalid",
    classHandler: function (el) {
        return el.$element.closest(".form-group")
    },
    errorsContainer: function (el) {
        return el.$element.closest(".form-group")
    },
    errorsWrapper: '<div class="parsley-error"></div>',
    errorTemplate: "<span></span>",
})

Parsley.on("field:validated", function (el) {
    var elNode = $(el)[0]
    if (elNode && !elNode.isValid()) {
        var rqeuiredValResult = elNode.validationResult.filter(function (vr) {
            return vr.assert.name === "required"
        })
        if (rqeuiredValResult.length > 0) {
            var fieldNode = $(elNode.element)
            var formGroupNode = fieldNode.closest(".form-group")
            var lblNode = formGroupNode.find(".form-label:first")
            if (lblNode.length > 0) {
                // change default error message to include field label
                var errorNode = formGroupNode.find(
                    "div.parsley-error span[class*=parsley-]"
                )
                if (errorNode.length > 0) {
                    var lblText = lblNode.text()
                    if (lblText) {
                        errorNode.html(lblText + " is required.")
                    }
                }
            }
        }
    }
})

Parsley.addValidator("restrictedCity", {
    requirementType: "string",
    validateString: function (value, requirement) {
        value = (value || "").trim()
        return value === "" || value.toLowerCase() === requirement.toLowerCase()
    },
    messages: {
        en: 'You have to live in <a href="https://www.google.com/maps/place/Jakarta">Jakarta</a>.',
    },
})


//has uppercase
Parsley.addValidator('uppercase', {
    requirementType: 'number',
    validateString: function (value, requirement) {
        var uppercases = value.match(/[A-Z]/g) || [];
        return uppercases.length >= requirement;
    },
    messages: {
        en: 'Your password must contain at least (%s) uppercase letter.' + '<br>'
    }
});

//has lowercase
Parsley.addValidator('lowercase', {
    requirementType: 'number',
    validateString: function (value, requirement) {
        var lowecases = value.match(/[a-z]/g) || [];
        return lowecases.length >= requirement;
    },
    messages: {
        en: 'Your password must contain at least (%s) lowercase letter.' + '<br>'
    }
});

//has number
Parsley.addValidator('number', {
    requirementType: 'number',
    validateString: function (value, requirement) {
        var numbers = value.match(/[0-9]/g) || [];
        return numbers.length >= requirement;
    },
    messages: {
        en: 'Your password must contain at least (%s) number.' + '<br>'
    }
});

//has special char
Parsley.addValidator('special', {
    requirementType: 'number',
    validateString: function (value, requirement) {
        var specials = value.match(/[^a-zA-Z0-9]/g) || [];
        return specials.length >= requirement;
    },
    messages: {
        en: 'Your password must contain at least (%s) special characters.' + '<br>'
    }
});


Parsley.addValidator('minSelect', function (value, requirement) {
    return value.split(',').length >= parseInt(requirement, 10);
}, 32)
    .addMessage('en', 'minSelect', 'You must select at least %s.');


Parsley.addValidator('notequalto',
    function (value, requirement) {
        return value !== $(requirement).val();
    }, 32)
    .addMessage('en', 'notequalto', 'This value should not be the same.');

// Greater than validator
Parsley.addValidator('gt',
    function (value, requirement) {
        console.log('asdfsdfd');
        return parseFloat(value) > parseFloat($(requirement).val());
    }, 32)
    .addMessage('en', 'gt', 'This value should be greater %s');

// Greater than or equal to validator
Parsley.addValidator('ge',
    function (value, requirement) {
        return parseFloat(value) >= parseFloat($(requirement).val());
    }, 32)
    .addMessage('en', 'ge', 'This value should be greater or equal ');

// Less than validator
Parsley.addValidator('lt',
    function (value, requirement) {
        return parseFloat(value) < parseFloat($(requirement).val());
    }, 32)
    .addMessage('en', 'lt', 'This value should be less %s');

// Less than or equal to validator
Parsley.addValidator('le',
    function (value, requirement) {
        return parseFloat(value) <= parseFloat($(requirement).val());
    }, 32)
    .addMessage('en', 'le', 'This value should be less or equal');
