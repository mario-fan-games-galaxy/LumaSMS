<?php

class CRUDController extends Controller
{
    protected $type = '';
    protected $join = [];
    protected $where = [];
    
    public function archive()
    {
        if (!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])) {
            $page = $GLOBALS['params'][0];
        } else {
            $page = 1;
        }
        
        $class = $this->type . 'Model';
        
        $objects = new $class();
        
        $objects = $objects->Read([
            'page' => $page,
            'join' => $this->join,
            'where' => $this->where,
        ]);
        
        echo view($this->type . '/archive', [
            'objects' => $objects['data'],
            'pages' => $objects['pages'],
            'page' => $page,
            'total' => $objects['total']
        ]);
    }
    
    public function single()
    {
        if (!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])) {
            $oid = $GLOBALS['params'][0];
        } else {
            $oid = 1;
        }
        
        
        
        
        
        if (!empty($GLOBALS['params'][2]) && is_numeric($GLOBALS['params'][2])) {
            $commentsPage = $GLOBALS['params'][2];
        } else {
            $commentsPage = 1;
        }
        
        
        
        
        
        $class = $this->type . 'Model';
        $object = new $class();
        $comments = new CommentsModel();
        
        
        
        
        
        $object = $object->Read([
            'limit' => 1,
            'where' => [
                [
                    'field' => $this->idField,
                    'value' => $oid
                ]
            ]
        ]);
        
        
        
        
        
        if (empty($object['data'])) {
            echo view('information', [
                'title' => 'Object Not Found',
                'message' => 'Could not find it'
            ]);
            
            return;
        }
        
        
        
        
        
        $object = $object['data'][0]->data;
        
        
        
        
        
        $comments = $comments->Read([
            'page' => $commentsPage,
            'where' => [
                [
                    'field' => 'rid',
                    'value' => $object[$this->idField]
                ],
                [
                    'field' => 'type',
                    'value' => $this->commentsType
                ]
            ]
        ]);
        
        
        
        
        
        echo view($this->type . '/single', [
            'object' => $object,
            'comments' => $comments['data'],
            'commentsPage' => $commentsPage,
            'commentsPages' => $comments['pages']
        ]);
    }
}
