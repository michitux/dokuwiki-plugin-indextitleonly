<?php
/**
 * DokuWiki Plugin indextitleonly (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Michael Hamann <michael@content-space.de>
 */

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\Event;
use dokuwiki\Extension\EventHandler;

class action_plugin_indextitleonly extends ActionPlugin
{
    /** @inheritdoc */
    public function register(EventHandler $controller)
    {
        $controller->register_hook('INDEXER_PAGE_ADD', 'BEFORE', $this, 'handle_indexer_page_add');
        $controller->register_hook('INDEXER_VERSION_GET', 'BEFORE', $this, 'handle_indexer_version_get');
    }

    public function handle_indexer_page_add(Event $event, $param)
    {
        if (strpos(getNS($event->data['page']) . ':', $this->getConf('namespace')) === 0) {
            $event->data['body'] = $event->data['metadata']['title'];
            $event->preventDefault();
        }
    }

    public function handle_indexer_version_get(Event $event, $param)
    {
        $event->data['indextitleonly'] = 1;
    }
}

// vim:ts=4:sw=4:et:
