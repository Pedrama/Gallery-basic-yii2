<?php

namespace common\models;
use common\components\ActiveRecord;


/**
 * This is the model class for table "{{%image}}".
 *
 * @property string $id
 * @property string $name
 * @property string $album_id
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property Album[] $albums
 * @property Album $album
 * @property User $createUser
 * @property User $updateUser
 *
 */
class Image extends ActiveRecord
{
    /**
     * @inheritdoc
     */
public $image_tmp_name;
//public $album_tml_id;
    public static $validExtImageUpload = [
        'jpg',
        'png',
        'jpeg',
    ];
    public static $maxUploadImageSize=5242880;

    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
//            [['album_id', 'create_user_id', 'update_user_id', 'created_at', 'updated_at'], 'integer'],
            [['album_id',], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['album_id' => 'id']],
//            [['create_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_user_id' => 'id']],
//            [['update_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'کد تصویر',
            'name' => 'نام فایل',
            'album_id' => 'َشماره آلبوم',
            'create_user_id' => '  کاربر ایجاد کننده',
            'update_user_id' => '  کاربر بروز رسانی',
            'created_at' => ' زمان ایجاد',
            'updated_at' => ' زمان بروز رسانی',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['cover_image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::className(), ['id' => 'album_id']);
    }
    public function getParentAlbum()
    {
        return $this->hasOne(Album::className(), ['parent_id' => 'album_id']);
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

    public function parentAlbum()
    {
        return $this->hasOne(Album::className(), ['parent_id' => 'album_id']);
    }
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['image_id' => 'id'])->where(['status' => Comment::STATUS_CONFIRMED]);
    }
    public function getLike()
    {
        return $this->hasMany(Like::className(), ['image_id' => 'id'])->count();
    }

}
