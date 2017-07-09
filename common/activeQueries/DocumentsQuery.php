<?php

namespace common\activeQueries;

use common\models\Documents;
/**
 * This is the ActiveQuery class for [[\common\models\Documents]].
 *
 * @see \common\models\Documents
 */
class DocumentsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Documents[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Documents|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @param integer $directory parent folder id
     * @param string $name document name
     * @param integer $id document id
     * @return \common\models\Documents ActiveRecord
     */
    public function duplicateName($directory, $name, $id) {
        return $this->where("directory='$directory' && name='$name' && id !='$id'")->one();
    }

    /**
     * 
     * @param integer $pk document id
     * @param integer $status file status
     * @return \common\models\Documents ActiveRecord
     */
    public function byIdAndStatus($pk, $status) {
        return $this->where("id='$pk' && status='$status'")->one();
    }
    
    /**
     * 
     * @param string $ids where sub-clause: id in ('$ids')
     * @return \common\models\Documents ActiveRecords
     */
    public function whereIDs($ids) {
        return $this->where("id in ($ids)")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $ids where sub-clause: id in ('$ids')
     * @param integer $status file status
     * @return \common\models\Documents ActiveRecords
     */
    public function whereIDsAndStatus($ids, $status) {
        return $this->where("id in ($ids) && status='$status'")->orderBy('name asc')->all();
    }
    
    /* 
     * @param string $filenames where sub-clause: filename like 'filename/%'
     * @param integer $status file status
     * @return \common\models\Documents ActiveRecords
     */
    public function whereFileNamesAndStatus($filenames, $status) {
        $is_doc = Documents::FILE_IS_DOCUMENT;
        return $this->where("($filenames) && status='$status' && dir_or_file = '$is_doc'")->orderBy('name asc')->all();
    }

    /**
     * 
     * @param string $filename file location
     * @param integer $status file status
     * @return \common\models\Documents ActiveRecord
     */
    public function byFileNameAndStatus($filename, $status) {
        return $this->where("filename='$filename' && status='$status'")->one();
    }

    /**
     * 
     * @param string $name file name
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByName($name, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "name like '%$name%'")->orderBy('name asc')->all();
    }

    /**
     * 
     * @param string $desc file description
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByDescription($desc, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "description like '%$desc%'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByAuthor($author, $not_in) {
        $t = Documents::tableName();
        $u = \common\models\User::tableName();
        
        return $this->select(
                "t.id, t.directory, t.name, t.filename, t.file_level, t.dir_or_file, t.description, t.created_by, t.created_at, t.status, t.status_by, t.status_at, t.permissions, t.forwarded_for_update_by, t.opened_for_update, t.opened_for_update_by, t.opened_for_update_at, t.visible_to_others_during_update, t.can_be_updated, t.can_be_moved, t.can_be_deleted, t.updated_by, t.updated_at, t.archived_in, t.archived_by, t.archived_at, t.deleted_to, t.deleted_by, t.deleted_at, t.restored_by, t.restored_at"
                )->from("$t t")->leftJoin("$u u", 't.created_by = u.id')->where((empty($not_in) ? '' : "t.id not in ($not_in) && ") . "(u.name like '%$author%' || u.phone like '%$author%' || u.email like '%$author%' || u.username like '%$author%')")->orderBy('t.name asc')->all();
    }
    
    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByUpdater($author, $not_in) {
        $t = Documents::tableName();
        $u = \common\models\User::tableName();
        
        return $this->select(
                "t.id, t.directory, t.name, t.filename, t.file_level, t.dir_or_file, t.description, t.created_by, t.created_at, t.status, t.status_by, t.status_at, t.permissions, t.forwarded_for_update_by, t.opened_for_update, t.opened_for_update_by, t.opened_for_update_at, t.visible_to_others_during_update, t.can_be_updated, t.can_be_moved, t.can_be_deleted, t.updated_by, t.updated_at, t.archived_in, t.archived_by, t.archived_at, t.deleted_to, t.deleted_by, t.deleted_at, t.restored_by, t.restored_at"
                )->from("$t t")->leftJoin("$u u", 't.updated_by = u.id')->where((empty($not_in) ? '' : "t.id not in ($not_in) && ") . "(u.name like '%$author%' || u.phone like '%$author%' || u.email like '%$author%' || u.username like '%$author%')")->orderBy('t.name asc')->all();
    }
    
    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByStatuser($author, $not_in) {
        $t = Documents::tableName();
        $u = \common\models\User::tableName();
        
        return $this->select(
                "t.id, t.directory, t.name, t.filename, t.file_level, t.dir_or_file, t.description, t.created_by, t.created_at, t.status, t.status_by, t.status_at, t.permissions, t.forwarded_for_update_by, t.opened_for_update, t.opened_for_update_by, t.opened_for_update_at, t.visible_to_others_during_update, t.can_be_updated, t.can_be_moved, t.can_be_deleted, t.updated_by, t.updated_at, t.archived_in, t.archived_by, t.archived_at, t.deleted_to, t.deleted_by, t.deleted_at, t.restored_by, t.restored_at"
                )->from("$t t")->leftJoin("$u u", 't.status_by = u.id')->where((empty($not_in) ? '' : "t.id not in ($not_in) && ") . "(u.name like '%$author%' || u.phone like '%$author%' || u.email like '%$author%' || u.username like '%$author%')")->orderBy('t.name asc')->all();
    }
    
    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByLocker($author, $not_in) {
        $t = Documents::tableName();
        $u = \common\models\User::tableName();
        
        return $this->select(
                "t.id, t.directory, t.name, t.filename, t.file_level, t.dir_or_file, t.description, t.created_by, t.created_at, t.status, t.status_by, t.status_at, t.permissions, t.forwarded_for_update_by, t.opened_for_update, t.opened_for_update_by, t.opened_for_update_at, t.visible_to_others_during_update, t.can_be_updated, t.can_be_moved, t.can_be_deleted, t.updated_by, t.updated_at, t.archived_in, t.archived_by, t.archived_at, t.deleted_to, t.deleted_by, t.deleted_at, t.restored_by, t.restored_at"
                )->from("$t t")->leftJoin("$u u", 't.opened_for_update_by = u.id')->where((empty($not_in) ? '' : "t.id not in ($not_in) && ") . "(u.name like '%$author%' || u.phone like '%$author%' || u.email like '%$author%' || u.username like '%$author%')")->orderBy('t.name asc')->all();
    }
    
    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByArchiver($author, $not_in) {
        $t = Documents::tableName();
        $u = \common\models\User::tableName();
        
        return $this->select(
                "t.id, t.directory, t.name, t.filename, t.file_level, t.dir_or_file, t.description, t.created_by, t.created_at, t.status, t.status_by, t.status_at, t.permissions, t.forwarded_for_update_by, t.opened_for_update, t.opened_for_update_by, t.opened_for_update_at, t.visible_to_others_during_update, t.can_be_updated, t.can_be_moved, t.can_be_deleted, t.updated_by, t.updated_at, t.archived_in, t.archived_by, t.archived_at, t.deleted_to, t.deleted_by, t.deleted_at, t.restored_by, t.restored_at"
                )->from("$t t")->leftJoin("$u u", 't.archived_by = u.id')->where((empty($not_in) ? '' : "t.id not in ($not_in) && ") . "(u.name like '%$author%' || u.phone like '%$author%' || u.email like '%$author%' || u.username like '%$author%')")->orderBy('t.name asc')->all();
    }
    
    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByDeleter($author, $not_in) {
        $t = Documents::tableName();
        $u = \common\models\User::tableName();
        
        return $this->select(
                "t.id, t.directory, t.name, t.filename, t.file_level, t.dir_or_file, t.description, t.created_by, t.created_at, t.status, t.status_by, t.status_at, t.permissions, t.forwarded_for_update_by, t.opened_for_update, t.opened_for_update_by, t.opened_for_update_at, t.visible_to_others_during_update, t.can_be_updated, t.can_be_moved, t.can_be_deleted, t.updated_by, t.updated_at, t.archived_in, t.archived_by, t.archived_at, t.deleted_to, t.deleted_by, t.deleted_at, t.restored_by, t.restored_at"
                )->from("$t t")->leftJoin("$u u", 't.deleted_by = u.id')->where((empty($not_in) ? '' : "t.id not in ($not_in) && ") . "(u.name like '%$author%' || u.phone like '%$author%' || u.email like '%$author%' || u.username like '%$author%')")->orderBy('t.name asc')->all();
    }
    
    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentsByRestorer($author, $not_in) {
        $t = Documents::tableName();
        $u = \common\models\User::tableName();
        
        return $this->select(
                "t.id, t.directory, t.name, t.filename, t.file_level, t.dir_or_file, t.description, t.created_by, t.created_at, t.status, t.status_by, t.status_at, t.permissions, t.forwarded_for_update_by, t.opened_for_update, t.opened_for_update_by, t.opened_for_update_at, t.visible_to_others_during_update, t.can_be_updated, t.can_be_moved, t.can_be_deleted, t.updated_by, t.updated_at, t.archived_in, t.archived_by, t.archived_at, t.deleted_to, t.deleted_by, t.deleted_at, t.restored_by, t.restored_at"
                )->from("$t t")->leftJoin("$u u", 't.restored_by = u.id')->where((empty($not_in) ? '' : "t.id not in ($not_in) && ") . "(u.name like '%$author%' || u.phone like '%$author%' || u.email like '%$author%' || u.username like '%$author%')")->orderBy('t.name asc')->all();
    }
    
    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByCreationDate($date, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "created_at >= '$date'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByUpdateDate($date, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "updated_at >= '$date'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByStatusDate($date, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "status_at >= '$date'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByLockDate($date, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "opened_for_update_at >= '$date'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByArchiveDate($date, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "archived_at >= '$date'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByRecycleDate($date, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "deleted_at >= '$date'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByRestoreDate($date, $not_in) {
        return $this->where((empty($not_in) ? '' : "id not in ($not_in) && ") . "restored_at >= '$date'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public function searchDocumentByFileContent($not_in) {
        $is_file = Documents::FILE_IS_DOCUMENT;
        
        return $this->where("dir_or_file = '$is_file'" . (empty($not_in) ? '' : " && id not in ($not_in)"))->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $filename file name
     * @return \common\models\Documents ActiveRecord
     */
    public function byJustFilename($filename) {
        return $this->where("filename like '%$filename'")->one();
    }
    
    /**
     * 
     * @param integer $directory integer $directory parent folder id
     * @param string $filename file location
     * @return \common\models\Documents ActiveRecord
     */
    public function childByDirectoryOrFilename($directory, $filename) {
        return $this->where("directory='$directory' || (filename like '$filename%' && filename!='$filename')")->one();
    }
    
    /**
     * 
     * @param string $filename file location
     * @param integer $status file status
     * @param string $type file type 0 - directory, 1 - file
     * @return \common\models\Documents ActiveRecords
     */
    public function childrenToDirectoryByFilenameAndLocation($filename, $status, $type) {
        return $this->where("filename like '$filename/%' && status='$status' && dir_or_file='$type'")->all();
    }
    
    /**
     * 
     * @param string $filename file location
     * @param integer $status file status
     * @return \common\models\Documents ActiveRecord
     */
    public function directoryContainsAnArchivedOrRecycledChild($filename, $status) {
        return $this->where("filename like '$filename/%' && status='$status'")->one();
    }
    
    /**
     * 
     * @param integer $directory integer $directory parent folder id
     * @param string $name file name
     * @return \common\models\Documents ActiveRecord
     */
    public function byDirectoryAndName($directory, $name) {
        return $this->where("directory='$directory' && name='$name'")->one();
    }
    
    /**
     * 
     * @param string $order order by clause
     * @return \common\models\Documents ActiveRecords
     */
    public function allDocuments($order) {
        return $this->orderBy($order)->all();
    }
    
    /**
     * 
     * @param string $type file type 0 - directory, 1 - file
     * @return \common\models\Documents ActiveRecords
     */
    public function byDocumentType($type) {
        return $this->where("dir_or_file='$type'")->all();
    }
    
    /**
     * 
     * @param integer $directory folder id
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @param boolean $foldersOnly true - folders only
     * @param string $order order by clause
     * @return \common\models\Documents ActiveRecords
     */
    public function documentsInDirectory($directory, $status, $foldersOnly, $order) {
        $file_type = Documents::FILE_IS_DIRECTORY;
        return $this->where("directory='$directory'" . (empty($status) ? '' : " && status='$status'") . ($foldersOnly ? " && dir_or_file='$file_type'" : ''))->orderBy($order)->all();
    }
    
    /**
     * 
     * @param integer $file_type 0 - folder, 1 - file
     * @return integer max folder level
     */
    public function maxFileLevelsForDirOrFile($file_type) {
        $available = Documents::FILE_STATUS_AVAILABLE;
        
        foreach ($this->select('max(file_level) as max_level')->where("dir_or_file='$file_type' && status='$available'")->all() as $folder)
            return $folder->max_level;
    }
    
    /**
     * 
     * @param integer $user user id
     * @return \common\models\Documents ActiveRecords
     */
    public function openedByUserForUpdate($user) {
        $open = Documents::FILE_OPENED_FOR_UPDATE;
        return $this->where("opened_for_update = '$open' && opened_for_update_by = '$user'")->orderBy('opened_for_update_at asc')->all();
    }
    
    /**
     * 
     * @param string $where where clause
     * @param string $oneOrAll one, all
     * @return \common\models\Documents ActiveRecords
     */
    public function documentsByCustomQuery($where, $oneOrAll) {
        return $this->where($where)->orderBy('name asc')->$oneOrAll();
    }

}
