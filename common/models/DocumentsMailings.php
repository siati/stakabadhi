<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%documents_mailings}}".
 *
 * @property integer $id
 * @property integer $sender
 * @property string $from
 * @property string $to
 * @property string $cc
 * @property string $bcc
 * @property string $subject
 * @property string $documents
 * @property string $body
 * @property string $footer
 * @property string $zip_folder
 * @property string $sent
 * @property string $narration
 * @property string $sent_at
 * @property string $expiry
 */
class DocumentsMailings extends \yii\db\ActiveRecord {

    const validity = 14;
    const detail_delimiter = '~';
    const connection_failed = 'connection failed';
    const sent = 'sent';
    const not_sent = 'failed';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%documents_mailings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sender', 'from', 'to', 'subject', 'documents', 'body', 'sent_at', 'expiry'], 'required'],
            [['sender'], 'integer'],
            [['to', 'cc', 'bcc', 'subject', 'documents', 'body', 'footer', 'narration'], 'string'],
            [['sent_at', 'zip_folder', 'sent', 'expiry'], 'safe'],
            [['to', 'cc', 'bcc', 'subject', 'body', 'footer'], 'notNumerical'],
            [['subject'], 'string', 'min' => 5, 'max' => 200],
            [['body', 'footer'], 'string', 'min' => 5, 'max' => 1000],
            [['from'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender' => Yii::t('app', 'Sender ID'),
            'from' => Yii::t('app', 'Sender Email'),
            'to' => Yii::t('app', 'Primary Recipients'),
            'cc' => Yii::t('app', 'Secondary Recipients'),
            'bcc' => Yii::t('app', 'Tertiary Recipients'),
            'subject' => Yii::t('app', 'Subject'),
            'documents' => Yii::t('app', 'Documents'),
            'body' => Yii::t('app', 'Body'),
            'footer' => Yii::t('app', 'Footer'),
            'zip_folder' => Yii::t('app', 'Zip Folder'),
            'sent' => Yii::t('app', 'sent'),
            'narration' => Yii::t('app', 'Narration'),
            'sent_at' => Yii::t('app', 'Sent At'),
            'expiry' => Yii::t('app', 'Expiry Date'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\DocumentsMailingsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\DocumentsMailingsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk mail id
     * @return DocumentsMailings model
     */
    public static function returnMail($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param string|integer $mailOrID user id or email
     * @return DocumentsMailings models
     */
    public static function mailsBySender($mailOrID) {
        return static::find()->mailsBySender($mailOrID);
    }

    /**
     * 
     * @param string $recipient recipient email
     * @return DocumentsMailings models
     */
    public static function mailsToRecipient($recipient) {
        return static::find()->mailsToRecipient($recipient);
    }

    /**
     * 
     * @param string|integer $idOrName document id or name
     * @return DocumentsMailings models
     */
    public static function mailsForDocument($idOrName) {
        return static::find()->mailsForDocument($idOrName);
    }

    /**
     * 
     * @param string|integer $mailOrID user id or email
     * @param string|integer $idOrName document id or name
     * @return DocumentsMailings models
     */
    public static function mailsBySenderForDocument($mailOrID, $idOrName) {
        return static::find()->mailsBySenderForDocument($mailOrID, $idOrName);
    }

    /**
     * 
     * @param string string $recipient recipient email
     * @param string|integer $idOrName document id or name
     * @return DocumentsMailings models
     */
    public static function mailsToRecipientForDocument($recipient, $idOrName) {
        return static::find()->mailsToRecipientForDocument($recipient, $idOrName);
    }

    /**
     * 
     * @param string $to recipient mails
     * @param string $cc copy to mails
     * @param string $bcc blind copy to mails
     * @param string $documents attached document ids and names
     * @return \common\models\DocumentsMailings model
     */
    public static function newMail($to, $cc, $bcc, $documents) {
        $model = new DocumentsMailings;

        $model->sender = Yii::$app->user->identity->id;
        $model->from = Yii::$app->params['supportEmail'];
        $model->to = $to;
        $model->cc = $cc;
        $model->bcc = $bcc;
        $model->documents = $documents;
        $model->sent = self::not_sent;
        $model->expiry = StaticMethods::dateAddDays(StaticMethods::now(), self::validity);

        return $model;
    }

    /**
     * 
     * @param integer $id mail id
     * @param string $to recipient mails
     * @param string $cc copy to mails
     * @param string $bcc blind copy to mails
     * @param string $documents attached document ids and names
     * @return DocumentsMailings model
     */
    public static function mailToLoad($id, $to, $cc, $bcc, $documents) {
        return is_object($model = static::returnMail($id)) ? $model : static::newMail($to, $cc, $bcc, $documents);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord) {
            $this->sent_at = StaticMethods::now();
            $this->expiry = StaticMethods::dateAddDays($this->sent_at, self::validity);
        }

        return $this->save(false) && (Logs::newLog(Logs::send_documents_by_mail, "Sent documents via mail captured in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $this->subject, $this->id, StaticMethods::mail_zips_folder . "/$this->zip_folder", $this->documents, $this->sent == self::sent ? Logs::success : Logs::failed) || true);
    }

    /**
     * 
     * @param string $source location of the attached zip folder
     */
    public function saveTheZip($source) {
        if (!$this->isNewRecord && (is_dir($fldr = StaticMethods::mailZipsFolder() . $this->zip_folder) || is_file($fldr)))
            @unlink ($fldr);
        
        copy($source, $destination = str_replace(StaticMethods::downloadsFolder(), $zip = StaticMethods::mailZipsFolder(), $source)) ? $this->zip_folder = str_replace($zip, '', $destination) : '';
    }

    /**
     * 
     * capture document ids and names
     */
    public function explodeDocuments() {
        $docs = null;

        foreach (explode(',', $this->documents) as $ids) {
            $id = explode(self::detail_delimiter, $ids);
            $docs = $docs . (empty($docs) ? '' : ',') . $id[1];
        }

        return $docs;
    }

    /**
     * 
     * @param string $attribute - 'to', 'cc', 'bcc'
     * @return array mail recipients - email and name
     */
    public function explodeRecipients($attribute) {
        if (!empty($this->$attribute))
            foreach (explode(',', $this->$attribute) as $details) {
                $detail = explode(self::detail_delimiter, $details);
                $recipients[$detail[1]] = $detail[0];
            }

        return empty($recipients) ? [] : $recipients;
    }

    /**
     * 
     * @param integer $status status of documents to be sent
     * @return boolean|string true - mail sent and mailing saved
     */
    public function sendFiles($status) {
        $zip = Documents::zipAndExport($this->explodeDocuments(), $status, Documents::zip_location);

        if (empty($zip[0]))
            return false;

        $this->documents = $zip[1];
        $this->saveTheZip($zip[0]);

        try {
            $this->sent = Yii::$app->mailer
                            ->compose(['html' => 'send-document-html', 'text' => 'send-document-text'], ['mail' => $this])
                            ->setFrom([$this->from => Yii::$app->name])
                            ->setTo($this->explodeRecipients('to'))
                            ->setCc($this->explodeRecipients('cc'))
                            ->setBcc($this->explodeRecipients('bcc'))
                            ->setSubject($this->subject)
                            ->attach($zip[0])
                            ->send() ? self::sent : self::not_sent;

            $sent = $this->sent == self::sent;
        } catch (\Exception $ex) {
            $this->narration = substr($ex, 0, 100);
            $sent = self::connection_failed;
        }

        $this->modelSave();

        @unlink($zip[0]);

        return $sent == self::connection_failed ? $sent : !empty($sent);
    }

}
