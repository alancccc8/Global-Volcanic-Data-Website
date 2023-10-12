<?php
$home = '/home/'.get_current_user();

$f3 = require($home.'/AboveWebRoot/fatfree-master/lib/base.php');

// autoload Controller class(es) and anything hidden above web root, e.g. DB stuff
$f3->set('AUTOLOAD','autoload/;'.$home.'/AboveWebRoot/autoload/');

$db = DatabaseConnection::connect(); // defined as autoloaded class in AboveWebRoot/autoload/
$f3->set('DB', $db);
$f3->set('UI', 'dist/');
$f3->set('DEBUG',3);		// set maximum debug level
//=======================================================================
// URL

$f3->route('GET /',
    function($f3)
    {
//        $f3->set('html_title','Volcano');
//        echo template::instance()->render('index.html');
        echo 'hei';
    }
);

$f3->route('GET /volcano/@type/total',
    function($f3, $params)
    {
        $controller = new Controller('volcano-beta');
        $data = $controller->getVolcanoTotalNumByType($params['type']);
        echo json_encode($data);
    }
);

$f3->route('GET /volcano/@type',
    function($f3, $params)
    {
        // 获取查询参数
        $queryParams = array();
        parse_str($f3->get('QUERY'), $queryParams);
        $page = isset($queryParams['page']) ? intVal($queryParams['page']) : 1;

        $controller = new Controller('volcano-beta');
        $data = $controller->getVolcanoByType($params['type'], $page);
        echo json_encode($data);
    }
);

$f3->route('PUT /volcano/like/@v_id',
    function($f3, $params)
    {
        $controller = new Controller('volcano-beta');
        $res = $controller->likeVolcano($params['v_id']);
        echo json_encode($res);
    }
);

$f3->route('PUT /volcano/dislike/@v_id',
    function($f3, $params)
    {
        $controller = new Controller('volcano-beta');
        $res = $controller->dislikeVolcano($params['v_id']);
        echo json_encode($res);
    }
);

$f3->route('POST /volcano/report',
    function($f3)
    {
        $formdata = array();
        $formdata['vName'] = $f3->get('POST.vName');
        $formdata['eDesc'] = $f3->get('POST.eDesc');
        $formdata['email'] = $f3->get('POST.email');
        $controller = new Controller('report');
        $res = $controller->putIntoDatabase($formdata);
        echo json_encode($res);
    }
);

$f3->route('GET /volcano/learnmore',
    function($f3)
    {
        $controller = new Controller('learnmore');
        $data = $controller->getGraphs();
        echo json_encode($data);
    }
);

$f3->route('GET /volcano/search/@type/@name',
    function($f3, $params)
    {
        $controller = new Controller('volcano-beta');
        $data = $controller->getVolcanoByName($params['type'], $params['name']);
        echo json_encode($data);
    }
);

//====================================================================
// Run the FFF engine //
$f3->run();