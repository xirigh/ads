(function(I,C,F,A){var B={name:"wuxing.zhixuan.danshi",editorobj:".content-text-balls",uploadButton:"#file",exampleText:"12345 33456 87898 <br />12345 33456 87898 <br />12345 33456 87898 ",tips:"五星直选单式玩法提示",exampleTip:"这是单式弹出层提示",checkFont:/[\u4E00-\u9FA5]|[/\n]|[/W]/g,filtration:/[\s]|[,]|[;]|[<br>]|[，]|[；]/i,checkNum:/^[0-9]*$/,normalTips:'<p style="color:#888;font-size:12px;line-height:170%;">'+["说明：",'1、请参照"标准格式样本"格式录入或上传方案。',"2、每一注号码之间的间隔符支持 回车 空格[ ] 逗号[,] 分号[;] 冒号[:] 竖线 [|]","3、文件格式必须是.txt格式。","4、文件较大时会导致上传时间较长，请耐心等待！","5、将文件拖入文本框即可快速实现文件上传功能。","6、导入文本内容后将覆盖文本框中现有的内容。"].join("<br>")+"</p>"},D=I.Games,E=I.Games.SSC;var G={init:function(K){var J=this;J.ieRange="";J.vData=[];J.aData=[];J.tData=[];J.errorData=[];J.sameData=[];J.firstfocus=true;J.ranNumTag=false;J.isFirstAdd=true;D.getCurrentGameStatistics().addEvent("afterStatisReset",function(L,N){var M=this,O=M.defConfig;methodName=M.getGameMethodName()});D.getCurrentGameOrder().addEvent("beforeAdd",function(M,O){var N=this,P=J.tData,L="";if(O["type"]==J.defConfig.name){if(J.isFirstAdd){if(!J["ranNumTag"]){O["lotterys"]=[];J.isFirstAdd=null;J.updateData();D.getCurrentGameOrder().add(D.getCurrentGameStatistics().getResultData())}}else{if(J.errorData.join("")!=""||J.sameData.join("")!=""){J.ballsErrorTip()}J.checkLimitBall(O);J.isFirstAdd=true}}})},initFrame:function(){var K=this;K.win=K.container.find(K.defConfig.editorobj)[0].contentWindow;K.doc=K.win.document;K._bulidEditDom();var J=I.Tip.getInstance();K.container.find(".balls-example-danshi-tip").click(function(M){M.preventDefault();var L=$(this);J.setText(K.getExampleText());J.show(L.outerWidth()+10,0,this)}).mouseout(function(){J.hide()})},getExampleText:function(){return this.defConfig.exampleText},rebuildData:function(){var J=this;J.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var J=this;J.container.html(J.getHTML())},reSelect:function(){},batchSetBallDom:function(){},getNormalTips:function(){return this.defConfig.normalTips},showNormalTips:function(){var J=this;J.replaceText(J.getNormalTips.call(J));J.firstfocus=true},_bulidEditDom:function(){var K=this,J="";K.doc.designMode="On";K.doc.contentEditable=true;K.doc.open();J='<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';J=J+"<style>*{margin:0;padding:0;font-size:14px;}</style>";J=J+"</head>";K.doc.writeln("<html>"+J+'<body style="word-break: break-all">'+K.getNormalTips()+"</body></html>");K.doc.close();K.bindPress();if(document.all){K.doc.onkeypress=function(){return K._ieEnter()}}K.dragUpload()},dragUpload:function(){var J=this,K=$(J.doc.body);if(window.FileReader){K.bind("dragover",function(L){L.preventDefault();L.stopPropagation()});K.get(0).addEventListener("drop",function(L){L.preventDefault();L.stopPropagation();var N=L.dataTransfer.files,O=N[0],M=new FileReader(),P=O.type?O.type:"n/a";if(P!="text/plain"){return}M.onload=function(Q){var R=Q.target.result;if($.trim(R)!=""){J.replaceText(R);J.firstfocus=false;J.updateData()}};M.readAsText(O)},false)}},_ieEnter:function(){var K=this,J=K.win.event;if(J.keyCode==13){this._saveRange();this._insert("<br/>");return false}},_insert:function(L){var J=this;if(!!J.ieRange){J.ieRange.pasteHTML(L);J.ieRange.select();J.ieRange=false}else{J.win.focus();if(document.all){J.doc.body.innerHTML+=L}else{var M=win.getSelection();var N=M.getRangeAt(0);var K=N.createContextualFragment(L);N.insertNode(K)}}},_saveRange:function(){var K=this;if(!!document.all&&!K.ieRange){var L=K.doc.selection;K.ieRange=L.createRange();if(L.type!="Control"){var J=K.ieRange.parentElement();if(J.tagName=="INPUT"||J==document.body){K.ieRange=false}}}},getHtml:function(){var J=this;return J.doc?$(J.doc.body).html():""},getText:function(){var J=this;return J.doc?$(J.doc.body).text():""},replaceText:function(K){var J=this,K=K.replace(/\n/g,"<br>");if(J.doc&&K){$(J.doc.body).html(K)}},bindPress:function(){var K=this,L=K.container.find(K.defConfig.uploadButton),J=window.navigator.userAgent.toLowerCase();$(K.doc).bind("input",function(){K.updateData()});if(J.indexOf("msie")>0){$(K.doc.body).bind("keyup",function(){K.updateData()});$(K.doc.body).bind("blur",function(){K.updateData()})}$(K.doc).bind("focus",function(){if(K.firstfocus){K.replaceText(" ");K.firstfocus=false}});$(K.doc).bind("blur",function(){var M=K.getText();if($.trim(M)==""){K.showNormalTips()}});$(K.doc.body).bind("focus",function(){if(K.firstfocus){K.replaceText(" ");K.firstfocus=false;K.docBodyFocusAfter()}});$(K.doc.body).bind("blur",function(){var M=K.getText();if($.trim(M)==""){K.showNormalTips()}});L.bind("change",function(){var M=$(this).parent();K.checkFile(this,M)})},iterator:function(M){var P=this,Q=P.defConfig,J=M,L=[],N=0,K=0;for(var O=0;O<M.length;O++){if(Q.filtration.test(M.charAt(O))){L.push(M.substr(N,O-N));N=O+1}}return L},checkResult:function(L,J){for(var K=J.length-1;K>=0;K--){if(J[K].join("")==L){return false}}return true},filterLotters:function(L){var K=this,J="";J=L.replace(/<br>+|&nbsp;+/gi," ");J=J.replace(/[\s]|[,]+|[;]+|[，]+|[；|]+/gi," ");J=J.replace(/<(?:"[^"]*"|'[^']*'|[^>'"]*)+>/g," ");J=J.replace(K.defConfig.checkFont,"")+" ";return J},checkSingleNum:function(K){var J=this;return J.defConfig.checkNum.test(K)&&K.length==J.balls.length},checkBallIsComplete:function(O){var M=this,J=0,K=[];if(M["isFirstAdd"]){M.aData=[];M.vData=[];M.sameData=[];M.errorData=[];M.tData=[];M.vDataBack={};M.aDataBack={};M.tDataBack={};M.sameDataBack={};M.errorDataBack={};K=M.iterator(M.filterLotters(O))||[];for(;J<K.length;J++){var N=K[J].split(""),L=K[J];if(M.checkSingleNum(L)){(M["vDataBack"][L])?M["sameData"].push(N):M["tData"].push(N);M["vDataBack"][L]=N;M["vData"].push(N)}else{(M["errorDataBack"][L])?M["sameData"].push(N):M["errorData"].push(N);M["errorDataBack"][L]=N}(!M["aDataBack"][L])?M["aData"].push(N):"";M["aDataBack"][L]=N}}if(M.vData.length>0){M.isBallsComplete=true;if(M.isFirstAdd){return M.vData}else{if(M.tData.length>0){return M.tData}else{return[]}}}else{M.isBallsComplete=false;return[]}},countInstances:function(L,M){var K=[];var J=0;do{J=L.indexOf(M,J);if(J!=-1){K.push(J);J+=M.length}}while(J!=-1);return K},removeOrderError:function(){var L=this,K=L.vData.length>0?"":" ";if(L.firstfocus){return}for(var J=0;J<L.vData.length;J++){K+=L.vData[J].join("")+"&nbsp;"}L.errorDataTips();if($.trim(K)==""){L.showNormalTips();return}L.replaceText(K);L.checkBallIsComplete(K);L.updateData()},removeOrderSame:function(){var L=this,K=L.aData.length>0?"":" ";if(L.firstfocus){return}for(var J=0;J<L.aData.length;J++){K+=L.aData[J].join("")+"&nbsp;"}L.sameDataTips();L.replaceText(K);L.checkBallIsComplete(K);L.updateData()},removeOrderAll:function(){var J=this;if(J.firstfocus){return}J.replaceText(" ");J.sameData=[];J.aData=[];J.tData=[];J.vData=[];D.getCurrentGameStatistics().reSet();J.showNormalTips()},checkFile:function(J,L){var M=J.value,K=M.substring(M.lastIndexOf("."),M.length),K=K.toLowerCase();if(K!=".txt"){alert("对不起，导入数据格式必须是.txt格式文件哦，请您调整格式后重新上传，谢谢 ！");return false}L[0].submit()},getFile:function(J){var K=this,L=K.container.find(":reset");if(!J){return}K.replaceText(J);K.firstfocus=false;K.updateData();L.click()},errorTip:function(J,O){var L=this,N,M,K=[];alert(L.errorData.join())},sameDataTips:function(){var J=this,L=J.sameData,P="",Q="",N=D.getCurrentGameMessage(),K=[],M=[];if(L.join("")==""){return}for(var O=0;O<L.length;O++){if($.trim(L[O].join(""))){K.push(L[O].join(""))}}P='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码重复，已进行自动过滤</h4><p class="pop-text" style="display:block">'+K.join(", ")+"</p>";N.show({mask:true,content:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">'+P+"</div>","</div>","</div>"].join(""),closeIsShow:true,closeFun:function(){this.hide()}})},errorDataTips:function(){var N=this,M=N.errorData,L="",O="",K=D.getCurrentGameMessage(),P=[],J=[];if(M.join("")==""){return}for(var Q=0;Q<M.length;Q++){if($.trim(M[Q].join(""))){P.push(M[Q].join(""))}}L='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码错误，已进行自动过滤</h4><p class="pop-text" style="display:block">'+P.join(", ")+"</p>";K.show({mask:true,content:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">'+L+"</div>","</div>","</div>"].join(""),closeIsShow:true,closeFun:function(){this.hide()}})},ballsErrorTip:function(W,N){var J=this,S=J.errorData,L=J.sameData,R="",T="",U="",Q="",P=D.getCurrentGameMessage(),V=[],K=[],M=[];if(L.join("")!=""){for(var O=0;O<L.length;O++){if($.trim(L[O].join(""))){K.push(L[O].join(""))}}T='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码重复，已进行自动过滤</h4><p class="pop-text" style="display:block">'+K.join(", ")+"</p>"}if(S.join("")!=""){for(var O=0;O<S.length;O++){if($.trim(S[O].join(""))){V.push(S[O].join(""))}}R='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码错误，已进行自动过滤</h4><p class="pop-text" style="display:block">'+V.join(", ")+"</p>"}P.show({mask:true,content:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">'+T+R+"</div>","</div>","</div>"].join(""),closeIsShow:true,closeFun:function(){this.hide()}})},reSet:function(){var J=this;J.isBallsComplete=false;J.rebuildData();J.updateData();if(!J.ranNumTag){J.showNormalTips()}J.removeRanNumTag()},makePostParameter:function(N,M){var J=this,L=[],N=M["lotterys"],K=0;for(;K<N.length;K++){L=L.concat(N[K].join(""))}return L.join(",")},getLottery:function(){var J=this,K=J.getHtml();if(K==""){return}return J.checkBallIsComplete(K)},removeSameNum:function(N){var J=0,K,M=this,L=this.getBallData()[0].length;len=N.length;K=Math.floor(Math.random()*L);for(;J<N.length;J++){if(K==N[J]){return arguments.callee.call(M,N)}}return K},emptySameData:function(){this.sameData=[]},emptyErrorData:function(){this.errorData=[]},addRanNumTag:function(){var J=this;J.ranNumTag=true;J.emptySameData();J.emptyErrorData()},getTdata:function(){return this.tData},getOriginal:function(){var L=this,K=L.getBallData(),M=K.length,J=K[0].length;i=0,j=0,row=[],tData=L.getTdata(),data=L.getHtml(),result=[];for(;i<M;i++){row=[];for(j=0;j<J;j++){if(K[i][j]>0){row.push(j)}}result.push(row)}if(tData.length>0){result[0][0]=L.getTdata().join(",")}return result},removeRanNumTag:function(){this.ranNumTag=false},checkRandomBets:function(O,P){var Q=this,M=typeof O=="undefined"?true:false,O=O||{},K=[],P=P||0,R=Q.getBallData().length,L=Q.getBallData()[0].length,S=D.getCurrentGameOrder().getTotal()["orders"];K=Q.createRandomNum();if(Number(P)>Number(Q.getRandomBetsNum())){return K}if(M){for(var N=0;N<S.length;N++){if(S[N]["type"]==Q.defConfig.name){var J=S[N]["original"].join("").replace(/,/g,"");O[J]=J}}}if(O[K.join("")]){P++;return arguments.callee.call(Q,O,P)}return K},randomNum:function(){var J=this,O=0,M=[],Q,N,P=null,L=J.getBallData(),R=J.defConfig.name,S=[],K=[];J.addRanNumTag();M=J.checkRandomBets();K=M;S=J.combination(K);P={"type":D.getCurrentGame().getCurrentGameMethod().getGameMethodName(),"original":K,"lotterys":S,"moneyUnit":D.getCurrentGameStatistics().getMoneyUnit(),"multiple":D.getCurrentGameStatistics().getMultip(),"onePrice":D.getCurrentGameStatistics().getOnePrice(),"num":S.length};P["amountText"]=D.getCurrentGameStatistics().formatMoney(P["num"]*P["moneyUnit"]*P["multiple"]*P["onePrice"]);return P},getHTML:function(){var J=[];J.push('<div class="balls-import clearfix">');J.push('<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="'+D.getCurrentGame().getGameConfig().getInstance().getUploadPath()+'" target="check_file_frame" style="position:relative;padding-bottom:10px;">');J.push('<a class="balls-example-danshi-tip" href="#">查看标准格式样本</a>');J.push('<input type="reset" style="outline:none;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:alpha(opacity=0);opacity: 0;width:0px; height:0px;z-index:1;background:#000" />');J.push('<iframe src="" name="check_file_frame" style="display:none;"></iframe>');J.push("</form>");J.push('<div class="panel-select" ><iframe style="width:100%;height:100%;border:0 none;background-color:#F9F9F9;" class="content-text-balls"></iframe></div>');J.push('<div class="panel-btn">');J.push('<a class="remove-error" id="" href="javascript:void(0);"><i></i>删除错误项</a>');J.push('<a class="remove-same" id="" href="javascript:void(0);"><i></i>删除重复项</a>');J.push('<a class="remove-all" id="" href="javascript:void(0);"><i></i>清空文本框</a>');J.push("</div>");J.push("</div>");return J.join("")},getRenXuanChenkSelMedia:function(){var J=this;var K="";J.container.find(".selposition input[name*='position']").each(function(){if($(this).is(":checked")){K+="1"}else{K+="0"}});return K},getRenXuanChenkSelMediaText:function(){var L=this;var J=L.getRenXuanChenkSelMedia();var M="";for(var K=0;K<J.length;K++){if(K==0&&J.substr(K,1)=="1"){M+="万"}else{if(K==1&&J.substr(K,1)=="1"){M+="千"}else{if(K==2&&J.substr(K,1)=="1"){M+="百"}else{if(K==3&&J.substr(K,1)=="1"){M+="十"}else{if(K==4&&J.substr(K,1)=="1"){M+="个"}}}}}}return M},docBodyFocusAfter:function(){}};var H=I.Class(G,F);H.defConfig=B;E[C]=H})(phoenix,"Danshi",phoenix.GameMethod);