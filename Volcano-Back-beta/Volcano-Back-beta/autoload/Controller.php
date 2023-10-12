<?php

class Controller extends DB\SQL\Mapper
{
    public function __construct($table)
    {
        global $f3;
        parent::__construct($f3->get('DB'), $table);
    }

    public function getVolcanoById($v_id)
    {
        return $this->load(['id=?', $v_id]);
    }

    public function getVolcanoTotalNumByType($type)
    {
        return $this->count(array('primary_volcano_type=?', $type));
    }

    public function getVolcanoByType($type, $page)
    {
        $limit = 10; // records per page
        $offset = (intVal($page) - 1)* $limit;

        $result_array = array();
        $this->load(
            array('primary_volcano_type=?', $type),
            array('limit'=>$limit, 'offset'=>$offset)
        );
        while (!$this->dry()) {
//        $count = 0;
//        while ($count < 5) {
            $record = $this->cast();
            array_push($result_array, $record);
            $this->next();
//            $count += 1;
        }
        return $result_array;
    }

    public function getVolcanoByName($type, $name)
    {
        $this->load(['volcano_name=? AND primary_volcano_type=?', $name, $type]);
        if (!$this->dry())
        {
            return $this->load(['volcano_name=? AND primary_volcano_type=?', $name, $type])->cast();
        }
        return array('status_code'=>404, 'description'=>'Record not found');
    }

    public function likeVolcano($v_id)
    {
        $volcano = $this->getVolcanoById($v_id);
        $num_likes = $volcano->likes;
        $volcano->likes = $num_likes + 1;
        $volcano->update();
        return array('status_code'=>204, 'likes'=>$num_likes + 1);
    }

    public function dislikeVolcano($v_id)
    {
        $volcano = $this->getVolcanoById($v_id);
        $num_likes = $volcano->likes;
        $volcano->likes = $num_likes - 1;
        $volcano->update();
        return array('status_code'=>204, 'likes'=>$num_likes - 1);
    }

    public function getGraphs()
    {
        $result_array = array();
        $this->load();
        $count = 0;
        while (!$this->dry()) {
//        while ($count < 5) {
            $record = $this->cast();
            array_push($result_array, $record);
            $this->next();
//            $count += 1;
        }
        return $result_array;
    }

    public function putIntoDatabase($data)
    {
        $this->vName = $data['vName'];
        $this->eDesc = $data['eDesc'];
        $this->email = $data['email'];
        $this->save();
        return array('status_code'=>201, 'description'=>'Report Successfully!');
    }
}