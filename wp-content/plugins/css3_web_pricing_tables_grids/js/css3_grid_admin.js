jQuery(document).ready(function($){
	$("#css3_grid_configuration_tabs").tabs();
	$("#css3_grid_settings")[0].reset();
	$(".css3_grid_less, .css3_grid_more").click(function(event){
		event.preventDefault();
		var element = $(this).prev();
		if($(this).hasClass("css3_grid_less"))
			element.val((parseInt($(this).prev().val())-1>0 ? parseInt($(this).prev().val())-1 : ($(this).hasClass("css3_grid_to_zero") ? 0 : 1))).trigger("change");
		else
		{
			element = element.prev();
			element.val(parseInt($(this).prev().prev().val())+1).trigger("change");
		}
	});
	$("#kind").change(function(){
		if($(this).val()=="1")
		{
			$("#styleForTable2, #hoverTypeForTable2").css("display", "none");
			$("#styleForTable1, #hoverTypeForTable1").css("display", "inline");
		}
		else if($(this).val()=="2")
		{
			$("#styleForTable1, #hoverTypeForTable1").css("display", "none");
			$("#styleForTable2, #hoverTypeForTable2").css("display", "inline");
		}
		$(".css3_hover_type_row").css("display", ($(this).val()=="1" && $("#slidingColumns").val()=="1" ? "none" : "table-row"));
		$(".css3_active_column_label, .css3_active_column_select, .css3_active_column_br").css("display", ($(this).val()=="1" && $("#slidingColumns").val()=="1" ? "none" : "inline"));
	});
	$("#hiddenRows").change(function(){
		if(parseInt($(this).val())==0)
			$(".css3_hidden_rows_row").css("display", "none");
		else
			$(".css3_hidden_rows_row").css("display", "table-row");
	});
	$("#responsive").change(function(){
		$(".responsiveStepsRow, .responsiveStepRow, .responsiveButtonWidthRow, .responsiveHeaderFontSizeRow, .responsivePriceFontSizeRow, .responsivePermonthFontSizeRow, .responsiveContentFontSizeRow, .responsiveButtonsFontSizeRow, .responsiveHideCaptionColumnRow").css("display", ($(this).val()=="1" ? "table-row" : "none"));
		$(".css3_responsive_width, .css3_responsive_height").css("display", ($(this).val()=="1" ? "inline" : "none"));
	});
	$("#responsiveSteps").change(function(){
		var previousResponsiveSteps = $(".responsiveStepRow").length;
		var responsiveSteps = $(this).val();
		//responsiveSteps
		for(i=responsiveSteps; i<previousResponsiveSteps; i++)
		{
			$("#tab-responsive .responsiveStepRow"+(i*1+1)).remove();
			$("#tab-responsive .responsiveButtonWidthRow"+(i*1+1)).remove();
			$("#tab-fonts .responsiveHeaderFontSizeRow"+(i*1+1)).remove();
			$("#tab-fonts .responsivePriceFontSizeRow"+(i*1+1)).remove();
			$("#tab-fonts .responsivePermonthFontSizeRow"+(i*1+1)).remove();
			$("#tab-fonts .responsiveContentFontSizeRow"+(i*1+1)).remove();
			$("#tab-fonts .responsiveButtonsFontSizeRow"+(i*1+1)).remove();
			$(".css3_responsive_width"+(i*1+1)).remove();
			$(".css3_responsive_height"+(i*1+1)).remove();
		}
		
		var rowHtml = '';
		rowHtml += '<tr valign="top" class="responsiveStepRow responsiveStepRow[number]" style="display: table-row;">';
		rowHtml += '	<th scope="row">';
		rowHtml += '		<label>' + config.translation.screenWidth + ' [number]</label>';
		rowHtml += '	</th>';
		rowHtml += '	<td>';
		rowHtml += '	<input type="text" class="regular-text" value="" name="responsiveStepWidth[]">';
		rowHtml += '	</td>';
		rowHtml += '</tr>';
		
		var buttonWidthRowHtml = '';
		buttonWidthRowHtml += '<tr valign="top" class="responsiveButtonWidthRow responsiveButtonWidthRow[number]" style="display: table-row;">';
		buttonWidthRowHtml += '		<th scope="row">';
		buttonWidthRowHtml += '			<label>' + config.translation.responsiveButtonWidth + ' [number]</label>';
		buttonWidthRowHtml += '		</th>';
		buttonWidthRowHtml += '		<td>';
		buttonWidthRowHtml += '			<input type="text" class="regular-text" value="" name="responsiveButtonWidth[]">';
		buttonWidthRowHtml += '		</td>';
		buttonWidthRowHtml += '</tr>';
		
		var fontSizeRowHtml = '';
		fontSizeRowHtml += '<tr valign="top" class="responsive[type]FontSizeRow responsive[type]FontSizeRow[number]" style="display: table-row;">';
		fontSizeRowHtml += '	<th scope="row">';
		fontSizeRowHtml += '		<label>' + config.translation.responsiveFontSize + ' [number] ' + config.translation.inPx + '</label>';
		fontSizeRowHtml += '	</th>';
		fontSizeRowHtml += '	<td>';
		fontSizeRowHtml += '		<input type="text" class="regular-text" value="" name="responsive[type]FontSize[]">';
		fontSizeRowHtml += '	</td>';
		fontSizeRowHtml += '</tr>';
		
		var widthHtml = '<br class="css3_responsive_width css3_responsive_width[number]" style="display: inline;"><label class="css3_responsive_width css3_responsive_width[number]" style="display: inline;">' + config.translation.responsiveWidth + ' [number] ' + config.translation.optional + '</label>';
		widthHtml += '<input class="css3_responsive_width css3_responsive_width[number]" type="text" name="responsiveWidths[]" value="" style="display: inline;" />';
		var heightHtml = '<br class="css3_responsive_height css3_responsive_height[number]" style="display: inline;"><input class="css3_grid_short css3_responsive_height css3_responsive_height[number]" type="text" name="responsiveHeights[]" value="" style="display: inline;" />';
		heightHtml += '<label class="css3_responsive_height css3_responsive_height[number]" style="display: inline;">' + config.translation.responsiveHeight + ' [number] ' + config.translation.optional + '</label>';
		
		for(i=previousResponsiveSteps; i<responsiveSteps; i++)
		{
			$("#tab-responsive .responsiveStepRow:last").after($(rowHtml.replace(/\[number\]/g, (i+1))));
			$("#tab-responsive .responsiveButtonWidthRow:last").after($(buttonWidthRowHtml.replace(/\[number\]/g, (i+1))));
			$("#tab-fonts .responsiveHeaderFontSizeRow:last").after($(fontSizeRowHtml.replace(/\[number\]/g, (i+1)).replace(/\[type\]/g, 'Header')));
			$("#tab-fonts .responsivePriceFontSizeRow:last").after($(fontSizeRowHtml.replace(/\[number\]/g, (i+1)).replace(/\[type\]/g, 'Price')));
			$("#tab-fonts .responsivePermonthFontSizeRow:last").after($(fontSizeRowHtml.replace(/\[number\]/g, (i+1)).replace(/\[type\]/g, 'Permonth')));
			$("#tab-fonts .responsiveContentFontSizeRow:last").after($(fontSizeRowHtml.replace(/\[number\]/g, (i+1)).replace(/\[type\]/g, 'Content')));
			$("#tab-fonts .responsiveButtonsFontSizeRow:last").after($(fontSizeRowHtml.replace(/\[number\]/g, (i+1)).replace(/\[type\]/g, 'Buttons')));
			$(".css3_responsive_width_container").append($(widthHtml.replace(/\[number\]/g, (i+1))));
			$(".css3_responsive_height_container").append($(heightHtml.replace(/\[number\]/g, (i+1))));
		}
	});
	$("#slidingColumns").change(function(){
		$(".css3_sliding_row").css("display", ($(this).val()=="1" ? "table-row" : "none"));
		$(".css3_hover_type_row").css("display", ($(this).val()=="1" && $("#kind").val()=="1" ? "none" : "table-row"));
		$(".css3_active_column_label, .css3_active_column_select, .css3_active_column_br").css("display", ($(this).val()=="1" && $("#kind").val()=="1" ? "none" : "inline"));
		if($(this).val()=="0")
			$("#slidingNavigation").val("0");
		$("#slidingNavigation").trigger("change");
	});
	$("#slidingNavigation").change(function(){
		$(".css3_sliding_navigation_row").css("display", ($(this).val()=="1" ? "table-row" : "none"));
		if($(this).val()=="0")
		{
			$("#slidingNavigationArrows").val("0");
			$("#slidingPagination").val("0");
		}
		$("#slidingNavigationArrows").trigger("change");
		$("#slidingPagination").trigger("change");
	});
	$("#slidingNavigationArrows").change(function(){
		$(".css3_sliding_arrows_row").css("display", ($(this).val()=="1" ? "table-row" : "none"));
	});
	$("#slidingPagination").change(function(){
		$(".css3_sliding_pagination_row").css("display", ($(this).val()=="1" ? "table-row" : "none"));
	});
	$("[name='inset']").live("change", function(){
		var textField = $(this).prev().prev();
		if(parseInt($(this).val())==-1)
			textField.val("");
		else if($(this).val()=="caption")
			textField.val("<h2 class='caption'>choose <span>your</span> plan</h2>");
		else if($(this).val()=="header_title")
			textField.val("<h2 class='col1'>sample title</h2>");
		else if($(this).val()=="price")
			textField.val("<h1 class='col1'>$<span>10</span></h1><h3 class='col1'>per month</h3>");
		else if($(this).val()=="button")
			textField.val('<a href="' + config.siteUrl + '?plan=sample_param" class="sign_up radius3">sign up!</a>');
		else if($(this).val()=="button_orange")
			textField.val('<a href="' + config.siteUrl + '?plan=sample_param" class="sign_up sign_up_orange radius3">sign up!</a>');
		else if($(this).val()=="button_yellow")
			textField.val('<a href="' + config.siteUrl + '?plan=sample_param" class="sign_up sign_up_yellow radius3">sign up!</a>');
		else if($(this).val()=="button_lightgreen")
			textField.val('<a href="' + config.siteUrl + '?plan=sample_param" class="sign_up sign_up_lightgreen radius3">sign up!</a>');
		else if($(this).val()=="button_green")
			textField.val('<a href="' + config.siteUrl + '?plan=sample_param" class="sign_up sign_up_green radius3">sign up!</a>');
		else if($(this).val()=="caption2")
			textField.val("<h1 class='caption'>Hosting <span>Plans</span></h1>");
		else if($(this).val()=="header_title2")
			textField.val("<h2>sample title</h2>");
		else if($(this).val()=="price2")
			textField.val("<h1>$3.95</h1><h3>per month</h3>");
		else if($(this).val()=="button1")
			textField.val('<a class="button_1 radius5" href="' + config.siteUrl + '?plan=sample_param">sign up</a>');
		else if($(this).val()=="button2")
			textField.val('<a class="button_2 radius5" href="' + config.siteUrl + '?plan=sample_param">sign up</a>');
		else if($(this).val()=="button3")
			textField.val('<a class="button_3 radius5" href="' + config.siteUrl + '?plan=sample_param">sign up</a>');
		else if($(this).val()=="button4")
			textField.val('<a class="button_4 radius5" href="' + config.siteUrl + '?plan=sample_param">sign up</a>');
		else if($(this).val().substr(0,4)=="tick" || $(this).val().substr(0,5)=="cross")
			textField.val("<img src='" + config.imgUrl + $(this).val() + ".png' alt='" + ($(this).val().substr(0,4)=="tick" ? "yes":"no") + "' />")
		else if($(this).val().substr(0,3)=="yes" || $(this).val().substr(0,2)=="no")
			textField.val('<span class="css3_grid_icon icon_' + $(this).val() + '"></span>');
	});
	$("#editShortcodeId").change(function(){
		if($(this).val()!="-1")
		{
			var id = $("#editShortcodeId :selected").text();
			$("#shortcodeId").val(id).trigger("paste");
			$("#ajax_loader").css("display", "inline");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					dataType: 'html',
					data: {
						action: 'css3_grid_get_settings',
						id: id
					},
					success: function(json){
						json = $.trim(json);
						var indexStart = json.indexOf("css3_start")+10;
						var indexEnd = json.indexOf("css3_end")-indexStart;
						json = $.parseJSON(json.substr(indexStart, indexEnd));
						$("#columns").val(json.columns).trigger("change");
						$("#rows").val(json.rows).trigger("change");
						$("#responsiveSteps").val(json.responsiveSteps).trigger("change");
						$.each(json, function(key, val){
							if(key!="columns" && key!="rows" && key!="responsiveSteps")
							{
								if(val!=null)
								{
									if(key=="responsiveStepWidth")
									{
										$("[name='responsiveStepWidth[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsiveButtonWidth")
									{
										$("[name='responsiveButtonWidth[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsiveHeaderFontSize")
									{
										$("[name='responsiveHeaderFontSize[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsivePriceFontSize")
									{
										$("[name='responsivePriceFontSize[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsivePermonthFontSize")
									{
										$("[name='responsivePermonthFontSize[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsiveContentFontSize")
									{
										$("[name='responsiveContentFontSize[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsiveButtonsFontSize")
									{
										$("[name='responsiveButtonsFontSize[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="widths")
									{
										$("[name='widths[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsiveWidths")
									{
										$("[name='responsiveWidths[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="aligments")
									{
										$("[name='aligments[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="actives")
									{
										$("[name='actives[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="hiddens")
									{
										$("[name='hiddens[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="ribbons")
									{
										$("[name='ribbons[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="heights")
									{
										$("[name='heights[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="responsiveHeights")
									{
										$("[name='responsiveHeights[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="paddingsTop")
									{
										$("[name='paddingsTop[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="paddingsBottom")
									{
										$("[name='paddingsBottom[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="texts")
									{
										$("[name='texts[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="tooltips")
									{
										$("[name='tooltips[]']").each(function(index){
											$(this).val(val[index]);
										});
									}
									else if(key=="headerFontSubset")
									{
										if(val!=null)
											$("[name='headerFontSubset[]']").each(function(index){
												$(this).val(val[index]);
											});
										$("#headerFont").trigger("change", [val]);
									}
									else if(key=="priceFontSubset")
									{
										if(val!=null)
											$("[name='priceFontSubset[]']").each(function(index){
												$(this).val(val[index]);
											});
										$("#priceFont").trigger("change", [val]);
									}
									else
										$("#" + key).val(val);
								}
							}
						});
						$("#kind").trigger("change");
						$("#responsive").trigger("change");
						$("#hiddenRows").trigger("change");
						$("#slidingColumns").trigger("change");
						$("#preview").trigger("click");
						$("#ajax_loader").css("display", "none");
						$("#deleteButton").css("display", "inline");
					}
			});
		}
		else
		{
			$("#css3_grid_settings")[0].reset();
			$("#deleteButton").css("display", "none");
		}
	});
	$("#deleteButton").click(function(){
		var id = $("#editShortcodeId").val();
		$("#deleteButton").css("display", "none");
		$("#ajax_loader").css("display", "inline");
		$.ajax({
					url: ajaxurl,
					type: 'post',
					dataType: 'html',
					data: {
						action: 'css3_grid_delete',
						id: id
					},
					success: function(data){
						data = $.trim(data);
						var indexStart = data.indexOf("css3_start")+10;
						var indexEnd = data.indexOf("css3_end")-indexStart;
						data = data.substr(indexStart, indexEnd);
						if(parseInt(data)==1)
						{
							$("#editShortcodeId [value='" + id + "']").remove();
							$("#css3_grid_settings")[0].reset();
							$("#columns").trigger("change");
							$("#rows").trigger("change");
							$("#hiddenRows").trigger("change");
							$("#kind").trigger("change");
							$("#responsive").trigger("change");
							$("#slidingColumns").trigger("change");
							$("#preview").trigger("click");
							$("#ajax_loader").css("display", "none");
						}
					}
		});
	});
	function css3GridSetWidth(id)
	{
		$("#"+id).css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width() + "px");
		$("#css3_grid_" + id + "_slider_container, .css3_grid_" + id + "_pagination").css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width() + (2*$("#css3_grid_" + id + "_slider_container .css3_grid_arrow_area").outerWidth()) + "px");				
		$("#"+id+" .css3_grid_caroufredsel_wrapper").css("height", ($("#"+id+" .caption_column").length ? $("#"+id+" .caption_column").height() : $("#"+id+" [class^='column_']:first").height()) + "px");
		$(".p_table_1 .css3_grid_hidden_rows_control_"+id).css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width()-2 + "px");
		$(".p_table_2 .css3_grid_hidden_rows_control_"+id).css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width() + "px");
	};
	$("#preview").click(function(event){
		$("#ajax_loader_save_1,#ajax_loader_save_2").css("display", "inline");
		var data = $("#css3_grid_settings input[type='text'], #css3_grid_settings textarea, #css3_grid_settings select").serialize();
		$("#css3_grid_data_hidden").val(data);
		$("#css3_grid_action_hidden").val("css3_grid_preview");
		var data_serialized = $("#css3_grid_settings_hidden").serialize();
		$.ajax({
				url: ajaxurl,
				type: 'post',
				data: data_serialized,
				success: function(data){
					data = $.trim(data);
					var indexStart = data.indexOf("css3_start")+10;
					var indexEnd = data.indexOf("css3_end")-indexStart;
					data = data.substr(indexStart, indexEnd);
					$("#previewContainer").html(data);
					var items = 1, autoplay = 0, effect = 'scroll', easing = 'swing', duration = 500, id;
					$(".css3_grid_slider").each(function(){
						var self = $(this);
						var elementClasses = $(this).attr('class').split(' ');
						for(var i=0; i<elementClasses.length; i++)
						{
							if(elementClasses[i].indexOf('id-')!=-1)
								id = elementClasses[i].replace('id-', '');
							if(elementClasses[i].indexOf('autoplay-')!=-1)
								autoplay = elementClasses[i].replace('autoplay-', '');
							if(elementClasses[i].indexOf('items-')!=-1)
								items = elementClasses[i].replace('items-', '');
							if(elementClasses[i].indexOf('scroll-')!=-1)
								scroll = elementClasses[i].replace('scroll-', '');
							if(elementClasses[i].indexOf('effect-')!=-1)
								effect = elementClasses[i].replace('effect-', '');
							if(elementClasses[i].indexOf('easing-')!=-1)
								easing = elementClasses[i].replace('easing-', '');
							if(elementClasses[i].indexOf('duration-')!=-1)
								duration = elementClasses[i].replace('duration-', '');
							if(elementClasses[i].indexOf('threshold-')!=-1)
								threshold = elementClasses[i].replace('threshold-', '');
						}
						var carouselOptions = {
							circular:  (self.hasClass('circular') ? true : false),
							infinite:  (self.hasClass('infinite') ? true : false),
							items: parseInt(items),
							prev: {
								items: parseInt(scroll),
								button: $('#css3_grid_' + id + '_prev'),
								fx: effect,
								easing: easing,
								duration: parseInt(duration)
							},
							next: {
								items: parseInt(scroll),
								button: $('#css3_grid_' + id + '_next'),
								fx: effect,
								easing: easing,
								duration: parseInt(duration)
							},
							auto: {
								items: parseInt(scroll),
								play: (parseInt(autoplay) ? true : false),
								fx: effect,
								easing: easing,
								duration: parseInt(duration)
							}
						};
						if(self.hasClass('ontouch') || self.hasClass('onmouse'))
							carouselOptions.swipe = {
								items: parseInt(scroll),
								onTouch: (self.hasClass('ontouch') ? true : false),
								onMouse: (self.hasClass('onmouse') ? true : false),
								options: {
									allowPageScroll: "none",
									threshold: parseInt(threshold)
								},
								fx: effect,
								easing: easing,
								duration: parseInt(duration)
							};
						if(self.hasClass('slidingPagination'))
							carouselOptions.pagination = {
								items: parseInt(scroll),
								container: $(".css3_grid_" + id + "_pagination"),
								fx: effect,
								easing: easing,
								duration: parseInt(duration)
							};
						$(".css3_grid_slider").carouFredSel(carouselOptions, {
							wrapper: {
								classname: 'css3_grid_caroufredsel_wrapper'
							}
						});
						css3GridSetWidth(id);
						$(window).resize(function(){
							if($("#"+id).hasClass("p_table_sliding"))
								css3GridSetWidth(id);
							$(".css3_grid_slider").trigger('configuration', ['debug', false, true]);
						});
					});
					$(".css3_grid_hidden_rows_control").click(function(event){
						event.preventDefault();
						var self = $(this);
						self.parent().find(".css3_grid_hidden_row").toggleClass("css3_grid_hide");
						$(this).children(".css3_grid_hidden_rows_control_expand_text").toggleClass("css3_grid_hide");
						$(this).children(".css3_grid_hidden_rows_control_collapse_text").toggleClass("css3_grid_hide");
						if(self.parent().hasClass("p_table_sliding"))
						{
							var time = 250;
							var animationInterval = setInterval(function(){
								time--;
								css3GridSetWidth(self.parent().attr("id"));
								if(time==0)
									clearInterval(animationInterval);
							}, 1);
						}
					});
					$("#ajax_loader_save_1,#ajax_loader_save_2").css("display", "none");
				}
		});
	});
	$("#columns, #rows").bind("keyup change", function(event){
		var previousColumns = $("#textsTable thead tr th").length;
		var previousRows = $("#textsTable tbody tr").length;
		var columns = parseInt($("#columns").val())+1;
		var rows = parseInt($("#rows").val());
		var html = "";
		var shortcodesSelect = "";
		var i;
		shortcodesSelect += "<br />";
		shortcodesSelect += "	<select name='inset'>";
		shortcodesSelect += "		<option value='-1'>" + config.translation.chooseShortcode + "</option>";
		shortcodesSelect += "		<optgroup label='" + config.translation.table + " 1'>";
		shortcodesSelect += "			<option value='caption'>" + config.translation.caption + "</option>";
		shortcodesSelect += "			<option value='header_title'>" + config.translation.headerTitle + "</option>";
		shortcodesSelect += "			<option value='price'>" + config.translation.price + "</option>";
		shortcodesSelect += "			<option value='button'>" + config.translation.button + "</option>";
		shortcodesSelect += "			<option value='button_orange'>" + config.translation.buttonOrange + "</option>";
		shortcodesSelect += "			<option value='button_yellow'>" + config.translation.buttonYellow + "</option>";
		shortcodesSelect += "			<option value='button_lightgreen'>" + config.translation.buttonLightgreen + "</option>";
		shortcodesSelect += "			<option value='button_green'>" + config.translation.buttonGreen + "</option>";
		shortcodesSelect += "		</optgroup>";
		shortcodesSelect += "		<optgroup label='" + config.translation.table + " 2'>";
		shortcodesSelect += "			<option value='caption2'>" + config.translation.caption + "</option>";
		shortcodesSelect += "			<option value='header_title2'>" + config.translation.headerTitle + "</option>";
		shortcodesSelect += "			<option value='price2'>" + config.translation.price + "</option>";
		shortcodesSelect += "			<option value='button1'>" + config.translation.buttonStyle + " 1</option>";
		shortcodesSelect += "			<option value='button2'>" + config.translation.buttonStyle + " 2</option>";
		shortcodesSelect += "			<option value='button3'>" + config.translation.buttonStyle + " 3</option>";
		shortcodesSelect += "			<option value='button4'>" + config.translation.buttonStyle + " 4</option>";
		shortcodesSelect += "		</optgroup>";
		shortcodesSelect += "		<optgroup label='" + config.translation.yesIcons + "'>";
		for(i=0; i<10; i++)
			shortcodesSelect += "		<option value='yes_" + (i<9 ? "0" : "") + (i+1) + "'>" + config.translation.style + " " + (i+1) + "</option>";
		for(i=0; i<21; i++)
			shortcodesSelect += "		<option value='tick_" + (i<9 ? "0" : "") + (i+1) + "'>" + config.translation.style + " " + (i+1) + " " + config.translation.old + "</option>";
		shortcodesSelect += "		</optgroup>";
		shortcodesSelect += "		<optgroup label='" + config.translation.noIcons + "'>";
		for(i=0; i<10; i++)
			shortcodesSelect += "		<option value='no_" + (i<9 ? "0" : "") + (i+1) + "'>" + config.translation.style + " " + (i+1) + "</option>";
		for(i=0; i<21; i++)
			shortcodesSelect += "		<option value='cross_" + (i<9 ? "0" : "") + (i+1) + "'>" + config.translation.style + " " + (i+1) + " " + config.translation.old + "</option>";
		shortcodesSelect += "		</optgroup>";
		shortcodesSelect += "	</select>";
		shortcodesSelect += "	<span class='css3_grid_tooltip css3_grid_admin_info'>";
		shortcodesSelect += "		<span>";
		shortcodesSelect += "		<div class='css3_grid_tooltip_column'>";
		shortcodesSelect += "			<strong>" + config.translation.yesIcons + "</strong>";
		for(i=0; i<10; i++)
			shortcodesSelect += "		<div class='p_table_1'><span class='css3_grid_icon icon_yes_" + (i<9 ? "0" : "") + (i+1) + "'></span></div><label>&nbsp;" + config.translation.style + " " + (i+1) + "</label><br />";
		shortcodesSelect += "		</div>";
		shortcodesSelect += "		<div class='css3_grid_tooltip_column'>";
		shortcodesSelect += "			<strong>" + config.translation.yesIconsOld + "</strong>";
		for(i=0; i<11; i++)
			shortcodesSelect += "		<img src='" + config.imgUrl + "tick_" + (i<9 ? "0" : "") + (i+1) + ".png' /><label>&nbsp;" + config.translation.style + " " + (i+1) + "</label><br />";
		shortcodesSelect += "		</div>";
		shortcodesSelect += "		<div class='css3_grid_tooltip_column'>";
		shortcodesSelect += "			<strong>" + config.translation.yesIconsOld + "</strong>";
		for(i=11; i<21; i++)
			shortcodesSelect += "		<img src='" + config.imgUrl + "tick_" + (i+1) + ".png' /><label>&nbsp;" + config.translation.style + " " + (i+1) + "</label><br />";
		shortcodesSelect += "		</div>";
		shortcodesSelect += "		<div class='css3_grid_tooltip_column'>";
		shortcodesSelect += "			<strong>" + config.translation.noIcons + "</strong>";
		for(i=0; i<10; i++)
			shortcodesSelect += "		<div class='p_table_1'><span class='css3_grid_icon icon_no_" + (i<9 ? "0" : "") + (i+1) + "'></span></div><label>&nbsp;" + config.translation.style + " " + (i+1) + "</label><br />";
		shortcodesSelect += "		</div>";
		shortcodesSelect += "		<div class='css3_grid_tooltip_column'>";
		shortcodesSelect += "			<strong>" + config.translation.noIconsOld + "</strong>";
		for(i=0; i<11; i++)
			shortcodesSelect += "		<img src='" + config.imgUrl + "cross_" + (i<9 ? "0" : "") + (i+1) + ".png' /><label>&nbsp;" + config.translation.style + " " + (i+1) + "</label><br />";
		shortcodesSelect += "		</div>";
		shortcodesSelect += "		<div class='css3_grid_tooltip_column'>";
		shortcodesSelect += "			<strong>" + config.translation.noIconsOld + "</strong>";
		for(i=11; i<21; i++)
			shortcodesSelect += "		<img src='" + config.imgUrl + "cross_" + (i+1) + ".png' /><label>&nbsp;" + config.translation.style + " " + (i+1) + "</label><br />";
		shortcodesSelect += "		</div>";
		shortcodesSelect += "	</span>";
		shortcodesSelect += "	</span>";
		shortcodesSelect += "	<br />";
		shortcodesSelect += "	<label>" + config.translation.tooltip + "</label><input class='css3_grid_tooltip_input' type='text' name='tooltips[]' value='' />";
		if(columns>0 && rows>0 && columns<200 && rows<200)
		{
			i=0;
			if($(event.target).attr("id")=="rows")
			{
				//rows
				for(i=rows; i<previousRows; i++)
					$("#textsTable tbody .css3_grid_admin_row"+(i+1)).remove();
				if(rows>previousRows)
				{
					var rowHtml = "";
					rowHtml += "<tr>";
					for(var j=0; j<columns; j++)
					{
						rowHtml += "<td class='css3_grid_admin_column"+(j+1)+"'>";
						if(j==0)
						{
							//responsive heights
							var responsiveSteps = parseInt($("#responsiveSteps").val());
							var responsiveHeightHtml = '<div class="css3_responsive_height_container">';
							for(k=0; k<responsiveSteps; k++)
							{
								responsiveHeightHtml += (k>0 ? '<br class="css3_responsive_height css3_responsive_height' + (k+1) + '"' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + '>' : '') + '<input class="css3_grid_short css3_responsive_height css3_responsive_height' + (k+1) + '" type="text" name="responsiveHeights[]" value=""' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + ' />';
								responsiveHeightHtml += '<label class="css3_responsive_height css3_responsive_height' + (k+1) + '"' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + '>' + config.translation.responsiveHeight + ' ' + (k+1) + ' ' + config.translation.optional + '</label>';
							}
							responsiveHeightHtml += '</div>';
							rowHtml += "<div class='css3_grid_arrows_row'><a href='#' class='css3_grid_sort_up' title='" + config.translation.up + "'></a><a href='#' class='css3_grid_sort_down' title='" + config.translation.down + "'></a></div><div class='css3_grid_row_config'><input class='css3_grid_short' type='text' name='heights[]' value='' /><label>" + config.translation.heightOptionalInPx + "</label>" + responsiveHeightHtml + "<input class='css3_grid_short' type='text' name='paddingsTop[]' value='' /><label>" + config.translation.paddingTopOptionalInPx + "</label><br><input class='css3_grid_short' type='text' name='paddingsBottom[]' value='' /><label>" + config.translation.paddingBottomOptionalInPx + "</label></div>";
						}
						else
							rowHtml += "<input type='text' name='texts[]' value='' />"+shortcodesSelect;
						html += "</td>";
					}
					rowHtml += "</tr>";
				}
				for(i=previousRows; i<rows; i++)
					$("#textsTable tbody").append($(rowHtml).addClass("css3_grid_admin_row"+(i+1)));
			}
			else
			{
				//columns
				for(i=columns; i<previousColumns; i++)
					$("#textsTable .css3_grid_admin_column"+(i+1)).remove();
				for(i=previousColumns; i<columns; i++)
				{
					if(i==0)
					{
						//responsive heights
						var responsiveSteps = parseInt($("#responsiveSteps").val());
						var responsiveHeightHtml = '<div class="css3_responsive_height_container">';
						for(j=0; j<responsiveSteps; j++)
						{
							responsiveHeightHtml += (j>0 ? '<br class="css3_responsive_height css3_responsive_height' + (j+1) + '"' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + '>' : '') + '<input class="css3_grid_short css3_responsive_height css3_responsive_height' + (j+1) + '" type="text" name="responsiveHeights[]" value=""' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + ' />';
							responsiveHeightHtml += '<label class="css3_responsive_height css3_responsive_height' + (j+1) + '"' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + '>' + config.translation.responsiveHeight + ' ' + (j+1) + ' (optional)</label>';
						}
						responsiveHeightHtml += '</div>';
						$("#textsTable thead tr").append("<th class='css3_grid_admin_column1'>" + config.translation.rowsConfiguration + "</th>");
						$("#textsTable tbody tr").append("<td class='css3_grid_admin_column1'><div class='css3_grid_arrows_row'><a href='#' class='css3_grid_sort_up' title='up'></a><a href='#' class='css3_grid_sort_down' title='down'></a></div><div class='css3_grid_row_config'><input class='css3_grid_short' type='text' name='heights[]' value='' /><label>" + config.translation.heightOptionalInPx + "</label>" + responsiveHeightHtml + "<input class='css3_grid_short' type='text' name='paddingsTop[]' value='' /><label>" + config.translation.paddingTopOptionalInPx + "</label><input class='css3_grid_short' type='text' name='paddingsBottom[]' value='' /><label>" + config.translation.paddingBottomOptionalInPx + "</label></div></td>");
					}
					else
					{
						//responsive widths
						var responsiveSteps = parseInt($("#responsiveSteps").val());
						var responsiveWidthHtml = '<div class="css3_responsive_width_container">';
						for(j=0; j<responsiveSteps; j++)
						{
							responsiveWidthHtml += (j>0 ? '<br class="css3_responsive_width css3_responsive_width' + (j+1) + '"' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + '>' : '') + '<label class="css3_responsive_width css3_responsive_width' + (j+1) + '"' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + '>' + config.translation.responsiveWidth + ' ' + (j+1) + ' ' + config.translation.optional + '</label>';
							responsiveWidthHtml += '<input class="css3_responsive_width css3_responsive_width' + (j+1) + '" type="text" name="responsiveWidths[]" value=""' + (parseInt($("#responsive").val())==1 ? ' style="display: inline;"' : '') + ' />';
						}
						responsiveWidthHtml += '</div>';
						$("#textsTable thead tr").append("<th class='css3_grid_admin_column"+(i+1)+"'><div class='css3_grid_sort_column css3_clearfix'><div class='css3_grid_arrows'><a href='#' class='css3_grid_sort_left' title='" + config.translation.left + "'></a><a href='#' class='css3_grid_sort_right' title='" + config.translation.right + "'></a></div></div>" + config.translation.column + " "+i+"<br /><label>" + config.translation.widthOptional + " </label><input type='text' name='widths[]' value='' />" + responsiveWidthHtml + "<label>" + config.translation.aligmentOptional + " </label><select name='aligments[]'><option value='-1'>" + config.translation.choose + "</option><option value='left'>" + config.translation.left + "</option><option value='center'>" + config.translation.center + "</option><option value='right'>" + config.translation.right + "</option></select><br class='css3_active_column_br' /><label class='css3_active_column_label'>" + config.translation.activeOptional + " </label><select name='actives[]' class='css3_active_column_select'><option value='-1'>" + config.translation.no + "</option><option value='1'>" + config.translation.yes + "</option></select><br /><label>" + config.translation.disableHiddenOptional + "</label><select name='hiddens[]'><option value='-1'>" + config.translation.no + "</option><option value='1'>" + config.translation.yes + "</option></select><br /><label>" + config.translation.ribbonOptional + " </label><select name='ribbons[]'><option value='-1'>" + config.translation.choose + "</option><optgroup label='" + config.translation.Style + " 1'><option value='style1_best'>" + config.translation.best + "</option><option value='style1_buy'>" + config.translation.buy + "</option><option value='style1_free'>" + config.translation.free + "</option><option value='style1_free_caps'>" + config.translation.freeUppercase + "</option><option value='style1_fresh'>" + config.translation.fresh + "</option><option value='style1_gift_caps'>" + config.translation.giftUppercase + "</option><option value='style1_heart'>" + config.translation.heart + "</option><option value='style1_hot'>" + config.translation.hot + "</option><option value='style1_hot_caps'>" + config.translation.hotUppercase + "</option><option value='style1_new'>" + config.translation.new + "</option><option value='style1_new_caps'>" + config.translation.newUppercase + "</option><option value='style1_no1'>" + config.translation.no1 + "</option><option value='style1_off5'>" + config.translation.off5 + "</option><option value='style1_off10'>" + config.translation.off10 + "</option><option value='style1_off15'>" + config.translation.off15 + "</option><option value='style1_off20'>" + config.translation.off20 + "</option><option value='style1_off25'>" + config.translation.off25 + "</option><option value='style1_off30'>" + config.translation.off30 + "</option><option value='style1_off35'>" + config.translation.off35 + "</option><option value='style1_off40'>" + config.translation.off40 + "</option><option value='style1_off50'>" + config.translation.off50 + "</option><option value='style1_off75'>" + config.translation.off75 + "</option><option value='style1_pack'>" + config.translation.pack + "</option><option value='style1_pro'>" + config.translation.pro + "</option><option value='style1_sale'>" + config.translation.sale + "</option><option value='style1_save'>" + config.translation.save + "</option><option value='style1_save_caps'>" + config.translation.saveUppercase + "</option><option value='style1_top'>" + config.translation.top + "</option><option value='style1_top_caps'>" + config.translation.topUppercase + "</option><option value='style1_trial'>" + config.translation.trial + "</option></optgroup><optgroup label='" + config.translation.Style + " 2'><option value='style2_best'>" + config.translation.best + "</option><option value='style2_buy'>" + config.translation.buy + "</option><option value='style2_free'>" + config.translation.free + "</option><option value='style2_free_caps'>" + config.translation.freeUppercase + "</option><option value='style2_fresh'>" + config.translation.fresh + "</option><option value='style2_gift_caps'>" + config.translation.giftUppercase + "</option><option value='style2_heart'>" + config.translation.heart + "</option><option value='style2_hot'>" + config.translation.hot + "</option><option value='style2_hot_caps'>" + config.translation.hotUppercase + "</option><option value='style2_new'>" + config.translation.new + "new</option><option value='style2_new_caps'>" + config.translation.newUppercase + "</option><option value='style2_no1'>" + config.translation.no1 + "</option><option value='style2_off5'>" + config.translation.off5 + "</option><option value='style2_off10'>" + config.translation.off10 + "</option><option value='style2_off15'>" + config.translation.off15 + "</option><option value='style2_off20'>" + config.translation.off20 + "</option><option value='style2_off25'>" + config.translation.off25 + "</option><option value='style2_off30'>" + config.translation.off30 + "</option><option value='style2_off35'>" + config.translation.off35 + "</option><option value='style2_off40'>" + config.translation.off40 + "</option><option value='style2_off50'>" + config.translation.off50 + "</option><option value='style2_off75'>" + config.translation.off75 + "</option><option value='style2_pack'>" + config.translation.pack + "</option><option value='style2_pro'>" + config.translation.pro + "</option><option value='style2_sale'>" + config.translation.sale + "</option><option value='style2_save'>" + config.translation.save + "</option><option value='style2_save_caps'>" + config.translation.saveUppercase + "</option><option value='style2_top'>" + config.translation.top + "</option><option value='style2_top_caps'>" + config.translation.topUppercase + "</option><option value='style2_trial'>" + config.translation.trial + "</option></optgroup></select></th>");
						$("#textsTable tbody tr").append("<td class='css3_grid_admin_column"+(i+1)+"'><input type='text' name='texts[]' value='' />"+shortcodesSelect+"</td>");
					}
				}
			}
		}
	});
	$("#export_to_file").click(function(event){
		event.preventDefault();
		window.location.href = $(this).attr("href")+"&"+decodeURI($("#exportIds").serialize());
	});
	
	$("#save_css3_grid_1, #save_css3_grid_2, #import_from_file, #restore_default_tables").click(function(){
		var id = ($(this).attr("id")=="save_css3_grid_1" || $(this).attr("id")=="save_css3_grid_2" ? $(this).attr("id").substr(0, $(this).attr("id").length-2) : $(this).attr("id"));
		$("#css3_grid_settings [name='action']").val(id);
	});
	$("#css3_grid_settings").one("submit", submitConfigForm);
	function submitConfigForm(event)
	{
		event.preventDefault();
		$("#ajax_loader_save_1,#ajax_loader_save_2").css("display", "inline");
		if($("#css3_grid_settings [name='action']").val()=="save_css3_grid" && $("#shortcodeId").val()!="")
		{
			var data = $("#css3_grid_settings input[type='text'], #css3_grid_settings textarea, #css3_grid_settings select").serialize();
			$("#css3_grid_data_hidden").val(data);
			$("#css3_grid_action_hidden").val("save_css3_grid");
			$("#css3_grid_settings_hidden").submit();
		}
		else if($("#css3_grid_settings [name='action']").val()=="restore_default_tables" || $("#css3_grid_settings [name='action']").val()=="import_from_file")
		{
			$(this).submit();
		}
		else
		{
			$("#shortcodeId").addClass("css3_grid_input_error");
			var offset = $("#shortcodeId").offset();
			$(document).scrollTop(offset.top-30);
			$("#css3_grid_settings").one("submit", submitConfigForm);
			$("#ajax_loader_save_1,#ajax_loader_save_2").css("display", "none");
		}
	}
	$("#shortcodeId").bind("keyup paste", function(){
		if($(this).val()!="")
			$(this).removeClass("css3_grid_input_error");
	});
	//sorting
	$(".css3_grid_sort_left").live("click", function(event){
		event.preventDefault();
		$("." + $(this).parent().parent().parent().attr("class")).each(function(){
			$(this).insertBefore($(this).prev(":not('.css3_grid_admin_column1')"));
		});
	});
	$(".css3_grid_sort_right").live("click", function(event){
		event.preventDefault();
		$("." + $(this).parent().parent().parent().attr("class")).each(function(){
			$(this).insertAfter($(this).next());
		});
	});
	$(".css3_grid_sort_up").live("click", function(event){
		event.preventDefault();
		$("." + $(this).parent().parent().parent().attr("class")).each(function(){
			$(this).insertBefore($(this).prev());
		});
	});
	$(".css3_grid_sort_down").live("click", function(event){
		event.preventDefault();
		$("." + $(this).parent().parent().parent().attr("class")).each(function(){
			$(this).insertAfter($(this).next());
		});
	});
	$(".google_font_chooser").change(function(event, param){
		var self = $(this);
		if(self.val()!="")
		{
			self.next().css("display", "inline");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					data: "action=css3_grid_get_font_subsets&font=" + $(this).val(),
					success: function(data){
						data = $.trim(data);
						var indexStart = data.indexOf("css3_start")+10;
						var indexEnd = data.indexOf("css3_end")-indexStart;
						data = data.substr(indexStart, indexEnd);
						self.next().css("display", "none");
						self.parent().parent().next().find(".fontSubset").css("display", "inline").html(data);
						self.parent().parent().next().css("display", "table-row");
						if(param!=null)
						{
							for(val in param)
								self.parent().parent().next().find("[value='" + param[val] + "']").attr("selected", "selected");
							if(param.length)
								$("#preview").trigger("click");
						}
					}
			});
		}
		else
			self.parent().parent().next().css("display", "none");
	});
	if(config.selectedShortcodeId!="")
		$("#editShortcodeId").val("css3_grid_shortcode_settings_" + config.selectedShortcodeId).trigger("change");
});