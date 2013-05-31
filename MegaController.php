<?php
class MegaController
{
    public $isSetup = false;
    protected $db = null;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function run()
    {
        if (!file_exists('setup.flag')) {
            $this->setup();
        }
        $this->render();
    }

    public function setup()
    {
        if (!file_exists('setup.flag')) {
            $this->getDb()->installApp();
            $ourFileName = realpath(dirname(__FILE__)) . "/setup.flag";
            $ourFileHandle = fopen($ourFileName, 'a+') or die("can't open file");
            fclose($ourFileHandle);
        }
        $this->render();
    }

    public function render()
    {
        require_once 'tz.phtml';
    }

    public function getDb()
    {
        if (!$this->db) {
            $this->db = new DB();
        }
        return $this->db;
    }

    public function getTreeJson($nodeId = null)
    {
        if (file_exists('setup.flag')) {
            return json_encode($this->getAllLevelChildren());
        }
    }

    public function getOneLevelChildren($parentNodeId = null)
    {
        if (file_exists('setup.flag')) {
            if (!$parentNodeId) {
                $where = 'parent_id is null';
            } else {
                $where = 'parent_id="' . $parentNodeId . '"';
            }
            $nodes = $this->db->query("SELECT id, label from nodes WHERE " . $where . ";");
            return $nodes;
        }
    }

    public function addNode( $id, $label= '', $parentNodeId = null)
    {
        if (file_exists('setup.flag')) {
            $result = $this->db->query("INSERT INTO nodes (id, label, parent_id)  (" . $id . "," . $label . "," . $parentNodeId . ");");
            return $result;
        }
    }

    public function removeNode( $id)
    {
        if (file_exists('setup.flag')) {
            $result = $this->db->query("DELETE  FROM nodes WHERE id='" . $id . "';");
            return $result;
        }
    }

    public function removeAllLevelChildren($parentNodeId = null)
    {
        if (file_exists('setup.flag')) {
            $this->removeNode($parentNodeId);
            $childNodes = $this->getOneLevelChildren($parentNodeId);
            foreach ($childNodes as $child) {
                $this->removeAllLevelChildren($child['id']);
            }
            return true;
        }
    }

    public function getAllLevelChildren($parentNodeId = null, $nodes = array())
    {
        if (file_exists('setup.flag')) {
            $childNodes = $this->getOneLevelChildren($parentNodeId);
            if ($childNodes) {
                $nodes['items'] = $childNodes;
                foreach ($childNodes as $child) {
                    $childChildNodes = $this->getAllLevelChildren($child['id'], $child);
                    if ($childChildNodes) {
                        $nodes['items'][$child['id']] = $childChildNodes;
                    }
                }
            }

            return $nodes;
        }
    }
}
