<?php
define('APP_RUNNING', true);
session_start();

$LOGIN = 'admin';
$PASS = '123456';
//Список галерей, для кожної треба створити відповідний файл в папці data. В файл записати a:0:{}
$galleries = array(
    '1'=>'Букеты',
    '2'=>'Композиции',
);

if ($_POST['login'] == $LOGIN && $_POST['password'] == $PASS) {
    $_SESSION['admin'] = true;
}

if (!$_SESSION['admin']) {
    include './templates/login.tpl.php';
    exit();
}

function sendJSON($data)
{
    //Заголовки на всяк випадок шоб не кешувалось
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    //
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}

function saveUploadedImage($name)
{
    if (!$_FILES['file']['name']) return false;
    $fileName = '../images/' . $name . '.jpg';
    move_uploaded_file($_FILES['file']['tmp_name'], $fileName);
    return '/images/' . $name . '.jpg';
}

require './Data.class.php';

if($galleries[$_GET['gallery']]){
    $data = new Data('../data/images_'.$_GET['gallery']);
} else {
    $galeryIds = array_keys($galleries);
    $firstGaleryId = $galeryIds[0];
    header("Location: /manager/?gallery=".$firstGaleryId);
    exit();
}


switch ($_GET['action']) {
    case 'list':
        $data->load();
        sendJSON(array('success' => true, 'data' => $data->getAll()));
        break;

    case 'add':
        $data->load();
        $id = $data->generateId();
        $image = array(
            'id'=>$id,
            'title' => $_POST['title'],
            'price' => $_POST['price'],
            'image' => saveUploadedImage($id)
        );
        if ($image['image']) {
            $data->set($id, $image);
            $data->save();
            sendJSON(array('success' => true, 'data' => $image));
        } else {
            sendJSON(array('success' => false));
        }
        break;

    case 'save':
        $data->load();
        $id = $_POST['id'];
        $image = $data->get($id);
        $image['title'] = $_POST['title'];
        $image['price'] = $_POST['price'];
        $data->set($id, $image);
        $data->save();
        sendJSON(array('success' => true, 'data' => $image));
        break;

    case 'delete':
        $data->load();
        $id = $_POST['id'];
        $image = $data->get($id);
        $file = '..'.$image['image'];
        if(file_exists($file)){
            unlink($file);
        }
        $data->delete($id);
        $data->save();
        sendJSON(array('success' => true));
        break;

    default:
        include './templates/images.tpl.php';
}

