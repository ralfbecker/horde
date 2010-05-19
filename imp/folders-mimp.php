<?php
/**
 * Mobile (MIMP) folder display page.
 *
 * URL Parameters:
 *   'ts' = (integer) Toggle subscribe view.
 *
 * Copyright 2000-2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * @author   Chuck Hagenbuch <chuck@horde.org>
 * @author   Anil Madhavapeddy <avsm@horde.org>
 * @author   Michael Slusarz <slusarz@horde.org>
 * @category Horde
 * @license  http://www.fsf.org/copyleft/gpl.html GPL
 * @package  IMP
 */

require_once dirname(__FILE__) . '/lib/Application.php';
Horde_Registry::appInit('imp', array('impmode' => 'mimp'));

/* Redirect back to the mailbox if folder use is not allowed. */
if (empty($conf['user']['allow_folders'])) {
    $notification->push(_("Folder use is not enabled."), 'horde.error');
    header('Location: ' . Horde::applicationUrl('mailbox-mimp.php', true));
    exit;
}

/* Decide whether or not to show all the unsubscribed folders */
$subscribe = $prefs->getValue('subscribe');
$showAll = (!$subscribe || $_SESSION['imp']['showunsub']);

/* Initialize the IMP_Imap_Tree object. */
$imptree = $injector->getInstance('IMP_Imap_Tree');
$mask = IMP_Imap_Tree::NEXT_SHOWCLOSED;

/* Toggle subscribed view, if necessary. */
if ($subscribe && Horde_Util::getFormData('ts')) {
    $showAll = !$showAll;
    $_SESSION['imp']['showunsub'] = $showAll;
    $imptree->showUnsubscribed($showAll);
    $mask |= IMP_Imap_Tree::NEXT_SHOWSUB;
}

/* Initialize Horde_Template. */
$t = $injector->createInstance('Horde_Template');

/* Start iterating through the list of mailboxes, displaying them. */
$rows = array();
$tree_ob = $imptree->build($mask);
foreach ($tree_ob[0] as $val) {
    $rows[] = array(
        'level' => str_repeat('&nbsp;', $val['level'] * 2),
        'label' => htmlspecialchars(Horde_String::abbreviate($val['base_elt']['l'], 30 - ($val['level'] * 2))),
        'link' => (empty($val['container']) ? IMP::generateIMPUrl('mailbox-mimp.php', $val['value']) : null),
        'msgs' => (isset($val['msgs']) ? ($val['unseen'] . '/' . $val['msgs']) : null)
    );
}
$t->set('rows', $rows);

$selfurl = Horde::applicationUrl('folders-mimp.php');
$menu = array(array(_("Refresh"), $selfurl));
if ($subscribe) {
    $menu[] = array(
        ($showAll ? _("Show Subscribed Folders") : _("Show All Folders")),
        $selfurl->copy()->add('ts', 1)
    );
}

$t->set('menu', $injector->getInstance('IMP_Ui_Mimp')->getMenu('folders', $menu));

$title = _("Folders");
$t->set('title', $title);

require_once IMP_TEMPLATES . '/common-header.inc';
IMP::status();
echo $t->fetch(IMP_TEMPLATES . '/mimp/folders/folders.html');
