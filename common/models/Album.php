<?php

namespace common\models;

use common\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%album}}".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property string $cover_image_id
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Image $coverImage
 * @property Album $parent
 *
 * @property Album[] $parent2
 * @property Album[] $albumMaster
 *
 * @property Album[] $albums
 * @property User $createUser
 * @property User $updateUser
 * @property Image[] $images
 */
class Album extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%album}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
           [['cover_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['cover_image_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['parent_id' => 'id']],
           // [['create_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_user_id' => 'id']],
            //[['update_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نام آلبوم',
            'parent_id' => 'نام زیر آلبوم',
            'cover_image_id' => 'تصویر',
            'create_user_id' => 'کاربر ایجاد کننده',
            'update_user_id' => 'کاربر ویرایش کننده',
            'created_at' => 'زمان ایجاد',
            'updated_at' => 'زمان ویرایش',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoverImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'cover_image_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent2()
    {
        return $this->hasMany(Image::className(), ['album_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Album::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['parent_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['album_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumsMaster()
    {
        return $this->hasMany(Album::className(), ['parent_id' => null]);
    }


}
