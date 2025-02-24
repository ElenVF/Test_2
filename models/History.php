<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property string $text
 * @property string|null $created_at
 * @property string $list_error
 * @property string $lang
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['text'], 'required'],
//            [['text'], 'string'],
            [['created_at'], 'safe'],
            [['list_error', 'lang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'created_at' => 'Дата проверки',
            'list_error' => 'Ошибки',
            'lang' => 'Язык',
        ];
    }
}
