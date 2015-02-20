<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 4:20 PM
 * Last Modified by Daniel Vidmar.
 */
class LabelFunc {

    //add label
    /**
     * @param $project
     * @param $list
     * @param $name
     * @param $textcolor
     * @param $backgroundcolor
     */
    public static function addLabel($project, $list, $name, $textcolor, $backgroundcolor) {
		global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, project, list, label_name, text_color, background_color) VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->execute(array($project, $list, $name, $textcolor, $backgroundcolor));
    }

    //delete label
    /**
     * @param $id
     */
    public static function deleteLabel($id) {
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //edit label
    /**
     * @param $id
     * @param $project
     * @param $list
     * @param $name
     * @param $textcolor
     * @param $backgroundcolor
     */
    public static function editLabel($id, $project, $list, $name, $textcolor, $backgroundcolor) {
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET project = ?, list = ?, label_name = ?, text_color = ?, background_color = ? WHERE id = ?");
        $stmt->execute(array($project, $list, $name, $textcolor, $backgroundcolor, $id));
    }

    //change color
    /**
     * @param $id
     * @param $textcolor
     * @param $backgroundcolor
     */
    public static function changeColor($id, $textcolor, $backgroundcolor) {
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET text_color = ?, background_color = ? WHERE id = ?");
        $stmt->execute(array($textcolor, $backgroundcolor, $id));
    }

    //rename label
    /**
     * @param $id
     * @param $name
     */
    public static function renameLabel($id, $name) {
        setValue("labels", "label_name", $name, " WHERE id = '".cleanInput($id)."'");
    }

    /**
     * @param $id
     * @return array
     */
    public static function labelDetails($id) {
        $details = array();
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("SELECT project, list, label_name, text_color, background_color FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $details['project'] = $result['project'];
        $details['list'] = $result['list'];
        $details['label'] = $result['label_name'];
        $details['text'] = $result['text_color'];
        $details['background'] = $result['background_color'];
        return $details;
    }

    /**
     * @param $project
     * @param $list
     * @return array
     */
    public static function labels($project, $list) {
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("SELECT id, label_name, text_color, background_color FROM `".$t."` WHERE project = ? AND list = ?");
        $stmt->execute(array($project, $list));
        $result = $stmt->fetchAll();

        $labels = array();
        for($i = 0; $i < count($result); $i++) {
            $label = $result[$i];
            //$labels[$i] = $label[0];
            $labels[$i] = array();
            $labels[$i]['id'] = $label[0];
            $labels[$i]['label'] = $label[1];
            $labels[$i]['text'] = $label[2];
            $labels[$i]['background'] = $label[3];
        }

        return $labels;
    }

    /**
     * @param $id
     * @return string
     */
    public static function printEditForm($id) {
        $details = self::labelDetails($id);
        $out = '';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input name="id" type="hidden" value="'.$id.'">';
        $out .= '<input name="project" type="hidden" value="'.$details['project'].'">';
        $out .= '<input name="list" type="hidden" value="'.$details['list'].'">';
        $out .= '<input name="labelname" type="text" value="'.$details['label'].'" placeholder="Label Name">';
        $out .= '<label for="textcolor">Text Color: </label><label id="labelcolor-text" style="background:'.$details['text'].';" onclick="linkColorField(event, \'labelcolor-text\', \'textcolor\'); return false;"></label><input type="hidden" name="textcolor" value="'.$details['text'].'"><br />';
        $out .= '<label for="backgroundcolor">Background Color: </label><label id="labelcolor-background" style="background:'.$details['background'].';"onclick="linkColorField(event, \'labelcolor-background\', \'backgroundcolor\'); return false;"></label><input type="hidden" name="backgroundcolor" value="'.$details['background'].'"><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<input type="submit" class="submit" name="edit-label" value="Edit">';
        $out .= '</fieldset>';
        $out .= '</div>';
        return $out;
    }
}
?>