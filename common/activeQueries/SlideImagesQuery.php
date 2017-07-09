<?php

namespace common\activeQueries;

use common\models\SlideImages;

/**
 * This is the ActiveQuery class for [[\common\models\SlideImages]].
 *
 * @see \common\models\SlideImages
 */
class SlideImagesQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\SlideImages[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SlideImages|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return SlideImages ActiveRecords
     */
    public function allImages() {
        return $this->orderBy('active desc, name asc')->all();
    }

    /**
     * 
     * @return SlideImages ActiveRecords
     */
    public function allActiveImages() {
        $active = SlideImages::active;
        return $this->where("active = '$active'")->orderBy('name asc')->all();
    }

    /**
     * 
     * @return SlideImages ActiveRecords
     */
    public function allInactiveImages() {
        $inactive = SlideImages::not_active;
        return $this->where("active = '$inactive'")->orderBy('name asc')->all();
    }

    /**
     * 
     * @param integer $active 0 - inactive, 1 - active
     * @param string $name image name
     * @param string $caption image caption
     * @param string $url_to image link to
     * @param integer $created_by user id
     * @param string $created_since created since
     * @param string $created_till created till
     * @param integer $updated_by user id
     * @param string $updated_since updated since
     * @param string $updated_till updated till
     * @return SlideImages ActiveRecords
     */
    public function queryImages($active, $name, $caption, $url_to, $created_by, $created_since, $created_till, $updated_by, $updated_since, $updated_till) {
        return $this->where(
                        "id > 0"
                        . (in_array($active, [SlideImages::active, SlideImages::not_active]) ? " && active = '$active'" : '')
                        . (empty($name) ? '' : " && name like '%$active%'")
                        . (empty($caption) ? '' : " && caption like '%$caption%'")
                        . (empty($url_to) ? '' : " && url_to like '%$url_to%'")
                        . (empty($created_by) ? '' : " && created_by in ($created_by)")
                        . (empty($created_since) ? '' : " && created_at >= '$created_since'")
                        . (empty($created_till) ? '' : " && created_at <= '$created_till'")
                        . (empty($updated_by) ? '' : " && updated_by in ($updated_by)")
                        . (empty($updated_since) ? '' : " && updated_at >= '$updated_since'")
                        . (empty($updated_till) ? '' : " && updated_at <= '$updated_till'")
                )->orderBy('active desc, name asc')->all();
    }

}
