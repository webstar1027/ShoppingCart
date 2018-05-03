$(document).ready(function(){
 /**
  *  Add product to cart.
  *
  *  @param {product_id}
  *  @param {quantity}  
  */
	$('.add-cart').on('click', function(event) {		 
		var product_id = event.target.id;	
		var quantity = $("input[name=quantity"+product_id+"]").val();		

		if (quantity == '') {
		 	alert('Quantity can not be empty.');
		} else {
		 	window.location.href = "add_cart.php?id="+product_id+"&quantity="+quantity;
		}		
	});

 /**
  *  Give rating each product. 
  *  Show modal dialog for rating.
  *
  *  @param {product_id}  
  */
	$('span').on('click', function() {
		var starss = $('.stars li').parent().children('li.star');			  
		responseMessage('');

		$(starss[0]).removeClass('selected');
		$(starss[1]).removeClass('selected');
		$(starss[2]).removeClass('selected');
		$(starss[3]).removeClass('selected');
		$(starss[4]).removeClass('selected');

		var product_id = $(this).attr('id');		

		$('#rating_product_id').val(product_id);
		$('#myModal').modal('show');
	});
 	
 /**
  *  Mouse hover event on rating dialog 
  */
  $('.stars li').on('mouseover', function(){			
		var onStar = parseInt($(this).data('value'), 10);

		$(this).parent().children('li.star').each(function(e) {
		  if (e < onStar) {
				$(this).addClass('hover');
		  } else {
				$(this).removeClass('hover');
		  }
		});
	}).on('mouseout', function(){
			$(this).parent().children('li.star').each(function(e) {
			  $(this).removeClass('hover');
			});
	});


 /**
  *  Get rating value on rating dialog, call ajax for passing rating value to backend.
  *
  *  @return message ( from ajax call )
  */
  $('.stars li').on('click', function(){
		var onStar = parseInt($(this).data('value'), 10);
		var stars = $(this).parent().children('li.star');
		
		for (i = 0; i < 5; i++) {
		  $(stars[i]).removeClass('selected');
		}
		
		for (i = 0; i < onStar; i++) {
		  $(stars[i]).addClass('selected');
		}
		
		var ratingValue = parseInt($('.stars li.selected').last().data('value'), 10);
		var product_id = $(this).closest(".stars").find("input[name='rating_product_id']").val();			
		var msg = "";			

    $.ajax({
      url: "add_rate.php",
      type: 'POST',
      data: 'rating=' + ratingValue + '&product_id=' + product_id,
      dataType: "json",
      context: this,
      success: function (data) {					  
				if (status === 1)	{
					responseMessage(data.message);
				} else {
					responseMessage(data.message);
				}
			},
      error: function (request) {
        alert("Your request is incorrect!");       
      }
    });    
	});
  
 /**  
  *  Display response message for giving rating.
  *  
  *  @param {message}  
  */
	function responseMessage(message){
		$('.success-box').fadeIn(200);
		$('.success-box div.text-message').html("<strong>" + message + "</strong>");
	}

 /**  
  *  Create payment.
  *  
  *  @param {payment price}  
  */
  $(document).on('click', '#payment', function() {
  	var shipprice = $('#ship_type option:selected').val();
  	var total_price = $('input[name=total_price]').val();

  	if (shipprice == '') {
  		alert("You should select shipping type!.");
  	} else {
  		if (total_price == undefined) {
  			alert('You did not add product to your cart');
  		} else {
  			window.location.href = "payments.php?total_price="+ (parseFloat(total_price) + parseFloat(shipprice));	
  		}  		
  	}

  	console.log(total_price);
  });
});