<?php

/**
 * Test the indextitleonly plugin
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author Michael Hamann <michael@content-space.de>
 */
class plugin_indextitleonly_test extends DokuWikiTest {
    public function setup() {
        global $conf;
        $this->pluginsEnabled[] = 'indextitleonly';
        parent::setup();

        $conf['plugin']['indextitleonly']['namespace'] = 'titleonly';

        saveWikiText('titleonly:sub:test', "====== Title ====== \n content", 'created');
        saveWikiText('test', "====== Title ====== \n content", 'created');
        idx_addPage('titleonly:sub:test');
        idx_addPage('test');
    }

    public function test_title_returns_both() {
        $query = array('title');
        $this->assertEquals(array('title' => array('test' => 1, 'titleonly:sub:test' => 1)), idx_get_indexer()->lookup($query));
    }

    public function test_content_doesnt_return_excluded() {
        $query = array('content');
        $this->assertEquals(array('content' => array('test' => 1)), idx_get_indexer()->lookup($query));
    }
}
