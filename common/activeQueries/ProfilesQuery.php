<?php

namespace common\activeQueries;

/**
 * This is the ActiveQuery class for [[\common\models\Profiles]].
 *
 * @see \common\models\Profiles
 */
class ProfilesQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Profiles[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Profiles|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return Profiles ActiveRecord
     */
    public function allProfiles() {
        return $this->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param sring $profile profile
     * @return Profiles ActiveRecord
     */
    public function byProfile($profile) {
        return $this->where("profile = '$profile'")->one();
    }
    
    /**
     * 
     * @param integer $pk profile id
     * @param array $profiles profile names
     * @return Profiles ActiveRecord
     */
    public function byPkAndProfiles($pk, $profiles) {
        foreach ($profiles as $profile)
            $in = empty($in) ? "'$profile'" : "$in, '$profile'";
        
        return empty($in) ? false : $this->where("id = '$pk' && profile in ($in)")->one();
    }
    
    /**
     * 
     * @param integer $pk profile id
     * @param array $profiles profile names
     * @param integer $status profile status
     * @return Profiles ActiveRecord
     */
    public function byPkAndProfilesAndStatus($pk, $profiles, $status) {
        foreach ($profiles as $profile)
            $in = empty($in) ? "'$profile'" : "$in, '$profile'";
        
        return empty($in) ? false : $this->where("id = '$pk' && status = '$status' && profile in ($in)")->one();
    }
    
    /**
     * 
     * @param integer $status profile status
     * @return Profiles ActiveRecord
     */
    public function byStatus($status) {
        return $this->where("status = '$status'")->orderBy('name asc')->all();
    }

}
