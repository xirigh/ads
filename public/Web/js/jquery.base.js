// By samfea.om 海东青 20160505
//Tab
$(function(){
		$("#s1 li").click(function(){
			$("#s1 li").removeClass("tab1");
			$("#s1 li").addClass("tab2");
			$(this).removeClass("tab2");
			$(this).addClass("tab1");
			$("#s2 .tab_box").addClass("tab_none");
			$("#s2 .tab_box_"+$(this).attr("rel")).removeClass("tab_none");
		});
	});
//Drop-down
$(function(){
	$(".drop-down").hover(function(){		
		$(this).find(".drop-title").addClass("drop-title-hover");
		$(this).find(".drop-box").show();
	},function(){
		$(this).find(".drop-title").removeClass("drop-title-hover");
		$(this).find(".drop-box").hide();
	});		
});
//Drop-title
$(function () {
	jQuery("a,img,i,input").each(function() {
		jQuery("#Drop-title").remove();
		if (this.title) {
			var a = this.title;
			jQuery(this).mouseover(function(b) {
				this.title = "";
				jQuery("body").append('<div id="Drop-title">' + a + "</div>");
				jQuery("#Drop-title").css({
					left: b.pageX - 15 + "px",
					top: b.pageY + 30 + "px",
					opacity: "0.8"
				}).fadeIn(250)
			}).mouseout(function() {
				this.title = a;
				jQuery("#Drop-title").remove()
			}).mousemove(function(b) {
				jQuery("#Drop-title").css({
					left: b.pageX - 15 + "px",
					top: b.pageY + 30 + "px"
				})
			})
		}
	})

})
$(function () {
				//排队天数
				$('#tsa-add').on('click', function() {
				    var tsa_val = $('#tsa').val();
				    if(isNaN(tsa_val)){tsa_val = 0;}

				    var mat=Math.floor(parseInt(tsa_val)+1);
				    if(mat<0){mat=0;}else if(mat>10){mat=10;}
				    $("#tsa").val(mat);
			        });
			        $('#tsa-sub').on('click', function() {
				    var tsa_val = $('#tsa').val();
				    if(isNaN(tsa_val)){tsa_val = 0;}
				    
				    var mat=Math.floor(parseInt(tsa_val)-1);
				    if(mat<0){mat=0;}else if(mat>10){mat=10;}
				    $("#tsa").val(mat);
			        });
				$("#tsa").bind("change",function(){
				    if(isNaN($(this).val())){
					$(this).val(0);
				    }
				    var ths=$(this).val();
				    var mat=Math.floor(ths);
				    if(mat<0){
					    mat=0;
				    }else if(mat>10){
					    mat=10;
				    }
				    $("#tsa").val(mat);
				});
				//分期打款
				$('#ments-add').on('click', function() {
				    var ments_val = $('#ments').val();
				    if(isNaN(ments_val)){ments_val = 0;}

				    var mat=Math.floor(parseInt(ments_val)+1);
				    if(mat<0){mat=0;}else if(mat>5){mat=5;}
				    $("#ments").val(mat);
			        });
			        $('#ments-sub').on('click', function() {
				    var ments_val = $('#ments').val();
				    if(isNaN(ments_val)){ments_val = 0;}
				    
				    var mat=Math.floor(parseInt(ments_val)-1);
				    if(mat<0){mat=0;}else if(mat>5){mat=5;}
				    $("#ments").val(mat);
			        });
				$("#ments").bind("change",function(){
				    if(isNaN($(this).val())){
					$(this).val(0);
				    }
				    var ths=$(this).val();
				    var mat=Math.floor(ths);
				    if(mat<0){
					    mat=0;
				    }else if(mat>5){
					    mat=5;
				    }
				    $("#ments").val(mat);
				});
			    });