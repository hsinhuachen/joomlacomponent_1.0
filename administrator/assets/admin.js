jQuery(function($){
	var showText = "刪除後就無法復原, 確定要刪除?";
	var confirmText = "是否要將此圖片從伺服器上刪除?\n按確定刪除\n按取消保留圖片"
	
	$(document).on('click', '.delImgBtn', function (event) {
		var file = $(this).attr('href');
		var name = $(this).attr('data-name');
		var parentId = $(this).attr('data-id');
		var type = $(this).attr('data-type');

		if(confirm(showText)){
			$('#' + name).attr('value','empty');
			$(this).parents(".controls").find(".uploadButton").html("選擇圖片");

			if(confirm(confirmText)){
				var delImg = "yes";
			}else{
				var delImg = "no";
			}

			$('#' + parentId).fadeTo(300,0, function(){
				$(this).html('');

				if(delImg == "yes"){
					$.post("index.php?option=com_onion_project&task=delimg",{
						file: file
					}, function(txt){
						//alert(txt);
					});
				}
			});
		}
		
		return false;		
	});
	
	if($("#galleryList").length > 0){
		$("#galleryList").on('click', '.delImgBtn2', function(event) {
			event.preventDefault();
			
			var file = $(this).attr("href");
			var id = $(this).attr("delid");

			if(confirm(showText)){
				if(confirm(confirmText)){
					var delImg = "yes";
				}else{
					var delImg = "no";
				}

				$(this).parents(".gallery-img").fadeTo(600,0, function(){
					$(this).remove();

					if(delImg == "yes"){
						$.post("index.php?option=com_onion_project&task=delimg",{
							file: file
						}, function(txt){
							//alert(txt);
						});
					}
				});
			}

		});
	
		if($.fn.sortable){
			var total = $("#galleryList").find('.gallery-img').size();
			$("#galleryList").sortable({
				revert: true,
				cursor: "move",
				placeholder: "placeholder",
				handle: "img",
				stop: function(event, ui) {
				}
			});
		}	
	}
});

function previewPhoto(input,name,target){
	//alert('change');
	//document.getElementById(name).value=input.value;
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			if(input.files[0].size > 1048576){
				alert("圖片大小請小於1M");
			}else{
				jQuery('#' + target).html('<img class="previewImg" /><a href="#" data-id="' + target + '" data-name="' + name + '" class="delImgBtn icon-32-cancel">Delete Image</a>');
				jQuery('#' + target).find('img.previewImg').attr('src',e.target.result);
				jQuery('#' + target).fadeTo(0,1);

				jQuery('#' + target).parents(".controls").find(".uploadButton").html("更換圖片");
			}
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function multiplePhoto(input){
	var maxCount = input.files.length;
	for (var i = 0; i < input.files.length; i++) {
		var file = input.files[i];

		//Only pics
		if (!file.type.match('image')) continue;
		
		var reader = new FileReader();
		var j = 0;
		reader.onload = function (e) {
			var picFile = e.target;
			var prevHtml = "<div id='insert" + j + "' class='gallery-img insertImg'>" + 
			"<img class='previewImg' src='" + picFile.result + "' />" + 
			"<input type='hidden' name='photoName[]' value='" + input.files[j].name + "' />" + 
			"<textarea name='photoDesc[]' placeholder='圖說' class='middle'></textarea>" + 
			"<a href='#' class='delImgBtn2 icon-32-cancel'></a><div class='clr'></div></div>";

			if(jQuery('#galleryList').find('.gallery-img').length > 0){
				jQuery('#galleryList').find('.gallery-img:eq(0)').before(prevHtml);
			}else{
				jQuery('#galleryList').append(prevHtml);
			}
			maxCount--;
			j++;
		}

		reader.readAsDataURL(file);
	}
}

function previewPDF(input,name,target){
	jQuery('.uploadfile').addClass('hidden');
	jQuery('#' + target).html('<img class="previewPDF" /><a href="#" data-id="' + target + '" data-name="' + name + '" class="delImgBtn">Delete PDF</a><div class="clear"></div>');
	jQuery('#' + target).find('img.previewPDF').attr('src',"components/com_onion_project/assets/pdf.png");
	jQuery('#' + target).fadeTo(0,1);
}


