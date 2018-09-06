/*
 * 网页前端提示信息框
 */
function ShowMsg(msg, reload) {

	if (!msg)
		return;

	if (typeof(reload) == "undefined") 
		reload = true;
	toastr.options = {
		"closeButton" : false, // 是否显示关闭按钮
		"debug" : false, // 是否使用debug模式
		"positionClass" : "toast-top-center",// 弹出窗的位置
		"showDuration" : "300",// 显示的动画时间
		"hideDuration" : "1000",// 消失的动画时间
		"timeOut" : "2000", // 展现时间
		"extendedTimeOut" : "1000",// 加长展示时间
		"showEasing" : "swing",// 显示时的动画缓冲方式
		"hideEasing" : "linear",// 消失时的动画缓冲方式
		"showMethod" : "fadeIn",// 显示时的动画方式
		"hideMethod" : "fadeOut" // 消失时的动画方式
	};
	var type = msg.toString().substring(0, 1);
	var msg = msg.toString().substring(1);
	switch (type) {
	case "S":
		toastr.success(msg);
		if (reload)
			setTimeout(function() {
				top.location.reload()
			}, 1000);
		break;
	case "W":
		toastr.warning(msg);
		break;
	case "E":
		toastr.error(msg);
		break;
	default:
		toastr.info(msg);
		break;
	}

}