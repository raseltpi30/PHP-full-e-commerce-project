$(document).ready(function(){
    // Js for Rating Data
    var rating_data = 0;
    $('#add_review').click(function(){
        $('#review_modal').modal('show');
    });
    $(document).on('click','.submit_star',function(){
       rating_data = $(this).data('rating');
        var rating = $(this).data('rating');
        for(var count=1; count <= rating; count++){
           $('#submit_star_'+count).addClass('text-warning');
         };
    });
    $(document).on('dblclick','.submit_star',function(){
        $('.submit_star').removeClass('text-warning');
        $('#submit_star_'+count).removeClass('text-warning');
    });
    $('#submit_review').click(function(){

        // var user_name = $('#user_name').val();
        var user_review = $('#user_review').val();
        // alert("val")
        if(rating_data == '' || user_review == ''){
            alert("Please Fill All field");
            return false;
        }
        else{
            $.ajax({
            url:"submit_rating.php",
            method:"POST",
            data:{
                rating_data:rating_data,
                user_review:user_review,   
            },
            success:function(data){
                $('#review_modal').modal('hide');
                alert(data);
            }
        })
    }
});
load_rating_data();
function load_rating_data(){
    $.ajax({
            url:"submit_rating.php",
            method:"POST",
            data:{action:'load_data'},
            dataType:"JSON",
            success:function(data){
                // Write Later
                $('#average_rating').text(data.average_rating);
                $('#top_rated').text(data.average_rating);
                $('#total_review').text(data.total_review);

                var count_star = 0;

                $('.main-star').each(function(){
                    count_star++;
                    if(Math.floor(data.average_rating) >= count_star){
                        $(this).addClass('text-warning');
                        $(this).addClass('star-light');
                    }
                });                    
                
            },

        })
    }
});