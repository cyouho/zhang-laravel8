<?php
return [
    'imageSearch' => [
        'baidu' => [
            'homePageHost' => 'https://graph.baidu.com/',
            'postHost'     => 'https://graph.baidu.com/upload',
            'resualtHost'  => 'https://graph.baidu.com/s?sign='
        ],
        'onesix' => [
            'homePageHost' => 'https://www.1688.com/',
            'postHost'     => [
                'timestamp' => 'https://open-s.1688.com/openservice/.htm?',
                'sign'      => 'https://open-s.1688.com/openservice/ossDataService',
                'img'       => 'https://cbusearch.oss-cn-shanghai.aliyuncs.com/'
            ],
            'resualtHost'  => 'https://s.1688.com/youyuan/index.htm?tab=imageSearch&imageType=oss&imageAddress=',
            'serviceIds'   => 'cbu.searchweb.config.system.currenttime'
        ],
        'alibaba' => [
            'homePageHost' => 'https://www.alibaba.com/',
            'postHost'     => 'https://kfupload.alibaba.com/mupload',
            'resultHost'   => 'https://www.alibaba.com/picture/search.htm?imageType=https://sc01.alicdn.com&escapeQp=true&imageAddress=/kf/'
        ],
        'taobao' => [
            'homePageHost' => 'https://taobao.com',
            'postHost'     => 'https://s.taobao.com/image',
            'resultHost'   => 'https://s.taobao.com/search?tfsid='
        ]
    ]
];
