<?php
/**
 * See docs/AUTHORS and docs/COPYRIGHT for relevant info.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Micah Carter <mcarter at tux dot appstate dot edu>
 */

class Score {
    public $id = 0;
    public $golfer_id = NULL;
    public $created_date = 0;
    public $course_name = NULL;
    public $course_rating = NULL;
    public $slope = NULL;
    public $score = NULL;
    Public $note = NULL;

    public function __construct($id=NULL) {
        if (!$id) {
            return;
        }

        $this->id = (int)$id;
        $this->init();

    }
    
    public function init() {
        $db = new PHPWS_DB('golfer_score');
        $result = $db->loadObject($this);
        if (PHPWS_Error::isError($result)) {
            $this->_error = & $result;
            $this->id = 0;
        } elseif (!$result) {
            $this->id = 0;
        }
    }

    public function setGolferId($id) {
        $this->golfer_id = $id;
    }

    public function setCourseName($course_name) {
        $this->course_name = $course_name;
    }

    public function setCourseRating($course_rating) {
        $this->course_rating = $course_rating;
    }

    public function setSlope($slope) {
        $this->slope = $slope;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function setScore($score) {
        $this->score = $score;
    }

    public function getDifferential() {
        $diff = ($this->score - $this->course_rating) * 133 / $this->slope;
        return $diff;
    }

    public function save() {
        $this->created_date = time();
        $db = new PHPWS_DB('golfer_score');
        
        $result = $db->saveObject($this);
        if (PHPWS_Error::isError($result)) {
            return $result;
        }
    }

    public function delete() {
        $db = new PHPWS_DB('golfer_score');
        $db->addWhere('id',$this->id);
        $result = $db->delete();
        if (PHPWS_Error::isError($result)) {
            return $result;
        }
    }

    public function get_row_tags() {
        $rowTags = array();

        $rowTags['TIMESTAMP'] = date('m-d-Y g:ia',$this->created_date);
        $rowTags['DELETE'] = PHPWS_Text::moduleLink('Delete Score','golfer',array('action'=>'delete_score','id'=>$this->id,'golfer_id'=>$this->golfer_id));

        return $rowTags;
    }

    public function deleteScore($id) {
        if (!isset($id)) return 'Invalid score id.';
        $score = new Score($id);
        $result = $score->delete();
        if (PEAR::isError($result)) return $result;
        return 'Score deleted successfully.';
    }

    public function newScoreFromRequest($error) {
        if($_REQUEST['golfer_id'] && $_REQUEST['course_name'] && $_REQUEST['slope'] && $_REQUEST['score']) {
            $g = new Score;
            $g->setGolferId($_REQUEST['golfer_id']);
            $g->setCourseName($_REQUEST['course_name']);
            $g->setCourseRating($_REQUEST['course_rating']);
            $g->setSlope($_REQUEST['slope']);
            $g->setScore($_REQUEST['score']);
            $g->save();
        }
    }

    public function recalcAllHcaps() {
        PHPWS_Core::initModClass('golfer','Golfer.php');
        $db = new PHPWS_DB('golfer_golfer');
        $db->addColumn('id');
        $golfers = $db->select();
        foreach($golfers as $golfer) {
            $golfer = new Golfer($golfer['id']);
            $result .= $golfer->updateHandicap();
        }
        if (PEAR::isError($result)) return $result;
        return "Updated Successfully!";
    }
}

?>
