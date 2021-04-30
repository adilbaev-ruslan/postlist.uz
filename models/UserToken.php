<?php

namespace app\models;

use Yii;

/**
* This is the model class for table "user_token".
*
* @property integer $id
* @property integer $user_id
* @property string $type
* @property string $token
* @property string $data
* @property string $expired_at
* @property string $created_at
*
* @property User $user
*/
class UserToken extends \yii\db\ActiveRecord
{


    const TYPE_RESET = 'reset-password';
    const TYPE_CONFIRM = 'confirm-email';
    const TYPE_CHANGE = 'change-email';


    /*
    |--------------------------------------------------------------------------
    | @return table name
    |--------------------------------------------------------------------------
    */
    public static function tableName()
    {
        return 'user_token';
    }

    /*
    |--------------------------------------------------------------------------
    | @return rules
    |--------------------------------------------------------------------------
    */
    public function rules()
    {
        return [
            [['user_id', 'type', 'token'], 'required'],
            [['user_id'], 'integer'],
            [['type'], 'string'],
            ['type', 'in', 'range' => [self::TYPE_RESET, self::TYPE_CONFIRM,self::TYPE_CHANGE]],
            [['expired_at', 'created_at'], 'safe'],
            [['token', 'data'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | @return attribute labels
    |--------------------------------------------------------------------------
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'user_id' => Yii::t('yii', 'User'),
            'type' => Yii::t('yii', 'Type'),
            'token' => Yii::t('yii', 'Token'),
            'data' => Yii::t('yii', 'Data'),
            'expired_at' => Yii::t('yii', 'Expired At'),
            'created_at' => Yii::t('yii', 'Created At'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | @return \yii\db\ActiveQuery
    |--------------------------------------------------------------------------
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /*
    |--------------------------------------------------------------------------
    | Finds user by token
    |--------------------------------------------------------------------------
    */
    public static function findByToken($token,$type)
    {

        $userToken = static::find()->where(['token'=>$token])
                              ->andWhere(['type'=>$type])
                              ->andWhere(['>=','expired_at',date('Y-m-d H:i:s')])
                              ->one();
        if ($userToken==null) {
            return null;
        }else{
            return $userToken;

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Generates new password reset token
    |--------------------------------------------------------------------------
    */
    public static function generate($user_id, $type, $data = null)
    {
        $model = static::find()->where(['user_id'=>$user_id, 'type'=>$type])->limit(1)->one();
        if ($model==null) {
            $model = new static();
        }
        $model->user_id = $user_id;
        $model->type = $type;
        $model->token = Yii::$app->security->generateRandomString();
        $model->data = $data;
        $model->expired_at = date('Y-m-d H:i:s', 60*60*24 + time());
        $model->created_at = date('Y-m-d H:i:s');
        $model->save();
        return $model;
    }
}
