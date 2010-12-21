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
 * @version $Id: index.php 7311 2010-03-10 13:21:15Z matt $
 * @author Micah Carter <mcarter at tux dot appstate dot edu>
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../core/conf/404.html';
    exit();
}

// Check permissions
if (!Current_User::allow('golfer')) {
    return;
}

$error = NULL;

if (!isset($_REQUEST['action'])){
    $req = "";
} else {
    $req = strip_tags($_REQUEST['action']);
}

switch ($req) {
    case 'add_golfer':
        PHPWS_Core::initModClass('golfer','UI/AddGolferUI.php');
        $message = NULL;
        if(isset($_REQUEST['golfer_name']) && !empty($_REQUEST['golfer_name'])) {
            PHPWS_Core::initModClass('golfer','Golfer.php');
            $gname = strip_tags($_REQUEST['golfer_name']);
            isset($_REQUEST['current_handicap']) ? $hcap = strip_tags($_REQUEST['current_handicap']) : $hcap = NULL;
            $message = Golfer::addGolfer($gname,$hcap);
        }
        addGolferUI::showAddGolfer($message);
        break;
    case 'delete_golfer':
        $message = 'Unable to delete golfer.';
        if(isset($_REQUEST['id'])) {
            PHPWS_Core::initModClass('golfer','Golfer.php');
            $message = Golfer::deleteGolfer($_REQUEST['id']);
        }
        PHPWS_Core::initModClass('golfer','UI/GolferHomeUI.php');
        GolferHomeUI::display($message);
        break;
    case 'view_scores':
        if(isset($_REQUEST['id'])) {
            PHPWS_Core::initModClass('golfer','UI/ViewScoreUI.php');
            ViewScoreUI::showScores($_REQUEST['id']);
            break;
        } else {
            $error = 'Improper ID for golfer.';
        }
    case 'add_score':
        PHPWS_Core::initModClass('golfer','Score.php');
        Score::newScoreFromRequest(&$error);
        PHPWS_Core::initModClass('golfer','UI/ViewScoreUI.php');
        ViewScoreUI::showScores($_REQUEST['golfer_id']);
        break;
    case 'delete_score':
        PHPWS_Core::initModClass('golfer','Score.php');
        Score::deleteScore($_REQUEST['id']);
        PHPWS_Core::initModClass('golfer','UI/ViewScoreUI.php');
        ViewScoreUI::showScores($_REQUEST['golfer_id']);
        break;
    case 'recalc_all':
        PHPWS_Core::initModClass('golfer','Score.php');
        $result = Score::recalcAllHcaps();
        PHPWS_Core::initModClass('golfer','UI/GolferHomeUI.php');
        GolferHomeUI::display($result);
        break;
    default:
        PHPWS_Core::initModClass('golfer','UI/GolferHomeUI.php');
        GolferHomeUI::display($error);
        break;
}

?>
