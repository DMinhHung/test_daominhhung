<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use \app\models\query\HrQuery;

/**
 * This is the base-model class for table "hr".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Employee $employee
 * @property \app\models\Request[] $requests
 */
abstract class Hr extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hr';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'value' => (new \DateTime())->format('Y-m-d H:i:s'),
                        ];
        
    return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['employee_id'], 'integer'],
            [['deleted_at'], 'safe'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Employee::class, 'targetAttribute' => ['employee_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(\app\models\Employee::class, ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(\app\models\Request::class, ['hr_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return HrQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HrQuery(static::class);
    }
}
