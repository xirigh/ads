
//消息提示类
(function(host, name, Event, $, undefined){
	var defConfig = {
		//初始化延迟加载时间
		delayTime: 0,
		//服务器端数据地址
		serviceUrl: '',
		//服务器请求方式
		//once: 单次请求
		//repeat: 多次请求[推送]
		serviceGetType: 'once',
		//服务器推送的等待时间
		msgPushWaitTime: 3,
		//消息提示弹层渐隐动画时间
		tipsHiddenTime: 5,
		//多条数据滚动间隔时间
		cycleTime: 5,
		//请求方法
		ajaxDataType:'json',
		//滚动方式top&&bottom
		cycleType: 'bottom',
		//数据加载失败后重新获取数据方式
		reloadType: 'auto'
	   
	
	};

	
	var pros = {
		init:function(cfg){
			var me = this;

			//循环滚动时间缓存
			me.cycleTime = null;
			//服务器推送参数缓存
		

		
			me.addEvent('afterGetServicePush', function(e, serviceData){
				me.getMethodByName(serviceData['data']);
			});
		},
		//获取延迟请求时间
		setdelayTime: function(timeNum){
			this.defConfig.delayTime = timeNum;
		},
		//获取延迟请求时间
		getdelayTime: function(){
			return this.defConfig.delayTime;
		},
		//修改服务器推送等待时间
		setMsgPushWaitTime: function(timeNum){
			this.defConfig.msgPushWaitTime = timeNum;
		},
		//获取服务器推送等待时间
		getMsgPushWaitTime: function(){
			return this.defConfig.msgPushWaitTime;
		},
		//获取延迟请求时间
		setServiceGetType: function(timeNum){
			this.defConfig.serviceGetType = timeNum;
		},
		//获取延迟请求时间
		getServiceGetType: function(){
			return this.defConfig.serviceGetType;
		},
		//获取服务器接口地址
		getServiceUrl: function(){
			return this.defConfig.serviceUrl;
		},
		//修改服务器接口地址
		setServiceUrl: function(url){
			this.defConfig.serviceUrl = url;
		},
		//获取通知HTML结构
		getNoticeHtml: function(){
			return this.defConfig.noticeHtml;
		},
		//获取代理首页通知HTML结构
		getProxyNoticeHtml:function(){
			return this.defConfig.noticeProxyHtml;
		},
		//修改通知HTML结构
		setNoticeHtml: function(html){
			this.defConfig.noticeHtml = html;
		},
		//获取提示类型
		getTipsHtml: function(){
			return this.defConfig.tipsHtml;
		},
		//修改提示类型
		setTipsHtml: function(html){
			this.defConfig.tipsHtml = html;
		},
		//修改滚动切换类型
		setCycleType: function(typeName){
			this.defConfig.cycleType = typeName;
		},
		//获取滚动切换类型
		getCycleType: function(){
			return this.defConfig.cycleType;
		},
		//获取通知HTML结构
		getCycleTime: function(){
			return this.defConfig.cycleTime;
		},
		//修改通知HTML结构
		setCycleTime: function(timeNum){
			this.defConfig.cycleTime = timeNum;
		},
		//输出消息提示容器DOM
		getTipsContainerHtml: function(){
			return 
		},
		//输出消息提示容器DOM
		setTipsContainerHtml: function(){

		},
		//模版替换
		formatRow:function(tpl, data){
			var me = this,o = data,p,reg;
			for(p in o){
				if(o.hasOwnProperty(p)){
					reg = RegExp('<#=' + p + '#>', 'g');
					tpl = tpl.replace(reg, o[p]);
				}
			}
			return tpl;
		},
		//初始化执行
		startLoadData: function(){
			var me = this,
				time = me.getdelayTime() || 0;

			//延迟执行数据加载
			setTimeout(function(){
				me.getServiceData();
			}, time * 1000);
		},
		//获取服务器端数据总接口
		//通过初始化参数 发起重复[推送]或者单次请求
		getServiceData: function(){
			var me = this;

			if(me.getServiceGetType() == 'once'){
				me.getServiceDataOnce();
			}else if(me.getServiceGetType() == 'push'){
				me.getServiceDataRepeat();
			}
		},
		
		//获取服务器端数据
		getServiceDataRepeat: function(num){
			var me = this,ajaxDataType = me.defConfig.ajaxDataType;


			//获取服务器端数据
			$.ajax({
				url: me.getServiceUrl(),
				cache:false,
				dataType: ajaxDataType,
				type: 'post',
				success: function (result) {

				    
				   
					if(result['isSuccess'] == 1){
					    if (result['msg'] == 'logOut')
					    {
					        me.setMsgPushWaitTime(86400);

					        var msg = new phoenix.Message();
					        var mask = phoenix.Mask.getInstance();
					        msg.addEvent('beforeShow', function () {
					            mask.show();
					        });
					        msg.addEvent('afterHide', function () {
					            mask.hide();
					        });
					        $(".closeBtn").click(function () {
					            msg.hide();
					            mask.hide();
					        });
					        mask.show();
					        msg.show({
					            hideTitle: 'true',
					            content: '<h3 style="height:30px;line-height:30px;text-align:center;">当前账号已在其他地点登录，请查证账户安全，重新登陆！</h3><div style="height:30px;line-height:30px;"></div>',
					            confirmIsShow: 'true',
					            confirmText: '重新登录',
					            confirmFun: function () {
					                location.reload();
					            }
					        });

					        
					    }
					    else
					    {
					        //服务器端修改等待时间
					        //服务器端控制压力
					        if (typeof result['data']['ClientReloadTime'] != 'undefined' && Number(result['data']['ClientReloadTime'])) {
					            me.setMsgPushWaitTime(Number(result['data']['ClientReloadTime']));
					        }
					        //执行对应的接口方法
					        me.fireEvent('afterGetServicePush', result);
					    }
						
					} else {

					    //var pop = new Pop("这里是标题，哈哈1",
			            //"http://www.yanue.info/js/pop/pop.html",
			            //"请输入你的内容简介，这里是内容简介.请输入你的内容简介，这里是内容简介.请输入你的内容简介，这里是内容简介");
					    
					}

				},
				error: function(){
				    
				},
				complete: function(){
					//请求完成
					//重新发送请求
					me.reloadService();
				}
			})
		},
		//
		reloadService: function(){
			var me = this;

			setTimeout(function(){
				me.getServiceDataRepeat();
			}, me.getMsgPushWaitTime() * 1000)
		},
		//执行对应内部方法
		getMethodByName: function(serviceData){
			
		},

	    //添加消息提示父容器到页面
		addTipsContainerDom: function () {
		    var me = this;

		    me.tipsContainer = $('<div id="pop" style="display:none;"><div id="popHead"><a id="popClose" title="关闭">关闭</a><h2>温馨提示</h2></div><div id="popContent"><dl><dt id="popTitle"><a href="" target="_blank"></a></dt><dd id="popIntro"></dd></dl><p id="popMore"><a href="" target="_blank">查看 »</a></p></div></div>');
		    $('body').append(me.tipsContainer);
		    return me;
		},
	    //操作后提示
		fn:function(obj) {
            var Idivdok = document.getElementById(obj);
            Idivdok.style.display = "block";
            Idivdok.style.left = (document.documentElement.clientWidth - Idivdok.clientWidth) / 2 + document.documentElement.scrollLeft + "px";
            Idivdok.style.top = (document.documentElement.clientHeight - Idivdok.clientHeight) / 2 + document.documentElement.scrollTop - 40 + "px";
        }

		
	
	};
	
	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
	host[name] = Main;
	
})(phoenix, "UserNotice", phoenix.Event, jQuery);

$(function(){

    
	
	//通知&&消息提示组件
    var msgTips = new phoenix.UserNotice({
		delayTime: 5,
		serviceUrl: '/UserNotice/GetUserNotice?r=' + Math.random(),
		serviceGetType: 'push',
		msgPushWaitTime: 10
	
	});

	//初始化消息推送
	msgTips.addTipsContainerDom().startLoadData();
});





