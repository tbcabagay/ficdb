<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FacultyEducation;

/**
 * FacultyEducationSearch represents the model behind the search form about `app\models\FacultyEducation`.
 */
class FacultyEducationSearch extends FacultyEducation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'faculty_id'], 'integer'],
            [['degree', 'school', 'date_graduate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FacultyEducation::find()->where(['faculty_id' => Yii::$app->request->get('faculty_id')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'faculty_id' => $this->faculty_id,
        ]);

        $query->andFilterWhere(['like', 'degree', $this->degree])
            ->andFilterWhere(['like', 'school', $this->school])
            ->andFilterWhere(['like', 'date_graduate', $this->date_graduate]);

        return $dataProvider;
    }

    public function faculty()
    {
        $query = FacultyEducation::find()->where(['faculty_id' => Yii::$app->request->get('id')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
