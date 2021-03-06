<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persons".
 *
 * @property int $id
 * @property string $nom
 * @property int $age
 * @property int $offices_id
 *
 * @property Offices $offices
 */
class Persons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'age', 'offices_id'], 'integer'],
            [['nom'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['offices_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offices::className(), 'targetAttribute' => ['offices_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
            'age' => 'Age',
            'offices_id' => 'Offices ID',
        ];
    }

    /**
     * Gets query for [[Offices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffices()
    {
        return $this->hasOne(Offices::className(), ['id' => 'offices_id']);
    }

    public function getCompetences(){
        return $this
        ->hasMany(
            Competences::className(),
            ['id' => 'competences_id']
        )->viaTable(
            'persons_competences',
            ['persons_id' => 'id']
        );
    }
}
