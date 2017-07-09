<?php

namespace common\activeQueries;

use common\models\DocumentsMailingsContacts;

/**
 * This is the ActiveQuery class for [[\common\models\DocumentsMailingsContacts]].
 *
 * @see \common\models\DocumentsMailingsContacts
 */
class DocumentsMailingsContactsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\DocumentsMailingsContacts[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DocumentsMailingsContacts|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return DocumentsMailingsContacts ActiveRecords
     */
    public function allContacts() {
        return $this->orderBy('names asc')->all();
    }
    
    /**
     * 
     * @param string $email contact email
     * @return DocumentsMailingsContacts ActiveRecord
     */
    public function contactByMail($email) {
        return $this->where("email = '$email'")->one();
    }
    
    /**
     * 
     * @param string $name contact name
     * @return DocumentsMailingsContacts ActiveRecord
     */
    public function contactsByName($name) {
        return $this->where("names like '%$name%'")->all();
    }

}
