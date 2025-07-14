jQuery.validator.addMethod("noSpace", function(value, element) { 
    return value.trim() !== "" && value.trim()[0] !== " "; 
}, "Spaces are not allowed");

$(document).ready(function() {
    $(document).ajaxStart(function() {
        $('.preloader').show(); 
    });

    $(document).ajaxStop(function() {
        $('.preloader').hide();
    });
    
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 2000);

    var scroll=$('.chat-box');
    scroll.animate({scrollTop: scroll.prop("scrollHeight")});

    
    

    var today = new Date();
    var yyyy = today.getFullYear();
    var mm = today.getMonth() + 1;
    var dd = today.getDate() - 1;

    // Format date as YYYY-MM-DD
    if (mm < 10) mm = '0' + mm; 
    if (dd < 10) dd = '0' + dd; 

    var maxDate = yyyy + '-' + mm + '-' + dd;
    $('#dob').attr('max', maxDate);

    const today1 = new Date().toISOString().split('T')[0];
    const dateInputs = document.getElementsByClassName('dateToInput');
    
    for (let i = 0; i < dateInputs.length; i++) {
        dateInputs[i].setAttribute('max', today1);
    }
});

/*** Questions management  */
$("input[name = 'Questioncategory']").on("click",function(){
    var cate = $(this).val();
    if(cate == "Optional"){
        $('#options').slideDown(500);
    }else{
        $('#options').slideUp(500);
    }
});

$(document).on('click', '.remove-option', function() {
    $(this).closest('.col-12').remove();
});

function addOption() {
    var lngth = $('input[name="opt[]"]').length + 1;
    var newOptionHTML = `
        <div class="col-12 col-md-6 mb-3">
            <div class="form-group">
                <label class="f-14">Option</label>
                <input type="text" name="opt[]" class="form-control">
                <div class="droppable" data-next-question-id=""></div> <!-- Add data-next-question-id attribute -->
                <div class="input-group-append">
                    <button type="button" class="remove-option">Remove</button>
                </div>
            </div>
        </div>
    `;
    $('.options').append(newOptionHTML);
    $('.options').children().last().find('.droppable').droppable({
        accept: ".draggable",
        drop: function(event, ui) {
            var questionText = ui.helper.find('.card-title').text();
            $(this).text(questionText);
            
    
            var nextQuestionId = ui.helper.data('next-question-id');
            
            var nextQuestionIds = $('#next_question_id').val().split(',');
            
            
            nextQuestionIds.push(nextQuestionId);
            
            $('#next_question_id').val(nextQuestionIds.join(','));
        }
    });
}

$(document).on('click', '#clear_filter', function(event) {
    event.preventDefault();
    
    const urlWithoutParams = window.location.href.split('?')[0];
    history.replaceState(null, null, urlWithoutParams);
    location.reload();
});

