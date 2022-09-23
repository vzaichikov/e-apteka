<?php
/**********************************************************/
/*	@copyright	OCTemplates 2015-2019.					  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**********************************************************/

class ModelOctemplatesSreviewReviews extends Model {
    public function addReview($data) {
	    if (isset($data['avg_ratings'])) {
		    $avg_rating = 0;
			$rate_val   = 0;
		    $count_i = 0;
		    
		    foreach ($data['avg_ratings'] as $key => $avg_ratings) {
			    $rate_val = (int)$rate_val + (int)$avg_ratings;
                $count_i++;
		    }
		    
		    if ($rate_val != 0) {
	            $avg_rating = $rate_val / $count_i;
	        }
	        
	        $data['avg_rating'] = $avg_rating;
	    }
	    
        $this->db->query("INSERT INTO " . DB_PREFIX . "oct_sreview_reviews SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', status = '" . (int) $data['status'] . "', avg_rating = '" . (float)$data['avg_rating'] . "', date_added = '" . $this->db->escape($data['date_added']) . "'");

        $oct_sreview_review_id = $this->db->getLastId();
		
		if (isset($data['avg_ratings'])) {
		    foreach ($data['avg_ratings'] as $key => $avg_ratings) {
			    $this->db->query("INSERT INTO " . DB_PREFIX . "oct_sreview_reviews_vote SET oct_sreview_subject_id = '" . (int)$key . "', oct_sreview_review_id = '" . (int)$oct_sreview_review_id . "', rating = '" . (int)$avg_ratings . "'");
		    }
	    }
		
        if ($this->checkIfColumnExist(DB_PREFIX . "oct_sreview_reviews", "admin_text")) {
            $this->db->query("UPDATE " . DB_PREFIX . "oct_sreview_reviews SET admin_text = '" . $this->db->escape(strip_tags($data['admin_text'])) . "' WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
        } else {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "oct_sreview_reviews` ADD `admin_text` text COLLATE 'utf8_general_ci' NOT NULL AFTER `text`");

            $this->db->query("UPDATE " . DB_PREFIX . "oct_sreview_reviews SET admin_text = '" . $this->db->escape(strip_tags($data['admin_text'])) . "' WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
        }

        return $oct_sreview_review_id;
    }

    public function editReview($oct_sreview_review_id, $data) {
	    if (isset($data['avg_ratings'])) {
		    $avg_rating = 0;
			$rate_val   = 0;
		    $count_i = 0;
		    
		    foreach ($data['avg_ratings'] as $key => $avg_ratings) {
			    $rate_val = (int)$rate_val + (int)$avg_ratings;
                $count_i++;
		    }
		    
		    if ($rate_val != 0) {
	            $avg_rating = $rate_val / $count_i;
	        }
	        
	        $data['avg_rating'] = $avg_rating;
	    }
	    
        $this->db->query("UPDATE " . DB_PREFIX . "oct_sreview_reviews SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', status = '" . (int) $data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', avg_rating = '" . (float)$data['avg_rating'] . "', date_modified = NOW() WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
		
		if (isset($data['avg_ratings'])) {
		    foreach ($data['avg_ratings'] as $key => $avg_ratings) {
			    $this->db->query("UPDATE " . DB_PREFIX . "oct_sreview_reviews_vote SET rating = '" . (int)$avg_ratings . "' WHERE oct_sreview_subject_id = '" . (int)$key . "' AND oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
		    }
	    }
		
        if ($this->checkIfColumnExist(DB_PREFIX . "oct_sreview_reviews", "admin_text")) {
            $this->db->query("UPDATE " . DB_PREFIX . "oct_sreview_reviews SET admin_text = '" . $this->db->escape(strip_tags($data['admin_text'])) . "' WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
        } else {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "oct_sreview_reviews` ADD `admin_text` text COLLATE 'utf8_general_ci' NOT NULL AFTER `text`");

            $this->db->query("UPDATE " . DB_PREFIX . "oct_sreview_reviews SET admin_text = '" . $this->db->escape(strip_tags($data['admin_text'])) . "' WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
        }
    }

    public function deleteReview($oct_sreview_review_id) {
        $reviews = $this->getReviewVote($oct_sreview_review_id);

        if ($reviews) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_reviews_vote WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_reviews WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
    }

    public function getReviewVote($oct_sreview_review_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_sreview_reviews_vote WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");

        return $query->rows;
    }

    public function getReviewVotes($oct_sreview_review_id = 0) {
	    if ($oct_sreview_review_id) {
        	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_sreview_reviews_vote v LEFT JOIN " . DB_PREFIX . "oct_sreview_subject_description sd ON (v.oct_sreview_subject_id = sd.oct_sreview_subject_id) WHERE v.oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "' AND sd.language_id = '" . (int) $this->config->get('config_language_id') . "'");
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_sreview_reviews_vote v LEFT JOIN " . DB_PREFIX . "oct_sreview_subject_description sd ON (v.oct_sreview_subject_id = sd.oct_sreview_subject_id) WHERE sd.language_id = '" . (int) $this->config->get('config_language_id') . "'");
		}
		
		$reviews_vote_data = [];
		
		foreach ($query->rows as $reviews_vote) {
			$reviews_vote_data[(int)$reviews_vote['oct_sreview_subject_id']] = [
				'name' => $reviews_vote['name'],
				'rating' => $oct_sreview_review_id ? $reviews_vote['rating'] : 5,
			];
		}
		
        return $reviews_vote_data;
    }

    public function getReview($oct_sreview_review_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "oct_sreview_reviews WHERE oct_sreview_review_id = '" . (int) $oct_sreview_review_id . "'");
		
        return $query->row;
    }

    public function getReviews($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "oct_sreview_reviews WHERE date_added != '00-00-0000'";

        if (isset($data['filter_status'])) {
            $sql .= " AND status = '" . $data['filter_status'] . "'";
        }

        if (!empty($data['filter_author'])) {
            $sql .= " AND author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        $sort_data = array(
            'author',
            'rating',
            'status',
            'date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY date_added";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalReviews($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "oct_sreview_reviews WHERE date_added != '00-00-0000'";

        if (!empty($data['filter_author'])) {
            $sql .= " AND author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND status = '" . (int) $data['filter_status'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function checkIfColumnExist($table_name, $table_column) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . $table_name . "' AND COLUMN_NAME  = '" . $table_column . "'")->row['total'];

        return $query;
    }
}
