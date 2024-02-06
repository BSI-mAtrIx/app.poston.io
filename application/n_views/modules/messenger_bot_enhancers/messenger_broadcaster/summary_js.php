<?php
if($this->uri->segment(2)=="edit_quick_broadcast_campaign" || $this->uri->segment(2)=="edit_subscriber_broadcast_campaign") { ?>
    <script type="text/javascript">
        var xlabels = "<?php echo $xdata['label_ids'];?>";
        var xexcluded_label_ids = "<?php echo $xdata['excluded_label_ids'];?>";
    </script>
<?php }?>

<?php
$is_quick_broadcast = "0";
if($this->uri->segment(2)=="create_quick_broadcast_campaign" || $this->uri->segment(2)=="edit_quick_broadcast_campaign") $is_quick_broadcast = "1";
?>

<script type="text/javascript">
    var base_url="<?php echo base_url();?>";

    $("document").ready(function(){

        var today = new Date();
        $('.datepicker_x').datetimepicker({
            theme:'light',
            format:'Y-m-d H:i:s',
            formatDate:'Y-m-d H:i:s',
            minDate: today
        });


        $(document).on('click','.lead_first_name',function(){

            //var textAreaTxt = $(this).parent().next().next().next().children('.emojionearea-editor').html();
            var textAreaTxt = $(this).parent().parent().find('.emojionearea-editor').first().html();
            var lastIndex = textAreaTxt.lastIndexOf("<br>");

            if(lastIndex!='-1')
                textAreaTxt = textAreaTxt.substring(0, lastIndex);

            var txtToAdd = " {{first_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().parent().find('.emojionearea-editor').first().html(new_text);
            $(this).parent().parent().find('.emojionearea-editor').first().click();
        });

        $(document).on('click','.lead_last_name',function(){

            var textAreaTxt = $(this).parent().parent().find('.emojionearea-editor').first().html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");

            if(lastIndex!='-1')
                textAreaTxt = textAreaTxt.substring(0, lastIndex);

            var txtToAdd = " {{last_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().parent().find('.emojionearea-editor').first().html(new_text);
            $(this).parent().parent().find('.emojionearea-editor').first().click();

        });

        $(document).on('change','#page,#label_ids,#excluded_label_ids,#user_gender,#user_time_zone,#user_locale,#broadcast_type',function(){
            var page_id=$("#page").val();
            var user_gender=$("#user_gender").val();
            var user_time_zone=$("#user_time_zone").val();
            var user_locale=$("#user_locale").val();
            var label_ids=$("#label_ids").val();
            var excluded_label_ids=$("#excluded_label_ids").val();
            var broadcast_type=$("#broadcast_type").val();
            var is_bot_subscriber = '1';
            var is_quick_broadcast = '<?php echo $is_quick_broadcast;?>';

            if(typeof(broadcast_type)==='undefined') broadcast_type = "";
            if(typeof(label_ids)==='undefined') label_ids = "";
            if(typeof(excluded_label_ids)==='undefined') excluded_label_ids = "";

            var load_label='0';
            if($(this).attr('id')=='page') load_label='1';

            if(load_label=='1')
            {
                $("#dropdown_con").removeClass('hidden');
                $("#first_dropdown").html('<?php echo $this->lang->line("Loading labels..."); ?>');
                $("#second_dropdown").html('<?php echo $this->lang->line("Loading labels..."); ?>');
            }
            $("#page_subscriber").html('<i class="bx bx-loader-alt bx-spin"></i>');
            $("#targetted_subscriber").html('<i class="bx bx-loader-alt bx-spin"></i>');

            if(page_id=="")
            {
                $("#page_subscriber,#targetted_subscriber").html("0");
            }

            $("#submit_post").addClass('btn-progress');

		  var hidden_id = 0;
		  var requested_url = base_url+"home/get_broadcast_summary";
		  if(broadcast_type == 'Recurring') requested_url = base_url+"home/get_rcn_broadcast_summary";


            $.ajax({
                type:'POST' ,
			  url: requested_url,
			  data: {page_id:page_id,label_ids:label_ids,excluded_label_ids:excluded_label_ids,user_gender:user_gender,user_time_zone:user_time_zone,user_locale:user_locale,load_label:load_label,is_bot_subscriber:is_bot_subscriber,broadcast_type:broadcast_type,hidden_id:hidden_id},
                dataType : 'JSON',
                success:function(response){

                    if(load_label=='1')
                    {
                        $("#dropdown_con").removeClass('hidden');
                        $("#first_dropdown").html(response.first_dropdown);
                        $("#second_dropdown").html(response.second_dropdown);
                    }
			    $(".template_types").html(response.templates);
			    // $("#media_type").val(response.media_type);

                    $("#submit_post").removeClass("btn-progress");

                    var estimated_reach = response.pageinfo.estimated_reach;
                    if(estimated_reach=="") estimated_reach='0';
                    if(is_quick_broadcast=='1') $("#page_subscriber").html(estimated_reach);
                    else $("#page_subscriber").html(response.pageinfo.total_subscriber_count);

                    $("#targetted_subscriber").html(response.pageinfo.subscriber_count);

                    if(typeof(response.pageinfo.estimated_reach)!=='undefined')
                    {
                        $("#fb_page_id").val(response.pageinfo.page_id);
                        $(".push_postback").html(response.push_postback);
                    }

                    if(load_label=='1')
                    {
                        if (typeof(xlabels)!=='undefined' && xlabels!="")
                        {
                            var xlabels_array = xlabels.split(',');
                            $("#label_ids").val(xlabels_array).trigger('change');
                        }
                        if (typeof(xexcluded_label_ids)!=='undefined' && xexcluded_label_ids!="")
                        {
                            var xexcluded_array = xexcluded_label_ids.split(',');
                            $("#excluded_label_ids").val(xexcluded_array).trigger('change');
                        }
                    }

                    $(".waiting").hide();
                }

            });
        });


        $(document).on('select2:select','#label_ids',function(e){
            var label_id = e.params.data.id;
            var temp;

            var excluded_label_ids = $("#excluded_label_ids").val();
            for(var i=0;i<excluded_label_ids.length;i++)
            {
                if(parseInt(excluded_label_ids[i])==parseInt(label_id))
                {
                    temp = "#label_ids option[value='"+label_id+"']";
                    $(temp).prop("selected", false);
                    $("#label_ids").trigger('change');
                    return false;
                }
            }
        });


        $(document).on('select2:select','#excluded_label_ids',function(e){
            var label_id = e.params.data.id;
            var temp;

            var label_ids = $("#label_ids").val();
            for(var i=0;i<label_ids.length;i++)
            {
                if(parseInt(label_ids[i])==parseInt(label_id))
                {
                    temp = "#excluded_label_ids option[value='"+label_id+"']";
                    $(temp).prop("selected", false);
                    $("#excluded_label_ids").trigger('change');
                    return false;
                }
            }

        });

        $(document).on('change','#message_tag',function(){
            var message_tag = $(this).val();
            if(message_tag=="NON_PROMOTIONAL_SUBSCRIPTION")
            {
                var success_message="News messages allow news publishers to send regular news updates to their subscribers in Messenger. This feature is only available for registered news Pages under the <br><a target='_BLANK' href='https://www.facebook.com/help/publisher/316333835842972'>Facebook News Page Index (NPI)</a> <br><a target='_BLANK' href='https://developers.facebook.com/docs/messenger-platform/policy/policy-overview/#news_messaging'>Read Policy Details here</a>";
                var span = document.createElement("span");
                span.innerHTML = success_message;
                swal.fire({ title:'<?php echo $this->lang->line("READ ME"); ?>', html:span,icon:'info'});
            }
        });


    });

</script>

