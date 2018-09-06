

//妯℃嫙涓嬫媺妗嗙粍浠�
(function(host, name, Event, $, undefined){
    var defConfig = {
        //鏈€澶栧眰娣诲姞鐨刢lass鏍峰紡
        cls:'ui-simulation-select',
        //鏄惁鍚屾椂鑳借緭鍏�
        isInput:false,
        //瀵瑰簲鐨勭湡瀹瀞elect
        realDom:'',
        //妯℃嫙select妯℃澘
        tpl:'<div class="choose-model"><div class="choose-list" style="display:none;"><#=loopItems#></div><span class="info"><input data-realvalue="<#=value#>" class="choose-input" disabled="disabled" type="text" value="<#=text#>" /></span><i></i></div>',
        //鍗曡鍏冪礌妯℃澘
        itemTpl:'<a data-value="<#=value#>" href="javascript:void(0);"><#=text#></a>'
    };
    
    var pros = {
        init:function(cfg){
            var me = this;
            me.realDom = $(cfg.realDom);
            me.realDom.hide();
            me.dom = null;
            me.listDom = null;
            me.buildSelect();
        },
        buildSelect:function(){
            var me = this,cfg = me.defConfig,tpl = cfg.tpl,itemTpl = cfg.itemTpl,items = me.getRealDom().options,len = items.length,i = 0,
                itemStrArr = [],
                currValue = '',
                currText = '';
            for(;i < len;i++){
                itemStrArr[i] = itemTpl.replace(/<#=value#>/g, items[i].value).replace(/<#=text#>/g, items[i].text);
                if(i == me.getRealDom().selectedIndex){
                    currValue = items[i].value;
                    currText = items[i].text;
                }
            }
            tpl = tpl.replace(/<#=text#>/g, currText).replace(/<#=loopItems#>/g, itemStrArr.join(''));
            me.dom = $(tpl);
            me.dom.addClass(cfg.cls);
            me.dom.insertBefore(me.getRealDom());
            
            me.dom.click(function(e){
                var el = e.target;
                //濡傛灉鏄€夐」鐐瑰嚮
                if(!!el.getAttribute('data-value')){
                    me.setValue(el.getAttribute('data-value'));
                }
                $(el).select();
                me.getListDom().toggle();
            });
            
            $(document).mousedown(function(e){
                var el = e.target;
                if(!$.contains(me.dom.get(0), el)){
                    me.getListDom().hide();
                }
            });

            me.getInput().blur(function (e) {
                var el = e.target;
                var valueInput = me.getInput().val()
                valueInput = valueInput.replace(/[^\d]/g, '');
                var v = Number(valueInput);
                if (v < 1) {
                    this.value = 1;
                    me.setValue(this.value);
                }
                

            });
            
            if(cfg.isInput){
                me.getInput().removeAttr('disabled');
                me.inputEvent();
            }
            me.setValue(currValue);
        },
        getInput:function(){
            var me = this;
            return me.input || (me.input = me.dom.find('.choose-input'));
        },
        //input鏍￠獙鍑芥暟
        inputEvent:function(){
            
        },
        getListDom:function(){
            var me = this;
            return me.listDom || (me.listDom = me.dom.find('.choose-list'));
        },
        getRealDom:function(){
            return this.realDom.get(0);
        },
        setValue:function(value){
            var me = this,dom = me.getRealDom(),index = dom.selectedIndex,options = dom.options,len = options.length,i = 0,text = '';
            for(;i < len;i++){
                if(value == options[i].value){
                    options[i].selected = true;
                    text = options[i].text;
                }else{
                    options[i].selected = false;
                }
            }
            me.getInput().attr('data-realvalue', value);
            text = text == '' ? value : text;
            me.getInput().val(text);
            me.fireEvent('change', value, text);
        },
        getValue:function(){
            var me = this,dom = me.getRealDom(),index = dom.selectedIndex;
            if(me.defConfig.isInput){
                return me.getInput().attr('data-realvalue');
            }
            return dom.options[index].value;
        },
        getText:function(){
            var dom = this.getRealDom(),index = dom.selectedIndex;
            return dom.options[index].text;
        },
        show:function(){
            this.dom.show();
        },
        hide:function(){
            this.dom.hide();
        }

    };

    var Main = host.Class(pros, Event);
        Main.defConfig = defConfig;
    host[name] = Main;


})(phoenix, "Select", phoenix.Event, jQuery);







