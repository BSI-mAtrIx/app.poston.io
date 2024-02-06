<style>
    h2.title {
        color: #6777ef;
    }
</style>

<script>
    fetch('<?php echo base_url('google_api/get_user_pages_ext');?>')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            appendData(data);
        })
        .catch(function (err) {
            console.log('error: ' + err);
        });

    function appendData(data) {

        for (i = 0; i < data.length; i++) {
            $('#pageList').append("<option value='" + data[i].page_id + "'>" + data[i].page_name + " (" + data[i].page_id + ")</option>");
        }
    }


</script>


<script> // Copy
    document.getElementById("copyButton_Sub").addEventListener("click", function () {
        copyToClipboard(document.getElementById("copyTarget_Sub"));
    });

    function copyToClipboard(elem) {
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch (e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }
</script>

<style> body {
        background: #e9e9e9;
    }

    .blockquote {
        font-family: unset;
        font-style: inherit;
    } </style>

<script>
    $(document).ready(function () {
        $('form#spComment').submit(function () {
            $.ajax({
                data: $(this).serialize(),
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                success: function (data) {
                    if (data['error'] == false) {
                        var msg = 'We got your flag. Our moderators will now look into it. You may close the window now!';
                        alert(msg);
                    } else {
                        alert(data);
                    }
                },
                error: function (data) {
                    var r = jQuery.parseJSON(data.responseText);
                    alert("Message: " + r.Message);
                    alert("StackTrace: " + r.StackTrace);
                    alert("ExceptionType: " + r.ExceptionType);
                }
            });
            return false;
        });
    });

    function ext_get_user_pages_ajax(user_id_raw) {
        return new Promise((resolve, reject) => {
            var domain = CurrentSiteUrl + "google/get_user_pages_ext";
            $.ajax({
                type: "POST",
                url: domain,
                timeout: 5000,
                data: {
                    user_id: user_id_raw,
                },
                success: function (result) {
                    var UserPages = JSON.parse(result);
                    console.log(UserPages);
                    resolve(UserPages);
                },
                error: function (errorThrown) {
                    swal.fire("<?php echo $this->lang->line("Failed To Get User Pages!"); ?>", "<?php echo $this->lang->line('Please try again...'); ?>", "error");
                }
            });
        })
    };

</script>
