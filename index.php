<?php

    if(!array_key_exists('path', $_GET)){
        echo 'Error. Path missing';
        exit;
    }

    $path = explode('/', $_GET['path']);

    if(count($path) == 0 || $path[0] == ""){
        echo 'Error. Path missing';
        exit;
    }

    $param1 = "";
    if(count($path)>=2){
        $param1 = $path[1];
    }

    $contents = file_get_contents('db.json');

    $json = json_decode($contents, true);

    $method = $_SERVER['REQUEST_METHOD'];

    $cstrong = True;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

    header('Content-type: application/json');
    $body = file_get_contents('php://input');

    //pegar obj por id
    function findById($vetor, $param1){
        $r = -1;
        foreach($vetor as $key => $obj){
            if($obj['iduser'] == $param1){
                $r = $key;
                break;
            }
        }
        return $r;
    }


    //lista todos os obj
    if($method === 'GET'){ 
        if($json[$path[0]]){
            if($param1==""){
                echo json_encode($json[$path[0]]);
            }else{
                $r = findById($json[$path[0]], $param1);
                if($r>=0){
                    echo json_encode($json[$path[0]][$r]);
                }else{
                    echo 'ERROR.';
                    exit;
                }
            }
        }else{
            echo '[]';
        }      
    }

    //POST
    if($method === 'POST'){
        //cria usuario
        if($param1==""){
            if($json[$path[0]]){
                $jsonBody = json_decode($body, true);
                if(!isset($jsonBody['email'])){
                    echo "O Usuário já existe!";
                }else{
                    $post = filter_input_array(INPUT_POST);
                    $jsonBody['iduser'] = time();
                    $jsonBody['email'] = $post['email'];
                    $jsonBody['name'] = $post['name'];
                    $jsonBody['password'] = $post['password'];
                    $jsonBody['token'] = sha1($token);
        
                    if(!$json[$path[0]]){
                        $json[$path[0]] = [];
                    }else{
                        $json[$path[0]][] = $jsonBody;
                        echo json_encode($jsonBody);
                        file_put_contents('db.json', json_encode($json));
                    }
                }
                
            }
        }

        else if($param1=="login"){
                $post = filter_input_array(INPUT_POST);
                $r = $json[$path[0]];
                if(count($r) > 0){
                    foreach ($r as $key => $user) {                       
                        if($user["email"] == $post['email'] and $post['password'] == $user["password"]){
                            echo json_encode($user);
                            echo "<br>";
                            echo 'Logado!';
                        break;
                        }else{
                            echo 'O Usuário não existe ou senha inválida!';
                            exit;
                        }
                    }
                }
            }

        else if($param1==$param1."/drink"){
            $r = $json[$path[0]];

            if($user["iduser"] == $param1){
                $user["drink_counter"] = +1;
                echo json_encode($user);
                echo "<br>";
                echo 'Bebeu agua!';
            }else{
                echo 'Usuário não bebeu água!';
                exit;
            }
        }
    }
    

    //deleta o obj por id
    if($method === 'DELETE'){
        if($json[$path[0]]){
            if($param1==""){
                echo 'ERROR';
            }else{
                $r = findById($json[$path[0]], $param1);
                if($r>=0){
                    echo json_encode($json[$path[0]][$r]);
                    unset($json[$path[0]][$r]);
                    file_put_contents('db.json', json_encode($json));
                }else{
                    echo 'ERROR.';
                    exit;
                }
            }
        }else{
            echo '[]';
        } 
    }

    //edita o obj por id
    if($method === 'PUT'){
        if($json[$path[0]]){
            if($param1==""){
                echo 'ERROR';
            }else{
                $r = findById($json[$path[0]], $param1);
                if($r>=0){
                    $jsonBody = json_decode($body, true);
                    $jsonBody['iduser'] = $param1;
                    $json[$path[0]][$r] = $jsonBody;
                    echo json_encode($json[$path[0]][$r]);
                    file_put_contents('db.json', json_encode($json));
                }else{
                    echo 'ERROR.';
                    exit;
                }
            }
        }else{
            echo '[]';
        } 
    }

    