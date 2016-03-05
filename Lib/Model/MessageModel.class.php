<?php
class MessageModel extends RelationModel {
  
    protected $_link = array(
       'user'=> array(
            'mapping_type'  => BELONGS_TO,
            'class_name'    =>'User',
            'foreign_key'   =>'uid',
            'mapping_fields'=>'fakeid, nickname'
        ),
    );
    
}