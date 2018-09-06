$(document).ready(function(){
	var form = $('#J-form');
	$('#divDetailed').hide(); 
	$('#J-date-start').val(getStartTimeOfNDay(-6));
	$('#J-date-end').val(getStartTimeOfNDay(1));
	if($.cookie(global_userID+'_Records_Open')=="true")
	{
		$('#divDetailed').show();
		$('#divExpansion').html("收起∧");
	}else if($.cookie(global_userID+'_Records_Open')=="false")
	{
		$('#divDetailed').hide();
		$('#divExpansion').html("展开∨");
	}
	
	//if($('#lotteryId').val()==0){
	//	$('#webIssueCode').empty();
	//	$('#webIssueCode').attr('disabled',true);
	//}else{
	//	$('#webIssueCode').removeAttr('disabled');
	//}

	
	lotterysSelect();
	
	//展开，收起
	$('#divExpansion').click(function(){		
		if($.trim($('#divExpansion').html())=="展开∨"){
			var uname=global_userID,key=uname+'_Records_Open';
		$.cookie(key,true,{path:'/',domain:window.location.hostname.substring(window.location.hostname.indexOf('.'))});
			$('#divDetailed').show();
			$('#divExpansion').html("收起∧");
		}
		else{
			var uname=global_userID,key=uname+'_Records_Open';
		$.cookie(key,false,{path:'/',domain:window.location.hostname.substring(window.location.hostname.indexOf('.'))});
			$('#divDetailed').hide();
			$('#divExpansion').html("展开∨");
		}	
	});

	//时间选择，隐藏域保存值,改变样式
	$(".time span").click(function () {		
		var txtday = $.trim($(this).attr("pro"));		
		$(".time span").removeClass().addClass("ico-tab");
        $(this).addClass("ico-tab ico-tab-current");		
		$("#time").attr("value", txtday);
	});

	//状态，隐藏域保存值,改变样式
	$(".state span").click(function () {		
	    var txtstatus = $.trim($(this).attr("pro"));		
		$(".state span").removeClass().addClass("ico-tab");
        $(this).addClass("ico-tab ico-tab-current");		
		$("#status").attr("value", txtstatus);
		
		if($.trim($('#divExpansion').html())=="展开∨"){
			if ($('#J-date-start').val() != '') {
				var time = convertDate2UnixTimestamp($('#J-date-start').val());
				$('#startTime').val(time);
			}
			if ($('#J-date-end').val() != '') {
				var time = convertDate2UnixTimestamp($('#J-date-end').val());
				$('#endTime').val(time);
			}
			if($('#status').val()==''){//status默认设置为选择全部
				$('#status').val(0);
			}
			form.submit();
		}
	});				
	
	$('#orderCode').focus(function(){
		if($('#orderCode').val()=='如：ABC7779')
		
		{ $("#orderCode").val('');}
		
		}).blur(function(){
			var v = $.trim($(this).val());
			if(v == ''){
				$("#orderCode").val('如：ABC7779');
			}
	
		});

	////彩种回显
	var temp = $("#lotteryIdValue").val();
	$("#lotteryId").find("option[value=" + temp + "]").attr("selected", true);
	
	//if($("#lotteryIdValue").val()!=0){
	//	$('#webIssueCode').removeAttr('disabled');
	//	$.ajax({
	//		type:  "post",
	//		url: 'getGameIssuesByLotteryId?lotteryId='+$('#lotteryId').val(),
	//		data: '',
	//		async:false, 
	//		success:function(data){
	//			$('#webIssueCode').empty();
	//			$('#webIssueCode').addOption('所有奖期','0');
	//			if(data.length!=0){
	//				for(var i = 0; i < data.length; i++){
	//					$('#webIssueCode').addOption(data[i].webIssueCode,data[i].issueCode);
	//					}
	//				}
	//		},
	//		error: function(){
	//			alert('get webIssueCode data error!')
	//		}
	//	});
	//}
	

	if ($('#startTime').val() != '') {
		$('#J-date-start').val($('#startTime').val());
	}
	
	if ($('#endTime').val() != '') {
		$('#J-date-end').val($('#endTime').val());
	}
	

	if($('#orderCodeValue').val()!=''){
		$("#orderCode").val($('#orderCodeValue').val());
	}
	
	if($('#status').val()!=''){
		$(".state span").removeClass().addClass("ico-tab");
		$(".state").find("span[pro="+$('#status').val()+"]").addClass("ico-tab ico-tab-current");		
	}
	
	if($('#time').val()!=''){
		$(".time span").removeClass().addClass("ico-tab");
		$(".time").find("span[pro="+$('#time').val()+"]").addClass("ico-tab ico-tab-current");		
	}
	

	if ($('#webIssueCodeValue').val() != '') {
	    $("#webIssueCode").val($('#webIssueCodeValue').val());
	}
	
	//表单提交校验
	$('#J-button-submit').click(function(){
		if ($('#J-date-start').val() != '') {
			var time = convertDate2UnixTimestamp($('#J-date-start').val());
			$('#startTime').val(time);
		}
		if ($('#J-date-end').val() != '') {
			var time = convertDate2UnixTimestamp($('#J-date-end').val());
			$('#endTime').val(time);
		}
		if($('#status').val()==''){//status默认设置为选择全部
			$('#status').val(0);
		}
		form.submit();
	});
	
	$('[id^=time]').click(function(){
		var n=$(this).attr('pro');
	    $('#J-date-start').val(getStartTimeOfNDay(1-n));
	    $('#J-date-end').val(getStartTimeOfNDay(1));
	    if($.trim($('#divExpansion').html())=="展开∨"){
			if ($('#J-date-start').val() != '') {
				var time = convertDate2UnixTimestamp($('#J-date-start').val());
				$('#startTime').val(time);
			}
			if ($('#J-date-end').val() != '') {
				var time = convertDate2UnixTimestamp($('#J-date-end').val());
				$('#endTime').val(time);
			}
			if($('#status').val()==''){//status默认设置为选择全部
				$('#status').val(0);
			}
			form.submit();
		}
	});
	
	form.submit(function(e){
		//e.preventDefault();
	    if ($.trim($('#orderCode').val()) == '如：ABC7779') { $('#orderCode').val(''); }
	   
	});
	
	//取消重置
	$('#restoreDefaults').click(function(e){
		e.preventDefault();
		$('#J-form').get(0).reset();
		//重置样式,值初始	
		$("#time").attr("value",1);
		$("#status").attr("value",0);	
		$(".time span").removeClass().addClass("ico-tab");
		$(".time span:eq(0)").addClass("ico-tab ico-tab-current");
		$('#J-date-start').val(getStartTimeOfNDay(0));
		$('#J-date-end').val(getStartTimeOfNDay(1));
		$(".state span").removeClass().addClass("ico-tab");
		$(".state span:eq(0)").addClass("ico-tab ico-tab-current");
		$('#lotteryId').val(0);
	
	});	
	

	function lotterysSelect()
	{
	    $.ajax({
	        type: "post",
	        url: '/GameUserCenter/getGameLotteryIdAndName',
	        data: '',
	        async: false,
	        success: function (data) {
	            var ss = '<select class="ui-select" name="lotteryId" id="lotteryId">';
	            ss += '<option value="0">全部彩种</option>';
	            var d = data;
	            for (var i in d) {
	                ss += '<option value="' + d[i].lotteryId + '">' + d[i].lotteryName + '</option>';
	            }
	            ss += '</select>'
	            $('#sel').append(ss);
	           
	            $('#lotteryId').change(function () {
	                

	                if ($.trim($('#divExpansion').html()) == "展开∨") {
	                    if ($('#J-date-start').val() != '') {
	                        var time = convertDate2UnixTimestamp($('#J-date-start').val());
	                        $('#startTime').val(time);
	                    }
	                    if ($('#J-date-end').val() != '') {
	                        var time = convertDate2UnixTimestamp($('#J-date-end').val());
	                        $('#endTime').val(time);
	                    }
	                    if ($('#status').val() == '') {//status默认设置为选择全部
	                        $('#status').val(0);
	                    }
	                    form.submit();
	                }

	            });

	        },
	        error: function () {
	            alert('get webIssueCode data error!')
	        }
	    });
	}

	function lotteryIdChangeBind()
	{
	    $('#lotteryId').change(function () {
	        if ($('#lotteryId').val() == 0) {
	            $('#webIssueCode').empty();
	            $('#webIssueCode').attr('disabled', true);
	        } else {
	            $('#webIssueCode').removeAttr('disabled');
	            $.ajax({
	                type: "post",
	                url: '/GameBet/getGameIssuesByLotteryId?lotteryId=' + $('#lotteryId').val(),
	                data: '',
	                success: function (data) {
	                    $('#webIssueCode').empty();
	                    $('#webIssueCode').addOption('所有奖期', '0');
	                    if (data.length != 0) {
	                        for (var i = 0; i < data.length; i++) {
	                            $('#webIssueCode').addOption(data[i].webIssueCode, data[i].issueCode);
	                        }
	                    }
	                },
	                error: function () {
	                    //alert('get webIssueCode data error!')
	                }
	            });
	        }

	        if ($.trim($('#divExpansion').html()) == "展开∨") {
	            if ($('#J-date-start').val() != '') {
	                var time = convertDate2UnixTimestamp($('#J-date-start').val());
	                $('#startTime').val(time);
	            }
	            if ($('#J-date-end').val() != '') {
	                var time = convertDate2UnixTimestamp($('#J-date-end').val());
	                $('#endTime').val(time);
	            }
	            if ($('#status').val() == '') {//status默认设置为选择全部
	                $('#status').val(0);
	            }
	            form.submit();
	        }

	    });
	}
	
	
});

jQuery.fn.addOption = function(text,val){
    $(this).get(0).options.add(new Option(text,val));
}
