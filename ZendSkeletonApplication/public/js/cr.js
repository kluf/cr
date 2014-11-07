$(document).ready(function() {

var CR = CR || {}

CR = (function() {
    
//    $('.collapse.navbar-collapse li a').click(function(){
//        $(this).parent('li').addClass('active');
//    });
    
    var authors = [],
        reviewers = [],
        states = [];
        
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
    
    function createPopUpForAddingChangesets() {
//        if ($('body > .container .add-changesets-popup-active')) {
//            $('body > .container .add-changesets-popup-active').removeClass('add-changesets-popup-non-active');
//        } else {
            $('body > .container').append('<div class="row"><div class="col-md-12"><div class="panel panel-default add-changesets-popup-active">\n\
                        <div class="panel-heading">Add changeset(s)<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div>\n\
                        <div class="panel-body"><form class="form-inline" role="form"></form><input type="text" id="numberOfCasesToAdd" placeholder="5"><button type="button" class="btn btn-success add-changeset-button">\n\
                        <span class="glyphicon glyphicon-plus-sign"></span></button></div></div></div></div>');
//        }
    }
    
    function addFieldsToFormForAddingChangesets() {
        var form;
        var selectAuthors = createSelectWithData(authors, 'authorid');
        var selectReviewers = createSelectWithData(reviewers, 'reviewerid');
        var selectStates = createSelectWithData(states, 'stateid');
        $('.row .panel-body').find('.form-inline').append('<div class="clearfix"><div class="form-group">\n\
            <input type="hidden" class="form-control" id="id"></div>\n\
            <div class="form-group"><label class="sr-only" for="creationdate">Creation date</label>\n\
            <input type="text" class="form-control" id="creationdate" placeholder="Enter date"></div>\n\
            <div class="form-group"><label class="sr-only" for="changeset">Changeset</label>\n\
            <input type="text" class="form-control" id="changeset" placeholder="Changeset url"></div>\n\
            <div class="form-group"><label class="sr-only" for="jiraticket">JIRA ticket</label>\n\
            <input type="text" class="form-control jiraticket-popup" id="jiraticket" placeholder="JIRA ticket"></div>\n\
            <div class="form-group"><label class="sr-only" for="authorcomments">Author\'s comments</label>\n\
            <textarea class="form-control" id="authorcomments" placeholder="Author\'s comments"></textarea></div>\n\
            <div class="form-group"><label class="sr-only" for="reviewercomments">Reviewer\'s comments</label>\n\
            <textarea type="text" class="form-control" id="reviewercomments" placeholder="Reviewer\'s comments"></textarea></div>'
            + selectStates + selectReviewers + selectAuthors +
            '<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></div>');
    }

    function createSelectWithData(items, id) {
        $select = '<div class="form-group"><label class="sr-only" for="'+id+'">Select</label><select class="form-control" id=' + id + '>';
            items.forEach(function(item) {
                $select += '<option value='+item.id+'>'+item.name+'</option>';
            });
        $select += '</select></div>';
        return $select
    }
    
    function getDataForSelect(resourceId, cb) {
        $.ajax({
        type: "GET",
        url: "/crapi/" + resourceId,
        })
        .done(function(data) {
            cb(data);
        });
    }
    
    function getDataForAllSelects(cb) {
        getDataForSelect('authors', function(data) {
            for(var i in data) {
                authors.push({id: i, name: data[i]});
            }
            getDataForSelect('reviewers', function(data) {
                for(var i in data) {
                    reviewers.push({id: i, name: data[i]});
                }
                getDataForSelect('states', function(data) {
                    for(var i in data) {
                        states.push({id: i, name: data[i]});
                    }
                    cb();
                });
            });
        });
        
    }
    
    function sendDataFromPopUp(){
        $.ajax({
        type: "POST",
        url: "/crapi/" + resourceId,
        })
        .done(function(data) {
            cb(data);
        });
    }

    if ($('.table.table-hover.table-striped')) {
        renderStatesForCodereviews();
    }
    
    $(document).on('click', '.add-changeset-button', function(event) {
        var quantityOfChangesets = parseInt($('#numberOfCasesToAdd').val(), 10);
        if (typeof(quantityOfChangesets) == 'number' && quantityOfChangesets > 1) {
            while (quantityOfChangesets--) {
                addFieldsToFormForAddingChangesets();
            }
        } else {
            addFieldsToFormForAddingChangesets();
        }
        event.preventDefault();
    });
    
    $('.pop-up-adding').bind('click', function(event) {
        if (authors.length == 0) {
            getDataForAllSelects(createPopUpForAddingChangesets);
        } else {
            createPopUpForAddingChangesets();
        }
        event.preventDefault();
    });
    
    $(document).on('click', '.close', function(event) {
        $('.panel-default.add-changesets-popup-active').addClass('add-changesets-popup-non-active');
        $('body').removeClass('body-background');
    });
    
    $(document).on('focusout', '.jiraticket-popup', function(event) {
        var ticketValue = $('.jiraticket-popup').first().val();
        $('.jiraticket-popup').val(ticketValue);
    });
    
    $(document).on('click', '.add-changesets-popup-active .form-inline  .btn-success', function(event) {
       $('.add-changesets-popup-active .form-inline .btn-success').parent('.clearfix').remove();
       var data;
       var formElementsArray = $(this).parent().find('input, select, textarea');
       formElementsArray.each(function(index, element) {
           data += $(element).attr('id')+ '=' +$(element).val();
       });
       JSON.stringify(data);
       console.log(data);
//       sendDataFromPopUp(data);
       event.preventDefault(); 
    });
    
})();
    
});

