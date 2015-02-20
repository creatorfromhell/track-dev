<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/13/14
 * Time: 6:20 PM
 * Version: Beta 1
 * Last Modified: 5/13/14 at 6:20 PM
 * Last Modified by Daniel Vidmar.
 */
$rules['table'] = array(
    'templates' => array(
        'languages' => '{include->'.$manager->GetTemplate((string)$theme->name, "tables/Languages.tpl").'}',
        'themes' => '{include->'.$manager->GetTemplate((string)$theme->name, "tables/Themes.tpl").'}',
        'plugins' => '{include->'.$manager->GetTemplate((string)$theme->name, "tables/Plugins.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'short' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->short)),
    'icon' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->icon)),
    'name' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)),
    'author' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->author)),
    'version' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->version)),
    'site' => 'site',
    'actions' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)),
);
$rules['table']['pages'] = array(
    'languages' => ' ',
    'themes' => ' ',
);
$languages_content = '';
$themes_content = '';
$plugins_content = '';
foreach($langmanager->languages as &$l) {
    $languages_content .= "<tr>";
    $languages_content .= "<td class='short'>".(string)$l->short."</td>";
    $languages_content .= "<td class='icon'><img src='resources/themes/".(string)$theme->directory."/img/".(string)$l->symbol."' /></td>";
    $languages_content .= "<td class='name'>".(string)$l->name."</td>";
    $languages_content .= "<td class='author'>".(string)$l->author."</td>";
    $languages_content .= "<td class='version'>".(string)$l->version."</td>";
    $languages_content .= "<td class='actions'>".$formatter->replaceShortcuts('%none')."</td>";
    $languages_content .= "</tr>";
}
foreach($manager->themes as &$t) {
    $name = (string)$t->name;
    $themes_content .= "<tr>";
    $themes_content .= "<td class='name'>".$name."</td>";
    $themes_content .= "<td class='author'>".(string)$t->author."</td>";
    $themes_content .= "<td class='version'>".(string)$t->version."</td>";
    $themes_content .= "<td class='actions'>".$formatter->replaceShortcuts('%none')."</td>";
    $themes_content .= "</tr>";
}
foreach($plugin_manager->plugins as &$plugin) {
    $info = $plugin['info'];
    $default = "unknown";
    $name = isset($info['name']) ? $info['name'] : $default;
    $author = isset($info['author']) ? $info['author'] : $default;
    $version = isset($info['version']) ? $info['version'] : $default;
    $site = isset($info['link']) ? $info['link'] : $default;
    $plugins_content .= "<tr>";
    $plugins_content .= "<td class='name'>".$name."</td>";
    $plugins_content .= "<td class='author'>".$author."</td>";
    $plugins_content .= "<td class='version'>".$version."</td>";
    $plugins_content .= "<td class='site'>".$site."</td>";
    $plugins_content .= "</tr>";

}
$rules['table']['content'] = array(
    'languages' => $languages_content,
    'themes' => $themes_content,
    'plugins' => $plugins_content,
);

?>