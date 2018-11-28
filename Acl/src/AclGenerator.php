<?php

namespace Vamshop\Acl;

use Acl\AclExtras;
use Cake\Core\Configure;
use Cake\Database\Exception;
use Cake\Datasource\ConnectionInterface;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;
use Vamshop\Core\Plugin;

class AclGenerator extends AclExtras
{
    public function __construct()
    {
        $this->Aco = TableRegistry::get('Vamshop/Acl.Acos');
        $this->_buildPrefixes();
    }

    public function insertAcos(ConnectionInterface $connection)
    {
        $this->Aco->connection($connection);
        $this->acoUpdate();
    }

    public function out($msg)
    {

        $dummyShell = new DummyShell();
        $this->Shell = $dummyShell;

        if (!isset($this->Shell)) {
            $msg = preg_replace('/\<\/?\w+\>/', null, $msg);
        }
        
        return parent::out($msg);
    }

    protected function _checkMethods($className, $controllerName, $node, $pluginPath = null, $prefixPath = null)
    {
        try {
            return parent::_checkMethods($className, $controllerName, $node, $pluginPath, $prefixPath);
        } catch (\Exception $exception) {
        }

        return false;
    }

    public function syncContentAcos()
    {
        $models = Configure::read('Access Control.models');
        if (!$models) {
            $message = 'No models are configured for row level access control';

        if ($this->controller) {
            $dummyShell = new DummyShell();
            $this->Shell = $dummyShell;
        }            
            
            if (isset($this->Shell) || isset($this->controller)) {
                $this->Shell->out($message);
            } else {
                \Cake\Log\Log::warning($message);
            }
        }
        $models = json_decode($models, true);

        $Acos = TableRegistry::get('Vamshop/Acl.Acos');
        $query = $Acos->node('contents');
        if ($query) {
            $parent = $query->first();
        } else {
            $entity = $Acos->newEntity([
                'parent_id' => null,
                'alias' => 'contents',
            ]);
            $parent = $Acos->save($entity);
        }
        foreach ($models as $model) {
            $Model = TableRegistry::get($model);
            $rows = $Model->find()
                ->select('id')
                ->all();
            foreach ($rows as $row) {
                try {
                    $node = $Acos->node($row);
                } catch (\Exception $e) {
                    $aco = $Acos->newEntity([
                        'model' => $Model->alias(),
                        'foreign_key' => $row->id,
                        'alias' => sprintf('%s.%s', $Model->alias(), $row->id),
                        'parent_id' => $parent->id,
                    ]);
                    $saved = $Acos->save($aco);
                }
            }
        }
    }

}

class DummyShell {
    use LogTrait;
    function out($msg, $newlines = 1, $level = 1) {
        $msg = preg_replace('/\<\/?\w+\>/', null, $msg);
        $this->log($msg);
    }
}
