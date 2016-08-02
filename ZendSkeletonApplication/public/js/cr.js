$(document).ready(function() {

var CR = CR || {}

CR = (function() {
    
//    $('.collapse.navbar-collapse li a').click(function(){
//        $(this).parent('li').addClass('active');
//    });
    
    var authors = [],
        reviewers = [],
        states = [],
        changesetForEditing,
        timeRef = [];
        
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
    $('body > .container .fadingWrapperInvisible').addClass('fadingWrapper').html('<div class="row"><div class="panel panel-default add-changesets-popup-active">\n\
                    <div class="panel-heading">Add changeset(s)<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div>\n\
                    <div class="panel-body"><div class="row"></div><form class="form-inline" role="form" method="POST"></form><input type="text" id="numberOfCasesToAdd" placeholder="5"><button type="button" class="btn btn-success add-changeset-button" disabled="disabled">\n\
                    <span class="glyphicon glyphicon-plus-sign"></span></button></div></div></div>');
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
            value = obj.value ? obj.value : "",
            disabled = obj.disabled ? 'disabled' : "";
            if (typeOfInput !== 'hidden') {
                markup = '<div class="form-group col-sm-1"><label for="'+name+'">Creation date</label>';
            } else {
                markup = '<div class="form-group col-sm-1">';
            }
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
        var selectAuthors = createSelectWithData(authors, 'authorid', 'authorid', authorid, 'Author');
        var selectReviewers = createSelectWithData(reviewers, 'reviewerid', 'reviewerid', reviewerid, 'Reviewer');
        var selectStates = createSelectWithData(states, 'stateid', 'stateid', stateid, 'State');
        var idInput = createInput({name: 'id', typeOfInput: 'hidden', value: id});
        var creationDateInput = createInput({name: 'creationdate', typeOfInput: 'text', value: formattedDate, disabled: 'disabled'});
        var changesetInput = createInput({name: 'changeset', typeOfInput: 'text', value: changeset});
        var jiraticketInput = createInput({name: 'jiraticket', typeOfInput: 'text', value: jiraticket});
        var authorcommentsInput = createInput({name: 'authorcomments', typeOfInput: 'textarea', value: authorcomments});
        var reviewercommentsInput = createInput({name: 'reviewercomments', typeOfInput: 'textarea', value: reviewercomments});
        var rowForAdding = '<div class="clearfix row">'
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

    function createSelectWithData(items, id, name, selected, label, className) {
        var selected = selected || 0,
            className = className ? className : 'col-sm-1';
        
        $select = '<div class="form-group ' + className + '"><label for="'+id+'">'+label+'</label><select class="form-control" id="' + id + '" name="'+name+'"><option value="">Select</option>';
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
        getDataForPopUp('/apiAuthors', function(data) {
            for(var i in data) {
                authors.push({id: i, name: data[i]});
            }
            getDataForPopUp('/apiAuthors', function(data) {
                for(var i in data) {
                    reviewers.push({id: i, name: data[i]});
                }
                getDataForPopUp('/apiStates', function(data) {
                    console.log(data);
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

    function sendDataFromPopUpMain(data, obj, objToRemove, cb) {
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
                if (typeof(cb) === 'function') {
                    cb();
                }
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
    
    function removeRequiredFieldMarkerWhenIsFilledIn() {
       if ($(this).val != '') {
           $(this).removeClass('requiredField');
       }
    }
    
    function editChangeset(event) {
        var popup = new PopUp();
        var data = $(this).attr('href').split('/');
        data = data[data.length-1];
        getDataForPopUp('/crapi/'+data, function(data) {
            changesetForEditing = data.result;
            getDataForAllSelects(addFieldsToFormForAddingChangesets);
        });
        $('.add-changesets-popup-active').find('#numberOfCasesToAdd, .add-changeset-button').remove();
        event.preventDefault();
    }
   
    function postEditChangeset(event) {
        var idIsMandatory = true;
        var currentMethod = 'PUT';
        if (event.target.className.indexOf('edit-changeset') == -1) {
            currentMethod = 'POST';
            idIsMandatory = false;
        };
        var data = {};
        var isAllRequiredFieldsFilled = true;
        var formElementsArray = $(this).parent().find('input, select, textarea');
        formElementsArray.each(function(index, element) {
            var elementName = $(element).attr('name');
            if (idIsMandatory) {
                if ($(element).val() == '' && elementName != 'authorcomments' && elementName != 'reviewercomments') {
                    console.log('yes');
                    $(element).addClass('requiredField');
                     isAllRequiredFieldsFilled = false;
                } else {
                    data[$(element).attr('name')] = $(element).val();
                }
            } else {
                 if ($(element).val() === '' && elementName != 'authorcomments' && elementName != 'reviewercomments' && elementName != 'id') {
                     $(element).addClass('requiredField');
                     isAllRequiredFieldsFilled = false;
                 } else {
                     data[$(element).attr('name')] = $(element).val();
                 }
            }
        });
        if (isAllRequiredFieldsFilled) {
             sendDataFromPopUpMain(data, {url: '/crapi/', method: currentMethod}, $(this).parent('.clearfix'));
             event.preventDefault();
        } else {
            alert('Please fill in all fields');
            event.preventDefault();
        }
    }
    
    function createRadioButton(value, name, className) {
        return '<div class="' + className + '"><label for="timereference">Time</label>' + name + '<input type="radio" checked="checked" value="'+ value + '" name=' + value + '></div>';
    }
    
    function addPopUpForAddingSchedule(event) {
        event.preventDefault();
        var popup = new PopUp();
        $('.fadingWrapper .panel-body').html($('#addOneScheduleForADay').html());
        getDataForPopUp('/apiAuthors', function(data) {
            for(var i in data) {
                authors.push({id: i, name: data[i]});
            }
            getDataForPopUp('/apiTimeRef', function(data) {
                for(var i in data[0]) {
                    timeRef.push({id: i, name: data[0][i]});
                }
                var reviewer = createSelectWithData(authors, 'Reviewer', 'Reviewer', 0, 'Reviewer');
                var traineeBackup = createSelectWithData(authors, 'traineebackupid', 'traineebackupid', 0, 'Trainee/backup');
                var replacement = createSelectWithData(authors, 'replacementreviewerid', 'replacementreviewerid', 0, 'Replacement');
                var original = createSelectWithData(authors, 'originalreviewerid', 'originalreviewerid', 0, 'Original');
                var designReviewer = createSelectWithData(authors, 'designreviewerid', 'designreviewerid', 0, 'Design');
                var designReviewerTrainee = createSelectWithData(authors, 'designtraineereviewerid', 'designtraineereviewerid', 0, 'Design Trainee', 'col-sm-2');
                var morning = createRadioButton(timeRef[0]['id'], timeRef[0]['name'], 'col-sm-2');
                var noon = createRadioButton(timeRef[1]['id'], timeRef[1]['name'], 'col-sm-2');
                var afternoon = createRadioButton(timeRef[2]['id'], timeRef[2]['name'], 'col-sm-2');
                $('.fadingWrapper .panel-body .form-control.col-sm-1.btn.btn-success').before('<div class="row">' + morning + reviewer + traineeBackup + replacement + original + designReviewer + designReviewerTrainee + '</div>');
                $('.fadingWrapper .panel-body .form-control.col-sm-1.btn.btn-success').before('<div class="row">' + noon + reviewer + traineeBackup + replacement + original + designReviewer + designReviewerTrainee + '</div>');
                $('.fadingWrapper .panel-body .form-control.col-sm-1.btn.btn-success').before('<div class="row">' + afternoon + reviewer + traineeBackup + replacement + original + designReviewer + designReviewerTrainee + '</div>');
            });
        });
    }
    
    function addSchedule(event) {
        event.preventDefault();
        var idIsMandatory = true;
        var currentMethod = 'POST';
        var data1 = {};
        var data2 = {};
        var data3 = {};
        var isAllRequiredFieldsFilled = true;
        var formElementsArray = $(this).parent().find('.row');
        var dateElement = $(this).parent().find('.startdate');
        if (dateElement.val() == '') {
            $(dateElement).addClass('requiredField');
            isAllRequiredFieldsFilled = false;
        }
        formElementsArray.each(function(index, elementmain) {
            var outerIndex = index;
            $(elementmain).find('input, select, textarea').each(function(index, element) {
                var elementName = $(element).attr('name');
                if ($(element).val() == '' && elementName != 'designreviewerid' && elementName != 'designtraineereviewerid') {
                    $(element).addClass('requiredField');
                     isAllRequiredFieldsFilled = false;
                } else {
                    switch(outerIndex) {
                        case 0:
                            if (elementName == '1') {
                                data1['timereference'] = $(element).val();
                            } else {
                                
                                data1[$(element).attr('name')] = $(element).val();
                            }
                            break;
                        case 1:
                            if (elementName == '2') {
                                data2['timereference'] = $(element).val();
                            } else {
                                
                                data2[$(element).attr('name')] = $(element).val();
                            }
                            break;
                        case 2:
                            if (elementName == '3') {
                                data3['timereference'] = $(element).val();
                            } else {
                                
                                data3[$(element).attr('name')] = $(element).val();
                            }
                            break;
                    }
                }
            });
        });
        if (isAllRequiredFieldsFilled) {
            data3['dateofschedule'] = $('.startdate ').val();
            data2['dateofschedule'] = $('.startdate ').val();
            data1['dateofschedule'] = $('.startdate ').val();
            sendDataFromPopUpMain(data1, {url: '/apiSchedule', method: currentMethod}, $(this).parent().find('.row'), function() {
                sendDataFromPopUpMain(data2, {url: '/apiSchedule', method: currentMethod}, $(this).parent().find('.row'), function() {
                    sendDataFromPopUpMain(data3, {url: '/apiSchedule', method: currentMethod}, $(this).parent().find('.row'), function() {
                        console.log('Shedule should be added');
                    });
                });
            });
            event.preventDefault();
        } else {
            alert('Please fill in all fields');
            event.preventDefault();
        }
    }
    
    function paintGrid() {
        var tableRows = $('table tr').length;
        while (tableRows) {
            
            tableRows -= 1;
        }
    }    
    
    $(document).on('click', '.add-changeset-button', addFieldsToPopUp);
    $('.pop-up-adding').bind('click', addPopUp);
    $(document).on('click', '.panel-heading .close', reloadDocumentOnClosePopUp);
    $(document).on('focusout', 'input[name="jiraticket"]', copyJiraTicketLinksAccrossTheForm);
    $(document).on('click', '.removeChangeset', removeRowFromPopUp);
    $(document).on('click', '.add-changesets-popup-active .form-inline .btn-success', postEditChangeset);
    $(document).on('blur', '.add-changesets-popup-active .form-inline input, \n\
                            .add-changesets-popup-active .form-inline select, \n\
                            .add-changesets-popup-active .form-inline textarea', removeRequiredFieldMarkerWhenIsFilledIn);
    $('.codereview a.glyphicon-pencil').bind('click', editChangeset);
    $('#addSchedule').bind('click', addPopUpForAddingSchedule);
    $(document).on('click', '.edit-changeset', postEditChangeset);
    $('.table .btn.btn-default').popover();
    $(document).on('click', '#postSchedule', addSchedule);
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
    $('body').on('focus',".startdate", function(e){
        e.stopImmediatePropagation();
        $(this).datepicker({
        changeMonth: true,
        numberOfMonths: 3,
        dateFormat: "mm-dd-yy",
        showButtonPanel: true,
        onClose: function( selectedDate ) {
            $( ".enddate" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    });
    
})();
    
});

