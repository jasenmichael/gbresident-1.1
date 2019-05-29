$( function() {
    // $( ".datepicker" ).datepicker({  stepMonths: 0,minDate: 0, maxDate: "+1M" });
    $( ".datepicker" ).datepicker( );
    
      $( ".datepicker" ).datepicker( "option", "showAnim", 'slideDown' );
	 // $("div#my-awesome-dropzone1").dropzone({ url: "/file/post" });
	  
	  Dropzone.options.dropzone = {
        accept: function(file, done) {
            console.log(file);
            if (file.type != "image/jpeg") {
                done("Error! Files of this type are not accepted");
            }
            else { done(); }
        }
    }
	
	Dropzone.options.myDrop = {
  maxFiles: 1,
  url: 'receipt-pdf-generator.php',
  maxFilesize: 30, //mb
  acceptedFiles: 'image/*, jpg, jpeg, png',
  addRemoveLinks: true,
  resizeWidth: 790,
  resizeHeight: 800,
  autoProcessQueue: false,// used for stopping auto processing uploads
  autoDiscover: false,
  paramName: 'prod_pic',
  previewsContainer: '#myDrop', //used for specifying the previews div
  clickable: '#myDrop', //used this but now i cannot click on previews div to showup the file select dialog box

  accept: function(file, done) {
    console.log("uploaded");
    done();
   //used for enabling the submit button if file exist 
    $( "#submitbtn" ).prop( "disabled", false );
  },

  init: function() {
    this.on("maxfilesexceeded", function(file){
        alert("No more files please!Only One image file accepted.");
        this.removeFile(file);
    });
      var myDropzone = this;
    $("#submitbtn").on('click',function(e) {
       e.preventDefault();
       myDropzone.processQueue();

    });

   this.on("reset", function (file) {   
		  //used for disabling the submit button if no file exist 
		  $( "#submitbtn" ).prop( "disabled", true );
	});
		
	//send all the form data along with the files:
	this.on("sending", function(data, xhr, formData) {
		formData.append("amount", jQuery("#amount").val());
		formData.append("name", jQuery("#name").val());
		var amount_option = jQuery(".amount_option:checked").val();
		formData.append("amount_option", amount_option);
		formData.append("description", jQuery("#description").val());
		formData.append("credit", jQuery("#credit").val());
		formData.append("donation", jQuery("#donation").val());
		formData.append("date", jQuery("#date").val());
		console.log('sendin');
	});
	
	this.on("success", function(file, responseText) {
		 //alert("HELLO ?" + responseText); 
		 console.log('done loading');
		 alert("Pdf Downloaded Successfully.");
		 window.location.href = 'receipt-form.php';
	   });

  }

};
	
	//$("div#myDrop").dropzone({ url: "/file/post" });
	
  } );
  
  $(document).on('click', '.amount_option', function() {
	 var value = $(this).val();
	 if (value == 3) {
		 $('#credit_donation_div').show('slow');
	 } else {
		 $('#credit_donation_div').hide('slow');
		 // $('#amount').val('');
	 }
  });
  
  $(document).on('keyup', '.amount_credit_donation', function () {
	  var credit = isNaN($('#credit').val())?0: $('#credit').val();
	  var donation = isNaN( $('#donation').val() ) ? 0: $('#donation').val();
	  
	  var total_amount = (parseFloat( credit )|| 0) + (parseFloat( donation ) || 0);
	  
	  $('#amount').val(total_amount.toFixed(2));
  });
  
   $(document).on('keyup', '#amount', function () {
	  var amount =  $(this).val();console.log(amount);
	  var maxAmount = 100;
	 if( parseFloat(amount) > maxAmount ) {
		 var donation = (parseFloat( amount )|| 0) - (parseFloat( maxAmount ) || 0);
		 $('#credit').val(maxAmount.toFixed(2));
		 $('#donation').val(donation.toFixed(2));
	 } else {
		 console.log(amount);
		 $('#credit').val(parseFloat(amount).toFixed(2));
		 $('#donation').val(0);
	 }
	  
	  
	 // $('#amount').val(total_amount);
  });
