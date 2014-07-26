<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 4:20 PM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("include/connect.php");
class LabelFunc {

    //add label
    public static function add($project, $list, $name, $textcolor, $backgroundcolor) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, project, list, labelname, textcolor, backgroundcolor) VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->bindParam(3, $name);
        $stmt->bindParam(4, $textcolor);
        $stmt->bindParam(5, $backgroundcolor);
        $stmt->execute();
    }

    //delete label
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit label
    public static function edit($id, $project, $list, $name, $textcolor, $backgroundcolor) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE `".$t."` SET project = ?, list = ?, labelname = ?, textcolor = ?, backgroundcolor = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->bindParam(3, $name);
        $stmt->bindParam(4, $textcolor);
        $stmt->bindParam(5, $backgroundcolor);
        $stmt->bindParam(6, $id);
        $stmt->execute();
    }

    //change color
    public static function changeColor($id, $textcolor, $backgroundcolor) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE `".$t."` SET textcolor = ?, backgroundcolor = ? WHERE id = ?");
        $stmt->bindParam(1, $textcolor);
        $stmt->bindParam(2, $backgroundcolor);
        $stmt->bindParam(3, $id);
        $stmt->execute();
    }

    //rename label
    public static function rename($id, $name) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE `".$t."` SET labelname = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    public static function details($id) {
        $details = array();
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("SELECT project, list, labelname, textcolor, backgroundcolor FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $details['project'] = $result['project'];
        $details['list'] = $result['list'];
        $details['label'] = $result['labelname'];
        $details['text'] = $result['textcolor'];
        $details['background'] = $result['backgroundcolor'];
        return $details;
    }

    public static function labels($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("SELECT id, labelname, textcolor, backgroundcolor FROM `".$t."` WHERE project = ? AND list = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->execute();
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

    public static function printAddForm($project, $list) {
        $out = '';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input name="project" type="hidden" value="'.$project.'">';
        $out .= '<input name="list" type="hidden" value="'.$list.'">';
        $out .= '<input name="labelname" type="text" placeholder="Label Name">';
        $out .= '<label for="textcolor">Text Color: </label><input type="color" name="textcolor"><br />';
        $out .= '<label for="backgroundcolor">Background Color: </label><input type="color" name="backgroundcolor"><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<input type="submit" class="submit" name="add_label" value="Add">';
        $out .= '</fieldset>';
        $out .= '</div>';

        return $out;
    }

    public static function printEditForm($id) {
        $details = self::details($id);
        $out = '';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input name="id" type="hidden" value="'.$id.'">';
        $out .= '<input name="project" type="hidden" value="'.$details['project'].'">';
        $out .= '<input name="list" type="hidden" value="'.$details['list'].'">';
        $out .= '<input name="labelname" type="text" value="'.$details['label'].'" placeholder="Label Name">';
        $out .= '<label for="textcolor">Text Color: </label><input type="color" name="textcolor" value="'.$details['text'].'"><br />';
        $out .= '<label for="backgroundcolor">Background Color: </label><input type="color" name="backgroundcolor" value="'.$details['background'].'"><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<input type="submit" id="submit" name="edit_label" value="Edit">';
        $out .= '</fieldset>';
        $out .= '</div>';
        return $out;
    }
}
?>