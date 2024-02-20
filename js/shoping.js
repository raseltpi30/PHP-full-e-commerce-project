$(document).ready(function () {
    $('.increment-btn').click(function (e) {
        e.preventDefault();
        var incre_value = $(this).parents('.quantity').find('.qty-input').val();
        var value = parseInt(incre_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value<5){
            value++;
            $(this).parents('.quantity').find('.qty-input').val(value);            
        }
    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var decre_value = $(this).parents('.quantity').find('.qty-input').val();
        var value = parseInt(decre_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value>1){
            value--;
            $(this).parents('.quantity').find('.qty-input').val(value);
        }
    });
});
$(document).ready(function(){
    $('.changeQuantity').click(function(){
        // product_id = $(this).val('#product_id');
        
        var quantity = $(this).closest('.cartpage').find('.qty-input').val();
        console.log(quantity);
        var product_id = $(this).closest('.cartpage').find('.product_id').val();
        var price = $(this).closest(".cartpage").find('.iprice').val();

        var data = {
            'quantity' : quantity,
            'product_id' : product_id,
        };
        gt=0;
        var iprice = document.getElementsByClassName('iprice');
        var iquantity = document.getElementsByClassName('qty-input');
        var itotal = document.getElementsByClassName('a');
        var gtotal = document.getElementById('gtotal')

        function subTotal(){
            gt=0;
            for(i=0;i<iprice.length;i++){
                itotal[i].innerText=(iprice[i].value)*(iquantity[i].value);
                gt=gt+(iprice[i].value)*(iquantity[i].value);
            }
            gtotal.innerText=gt;
        }
        subTotal();
        $.ajax({
            url:"submit.php",
            method:"POST",
            data:data,
            success:function(data){
            }
        })
    })
});