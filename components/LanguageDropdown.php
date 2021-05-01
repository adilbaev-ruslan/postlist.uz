<?php
namespace app\components;

use Yii;
use yii\base\Widget;

class LanguageDropdown extends Widget 
{
    public $language; 

    public function init() {
        parent::init();
    }   

    public function run() {
        $baseUrl = Yii::$app->homeUrl;
        $currentUrl = Yii::$app->getRequest()->getUrl();
        $this->language = Yii::$app->language;

          $dropdown = '<div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">' . (isset(Yii::$app->params['languages'][$this->language]) ? Yii::$app->params['languages'][$this->language] : ('NAN'))  .'
          <span class="caret"></span></button>
          <ul class="dropdown-menu">';
            foreach (Yii::$app->params['languages'] as $key => $language) {
                $dropdown .= '<li><a href="'. str_replace(Yii::$app->language, $key, $currentUrl) .'">' . $language . '</a></li>';
            }
        $dropdown .= '</ul></div>'; 
        return $dropdown;
    }
}