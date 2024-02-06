 "use strict";
 $(document).ready(function() {

	$(document).on('click', '#search_hashtag', function(event) {
		event.preventDefault();

		var account_name = $("#account_name").val();
		var hash_tag = $("#hash_tag").val();

		if(account_name == "") {
			swal.fire(global_lang_warning, instagram_hash_tag_select_account, 'warning');
			return false;
		}

		if(hash_tag == "") {
			swal.fire(global_lang_warning, instagram_hash_tag_provide_hash_tag, 'warning');
			return false;
		}

		$("#hashtag_search_result").html("");

		$(this).addClass('btn-progress disabled')

		$("#preloader").html('<img width="30%" class="center-block text-center" src="'+base_url+'assets/pre-loader/loading-animations.gif" alt="Processing...">');

		$.ajax({
			context:this,
			url: base_url+'instagram_reply/hashtag_search_result',
			type: 'POST',
			data: {account_name: account_name,hash_tag: hash_tag},
			success:function(response){
				$(this).removeClass('btn-progress disabled')
				$("#preloader").html("");
				var data = response;
				data = data.replaceAll('fas fa-code', 'bx bx-code');
				data = data.replaceAll('fas fa-edit', 'bx bx-edit');
				data = data.replaceAll('fa fa-edit', 'bx bx-edit');
				data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
				data = data.replaceAll('far fa-copy', 'bx bx-copy');
				data = data.replaceAll('fa fa-trash', 'bx bx-trash');
				data = data.replaceAll('fas fa-trash', 'bx bx-trash');
				data = data.replaceAll('fa fa-eye', 'bx bxs-show');
				data = data.replaceAll('fas fa-eye', 'bx bxs-show');
				data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
				data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
				data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
				data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
				data = data.replaceAll('fas fa-file-export', 'bx bx-export');
				data = data.replaceAll('fa fa-comment', 'bx bx-comment');
				data = data.replaceAll('fa fa-user', 'bx bx-user');
				data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
				data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
				data = data.replaceAll('fas fa-comments', 'bx bx-comment');
				data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
				data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
				data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
				data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
				data = data.replaceAll('fas fa-key', 'bx bx-key');
				data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
				data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
				data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
				data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
				data = data.replaceAll('fa fa-send', 'bx bx-send');
				data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
				data = data.replaceAll('fa fa-code', 'bx bx-code');
				data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
				data = data.replaceAll('fas fa-pause', 'bx bx-pause');
				data = data.replaceAll('fa fa-cog', 'bx bx-cog');
				data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
				data = data.replaceAll('fas fa-comment', 'bx bx-comment');
				data = data.replaceAll('swal(', 'swal.fire(');
				data = data.replaceAll('rounded-circle', 'rounded-circle');
				data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
				data = data.replaceAll('fas fa-plug', 'bx bx-plug');
				data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
				data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
				data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
				data = data.replaceAll('padding-10', 'p-10');
				data = data.replaceAll('padding-left-10', 'pl-10');
				data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
				data = data.replaceAll('data-toggle=\'tooltip\'', 'data-toggle=\'tooltip\' data-placement=\'bottom\'');
				data = data.replaceAll('fas fa-heart', 'bx bx-heart');
				data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
				data = data.replaceAll('fas fa-city', 'bx bxs-city');
				data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
				data = data.replaceAll('fas fa-at', 'bx bx-at');
				data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
				data = data.replaceAll('article-image','card-img-top img-fluid');
				data = data.replaceAll('white','');
				data = data.replaceAll('h2','h4');
				data = data.replaceAll('mb-0','mb-2');



				$("#hashtag_search_result").html(data);
			}
		})
		


	});
});