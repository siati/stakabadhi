<?php

namespace common\models;

use Yii;
use common\models\Stores;
use common\models\Compartments;
use common\models\SubCompartments;
use common\models\SubSubCompartments;
use common\models\Shelves;
use common\models\Drawers;
use common\models\Batches;
use common\models\Folders;
use common\models\Files;

/**
 * This is the model class for table "{{%store_levels}}".
 *
 * @property integer $id
 * @property integer $level
 * @property string $name
 * @property string $associated_table
 * @property integer $updated_by
 * @property string $updated_at
 */
class StoreLevels extends \yii\db\ActiveRecord {

    const stores = 1;
    const compartments = 2;
    const subcompartments = 3;
    const subsubcompartments = 4;
    const shelves = 5;
    const drawers = 6;
    const batches = 7;
    const folders = 8;
    const files = 9;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%store_levels}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['level', 'name', 'associated_table'], 'required'],
            [['level', 'updated_by'], 'integer'],
            [['updated_at'], 'safe'],
            [['name'], 'notNumerical'],
            [['name'], 'string', 'min' => 5, 'max' => 45],
            [['associated_table'], 'string', 'max' => 128],
            [['name'], 'unique'],
            [['level'], 'unique'],
            [['associated_table'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'level' => Yii::t('app', 'Store Level'),
            'name' => Yii::t('app', 'Level Name'),
            'associated_table' => Yii::t('app', 'Associated Table'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\StoreLevelsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\StoreLevelsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk store level id
     * @return StoreLevels model
     */
    public static function returnLevel($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return StoreLevels models
     */
    public static function allLevels() {
        return static::find()->allLevels();
    }

    /**
     * 
     * @param integer $level level
     * @return StoreLevels model
     */
    public static function byLevel($level) {
        return static::find()->byLevel($level);
    }

    /**
     * 
     * @param string $name level name
     * @return StoreLevels model
     */
    public static function byName($name) {
        return static::find()->byName($name);
    }

    /**
     * 
     * @param string $table level table
     * @return StoreLevels model
     */
    public static function byAssociatedTable($table) {
        return static::find()->byAssociatedTable($table);
    }

    /**
     * 
     * @param integer $level store
     * @param string $name level name
     * @param string $associated_table level associated table
     * @return StoreLevels model
     */
    public static function newLevel($level, $name, $associated_table) {
        $model = new StoreLevels;

        $model->id = $model->level = $level;
        $model->name = $name;
        $model->associated_table = $associated_table;

        return $model;
    }

    /**
     * 
     * @param integer $id level id
     * @param integer $level level
     * @param string $name level name
     * @param string $associated_table level associated table
     * @return StoreLevels model
     */
    public static function levelToLoad($id, $level, $name, $associated_table) {
        return is_object($model = static::returnLevel($id)) || is_object($model = static::returnLevel($level)) || is_object($model = static::byLevel($id)) || is_object($model = static::byLevel($level)) ||
                is_object($model = static::byName($name)) || is_object($model = static::byAssociatedTable($associated_table)) ? $model : static::newLevel($level, $name, $associated_table);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if (!$this->isNewRecord) {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
        }

        return $this->save();
    }

    /**
     * create default store level labels
     */
    public static function defaultLevels() {
        if (empty(static::allLevels()))
            foreach (static::defaultLevelsOrder() as $level => $levelDetails)
                static::levelToLoad(null, $level, $levelDetails[0], $levelDetails[1])->modelSave();
    }

    /**
     * 
     * @return array default levels order
     */
    public static function defaultLevelsOrder() {
        return [
            self::stores => ['Stores', Stores::tableName()],
            self::compartments => ['Compartments', Compartments::tableName()],
            self::subcompartments => ['Sections', SubCompartments::tableName()],
            self::subsubcompartments => ['SubSections', SubSubCompartments::tableName()],
            self::shelves => ['Shelves', Shelves::tableName()],
            self::drawers => ['Drawers', Drawers::tableName()],
            self::batches => ['Batches', Batches::tableName()],
            self::folders => ['Folders', Folders::tableName()],
            self::files => ['Files', Files::tableName()]
        ];
    }
    
    /**
     * 
     * @param integer $level storage level
     * @param integer $id storage id
     * @return Stores|Compartments|SubCompartments|SubSubCompartments|Shelves|Drawers|Batches|Folders|Files model
     */
    public static function storageByID($level, $id) {
        if ($level == self::files)
            return Files::returnFile($id);

        if ($level == self::folders)
            return Folders::returnFolder($id);

        if ($level == self::batches)
            return Batches::returnBatch($id);

        if ($level == self::drawers)
            return Drawers::returnDrawer($id);

        if ($level == self::shelves)
            return Shelves::returnShelf($id);

        if ($level == self::subsubcompartments)
            return SubSubCompartments::returnSubsubcompartment($id);

        if ($level == self::subcompartments)
            return SubCompartments::returnSubcompartment($id);

        if ($level == self::compartments)
            return Compartments::returnCompartment($id);

        return Stores::returnStore($id);
    }

    /**
     * 
     * @param integer $level storage level
     * @param integer $id storage id
     * @param boolean $whereStringAMust force where clause
     * @return Stores|Compartments|SubCompartments|SubSubCompartments|Shelves|Drawers|Batches|Folders|Files models
     */
    public static function defaultStoragesToLoad($level, $id, $whereStringAMust) {

        if ($level == self::files)
            return Files::searchFiles(null, null, null, null, null, null, null, $id, $whereStringAMust);

        if ($level == self::folders)
            return Folders::searchFolders(null, null, null, null, null, null, $id, $whereStringAMust);

        if ($level == self::batches)
            return Batches::searchBatches(null, null, null, null, null, $id, $whereStringAMust);

        if ($level == self::drawers)
            return Drawers::searchDrawers(null, null, null, null, $id, $whereStringAMust);

        if ($level == self::shelves)
            return Shelves::searchShelves(null, null, null, $id, $whereStringAMust);

        if ($level == self::subsubcompartments)
            return SubSubCompartments::searchSubsubcompartments(null, null, $id, $whereStringAMust);

        if ($level == self::subcompartments)
            return SubCompartments::searchSubcompartments(null, $id, $whereStringAMust);

        if ($level == self::compartments)
            return Compartments::compartmentsForStore($id, $whereStringAMust);

        return Stores::allStores();
    }

}
