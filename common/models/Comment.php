<?php

namespace common\models;

use common\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property string $content
 * @property string $image_id
 * @property integer $status
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Image $image
 * @property User $createUser
 * @property User $updateUser
 */
class Comment extends ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_CONFIRMED = 1;

    /**
     * @inheritdoc
     */



    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value'=> 0],
            [['content'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['content'], 'filter', 'filter' => 'trim'],
            [['content'], 'string'],
            [['content'] , 'required' , 'message' => 'لطفا متنی را وارد نمایید.'],
            [['status'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['create_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_user_id' => 'id']],
            [['update_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'متن نظر',
            'image_id' => 'شماره عکس',
            'status' => 'وضعیت',
            'create_user_id' => 'Create User ID',
            'update_user_id' => 'Update User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'update_user_id']);
    }
}
