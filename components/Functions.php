<?php

namespace app\components;

use Yii;

class Functions extends \yii\base\Component
{
	public static function getNoReplyEmail()
	{
	    return isset(Yii::$app->components['mailer']['transport']['username'])?Yii::$app->components['mailer']['transport']['username']:null;
	}

	public static function translateJson($value, $language=null) {
		$translateValue = null;
		if ($language) {
			$translateValue = json_decode($value, true);
			return $translateValue[$language];
		} else {
			$translateValue = json_decode($value, true);
			if (isset($translateValue[Yii::$app->language])) {
				if ($translateValue[Yii::$app->language] != '') {
					return $translateValue[Yii::$app->language];	
				} else {
					foreach ($translateValue as $value) {
					$result = null;
					if ($value != "") {
						$result = $value;
					}
					return $result;
				}	
				}
				
			} else {
				foreach ($translateValue as $value) {
					$result = null;
					if ($value != "") {
						$result = $value;
					}
					return $result;
				}
			}
		}
	}

	public static function translateArray($array, $language=null) {
		$resultArray = null;
		foreach ($array as $key => $value) {
			$resultArray[$key] = Functions::translateJson($value, $language);
		}
		return $resultArray;
	}
}