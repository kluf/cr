$(document).ready(function() {

var CR = CR || {}

CR = (function() {
    
//    $('.collapse.navbar-collapse li a').click(function(){
//        $(this).parent('li').addClass('active');
//    });
    $('.table .btn.btn-default').popover();
    
    
    renderStatesForCodereviews = function() {
        $('tr').find('.state').each(function(index) {
            paintStates($(this), $(this).text());
        });
    }
    
    paintStates = function(row, state) {
        switch (state) {
            case 'not ok':
                return row.wrapInner("<div class='alert alert-danger smaller_states'></div>");
                break;
            case 'looking':
                return row.wrapInner("<div class='alert alert-warning smaller_states'></div>");
                break;
            case 'good':
                return row.wrapInner("<div class='alert alert-success smaller_states'></div>");
                break;
            default:
                return row.wrapInner("<div class='alert alert-info smaller_states'></div>");
                break;
        }
    }
    
    if ($('.table.table-hover.table-striped')) {
        renderStatesForCodereviews();
    }
    
})();
    
});

