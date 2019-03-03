

		$('.js-show').on('click',function (e) {
            e.preventDefault();
            $('#filter').show();
        });
		$('.gfield_list_cell input').attr('disabled','disabled');
        $("#delete-button").on('click',function(e){
            //e.preventDefault();
            if(confirm("Are you sure you want to delete this?")){
            	$(this).form.submit();
                //$("#delete-button").attr("href", "query.php?ACTION=delete&ID='1'");
            }
            else{
                return false;
            }
        });
