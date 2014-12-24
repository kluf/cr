$(document).ready(function() {

var CR = CR || {}

CR = (function() {
    
//    $('.collapse.navbar-collapse li a').click(function(){
//        $(this).parent('li').addClass('active');
//    });
    
    var authors = [],
        reviewers = [],
        states = [],
        changesetForEditing;
        
    $('.table .btn.btn-default').popover();
    
    function renderStatesForCodereviews() {
        $('tr').find('.state').each(function() {
            paintStates($(this), $(this).text());
        });
    }
    
    function paintStates(row, state) {
        switch (state) {
            case 'not ok':
                return row.html("<div class='alert alert-danger smaller_states'><span class='glyphicon glyphicon-remove-sign'></span></div>");
                break;
            case 'looking':
                return row.html("<div class='alert alert-warning smaller_states'><span class='glyphicon glyphicon-eye-open'></span></div>");
                break;
            case 'good':
                return row.html("<div class='alert alert-success smaller_states'><span class='glyphicon glyphicon-ok-sign'></span></div>");
                break;
            case 'questions':
                return row.html("<div class='alert alert-questions smaller_states'><span class='glyphicon glyphicon-question-sign'></span></div>");
                break;
            default:
                return row.html("<div class='alert alert-info smaller_states'><span class='glyphicon glyphicon-bell'></span></div>");
                break;
        }
    }
    
    function PopUp() {
        if (typeof (this.instance) === 'object') {
            return this.instance;
        }
        this.body = $('body > .container').append('<div class="fadingWrapperInvisible fadingWrapper"><div class="row"><div class="col-md-12"><div class="panel panel-default add-changesets-popup-active">\n\
                    <div class="panel-heading">Add changeset(s)<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div>\n\
                    <div class="panel-body"><form class="form-inline" role="form" method="POST"></form><input type="text" id="numberOfCasesToAdd" placeholder="5"><button type="button" class="btn btn-success add-changeset-button" disabled="disabled">\n\
                    <span class="glyphicon glyphicon-plus-sign"></span></button></div></div></div></div></div>');
        this.instance = this;
    }
    
    function makePopUpActive() {
        $('.panel-default.add-changesets-popup-active').removeClass('add-changesets-popup-non-active');
    }
    
    function getFormattedDate() {
        var currentDate = new Date(),
            month = convertOneDigitToTwoInTime(currentDate.getMonth() + 1),
            dateOfMonth = convertOneDigitToTwoInTime(currentDate.getDate()),
            year = currentDate.getFullYear(),
            hour = convertOneDigitToTwoInTime(currentDate.getHours()),
            min = convertOneDigitToTwoInTime(currentDate.getMinutes() + 1),
            sec = convertOneDigitToTwoInTime(currentDate.getSeconds() + 1);
            return month + '-' + dateOfMonth + '-' + year + ' ' + hour + ':' + min + ':' + sec;
    }
    
    function convertOneDigitToTwoInTime(number) {
        if (number < 10) {
            return "0" + number;
        } else {
            return number;
        }
    }
    
    function createInput(obj) {
        var name = obj.name,
            typeOfInput = obj.typeOfInput,
            value = obj.value ? obj.value : ' ',
            disabled = obj.disabled ? 'disabled' : '',
            markup = '<div class="form-group"><label class="sr-only" for="'+name+'">Creation date</label>';
        switch(typeOfInput) {
            case 'text': 
                if (disabled) {
                    markup += '<input type="' + typeOfInput + '" class="form-control" id="' + name + '" name="' 
                    + name + '"  value="' + value + '" disabled="disabled">';
                } else {
                    markup += '<input type="' + typeOfInput + '" class="form-control" id="' + name + '" name="' 
                    + name + '"  value="' + value + '">';
                }
                break;
            case 'hidden': 
                markup += '<input type="' + typeOfInput + '" class="form-control" id="' + name + '" name="' 
                    + name + '"  value="' + value + '">';
                break;
            case 'textarea': 
                markup += '<textarea class="form-control" id="'+name+'" name="'+name+'">'+value+'</textarea>';    
                break;

        }
        markup += '</div>';
        return markup;
    }
    
    function addFieldsToFormForAddingChangesets() {
        var id = changesetForEditing ? changesetForEditing.id : '',
            creationDate = changesetForEditing ? changesetForEditing.creationDate : '',
            changeset = changesetForEditing ? changesetForEditing.changeset : '',
            jiraticket = changesetForEditing ? changesetForEditing.jiraticket : '',
            authorcomments = changesetForEditing ? changesetForEditing.authorcomments : '',
            reviewercomments = changesetForEditing ? changesetForEditing.reviewercomments : '',
            reviewerid = changesetForEditing ? changesetForEditing.reviewerid : '',
            authorid = changesetForEditing ? changesetForEditing.authorid : '',
            stateid = changesetForEditing ? changesetForEditing.stateid : '',
            formattedDate = changesetForEditing ? changesetForEditing.creationdate : getFormattedDate();
        var selectAuthors = createSelectWithData(authors, 'authorid', 'authorid', authorid);
        var selectReviewers = createSelectWithData(reviewers, 'reviewerid', 'reviewerid', reviewerid);
        var selectStates = createSelectWithData(states, 'stateid', 'stateid', stateid);
        var idInput = createInput({name: 'id', typeOfInput: 'hidden', value: id});
        var creationDateInput = createInput({name: 'creationdate', typeOfInput: 'text', value: formattedDate, disabled: 'disabled'});
        var changesetInput = createInput({name: 'changeset', typeOfInput: 'text', value: changeset});
        var jiraticketInput = createInput({name: 'jiraticket', typeOfInput: 'text', value: jiraticket});
        var authorcommentsInput = createInput({name: 'authorcomments', typeOfInput: 'textarea', value: authorcomments});
        var reviewercommentsInput = createInput({name: 'reviewercomments', typeOfInput: 'textarea', value: reviewercomments});
        var rowForAdding = '<div class="clearfix">'
            + idInput + creationDateInput + changesetInput + jiraticketInput + authorcommentsInput 
            + reviewercommentsInput + selectStates + selectReviewers + selectAuthors + '<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>\n\
            <button type="button" class="btn btn-danger removeChangeset"><span class="glyphicon glyphicon-minus"></span></button></div>';
        
        var rowForEditing = '<div class="clearfix">'
            + idInput + creationDateInput + changesetInput + jiraticketInput + authorcommentsInput 
            + reviewercommentsInput + selectStates + selectReviewers + selectAuthors + '<button type="submit" class="btn btn-warning edit-changeset"><span class="glyphicon glyphicon-check"></span></button></div>';
    
            if (changesetForEditing && changesetForEditing.id != '') {
                $('.row .panel-body').find('.form-inline').append(rowForEditing);
            } else {
                $('.row .panel-body').find('.form-inline').append(rowForAdding);
            }
    }

    function createSelectWithData(items, id, name, selected) {
        var selected = selected || 0;
        $select = '<div class="form-group"><label class="sr-only" for="'+id+'">Select</label><select class="form-control" id="' + id + '" name="'+name+'">';
            items.forEach(function(item) {
                if (item.id == selected) {
                    $select += '<option selected="selected" value='+item.id+'>'+item.name+'</option>';
                } else {
                    $select += '<option value='+item.id+'>'+item.name+'</option>';
                }
            });
        $select += '</select></div>';
        return $select
    }
    
    function getDataForPopUp(resourceId, cb) {
        $.ajax({
            type: "GET",
            url: resourceId,
        })
        .done(function(data) {
            if (cb) {
                cb(data);
            }
        });
    }
    
    function getDataForAllSelects(cb) {
        getDataForPopUp('/crapi/authors', function(data) {
            for(var i in data) {
                authors.push({id: i, name: data[i]});
            }
            getDataForPopUp('/crapi/reviewers', function(data) {
                for(var i in data) {
                    reviewers.push({id: i, name: data[i]});
                }
                getDataForPopUp('/crapi/states', function(data) {
                    for(var i in data) {
                        states.push({id: i, name: data[i]});
                    }
                    if (cb) {
                        cb();
                    }
                }, '');
            }, '');
        }, '');
    }

    function sendDataFromPopUpMain(data, obj, objToRemove) {
        var method = obj.method ? obj.method : 'POST',
            url = (method == 'POST') ? obj.url : obj.url + data.id;
        $.ajax({
            type: method,
            url: url,
            data: {data: JSON.stringify(data)}
        })
        .done(function(data) {
            if (data.result == 'error') {
                $(objToRemove).append('<div class="alert alert-dismissible alert-danger fade in" role="alert"><button class="close" data-dismiss="alert" type="button">x</button>Changeset wasn\'t added. Something horrible had happend...</div>');
            } else {
                $(objToRemove).replaceWith('<div class="clearfix"><div class="alert alert-success" role="alert">Changeset with id ' + data.result + ' was added</div></div>');
                setTimeout(function() {$('.add-changesets-popup-active .clearfix').remove()},1000);
            }
        });
    }
    
    if ($('.table.table-hover.table-striped')) {
        renderStatesForCodereviews();
    }
    
    function addFieldsToPopUp(event) {
        var quantityOfChangesets = parseInt($('#numberOfCasesToAdd').val(), 10);
        if (typeof(quantityOfChangesets) == 'number' && quantityOfChangesets > 1) {
            while (quantityOfChangesets--) {
                addFieldsToFormForAddingChangesets({});
            }
        } else {
            addFieldsToFormForAddingChangesets({});
        }
        event.preventDefault();
    }
    
    function addPopUp(event) {
        if (authors.length == 0) {
            var popup = new PopUp();
            getDataForAllSelects(madeAddButtonActive);
        } else {
            makePopUpActive();
        }
        event.preventDefault();
    }
    
    function removeRowFromPopUp() {
        $(this).parent('.clearfix').remove();
    }
    
    function madeAddButtonActive() {
        $('.add-changesets-popup-active .add-changeset-button').removeAttr('disabled');
    }
    
    function reloadDocumentOnClosePopUp() {
        $('.panel-default.add-changesets-popup-active').addClass('add-changesets-popup-non-active');
        $('.fadingWrapperInvisible').removeClass('fadingWrapper');
        location.reload();
    }
    
    function copyJiraTicketLinksAccrossTheForm() {
        var ticketValue = $('input[name="jiraticket"]').first().val();
        $('input[name="jiraticket"]').each(function(index, element) {
           if ($(element).val() == '') {
               $(element).val(ticketValue);
           }
        });
    }
    
    function processFieldsBeforeAddChangeset(event) {
       var data = {};
       var isAllRequiredFieldsFilled = true;
       var formElementsArray = $(this).parent().find('input, select, textarea');
       formElementsArray.each(function(index, element) {
           var elementName = $(element).attr('name');
           if ($(element).val() === '' && elementName != 'id' && elementName != 'authorcomments' && elementName != 'reviewercomments') {
                $(element).addClass('requiredField');
                isAllRequiredFieldsFilled = false;
           } else {
                data[$(element).attr('name')] = $(element).val();
           }
       });
       if (isAllRequiredFieldsFilled) {
            sendDataFromPopUpMain(data, {url: '/crapi', method: 'POST'}, $(this).parent('.clearfix'));
            event.preventDefault();
       } else {
           alert('Please fill in all fields');
           event.preventDefault();
       }
    }
    
    function removeRequiredFieldMarkerWhenIsFilledIn() {
       if ($(this).val != '') {
           $(this).removeClass('requiredField');
       }
    }
    
    function editChangeset(event) {
        var popup = new PopUp();
        var data = $(this).attr('href').split('/');
        data = data[data.length-1];
        getDataForPopUp('/crapi1/'+data, function(data) {
            changesetForEditing = data.result;
            getDataForAllSelects(addFieldsToFormForAddingChangesets);
        });
        $('.add-changesets-popup-active').find('#numberOfCasesToAdd, .add-changeset-button').remove();
        event.preventDefault();
    }
    
    function postEditChangeset(event) {
        var data = {};
        var isAllRequiredFieldsFilled = true;
        var formElementsArray = $(this).parent().find('input, select, textarea');
        formElementsArray.each(function(index, element) {
            var elementName = $(element).attr('name');
            if ($(element).val() === '' && elementName != 'authorcomments' && elementName != 'reviewercomments') {
                 $(element).addClass('requiredField');
                 isAllRequiredFieldsFilled = false;
            } else {
                 data[$(element).attr('name')] = $(element).val();
            }
        });
        if (isAllRequiredFieldsFilled) {
             sendDataFromPopUpMain(data, {url: '/crapi/', method: 'PUT'}, $(this).parent('.clearfix'));
             event.preventDefault();
        } else {
            alert('Please fill in all fields');
            event.preventDefault();
        }
    }
    
    $(document).on('click', '.add-changeset-button', addFieldsToPopUp);
    $('.pop-up-adding').bind('click', addPopUp);
    $(document).on('click', '.panel-heading .close', reloadDocumentOnClosePopUp);
    $(document).on('focusout', 'input[name="jiraticket"]', copyJiraTicketLinksAccrossTheForm);
    $(document).on('click', '.removeChangeset', removeRowFromPopUp);
    $(document).on('click', '.add-changesets-popup-active .form-inline  .btn-success', processFieldsBeforeAddChangeset);
    $(document).on('blur', '.add-changesets-popup-active .form-inline input, \n\
                            .add-changesets-popup-active .form-inline select, \n\
                            .add-changesets-popup-active .form-inline textarea', removeRequiredFieldMarkerWhenIsFilledIn);
    $('a.glyphicon-pencil').bind('click', editChangeset);
    $(document).on('click', '.edit-changeset', postEditChangeset);
    
    $( ".startdate" ).datepicker({
        defaultDate: "-1w",
        changeMonth: true,
        numberOfMonths: 3,
        dateFormat: "mm-dd-yy",
        onClose: function( selectedDate ) {
            $( ".enddate" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( ".enddate" ).datepicker({
        changeMonth: true,
        numberOfMonths: 3,
        showButtonPanel: true,
        dateFormat: "mm-dd-yy",
        onClose: function( selectedDate ) {
            $( ".startdate" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
    
})();
    
});

