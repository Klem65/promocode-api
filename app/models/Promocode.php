<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "promocodes".
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 *
 * @property User $user
 */
class Promocode extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'promocodes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'code'], 'required'],
            [['user_id'], 'integer'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'code' => 'Code',
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord && empty($this->code)) {
                $this->code = $this->generatePromoCode();
            }
            return true;
        }
        return false;
    }

    protected function generatePromoCode($length = 5): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $promoCode = '';
        for ($i = 0; $i < $length; $i++) {
            $promoCode .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $promoCode;
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function findIdentityByUser(User $user): ?Promocode
    {
        return static::findOne(['user_id' => $user->id]);
    }
}
