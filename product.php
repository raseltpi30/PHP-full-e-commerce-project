<?php  
require_once('../config.php');
get_header();
$user_id = $_SESSION['admin']['id'];


if(isset($_POST['add_sale'])){
    $product_id = $_POST['product_id'];
    $manufacture_name = $_POST['manufacture_name'];
    $group_name = $_POST['group_name'];
    $price = $_POST['price'];
    $mprice = $_POST['mprice'];
    $quantity = $_POST['quantity'];
    $expire = $_POST['expire'];

    // $slugCount = GetColumnCount('categories','category_slug',$category_slug);

    if(empty($group_name)){
        $error = "Group Name is Required!";
    }
    elseif(empty($price)){
        $error = "Price is Required!";
    }
    elseif(!is_numeric($price)){
        $error = "Price Must be Number!";
    }
    elseif(empty($mprice)){
        $error = "Manufacture Price is Required!";
    }
    elseif(!is_numeric($mprice)){
        $error = "Manufacture Price Must be Number!";
    }
    elseif(empty($quantity)){
        $error = "Quantity is Required!";
    }
    elseif(!is_numeric($quantity)){
        $error = "Quantity Must be Number!";
    }
    elseif(empty($expire)){
        $error = "Expire Date is Required!";
    }
    else{
        $total_price = $price * $quantity;
        $total_mprice = $mprice * $quantity;
        $created_at = date('Y-m-d H:i:s');

        $stm = $connection->prepare("INSERT INTO groups(user_id,product_id,group_name,price,manufacture_price,quantity,total_price,total_mprice,expire_date,created_at) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $cat=$stm->execute(array($user_id,$product_id,$group_name,$price,$mprice,$quantity,$total_price,$total_mprice,$expire,$created_at));

        $stm = $connection->prepare("INSERT INTO purchases(user_id,product_id,manufacture_id,group_name,price,manufacture_price,quantity,total_price,total_mprice,expire_date,created_at) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $cat=$stm->execute(array($user_id,$product_id,$manufacture_id,$group_name,$price,$mprice,$quantity,$total_price,$total_mprice,$expire,$created_at));

        $success = "Purchases Add Successfully!";
        unset($_POST);
    }

}

?>



<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Change Password</a></li>
        </ol>
    </div>
</div>
            <!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h3>Add New Product</h3>

                    <?php if(isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($success)) : ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                        <!-- <script>
                            setTimeout(function(){
                                window.location.href="index.php"
                            },1000);
                        </script> -->
                    <?php endif; ?>
                    <hr>

                    <div id="ajaxError" style="display:none;" class="alert alert-danger"></div> 

                    <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                            <label for="customer_name">Customer Name *</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control input-default" placeholder="Customer Name" value="<?php value('customer_name');?>">
                        </div>
                        <div class="form-group mt-4">
                            <label for="product_id">Select Product *</label>
                            <select name="product_id" id="product_id" class="form-control">
                                <?php  
                                $products = GetTableData('products');
                                foreach($products as $products) :
                                ?>
                                <option value="<?php echo $products['id']  ?>"><?php echo $products['product_name'] ?></option>
                                <?php  endforeach; ?>
                            </select>
                        </div>                       
                        <div class="form-group mt-4">
                            <label for="manufacture_name">Manufacture Name *</label>
                            <input type="text" name="manufacture_name" id="manufacture_name" class="form-control input-default" readonly>
                        </div>                       
                        <div class="form-group">
                            <label for="group_name">Group Name *</label>
                                <select name="group_name" id="group_name" class="form-control">
                                    
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Expire Date *</label>
                            <input type="text" name="expire" id="expire" class="form-control input-default" readonly>
                        </div>
                        <div class="form-group">
                            <label for="price">Price *</label>
                            <input type="text" name="price" id="price" class="form-control input-default" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mprice">Manufacture Price *</label>
                            <input type="text" name="mprice" id="mprice" class="form-control input-default" readonly>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity *</label>
                            <input type="text" name="quantity" id="quantity" class="form-control input-default" placeholder="Quantity" value="<?php value('quantity');?>">
                        </div>
                        <div class="form-group">
                            <label for="total_price">Total Price *</label>
                            <input type="text" name="total_price" id="total_price" class="form-control input-default" placeholder="Total Price" readonly>
                        </div>
                        <div class="form-group">
                            <label for="total_mprice">Total Manufacture Price *</label>
                            <input type="text" name="total_mprice" id="total_mprice" class="form-control input-default" placeholder="Total Manufacture Price" readonly>
                        </div>
                        <div class="form-group">
                            <label for="discount_type">Discount Type *</label>
                            <select name="discount_type" id="discount_type" class="form-control">
                                <option value="none">None</option>
                                <option value="fixed">Fixed</option>
                                <option value="perchentage">Perchentage</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discount_amount">Discount Amount *</label>
                            <input type="text" name="discount_amount" id="discount_amount" class="form-control input-default">
                        </div>
                        <div class="form-group">
                            <label for="sub_total">Sub Total *</label>
                            <input type="text" name="sub_total" id="sub_total" class="form-control input-default">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="add_sale" Value="Create sale">
                        </div>
                    </form>
                </div>
            </div>  
        </div>
        
    </div>
</div>


<?php get_footer(); ?>

<script>

    //product Data
    $('#product_id').on('change',function(){
        let product_id = $(this).val();

        // console.log(product_id);

        $.ajax({
            type:"POST",
            url:'ajax.php',
            data:{
                product_id:product_id,
            },
            success: function(response){
                let producResult = JSON.parse(response);
                console.log(producResult);


                if(producResult.count ==0){                    
                    // alert(producResult.message);
                    $('#ajaxError').show().text(producResult.message);
                    $('#manufacture_name').val(''); 
                    $('#group_name').val(''); 

                }
                else{
                    $('#ajaxError').hide();
                    $('#manufacture_name').val(producResult.manufacture_name); 


                    // Groups 
                    $('#group_name').empty();
                    let groups = producResult.groups;
                    $('#group_name').append('<option value="#">Select Group</option>');
                    $.each(groups,function(i,item){
                        $('<option value="'+groups[i].id+'" >').html(
                            '<span>'+groups[i].group_name+'</span>'
                        ).appendTo('#group_name');
                    });
                }
            },
        });
    });


    // Get group data

    $('#group_name').on('change',function(){
        let group_id = $(this).val();
        $.ajax({

            type: "POST",
            url: "ajax.php",
            data:{
                group_id:group_id
            },
            success:function(response){
                let groupResult = JSON.parse(response);
                console.log(groupResult);
                $('#expire').val(groupResult.expire_date);
                $('#price').val(groupResult.price);
                $('#mprice').val(groupResult.manufacture_price);
            },

        });
    });

    // calculate quantity 
    $('#quantity').on('keyup',function(){

        let price = $('#price').val();
        let quantity = $(this).val();
        let mprice = $('#mprice').val();


        if(price.length == 0){
            $('#ajaxError').show().text("Please First select Product Or Group");
        }
        else if(!jQuery.isNumeric(quantity)){
            $('#ajaxError').show().text("Quantity Must be Number");
        }
        else{
            $('#ajaxError').hide();

            let total_price = price*quantity;
            let total_mprice = mprice*quantity;

            $('#total_price').val(total_price);
            $('#total_mprice').val(total_mprice);

        }
    });

    $('#discount_amount').on('keyup',function(){
        let type = $('#discount_type').val();
        let discount_amount = $(this).val();

        if(type=="fixed"){
            if(!jQuery.isNumeric(discount_amount)){
                $('#ajaxError').show().text("Discount Amount Must be Number");
            }
            else{
                let total_p = $('#total_price').val();
                let sub_total = total_p-discount_amount;
                $('#sub_total').val(sub_total);
            }
        }
        else if(type=="perchentage"){
            
        }
    })
</script>