<section class="section section_custom">
	<div class="section-header">
		<h1><i class="fas fa-x-ray"></i> <?php echo $this->lang->line("Email Phone Opt-in Form Builder"); ?></h1>
		<div class="section-header-button">
	     	<a class="btn btn-primary" href="<?= base_url('email_optin_form_builder/create_email_optin_form') ?>">
	        <i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('Create opt-in Form'); ?></a>
	    </div>

	    <div class="section-header-breadcrumb">
	      <div class="breadcrumb-item active"><a href="<?php echo base_url('subscriber_manager'); ?>"><?php echo $this->lang->line("Subscriber Manager"); ?></a></div>
	      <div class="breadcrumb-item"><?php echo $page_title; ?></div>
	    </div>
	</div>

	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body data-card">
						<div class="table-responsive">
							<table id="optin-datatable" class="table table-bordered" style="width:100%">
						        <thead>
						            <tr>
						                <th><?php echo $this->lang->line("ID"); ?></th>
						                <th><?php echo $this->lang->line("Name"); ?></th>
						                <th><?php echo $this->lang->line("Form Position"); ?></th>
						                <th><?php echo $this->lang->line("Pop-up Delay (sec)"); ?></th>
						                <th><?php echo $this->lang->line("Actions"); ?></th>
						                <th><?php echo $this->lang->line("Contact Groups"); ?></th>
						                <th><?php echo $this->lang->line("Created At"); ?></th>

						            </tr>
						        </thead>
						    </table>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" role="dialog" id="get_embed_modal" data-backdrop='static' data-keyboard='false'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bbw">
        <h5 class="modal-title text-primary"><i class="fas fa-code"></i> <?php echo $this->lang->line('Get embed code'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <div class="alert alert-light text-center mb-4" id="readMeText"></div>
              <pre class="language-javascript" ><code id="test" class="dlanguage-javascript description" ></code></pre>   
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> <?php echo $this->lang->line('Close'); ?></button>
      </button>
      </div>
    </div>
  </div>
</div>


<script>
	$(document.body).on('click', '.get_js_embed', function(event) {	
		event.preventDefault();

		var embed_id = $(this).attr('embed_id');
		var form_type = $(this).attr('form_type');

		$.ajax({
			url: '<?php echo base_url('email_optin_form_builder/embeded_js_code') ?>',
			type: 'POST',
			dataType:'JSON',
			data: {embed_id: embed_id,form_type:form_type},
			success: function(response) {
				if(response)
				{
					$(".description").text(response.str1);
					$("#get_embed_modal").modal();
					Prism.highlightAll($('#test')[0]);

					$("#mme").text(response.str2);
					$("#readMeText").text(response.read_me_text);
					$(".toolbar-item").find('a').addClass('copy');
				}
				else
				{
					swal('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Something went wrong"); ?>', 'error');
				}


			}

		});    

	});

	$(document).on("click", ".copy", function(event) {
	    event.preventDefault();

	    $(this).html('<?php echo $this->lang->line("Copied!"); ?>');
	    var that = $(this);
	    
	    var text = $(this).parent().parent().parent().find('code').text();
	    var $temp = $("<input>");
	    $("body").append($temp);
	    $temp.val(text).select();
	    document.execCommand("copy");
	    $temp.remove();

	    setTimeout(function(){
	      $(that).html('<?php echo $this->lang->line("Copy"); ?>');
	    }, 2000); 

	});


	$(document).ready(function() {

		var data_table = $('#optin-datatable').DataTable({

	      	processing: true,
	      	serverSide: true,
			order: [[ 0, "desc" ]],
			pageLength: 10,	        
	        ajax: {
	        	url: '<?= base_url('email_optin_form_builder/form_lists_data') ?>',
	        	type: 'POST',
	        	dataSrc: function (json) {

	                $(".table-responsive").niceScroll();
	                return json.data;
	            },
	        },

	        columns: [
			    {data: 'id'},
			    {data: 'form_name'},
			    {data: 'form_position'},
			    {data:'interval_time'},
			    {data: 'actions'},
			    {data:'contact_group'},
			    {data: 'inserted_at'},

			],

			language: {

        		url: "<?= base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
  			},

      		columnDefs: [
      			{
      			    targets: [0],
      			    visible: false
      			},

				{ "className": "text-center", "targets": [2,3,4,6] },
				{ "sortable": false, "targets": [1,2,4,6] },
			],

			dom: '<"top"f>rt<"bottom"lip><"clear">',

		})



		// Displays form details

		var table1 = '';
		var perscroll1;

		$(document).on('keyup', '#searching', function(event) {

		  event.preventDefault(); 
		  table1.draw();

		});

		// Attempts to delete form

		$(document).on('click', '#delete-optin-form', function(e) {
			e.preventDefault()

			// Grabs form ID
			var form_id = $(this).data('form-id')

			swal({

				title: '<?php echo $this->lang->line("Are you sure?"); ?>',
				text: '<?php echo $this->lang->line("Once deleted, you will not be able to recover this form!"); ?>',
				icon: 'warning',
				buttons: true,
				dangerMode: true,

			}).then((yes) => {

				if (yes) {

					$.ajax({

						type: 'POST',

						url: '<?= base_url('email_optin_form_builder/delete_form_data') ?>',

						dataType: 'JSON',

						data: { form_id },

						success: function(response) {

							if (response) {
								if (response.success === true) {

									// Reloads datatable
									data_table.ajax.reload()

									// Displays success message
									iziToast.success({title: '',message: response.message,position: 'bottomRight'});
								} else if (response.error === true) {
									// Displays error message
									iziToast.error({title: '',message: response.message,position: 'bottomRight'});
								}	
							}
						},
						error: function(xhr, status, error) {
							// Displays error message
							iziToast.error({title: '',message: error,position: 'bottomRight'});							
						}
					})
				} else {
					return
				}
			})
		});


		$('.modal').on("hidden.bs.modal", function (e) { 
		    if ($('.modal:visible').length) { 
		        $('body').addClass('modal-open');
		    }
		});
	})

</script>

