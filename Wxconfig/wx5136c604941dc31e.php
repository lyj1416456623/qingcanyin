<?php return array (
  'WEIXINPAY_STATUS' => 'true',
  'WAIMAICONFIG' => 
  array (
    'DELIVERY_YYSTIME' => '45',
    'DELIVERY_YYTTIME' => '7',
    'DELIVERY_STIME' => '09:00',
    'DELIVERY_YTIME' => '21:00',
    'DELIVERY_PRICE_MIN' => '0.11',
    'DELIVERY_PRICE' => '89',
    'DELIVERY_GOODS' => 
    array (
      'goodsid' => '8',
      'goodsprice' => '0.01',
      'goodsname' => '外送费',
    ),
    'DELIVERY_PACKBOX' => 
    array (
      'goodsid' => '7',
      'goodsprice' => '0.01',
      'goodsname' => '打包盒',
    ),
    'DELIVERY_DATUCONFIG' => false,
    'PUBLIC_FAPIAOCONFIG' => false,
  ),
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
      'icon' => 'http://f.xinyisoft.org/45f2c035749153a2e61e7407f706cf69_480',
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
    'background' => 'http://f.xinyisoft.org/28edc841146bdaae03dccdacd693b145',
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
    'guanggaodata' => 
    array (
    ),
  ),
  'ZIZHUPAYTYPECONFIG' => 
  array (
    'YEPAYTYPE' => 
    array (
      'ptid' => '1',
      'paytype' => '0',
      'member' => '0',
      'payname' => '余额支付',
    ),
    'WXPAYTYPE' => 
    array (
      'ptid' => '5',
      'paytype' => '2',
      'member' => '0',
      'payname' => '微信支付',
    ),
  ),
  'WAIMAIPAYTYPECONFIG' => 
  array (
    'YEPAYTYPE' => 
    array (
      'ptid' => '1',
      'paytype' => '0',
      'member' => '0',
      'payname' => '余额支付',
    ),
    'WXPAYTYPE' => 
    array (
      'ptid' => '5',
      'paytype' => '2',
      'member' => '0',
      'payname' => '微信支付',
    ),
  ),
  'ZIZHUCONFIG' => 
  array (
    'SHOPPING_YYTTIME' => '5',
    'SHOPPING_STIME' => '09:00',
    'SHOPPING_TTIME' => '22:24',
    'SHOPPING_DATUCONFIG' => false,
    'PUBLIC_FAPIAOCONFIG' => true,
  ),
  'WEIXINTEMPLATEMSG' => 
  array (
    'status' => false,
    'industry' => 
    array (
      'primary_industry' => 
      array (
        'first_class' => 'IT科技',
        'second_class' => '互联网|电子商务',
      ),
      'secondary_industry' => 
      array (
        'first_class' => '餐饮',
        'second_class' => '餐饮',
      ),
    ),
    'msglist' => 
    array (
      'TM00050' => 
      array (
        'template_code' => 'TM00050',
        'template_id' => 't4jwbRG7qzzKMTaj99Nc-ripqIx5CpfZ4-ep0Xghutg',
        'title' => '购买成功通知',
        'content' => '您好，您已购买成功。

{{productType.DATA}}：{{name.DATA}}
购买数量：{{number.DATA}}
有效期：{{expDate.DATA}}
{{remark.DATA}}',
        'example' => '您好，您已购买成功。

商品名：微信餐饮店50元代金券
购买数量：1份
有效期：2014年9月30日
如有疑问，请咨询13912345678。',
      ),
      'TM00051' => 
      array (
        'template_code' => 'TM00051',
        'template_id' => '7F8uQmB2erLmds3JpbAkWopOH4Zfc32lmp3f_9y18r0',
        'title' => '预订成功通知',
        'content' => '{{first.DATA}}

{{productType.DATA}}：{{name.DATA}}
预订数量：{{number.DATA}}
有效期：{{expDate.DATA}}
{{remark.DATA}}',
        'example' => '您好，您已预订成功，请尽快付款。

商品名：微信餐饮店全家福席
预订数量：2桌
有效期：2013年10月1日
如有疑问，请咨询13912345678。',
      ),
      'TM00053' => 
      array (
        'template_code' => 'TM00053',
        'template_id' => '_2iOtDwrvdQSwqNhC_jl2MkxFfq0WeWNiwMn_Zok6ew',
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
        'template_id' => 'cncGbJyYiYBFcCGuDLFa1TZRMTr8iCgekc5pLlwO6nw',
        'title' => '会员到期提醒',
        'content' => '{{first.DATA}}

您的{{name.DATA}}有效期至{{expDate.DATA}}
{{remark.DATA}}',
        'example' => '您好，您的会员即将到期，请您注意。

您的微信某某店会员有效期至2013年9月12日，请注意时间，防止过期失效。',
      ),
      'TM00055' => 
      array (
        'template_code' => 'TM00055',
        'template_id' => '08KSC-t59TttsoBxeQhzXcHc29XwgRvRqMxqdeqpwFs',
        'title' => '会员充值通知',
        'content' => '{{first.DATA}}

{{accountType.DATA}}：{{account.DATA}}
充值金额：{{amount.DATA}}
充值状态：{{result.DATA}}
{{remark.DATA}}',
        'example' => '您好，您已成功进行会员卡充值。

会员卡号：11912345678
充值金额：50元
充值状态：充值成功
如有疑问，请致电13912345678联系我们。',
      ),
      'TM00056' => 
      array (
        'template_code' => 'TM00056',
        'template_id' => 'hZihFyu1yNNrhLqd6I0AVuqte-ohO12MX-xKyvDR218',
        'title' => '会员消费通知',
        'content' => '您好，您已成功消费。

{{productType.DATA}}：{{name.DATA}}
消费{{accountType.DATA}}：{{account.DATA}}
消费时间：{{time.DATA}}
{{remark.DATA}}',
        'example' => '您好，您已成功消费。

商品名：微信某某店某商品
消费会员卡号：11912345678
消费时间：2013年8月20日 20:38
您可以回复文字或语音对该商品及商家进行评价哦~',
      ),
      'OPENTM402104200' => 
      array (
        'template_code' => 'OPENTM402104200',
        'template_id' => 'sCNEc3tGWRu7rzpItamrY4PFqRpWRmCl2sYmwqsjgaQ',
        'title' => '订单变更通知',
        'content' => '{{first.DATA}}
订单金额：{{keyword1.DATA}}
下单时间：{{keyword2.DATA}}
订单状态：{{keyword3.DATA}}
{{remark.DATA}}',
        'example' => '您好，您的订单已发生变动
订单金额：220.00
下单时间：2016年5月1日
订单状态：待确认
请您确认新的订单情况',
      ),
      'OPENTM207582651' => 
      array (
        'template_code' => 'OPENTM207582651',
        'template_id' => 'yFs4DcOK3LFtAU55Cb3V65jrNdTmdv556P9JTDF8dQ4',
        'title' => '店内点餐提醒',
        'content' => '{{first.DATA}}
取餐 编号：{{keyword1.DATA}}
餐厅名称：{{keyword2.DATA}}
点餐时间：{{keyword3.DATA}}
订单内容：{{keyword4.DATA}}
订单金额：{{keyword5.DATA}}
{{remark.DATA}}',
        'example' => '订单已确认，凭取餐编号前台领餐。
取餐编号：00001
餐厅名称：秦一口主题餐厅
点餐时间：201509071004
订单内容：传统擀面皮1份
订单金额：6元
感谢您使用秦一口线上点餐。',
      ),
      'OPENTM200898560' => 
      array (
        'template_code' => 'OPENTM200898560',
        'template_id' => 'IAF7k-JHyfLPerZaMCnoNwreeJDgs9wh5V7yPT_-i9A',
        'title' => '积分变更提醒',
        'content' => '{{first.DATA}}
会员姓名：{{keyword1.DATA}}
会员账号：{{keyword2.DATA}}
积分变更：{{keyword3.DATA}}
剩余积分：{{keyword4.DATA}}
{{remark.DATA}}',
        'example' => '您好，您的会员积分信息有了新的变更。
会员姓名：张三
会员账号：13289028902
积分变更：您有200积分入户哦！
剩余积分：200
如有疑问，请拨打123456789.',
      ),
    ),
  ),
  'PUBLIC_FAPIAOCONFIG' => true,
  'APPLET' => '{"APPLET_STATUS":"false","APPLET_ACCOUNT":"666223"}',
  'NICK_NAME' => '芯易科技',
  'HEAD_IMG' => 'http://wx.qlogo.cn/mmopen/a5bNMialnu7KTGNFprJVftPcySgw3dIzefQMRzYFvsaS3DZcVt2SJcxQOS12rHelP8bne2d6W7uosyvI2vWiazCc40kuFaepox/0',
  'PRINCIPAL_NAME' => '芯易科技(北京)有限公司',
  'QRCODE_URL' => 'http://mmbiz.qpic.cn/mmbiz/Sic7icDadBFIic5kLpaSjEiauVClgyE69yNVobIDyKzk0vRQmL2LXEkbdR28h9apvcTjKZKWVicvZXWAr5ibWclgic6rw/0',
  'SIGNATURE' => '企业业务宣传',
  'BUSINESSNAME' => '餐饮',
  'XINYITOKEN' => '150948cebc6557c401c0aa8724c680966ae6d2b9',
  'ISWESOFT' => '0',
);