<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $count_view
 * @property string $status
 * @property string $create_at
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    public $translate_title;
    public $translate_content;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status'], 'required'],
            [['content', 'status'], 'string'],
            [['count_view'], 'integer'],
            [['translate_title', 'translate_content'], 'safe'],
            [['create_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'translate_title' => 'Title',
            'content' => 'Content',
            'translate_content' => 'Content',
            'count_view' => 'Count View',
            'status' => 'Status',
            'create_at' => 'Create At',
        ];
    }
}
