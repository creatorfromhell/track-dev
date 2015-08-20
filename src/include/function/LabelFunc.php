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
     * @param $text_color
     * @param $background_color
     */
    public static function add_label($project, $list, $name, $text_color, $background_color) {
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, project, list, label_name, text_color, background_color) VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->execute(array($project, $list, $name, $text_color, $background_color));
    }

    //delete label
    /**
     * @param $id
     */
    public static function delete_label($id) {
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
     * @param $text_color
     * @param $background_color
     */
    public static function edit_label($id, $project, $list, $name, $text_color, $background_color) {
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET project = ?, list = ?, label_name = ?, text_color = ?, background_color = ? WHERE id = ?");
        $stmt->execute(array($project, $list, $name, $text_color, $background_color, $id));
    }

    //change color
    /**
     * @param $id
     * @param $text_color
     * @param $background_color
     */
    public static function change_color($id, $text_color, $background_color) {
        global $prefix, $pdo;
        $t = $prefix."_labels";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET text_color = ?, background_color = ? WHERE id = ?");
        $stmt->execute(array($text_color, $background_color, $id));
    }

    //rename label
    /**
     * @param $id
     * @param $name
     */
    public static function rename_label($id, $name) {
        set_value("labels", "label_name", $name, " WHERE id = ?", array($id));
    }

    /**
     * @param $id
     * @return array
     */
    public static function label_details($id) {
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
}