<?php
/**
 * Created by PhpStorm.
 * User: XiaoSong
 * Date: 2018/7/25
 * Time: 10:49
 */

define('STATUS_ON_LINE',1); //上线状态
define('STATUS_OFF_LINE',0);//下线状态

define('SIGN_ON',1);//已签到
define('SIGN_OFF',0);//未签到

define('DEFAULT_F9P_BAUDRATE',115200);
define('DEFAULT_F9P_GNSS_SYSTEM','GPS');
define('DEFAULT_F9P_RATE',5);
define('DEFAULT_F9P_COLDSTART',false);
define('DEFAULT_F9P_NMEA_GGA',true);
define('DEFAULT_F9P_NMEA_VTG',true);
define('DEFAULT_F9P_DIFFERENCE_ADDRESS','default_string');
define('DEFAULT_IMU_RATE',100);
define('DEFAULT_BAROMETER_RATE',5);
define('DEFAULT_CONTROL_UWB',true);
define('DEFAULT_CONTROL_WIFI',false);
define('DEFAULT_CONTROL_TYPEC',false);
define('DEFAULT_CONTROL_BLE',false);
define('DEFAULT_CONTROL_F9P',true);
define('DEFAULT_CONTROL_BAROMETA',true);

define('AREA_SOUTH',1);//1 南区
define('AREA_NORTH',2);//2 北区
define('AREA_TOP',3);//3 顶部

define('REGION_ID_1_6_16_18_21_22',101);//
define('REGION_ID_2_7_19',102);//
define('REGION_ID_3_8_17_20',103);//
define('REGION_ID_4_9_23',104);//
define('REGION_ID_5_24',105);

define('TPNS_URL','https://api.tpns.sh.tencent.com/v3/push/app');//极光APPKEY()
define('TPNS_ACCESS_ID','1580006446');//极光APPKEY()
define('TPNS_ACCESS_KEY','AGBOVAS58OT7');//极光masterSecret()
define('TPNS_SECRET_KEY','6fdb65d43fb14b3a2dbfd32287a8b2dd');//极光masterSecret()

define('SOUNDS_PREFIX','http://www.bdips.cn:5619/storage/sounds/');//极光masterSecret()
define('IMG_PREFIX','http://www.bdips.cn:5619/storage/img/');//极光masterSecret()

define('TPNS_NEW_EVENT','1');
define('TPNS_NEW_SOUNDS','2');

define('YSY_GET_IMG_URL','https://open.ys7.com/api/lapp/device/capture');//
define('YSY_GET_TOKEN','https://open.ys7.com/api/lapp/token/get');//
define('YSY_APP_KEY','01516ddd41d94c9aa7086f0d4c99f2c6');//
define('YSY_APP_SECRET','f4b46b1e8b7630e20c840644109d0cb7');//
define('YSY_DEVICE_ID_1','G28674405');
define('YSY_DEVICE_ID_2','G14026592');
define('YSY_DEVICE_ID_3','G14025706');

define('INFLUXDB_URL_BAT2','http://61.240.144.70:2286');
define('INFLUXDB_URL_BAT1','http://61.240.144.70:1586');
define('INFLUXDB_URL','https://ts-8vbw34w5luy4m55i6.influxdata.tsdb.aliyuncs.com:8086');

define('JWT_TOKEN_KEY', '1gHuiop975cdashyex9Ud23ldsvm2Xq'); //密钥
define('AES_KEY', '1234567890123456'); //密钥
define('AES_IV', '1234567890123456'); //密钥



