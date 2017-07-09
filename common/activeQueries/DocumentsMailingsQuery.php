<?php

namespace common\activeQueries;

use common\models\DocumentsMailings;

/**
 * This is the ActiveQuery class for [[\common\models\DocumentsMailings]].
 *
 * @see \common\models\DocumentsMailings
 */
class DocumentsMailingsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\DocumentsMailings[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DocumentsMailings|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return DocumentsMailings ActiveRecords
     */
    public function allMails() {
        return $this->orderBy('sent_at desc')->all();
    }
    
    /**
     * 
     * @param string|integer $mailOrID user id or email
     * @return DocumentsMailings ActiveRecords
     */
    public function mailsBySender($mailOrID) {
        return $this->where("sender = '$mailOrID' || email = '$mailOrID'")->orderBy('sent_at desc')->all();
    }
    
    /**
     * 
     * @param string $recipient recipient email
     * @return DocumentsMailings ActiveRecords
     */
    public function mailsToRecipient($recipient) {
        return $this->where("to like '%$recipient%' || cc like '%$recipient%' || bcc like '%$recipient%'")->orderBy('sent_at desc')->all();
    }
    
    /**
     * 
     * @param integer $id document id
     * @return DocumentsMailings ActiveRecords
     */
    public function mailsForDocument($id) {
        $delimiter = DocumentsMailings::detail_delimiter;
        return $this->where("documents like '%$delimiter$id,%' || documents like '%$delimiter$id'")->orderBy('sent_at desc')->all();
    }
    
    /**
     * 
     * @param string|integer $mailOrID user id or email
     * @param integer $id document id
     * @return DocumentsMailings ActiveRecords
     */
    public function mailsBySenderForDocument($mailOrID, $id) {
        $delimiter = DocumentsMailings::detail_delimiter;
        return $this->where("(sender = '$mailOrID' || email = '$mailOrID') && (documents like '%$delimiter$id,%' || documents like '%$delimiter$id')")->orderBy('sent_at desc')->all();
    }
    
    /**
     * 
     * @param string $recipient recipient email
     * @param integer $id document id
     * @return DocumentsMailings ActiveRecords
     */
    public function mailsToRecipientForDocument($recipient, $id) {
        $delimiter = DocumentsMailings::detail_delimiter;
        return $this->where("(to like '%$recipient%' || cc like '%$recipient%' || bcc like '%$recipient%') && (documents like '%$delimiter$id,%' || documents like '%$delimiter$id')")->orderBy('sent_at desc')->all();
    }

}
