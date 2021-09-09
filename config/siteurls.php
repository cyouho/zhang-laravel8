<?php
return [
    'imageSearch' => [
        'homePageHost' => [
            'baidu'  => 'https://graph.baidu.com/',
            'onesix' => 'https://www.1688.com/'
        ],
        'postHost' => [
            'baidu'  => 'https://graph.baidu.com/upload',
            'onesix' => [
                'timestamp' => 'https://open-s.1688.com/openservice/.htm?',
                'sign'      => 'https://open-s.1688.com/openservice/ossDataService',
                'img'       => 'https://cbusearch.oss-cn-shanghai.aliyuncs.com/'
            ]
        ],
        'resualtHost' => [
            'baidu'  => 'https://graph.baidu.com/s?sign=',
            'onesix' => 'https://s.1688.com/youyuan/index.htm?tab=imageSearch&imageType=oss&imageAddress='
        ]
    ]
];
