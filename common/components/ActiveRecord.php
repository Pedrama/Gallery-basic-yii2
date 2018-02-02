<?php
namespace common\components;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

/**
 * Created by PhpStorm.
 * User: pedram
 * Date: 10/29/2017
 * Time: 10:21 AM
 */
class ActiveRecord extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        if($this->hasAttribute('created_at') || $this->hasAttribute('updated_at')) {
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'attributes' => [
                        BaseActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                        BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                    ],
                ]
            ];
        }else{
            return [];
        }
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->create_user_id = Yii::$app->user->id;
            $this->created_at=time();
        }else{
            $this->update_user_id = Yii::$app->user->id;
            $this->updated_at=time();
        }
        return parent::beforeSave($insert);
    }
}