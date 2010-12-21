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
 * @version $Id: Skeleton.php 7505 2010-04-15 20:07:35Z verdon $
 * @author Micah Carter <mcarter at tux dot appstate dot edu>
 */

class Golfer {
    public $id = 0;
    public $name = NULL;
    public $update_date = 0;
    public $current_handicap;

    public function __construct($id=NULL) {
        $this->id = (int)$id;
        $this->init();

    }
    
    public function init() {
        $db = new PHPWS_DB('golfer_golfer');
        $result = $db->loadObject($this);
        if (PHPWS_Error::isError($result)) {
            $this->_error = & $result;
            $this->id = 0;
        } elseif (!$result) {
            $this->id = 0;
        }
    }

    public function setName($name) {
        $this->name = strip_tags($name);
    }

    public function save() {
        $this->update_date = time();
        $db = new PHPWS_DB('golfer_golfer');
        
        $result = $db->saveObject($this);
        if (PHPWS_Error::isError($result)) {
            return $result;
        }
    }

    public function delete() {
        $gdb = new PHPWS_DB('golfer_golfer');
        $gdb->addWhere('id',$this->id);
        $result = $gdb->delete();
        if (PHPWS_Error::isError($result)) {
            return $result;
        }
        $sdb = new PHPWS_DB('golfer_score');
        $sdb->addWhere('golfer_id',$this->id);
        $result = $sdb->delete();
        if (PHPWS_Error::isError($result)) {
            return $result;
        }
    }

    public function get_row_tags() {
        $rowTags = array();

        $rowTags['SCORE_LINK'] = PHPWS_Text::moduleLink('View Scores','golfer',array('action'=>'view_scores','id'=>$this->id));
        if(Current_User::allow('delete_golfer')) {
           $rowTags['DELETE'] = PHPWS_Text::moduleLink('Delete Golfer','golfer',array('action'=>'delete_golfer','id'=>$this->id));
        }
        return $rowTags;
    }

    public function addGolfer($gname=NULL,$hcap=NULL) {
        if($gname == NULL) {
            return '"Add Golfer" failed.  You must specify a name.';
        }
        $golfer = new Golfer;
        $golfer->name = $gname;
        if($hcap) {
            $golfer->current_handicap = $hcap;
        }

        $result = $golfer->save();
        if (PEAR::isError($result)) {
            PHPWS_Core::initModClass('golfer','GolferHomeUI.php');
            GolferHomeUI::showAddGolfer($result);
        } else {
            return 'Added "'.$golfer->name.'" successfully.';
        }
    }

    public function deleteGolfer($id) {
        $golfer = new Golfer($id);
        $result = $golfer->delete();
        if (PEAR::isError($result)) return $result;
        return 'Deleted"'.$golfer->name.'" successfully.';
    }

    public function updateHandicap() {
        PHPWS_Core::initModClass('golfer','Score.php');
        $diffs = array();
        $db = new PHPWS_DB('golfer_score');
        $db->addWhere('golfer_id',$this->id);
        $scores = $db->select();
        foreach ($scores as $score) {
            $score = new Score($score['id']);
            $diffs[] = $score->getDifferential();
        }
        $numScores = count($diffs);
        if ($numScores < 5) {
            return; //Maybe put a message here?
        } else if ($numScores == 5 || $numScores == 6) {
            $diffsToUse = 1;
        } else if ($numScores == 7 || $numScores == 8) {
            $diffsToUse = 2;
        } else if ($numScores == 9 || $numScores == 10) {
            $diffsToUse = 3;
        } else if ($numScores == 11 || $numScores == 12) {
            $diffsToUse = 4;
        } else if ($numScores == 13 || $numScores == 14) {
            $diffsToUse = 5;
        } else if ($numScores == 15 || $numScores == 16) {
            $diffsToUse = 6;
        } else if ($numScores == 17) {
            $diffsToUse = 7;
        } else if ($numScores == 18) {
            $diffsToUse = 8;
        } else if ($numScores == 19) {
            $diffsToUse = 9;
        } else if ($numScores >= 20) {
            $diffsToUse = 10;
        }
        sort($diffs);
        $diffTotal = 0;
        for ($i = $diffsToUse; $i > 0; $i--) {
            $diffTotal += array_shift($diffs);
        }
        $diffTotal = $diffTotal / $diffsToUse;
        $diffTotal *= 0.96;
        $newHcap = floor($diffTotal * 10.0)/10.0;
        $this->current_handicap = $newHcap;
        return $this->save();
    }
}

?>
