<?php

namespace inquid\panel;

use app\components\Utilities;
use Yii;
use yii\base\Event;
use yii\base\UserException;
use yii\base\View;
use yii\base\ViewEvent;
use yii\debug\Panel;
use yii\helpers\Html;


class InquidPanel extends Panel
{
    private $_viewFiles = [];
    
    public function init()
    {
        parent::init();
        Event::on(View::className(), View::EVENT_BEFORE_RENDER, function (ViewEvent $event) {
            $this->_viewFiles[] = $event->sender->getViewFile();
        });
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Inquid Panel';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        $url = $this->getUrl();
        return "<div class=\"yii-debug-toolbar__block\"><a href=\"$url\">Inquid Panel</a></div>";
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        if(!isset(Yii::$app->params['google_cloud_project_id'])){
            throw new UserException('Es necesario setear el google_cloud_project_id en los parámetros del proyecto');
        }
        $detail = '<ol><li>' . Utilities::getIp() . '</li>';
        $detail .= "<li><a target='_blank' href='https://console.cloud.google.com/logs/viewer?project=" . Yii::$app->params['google_cloud_project_id'] . "'>View Logs on Google Cloud</a></li>";
        $detail .= "<li><a target='_blank' href='https://trello.com/" . Html::encode(Yii::$app->params['trello_url']) . "'>View Trello Dashboard</a></li>";
        $detail .= "<li><a target='_blank' href='https://ssh.cloud.google.com/projects/" . Yii::$app->params['google_cloud_project_id'] . "/zones/" . Yii::$app->params['google_cloud_project_zone'] . "/instances/" . Yii::$app->params['google_cloud_project_instance'] . "?authuser=0&hl=" . Yii::$app->params['google_cloud_project_lang'] . "&projectNumber=" . Yii::$app->params['google_cloud_project_number'] . "'>SSH connection to Server</a></li>";
        return $detail;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        return $this->_viewFiles;
    }
}
