<?php

class DeliveryAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );
		
		if ((stripos($this->msg, "快递") !== false || stripos($this->msg, "物流") !== false || stripos($this->msg, "速递") !== false) && $str1 != '翻译')
			return true;
		
		return false;
	}

	function handle(){

		$this->msg = str_replace("快递", " ", $this->msg);
		$this->msg = str_replace("物流", " ", $this->msg);
		$this->msg = str_replace("速递", " ", $this->msg);
		$str_key1 = strtok($this->msg, " ");;
		$str_key2 = str_replace($str_key1." ", "", $this->msg);

		$str_key1 = $this->pinyin($str_key1);

		$data = $this->delivery_search ($str_key1, $str_key2);
		
		if ($data->errCode == 0) {
			foreach ( $data->data as $value ){
				$contentStr .= $value->time . $value->context . "\n";
			}
		} else {
			$contentStr = $data->message;
		}
	
		if ($contentStr == "")
		{
				$contentStr = "单号不正确，请重新输入~";
		}
			
		return parent::getTextXml($contentStr);
	}
  
	private function pinyin($key){
		$expresses=array (
  'aae' => 'AAE',
  'anjie' => '安捷',
  'anxinda' => '安信达',
  'aramex' => 'Aramex',
  'balunzhi' => '巴伦支',
  'baotongda' => '宝通达',
  'benteng' => '成都奔腾',
  'cces' => 'CCES',
  'changtong' => '长通',
  'chengguang' => '程光',
  'chengji' => '城际',
  'chengshi100' => '城市100',
  'chuanxi' => '传喜',
  'chuanzhi' => '传志',
  'chukouyi' => '出口易',
  'citylink' => 'CityLinkExpress',
  'coe' => '东方',
  'cszx' => '城市之星',
  'datian' => '大田',
  'dayang' => '大洋',
  'debang' => '德邦',
  'dechuang' => '德创',
  'dhl' => 'DHL',
  'diantong' => '店通',
  'dida' => '递达',
  'dingdong' => '叮咚',
  'disifang' => '递四方',
  'dpex' => 'DPEX',
  'dsu' => 'D速',
  'ees' => '百福东方',
  'ems' => 'EMS',
  'fanyu' => '凡宇',
  'fardar' => 'Fardar',
  'fedex' => '国际Fedex',
  'fedexcn' => 'Fedex国内',
  'feibang' => '飞邦',
  'feibao' => '飞豹',
  'feihang' => '原飞航',
  'feihu' => '飞狐',
  'feite' => '飞特',
  'feiyuan' => '飞远',
  'fengda' => '丰达',
  'fkd' => '飞康达',
  'gdyz' => '广东邮政',
  'gnxb' => '邮政国内小包',
  'gongsuda' => '共速达',
  'guotong' => '国通',
  'haihong' => '山东海红',
  'haimeng' => '海盟',
  'haosheng' => '昊盛',
  'hebeijianhua' => '河北建华',
  'henglu' => '恒路',
  'huacheng' => '华诚',
  'huahan' => '华翰',
  'huaqi' => '华企',
  'huaxialong' => '华夏龙',
  'huayu' => '天地华宇',
  'huiqiang' => '汇强',
  'huitong' => '汇通',
  'hwhq' => '海外环球',
  'jiaji' => '佳吉',
  'jiayi' => '佳怡',
  'jiayunmei' => '加运美',
  'jinda' => '金大',
  'jingdong' => '京东',
  'jingguang' => '京广',
  'jinyue' => '晋越',
  'jixianda' => '急先达',
  'jldt' => '嘉里大通',
  'kangli' => '康力',
  'kcs' => '顺鑫',
  'kcs' => 'KCS',
  'kuaijie' => '快捷',
  'kuanrong' => '宽容',
  'kuayue' => '跨越',
  'lejiedi' => '乐捷递',
  'lianhaotong' => '联昊通',
  'lijisong' => '成都立即送',
  'longbang' => '龙邦',
  'minbang' => '民邦',
  'mingliang' => '明亮',
  'minsheng' => '闽盛',
  'nell' => '尼尔',
  'nengda' => '港中能达',
  'ocs' => 'OCS',
  'pinganda' => '平安达',
  'pingyou' => '平邮',
   'pingyou' => '中国邮政',
  'pinsu' => '品速心达',
  'quanchen' => '全晨',
  'quanfeng' => '全峰',
  'quanjitong' => '全际通',
  'quanritong' => '全日通',
  'quanyi' => '全一',
  'rpx' => 'RPX保时达',
  'rufeng' => '如风达',
  'saiaodi' => '赛澳递',
  'santai' => '三态',
  'scs' => 'SCS',
  'scs' => '伟邦',
  'shengan' => '圣安',
  'shengfeng' => '盛丰',
  'shenghui' => '盛辉',
  'shentong' => '申通',
  'shunfeng' => '顺丰',
  'suchengzhaipei' => '速呈宅配',
  'suijia' => '穗佳',
  'sure' => '速尔',
  'tiantian' => '天天',
  'tnt' => 'TNT',
  'tongcheng' => '通成',
  'tonghe' => '通和天下',
  'ups' => 'UPS',
  'usps' => 'USPS',
  'wanbo' => '万博',
  'wanjia' => '万家',
  'weitepai' => '微特派',
  'xianglong' => '祥龙运通',
  'xinbang' => '新邦',
  'xinfeng' => '信丰',
  'xingchengzhaipei' => '星程宅配',
  'xiyoute' => '希优特',
  'yad' => '源安达',
  'yafeng' => '亚风',
  'yibang' => '一邦',
  'yinjie' => '银捷',
  'yinsu' => '音素',
  'yishunhang' => '亿顺航',
  'yousu' => '优速',
  'ytfh' => '北京一统飞鸿',
  'yuancheng' => '远成',
  'yuantong' => '圆通',
  'yuanzhi' => '元智捷诚',
  'yuefeng' => '越丰',
  'yumeijie' => '誉美捷',
  'yunda' => '韵达',
  'yuntong' => '运通中港',
  'yuxin' => '宇鑫',
  'ywfex' => '源伟丰',
  'zhaijisong' => '宅急送',
  'zhengzhoujianhua' => '郑州建华',
  'zhima' => '芝麻开门',
  'zhongtian' => '济南中天万运',
  'zhongtian' => '中天',
  'zhongtie' => '中铁',
  'zhongtong' => '中通',
  'zhongxinda' => '忠信达',
  'zhongyou' => '中邮',
);
		$ch = curl_init();
		while (list($com, $val) = each($expresses))
		{
			if ($val == $key){
				$key = $com;
				break;
			}
		}
		return $key;
	}
	
	private function delivery_search($com, $num) {
		$uri = "http://api.ickd.cn/";                    //快递查询api的uri
        $authId = "E077B7C6D3F2DA9C92D13D7BD36CD171";    //个人注册的key
        $type = "json";                                  //api返回值类型
        $encode = "utf8";                                //数据返回的字符集
		$url = $uri . "?com=" . $com . "&nu=" . $num . "&id=" . $authId . "&type=" . $type . "&encode=" . $encode;

		$json = sendGet ( $url );
		$text = json_decode ( $json );
		return $text;
	}
}

?>