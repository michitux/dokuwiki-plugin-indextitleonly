<?php
/**
 * DokuWiki Plugin indextitleonly (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Michael Hamann <michael@content-space.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'action.php';

class action_plugin_indextitleonly extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler $controller) {
       $controller->register_hook('INDEXER_PAGE_ADD', 'BEFORE', $this, 'handle_indexer_page_add');
       $controller->register_hook('INDEXER_VERSION_GET', 'BEFORE', $this, 'handle_indexer_version_get');
    }

    public function handle_indexer_page_add(Doku_Event $event, $param) {
        if (strpos(getNS($event->data['page']).':', $this->getConf('namespace')) === 0) {
            $event->data['body'] = $event->data['metadata']['title'];
            $event->preventDefault();
        }
    }

    public function handle_indexer_version_get(Doku_Event $event, $param) {
        $event->data['indextitleonly'] = 1;
    }
}

// vim:ts=4:sw=4:et:
