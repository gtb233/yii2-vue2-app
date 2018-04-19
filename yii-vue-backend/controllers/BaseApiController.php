<?php
/**
 * 基础类
 */
namespace app\controllers;

use yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\web\Response;
use yii\rest\Controller;

class BaseApiController extends Controller
{
    public function behaviors()
    {
        //跨域处理
        $headers = Yii::$app->response->headers;
        $headers->add('Access-Control-Allow-Origin', '*');

        return yii\helpers\ArrayHelper::merge([
            [
                // 跨域资源共享 CORS 机制允许一个网页的许多资源 这些资源可以通过其他域名访问获取。
                'class' => Cors::class, //目前无法实现，原因未知
                'cors' => [
                    'Access-Control-Request-Method' => ['*'],  #允许动作数组
                    'Access-Control-Request-Headers' =>['*'],  #允许请求头部数组 例 ['X-Request-With'] 指定类型头部
                    'Access-Control-Allow-Credentials' => true,  #定义当前请求是否使用证书
                    'Access-Control-Max-Age' => 3600,  #定义请求的有效时间
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'] //指定其他自定义字段
                ],
                'actions' => [
                    'login' => [
                        'Access-Control-Allow-Credentials' => false, // 表示是否可以将对请求的响应暴露给页面。
                    ]
                ]
            ],
            // ContentNegotiator支持响应内容格式处理和语言处理。
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ], parent::behaviors());
    }

    public function _success($data = [],$type='')
    {
        header('Content-Type: application/json');
        $resuledata = json_encode($this->getResult('0001', $data,$type),JSON_UNESCAPED_UNICODE) ;
        echo $resuledata;
        exit();
    }

    public function _error($resultCode, $resultDesc = '',$type='')
    {
        header('Content-Type: application/json');
        $resuledata = json_encode($this->getResult($resultCode, $resultDesc,$type),JSON_UNESCAPED_UNICODE) ;

        echo $resuledata;
        exit();
    }

    public function getResult($resultCode,  $data,$type='')
    {
        $result = [
            'resultCode' => $resultCode,
            'resultDesc' => '',
            'resultData' => '',
            'actionType' => $type,
        ];
        if(is_string($data)||is_numeric($data))
        {
            $result['resultDesc'] = $data;
        }
        else
        {
            $result['resultData'] = $data;
        }

        return ['Response'=>$result];
    }



}