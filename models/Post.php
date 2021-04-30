<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property int $category_id
 * @property int $user_id
 * @property string $description
 * @property string $image
 * @property string $content
 * @property int $count_view
 * @property string $status
 * @property string $create_at
 *
 * @property User $user
 * @property Category $category
 * @property TagAssign[] $tagAssigns
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public $tag;
    public $translate_title;
    public $translate_description;
    public $translate_content;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'description', 'content','status'], 'required'],
            [['category_id',], 'integer'],
            [['content', 'status'], 'string'],
            [['create_at', 'tag',], 'safe'],
            [['translate_title', 'translate_description', 'translate_content'], 'safe'],
            [['title', 'description'], 'string'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg',],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'description' => 'Description',
            'translate_description' => 'Description',
            'content' => 'Content',
            'translate_content' => 'Content',
            'image' => 'Kartina',
            'tag' => 'Tags',
            'count_view' => 'Count View',
            'status' => 'Status',
            'create_at' => 'Create At',
        ];
    }

    public function upload()
    {
        if ($this->validate() and $this->image->baseName) {
            $this->image->saveAs(Yii::$app->basePath . '/web/uploads/' . time() . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[TagAssigns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagAssigns()
    {
        return $this->hasMany(TagAssign::className(), ['post_id' => 'id']);
    }
}
