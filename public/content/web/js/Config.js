

(function (host, name, Event, undefined) {
    var gameConfigData = {"awardGroups":[],"backOutRadio":0,"backOutStartFee":0,"defaultMethod":"qiansan.zhixuan.fushi","dynamicConfigUrl":"/GameBet/dynamicConfig?lotteryCode=10005","FenMaxMode":1952.0000,"gameMethods":[{"childs":[{"childs":[{"mode":"wuxing","name":"fushi","parent":"zhixuan","title":"常规选号"},{"mode":"wuxing","name":"danshi","parent":"zhixuan","title":"手工输入"}],"name":"zhixuan","parent":"wuxing","title":"五星直选"},{"childs":[{"mode":"wuxing","name":"zuxuan120","parent":"zuxuan","title":"组选120"},{"mode":"wuxing","name":"zuxuan60","parent":"zuxuan","title":"组选60"},{"mode":"wuxing","name":"zuxuan30","parent":"zuxuan","title":"组选30"},{"mode":"wuxing","name":"zuxuan20","parent":"zuxuan","title":"组选20"},{"mode":"wuxing","name":"zuxuan10","parent":"zuxuan","title":"组选10"},{"mode":"wuxing","name":"zuxuan5","parent":"zuxuan","title":"组选5"}],"name":"zuxuan","parent":"wuxing","title":"五星组选"},{"childs":[{"mode":"wuxing","name":"yifanfengshun","parent":"quwei","title":"一帆风顺"},{"mode":"wuxing","name":"haoshichengshuang","parent":"quwei","title":"好事成双"},{"mode":"wuxing","name":"sanxingbaoxi","parent":"quwei","title":"三星报喜"},{"mode":"wuxing","name":"sijifacai","parent":"quwei","title":"四季发财"}],"name":"quwei","parent":"wuxing","title":"五星特殊"}],"name":"wuxing","title":"五星"},{"childs":[{"childs":[{"mode":"sixing","name":"fushi","parent":"zhixuan","title":"常规选号"},{"mode":"sixing","name":"danshi","parent":"zhixuan","title":"手工输入"}],"name":"zhixuan","parent":"sixing","title":"后四直选"},{"childs":[{"mode":"sixing","name":"zuxuan24","parent":"zuxuan","title":"组选24"},{"mode":"sixing","name":"zuxuan12","parent":"zuxuan","title":"组选12"},{"mode":"sixing","name":"zuxuan6","parent":"zuxuan","title":"组选6"},{"mode":"sixing","name":"zuxuan4","parent":"zuxuan","title":"组选4"}],"name":"zuxuan","parent":"sixing","title":"四星组选"}],"name":"sixing","title":"四星"},{"childs":[{"childs":[{"mode":"qiansan","name":"fushi","parent":"zhixuan","title":"常规选号"},{"mode":"qiansan","name":"danshi","parent":"zhixuan","title":"手工输入"},{"mode":"qiansan","name":"hezhi","parent":"zhixuan","title":"直选和值"}],"name":"zhixuan","parent":"qiansan","title":"前三直选"},{"childs":[{"mode":"qiansan","name":"zusan","parent":"zuxuan","title":"组三"},{"mode":"qiansan","name":"zuliu","parent":"zuxuan","title":"组六"},{"mode":"qiansan","name":"hunhezuxuan","parent":"zuxuan","title":"混合组选"}],"name":"zuxuan","parent":"qiansan","title":"前三组选"},{"childs":[{"mode":"qiansan","name":"yimabudingwei","parent":"budingwei","title":"前三不定位"}],"name":"budingwei","parent":"qiansan","title":"前三不定位"}],"name":"qiansan","title":"前三"},{"childs":[{"childs":[{"mode":"zhongsan","name":"fushi","parent":"zhixuan","title":"常规选号"},{"mode":"zhongsan","name":"danshi","parent":"zhixuan","title":"手工输入"},{"mode":"zhongsan","name":"hezhi","parent":"zhixuan","title":"直选和值"}],"name":"zhixuan","parent":"zhongsan","title":"中三直选"},{"childs":[{"mode":"zhongsan","name":"zusan","parent":"zuxuan","title":"组三"},{"mode":"zhongsan","name":"zuliu","parent":"zuxuan","title":"组六"},{"mode":"zhongsan","name":"hunhezuxuan","parent":"zuxuan","title":"混合组选"}],"name":"zuxuan","parent":"zhongsan","title":"中三组选"},{"childs":[{"mode":"zhongsan","name":"yimabudingwei","parent":"budingwei","title":"中三不定位"}],"name":"budingwei","parent":"zhongsan","title":"中三不定位"}],"name":"zhongsan","title":"中三"},{"childs":[{"childs":[{"mode":"housan","name":"fushi","parent":"zhixuan","title":"常规选号"},{"mode":"housan","name":"danshi","parent":"zhixuan","title":"手工输入"},{"mode":"housan","name":"hezhi","parent":"zhixuan","title":"直选和值"}],"name":"zhixuan","parent":"housan","title":"后三直选"},{"childs":[{"mode":"housan","name":"zusan","parent":"zuxuan","title":"组三"},{"mode":"housan","name":"zuliu","parent":"zuxuan","title":"组六"},{"mode":"housan","name":"hunhezuxuan","parent":"zuxuan","title":"混合组选"}],"name":"zuxuan","parent":"housan","title":"后三组选"},{"childs":[{"mode":"housan","name":"yimabudingwei","parent":"budingwei","title":"后三不定位"}],"name":"budingwei","parent":"housan","title":"后三不定位"}],"name":"housan","title":"后三"},{"childs":[{"childs":[{"mode":"qianer","name":"fushi","parent":"zhixuan","title":"常规选号"},{"mode":"qianer","name":"danshi","parent":"zhixuan","title":"手工输入"}],"name":"zhixuan","parent":"qianer","title":"前二直选"},{"childs":[{"mode":"qianer","name":"fushi","parent":"zuxuan","title":"常规选号"}],"name":"zuxuan","parent":"qianer","title":"前二组选"}],"name":"qianer","title":"前二"},{"childs":[{"childs":[{"mode":"houer","name":"fushi","parent":"zhixuan","title":"常规选号"},{"mode":"houer","name":"danshi","parent":"zhixuan","title":"手工输入"}],"name":"zhixuan","parent":"houer","title":"后二直选"},{"childs":[{"mode":"houer","name":"fushi","parent":"zuxuan","title":"常规选号"}],"name":"zuxuan","parent":"houer","title":"后二组选"}],"name":"houer","title":"后二"},{"childs":[{"childs":[{"mode":"yixing","name":"fushi","parent":"dingweidan","title":"五星定位胆"}],"name":"dingweidan","parent":"yixing","title":"定位胆"}],"name":"yixing","title":"一星"},{"childs":[{"childs":[{"mode":"renxuan","name":"fushi","parent":"renerzhixuan","title":"常规选号"},{"mode":"renxuan","name":"danshi","parent":"renerzhixuan","title":"手工输入"}],"name":"renerzhixuan","parent":"renxuan","title":"任二直选"},{"childs":[{"mode":"renxuan","name":"fushi","parent":"renerzuxuan","title":"常规选号"}],"name":"renerzuxuan","parent":"renxuan","title":"任二组选"},{"childs":[{"mode":"renxuan","name":"fushi","parent":"rensanzhixuan","title":"常规选号"},{"mode":"renxuan","name":"danshi","parent":"rensanzhixuan","title":"手工输入"},{"mode":"renxuan","name":"hezhi","parent":"rensanzhixuan","title":"直选和值"}],"name":"rensanzhixuan","parent":"renxuan","title":"任三直选"},{"childs":[{"mode":"renxuan","name":"zusan","parent":"rensanzuxuan","title":"组三"},{"mode":"renxuan","name":"zuliu","parent":"rensanzuxuan","title":"组六"},{"mode":"renxuan","name":"hunhe","parent":"rensanzuxuan","title":"混合组选"}],"name":"rensanzuxuan","parent":"renxuan","title":"任三组选"},{"childs":[{"mode":"renxuan","name":"fushi","parent":"rensizhixuan","title":"常规选号"},{"mode":"renxuan","name":"danshi","parent":"rensizhixuan","title":"手工输入"}],"name":"rensizhixuan","parent":"renxuan","title":"任四直选"}],"name":"renxuan","title":"任选"}],"gameType":"10005","gameTypeCn":"五分彩","getBetAwardUrl":"/GameBet/getBetAward?lotteryCode=10005","getHandingChargeUrl":"/getHandingChargeUrl","getHotColdUrl":"/GameBet/frequency?lotteryCode=10005","getLotteryLogoPath":"/Images/game/ssc_logo/logo-wufen.png","getUserOrdersUrl":"/GameBet/getUserOrders?lotteryCode=10005","getUserPlansUrl":"/GameBet/getUserPlans?lotteryCode=10005","helpLink":"/helpLink","indexInit":"/indexInit","isLotteryStopSale":false,"lastNumberUrl":"/GameBet/lastNumber?lotteryCode=10005","lotteryId":"10005","poolBouns":"/poolBouns","queryGameUserAwardGroupByLotteryIdUrl":"/queryGameUserAwardGroupByLotteryIdUrl","queryUserBalUrl":"/Home/getuserMoney","saveProxyBetGameAwardGroupUrl":"/saveProxyBetGameAwardGroupUrl","sourceList":null,"sumbitUrl":"/GameBetSubmit/BettingCommand","trendChartUrl":"/trendChartUrl","uploadPath":"/uploadPath","userId":23006,"userLvl":"01","userName":"dang037","AdjustMaxBonus":1,"AdjustMinBonus":0,"AdjustShowMaxMode":false,"BasicReward":1952.0000,"BonusGruduation":0.0500,"CanAdjust":true,"FixedRewardMode":1952.0000,"getGameRewardUrl":"/GameBet/getGameReward?lotteryCode=10005","getHistoryOpenUrl":"/GameBet/getHistoryOpen?lotteryCode=10005","JiaoMaxMode":1952.0000,"PerBettingPrice":2,"PerGraduation":1,"RewardDown":1952.0000,"RewardUp":1952.0000,"userBonus":0.0000} ; 
    var defConfig = {
        //当前彩种名称
        gameType: gameConfigData['gameType'],
        gameTypeCn: gameConfigData['gameTypeCn'],
        lotteryId: gameConfigData['lotteryId'],
        awardGroups: gameConfigData['awardGroups'],
        userId: gameConfigData['userId'],
        userName: gameConfigData['userName'],
        userLvl: gameConfigData['userLvl'],
        backOutStartFee: gameConfigData['backOutStartFee'],
        backOutRadio: gameConfigData['backOutRadio'],
        isLotteryStopSale: gameConfigData['isLotteryStopSale'],
        helpLink: gameConfigData['helpLink'],
        sourceList: gameConfigData['sourceList']
    },
    instance;
    var pros = {
        init: function () {
            var me = this;
            me.types = gameConfigData['gameMethods'];
        },
        //获取玩法类型
        getTypes: function (isFilterClose) {
            return this.types;
        },
        getGameTypeCn: function () {
            return this.defConfig.gameTypeCn;
        },
        getDefaultMethod: function () {
            return gameConfigData['defaultMethod'];
        },
        //获取动态配置接口地址
        getDynamicConfigUrl: function () {
            return gameConfigData['dynamicConfigUrl'];
        },
        //获取单式上传接口地址
        getUploadPath: function () {
            return gameConfigData['uploadPath'];
        },
        //获取用户余额
        getUserBalUrl: function () {
            return gameConfigData['queryUserBalUrl'];
        },
        //获取投注页面显示订单接口地址
        getUserOrdersUrl: function () {
            return gameConfigData['getUserOrdersUrl'];
        },
        //获取单式上传接口地址
        getUserPlansUrl: function () {
            return gameConfigData['getUserPlansUrl'];
        },
        //获取历史开奖
        getHistoryOpenUrl: function () {
            return gameConfigData['getHistoryOpenUrl'];
        },
        //获取撤销手续费接口地址
        getHandingChargeUrl: function () {
            return gameConfigData['getHandingChargeUrl'];
        },
        //获取彩种logo地址
        getLotteryLogoPath: function () {
            return gameConfigData['getLotteryLogoPath'];
        },
        //获取玩法走势图接口地址
        trendChartUrl: function () {
            return gameConfigData['trendChartUrl'];
        },
        //查询玩法描述和默认冷热球及用户投注方式奖金接口地址
        getBetAwardUrl: function () {
            return gameConfigData['getBetAwardUrl'];
        },
        //获取冷热遗漏接口地址
        getHotColdUrl: function () {
            return gameConfigData['getHotColdUrl'];
        },
        //查询奖金组
        getQueryGameUserAwardGroupByLotteryIdUrl: function () {
            return gameConfigData['queryGameUserAwardGroupByLotteryIdUrl'];
        },
        //保存代理投注奖金组
        getSaveProxyBetGameAwardGroupUrl: function () {
            return gameConfigData['saveProxyBetGameAwardGroupUrl'];
        },
        //获取投注提交接口地址
        submitUrl: function () {
            return gameConfigData['sumbitUrl'];
        },
        //获取首页接口
        indexInitUrl: function () {
            return gameConfigData['indexInit'];
        },
        //获取最新开奖号码
        lastNumberUrl: function () {
            return gameConfigData['lastNumberUrl'];
        },
        //获取CanAdjust
        CanAdjust: function () {
            return gameConfigData['CanAdjust'];
        },
        //获取BasicReward
        BasicReward: function () {
            return gameConfigData['BasicReward'];
        },
        //获取PerGraduation
        PerGraduation: function () {
            return gameConfigData['PerGraduation'];
        },
        //获取PerBettingPrice
        PerBettingPrice: function () {
            return gameConfigData['PerBettingPrice'];
        },
        //获取游戏返点接口
        getUserBonus: function () {
            return gameConfigData['userBonus'];
        },
        //获取用户返点
        getGameRewardUrl: function () {
            return gameConfigData['getGameRewardUrl'];
        },
        //获取BonusGruduation
        BonusGruduation: function () {
            return gameConfigData['BonusGruduation'];
        },
        //获取AdjustMaxBonus
        AdjustMaxBonus: function () {
            return gameConfigData['AdjustMaxBonus'];
        },
        //AdjustMinBonus
        AdjustMinBonus: function () {
            return gameConfigData['AdjustMinBonus'];
        },
        //JiaoMaxMode
        JiaoMaxMode: function () {
            return gameConfigData['JiaoMaxMode'];
        },
        //FenMaxMode
        FenMaxMode: function () {
            return gameConfigData['FenMaxMode'];
        },
        //RewardUp
        RewardUp: function () {
            return gameConfigData['RewardUp'];
        },
        //RewardDown
        RewardDown: function () {
            return gameConfigData['RewardDown'];
        },
        //AdjustShowMaxMode
        AdjustShowMaxMode: function () {
            return gameConfigData['AdjustShowMaxMode'];
        },
        //FixedRewardMode
        FixedRewardMode: function () {
            return gameConfigData['FixedRewardMode'];
        },
        //name  wuxing.zhixuan.fushi
        getTitleByName: function (name) {
            var me = this,
                nameArr = name.split('.'),
                nameLen = nameArr.length,
                types = me.types,
                i = 0,
                len = types.length,
                i2,
                len2,
                i3,
                len3,
                tempArr = [],
                result = [];
            //循环一级
            for (; i < len; i++) {
                if (types[i]['name'] == nameArr[0]) {
                    if (gameConfigData['gameType'].indexOf('115') < 0) {
                        result.push(types[i]['title'].replace(/>&nbsp;/g, ''));
                    }
                    if (nameLen > 1 && types[i]['childs'].length > 0) {
                        tempArr = types[i]['childs'];
                        len2 = tempArr.length;
                        //循环二级
                        for (i2 = 0; i2 < len2; i2++) {
                            //console.log(tempArr[i2]['name']);
                            if (tempArr[i2]['name'] == nameArr[1]) {
                                if (gameConfigData['gameType'].indexOf('115') > 0) {
                                    result.push(tempArr[i2]['title'].replace(/&nbsp;/g, ''));
                                }
                                if (nameLen > 2 && tempArr[i2]['childs'].length > 0) {
                                    tempArr = tempArr[i2]['childs'];
                                    len3 = tempArr.length;
                                    //循环三级
                                    for (i3 = 0; i3 < len3; i3++) {
                                        if (tempArr[i3]['name'] == nameArr[2]) {
                                            if (tempArr[i3]['headline']) {
                                                return tempArr[i3]['headline'];
                                            }
                                            result.push(tempArr[i3]['title'].replace(/&nbsp;/g, ''));
                                            return result;
                                        }
                                    }
                                } else {
                                    return result;
                                }
                            }
                        }
                    } else {
                        return result;
                    }
                }
            }
            return '';
        }

    };

    var Main = host.Class(pros, Event);
    Main.defConfig = defConfig;
    Main.getInstance = function (cfg) {
        return instance || (instance = new Main(cfg));
    };
    host.Games.SSC[name] = Main;

})(phoenix, "Config", phoenix.Event);
