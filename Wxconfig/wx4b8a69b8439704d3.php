<?php return array (
  'WEIXINPAY_STATUS' => 'true',
  'WAIMAICONFIG' => '[]',
  'WEIXININDEXBUTTON' => 
  array (
    'zizhu' => 
    array (
      'status' => true,
      'text' => '自助点餐',
      'icon' => 'http://f.xinyisoft.org/7e0ee3bfffc9639c006fe8c1c972b608_480',
    ),
    'waimai' => 
    array (
      'status' => true,
      'text' => '外卖点餐',
      'icon' => 'http://f.xinyisoft.org/f91b2384d99fa67bcbd0713da2d27e3f_480',
    ),
    'jifenshangcheng' => 
    array (
      'status' => true,
      'text' => '积分商城',
      'icon' => 'http://f.xinyisoft.org/f25c8b3dc732e9bc7fd4b0b569200086_480',
    ),
    'mycoupons' => 
    array (
      'status' => true,
      'text' => '我的券码',
      'icon' => 'http://f.xinyisoft.org/de9f7743969400917abd5ac69d0a9514_480',
    ),
    'myorder' => 
    array (
      'status' => true,
      'text' => '我的订单',
      'icon' => 'http://f.xinyisoft.org/e267cdf6e412b05ae5be1244201e6cf2_480',
    ),
    'mycaiwuliushui' => 
    array (
      'status' => true,
      'text' => '财务流水',
      'icon' => 'http://f.xinyisoft.org/b63a5b51c3d456e352b9eb1161d86a89_480',
    ),
    'myjifenliushui' => 
    array (
      'status' => true,
      'text' => '积分流水',
      'icon' => 'http://f.xinyisoft.org/a744c9f3b0ab351ccc8bc066a807b674_480',
    ),
    'guanggao' => 
    array (
      'status' => true,
      'text' => '广告开启',
      'icon' => 'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480',
    ),
    'background' => 'http://f.xinyisoft.org/c237ed8673820a03880f29b42bcbcf16',
    'payqrcode' => 
    array (
      'status' => true,
      'text' => '支付码',
      'icon' => 'http://f.xinyisoft.org/880bf7704300d3611e5d565e286b1af7_480',
    ),
    'chongzhi' => 
    array (
      'status' => true,
      'text' => '账户充值',
      'icon' => 'http://f.xinyisoft.org/ee3c82b783c82bc07ac8c7fef83e89cb_480',
    ),
  ),
  'ZIZHUCONFIG' => 
  array (
    'SHOPPING_YYTTIME' => 1,
    'SHOPPING_STIME' => '09:00',
    'SHOPPING_TTIME' => '20:00',
    'SHOPPING_DATUCONFIG' => false,
    'PUBLIC_FAPIAOCONFIG' => false,
  ),
  'ZIZHUPAYTYPECONFIG' => 
  array (
    'YEPAYTYPE' => 
    array (
      'ptid' => '96',
      'paytype' => '0',
      'member' => '0',
      'payname' => '余额支付',
    ),
    'WXPAYTYPE' => 
    array (
      'ptid' => '66',
      'paytype' => '2',
      'member' => '0',
      'payname' => '微信支付',
    ),
  ),
  'WEIXINTEMPLATEMSG' => 
  array (
    'status' => false,
    'industry' => 
    array (
      'primary_industry' => 
      array (
        'first_class' => '餐饮',
        'second_class' => '餐饮',
      ),
      'secondary_industry' => 
      array (
        'first_class' => '消费品',
        'second_class' => '消费品',
      ),
    ),
    'msglist' => 
    array (
      'TM00050' => 
      array (
        'template_code' => 'TM00050',
        'template_id' => '',
        'title' => '购买成功通知',
        'content' => '',
      ),
      'TM00051' => 
      array (
        'template_code' => 'TM00051',
        'template_id' => '',
        'title' => '预订成功通知',
        'content' => '',
      ),
      'TM00053' => 
      array (
        'template_code' => 'TM00053',
        'template_id' => 'VD6tnnPEYa4V3czxUwhcvQFOrcw9LHBiqkI0wCZkGlk',
        'title' => '成为会员通知',
        'content' => '{{first.DATA}}

会员号：{{cardNumber.DATA}}
{{type.DATA}}地址：{{address.DATA}}
登记姓名：{{VIPName.DATA}}
登记手机号：{{VIPPhone.DATA}}
有效期：{{expDate.DATA}}
{{remark.DATA}}',
        'example' => '您好，您已成为微信某某店会员。

会员号：87457
商户地址：微信某某店【9店通用】
登记姓名：邹某某
登记手机号：13912345678
有效期：2014年9月30日
如有疑问，请咨询13912345678。',
      ),
      'TM00054' => 
      array (
        'template_code' => 'TM00054',
        'template_id' => '',
        'title' => '会员到期提醒',
        'content' => '',
      ),
      'TM00055' => 
      array (
        'template_code' => 'TM00055',
        'template_id' => '',
        'title' => '会员充值通知',
        'content' => '',
      ),
      'TM00056' => 
      array (
        'template_code' => 'TM00056',
        'template_id' => 'xQ161BbVzfhItGRrVekcdSpEvPcSyw-6ojQ-rhtFJXY',
        'title' => '会员消费通知',
        'content' => '{{first.DATA}}
消费时间：{{keyword1.DATA}}
消费门店：{{keyword2.DATA}}
消费金额：{{keyword3.DATA}}
当前余额：{{keyword4.DATA}}
获得积分：{{keyword5.DATA}}
{{remark.DATA}}',
        'example' => '您使用会员卡当面付功能消费成功
消费时间：2014年12月25日 18:23
消费门店：中山路店
消费金额：120元
当前余额：2元
获得积分：120分
客服电话：400-888-8888',
      ),
      'OPENTM402104200' => 
      array (
        'template_code' => 'OPENTM402104200',
        'template_id' => '',
        'title' => '订单变更通知',
        'content' => '',
      ),
      'OPENTM207582651' => 
      array (
        'template_code' => 'OPENTM207582651',
        'template_id' => '',
        'title' => '店内点餐提醒',
        'content' => '',
      ),
      'OPENTM200898560' => 
      array (
        'template_code' => 'OPENTM200898560',
        'template_id' => '',
        'title' => '积分变更提醒',
        'content' => '',
        'example' => '',
      ),
    ),
  ),
  'NICK_NAME' => '和合谷',
  'HEAD_IMG' => 'http://wx.qlogo.cn/mmopen/ib3nAoRWiaG7SXjHEBssgibduk6FrAmiaHj7zSicWcJ0aQMTnNbrlnxFwSRyIavBogpyvdoKZxVlmPEjq1X0v6y6ImlialwH85lM1Q/0',
  'PRINCIPAL_NAME' => '北京和合谷餐饮管理有限公司',
  'QRCODE_URL' => 'http://mmbiz.qpic.cn/mmbiz/8NWA7VwYsuWd1sl0EliaFiajzTHibBac29MKb1aiczPbuI6GmSVDSgVZV4MOSiaBjtJLdwwx4ZGjQQgBZjHGaeeSXPA/0',
  'SIGNATURE' => '和合谷4009009009外卖订餐服务开通啦！现在可拨打4009009009电话订餐，或通过网上订餐。',
  'BUSINESSNAME' => '北京和合谷',
  'XINYITOKEN' => '09460a5373115023bad87cc2cfc5410a67066e6f',
  'ISWESOFT' => '0',
);