<?php
return [
    'enable'  => true,
    /*
     * 命令行执行
     * alone:cli [method] ...[parameter]
     */
    'cli'     => "\app\alone\Cli",

    /*
     * 命令设置
     * alone:task start
     * alone:task start -d
     * alone:task stop
     * alone:task restart
     * alone:task status
     * alone:task reload
     * alone:task connections
     */
    'task'    => [
        /*
         * 分组启动
         * alone:task start       group
         * alone:task start       group -d
         * alone:task stop        group
         * alone:task restart     group
         * alone:task status      group
         * alone:task reload      group
         * alone:task connections group
         * alone:task add group   [name] [type]
         * alone:task del group   [name]
         */
        'group' => [
            /*
             * 扫描目录绝对路径(生成和读取都在此处)
             */
            'path'              => base_path('app/alone/task'),
            /*
             * 守护进程时是否监控
             */
            'monitor_daemonize' => true,
            /*
             * 自动重启设置,false关闭,int=多久重启一次,string=crontab
             */
            'restart'           => false
        ]
    ],

    /*
     * 自定义进程配置
     */
    'process' => [
        /*
         * 开启状态
         */
        'status'            => true,
        /*
         * 守护进程时是否监控
         */
        'monitor_daemonize' => true,
        /*
         * 静态变量或者静态方法名
         */
        'config'            => "aloneConfig",
        /*
         * 扫描目录绝对路径(生成和读取都在此处)
         */
        'path'              => base_path('app/alone/process'),
        /*
         * 自动重启设置,false关闭,int=多久重启一次,string=crontab
         */
        'restart'           => '',
    ]
];