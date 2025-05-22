<?php

namespace app\controllers;

use app\models\posts as posts;
use app\models\comments as comments;
use app\models\interactions as inter;

class PostsController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){}

    public function getPosts($parmas = null){
        $posts = new posts();
        echo $posts->getAllPosts(5);
        //echo $posts->all();
    }
    
    public function lastPost($params = null){
        $posts = new posts();
        $rp = json_decode($posts->getLastPost());
        if( count($rp) > 0 ){
            $comments = new comments();
            $rc = $comments->count('postId')
                           ->where([['postId',$rp[0]->id]])
                           ->get();
            $inter = new inter();
            $ri = $inter->count('postId')
                        ->where([['postId',$rp[0]->id]])
                        ->get();
            $ri = self::youLiked($ri);
            echo json_encode( array_merge( $rp,json_decode($ri),json_decode($rc) ) );
        }else{
            echo json_encode(["r" => false ]);
        }

    }
    public function openPost($params = null){
        $posts = new posts();
        $pid = $params[2];
        $rp = json_decode($posts->openPost($pid));
        if( count($rp) > 0 ){
            $comments = new comments();
            $rc = $comments->count('postId')
                           ->where([['postId',$pid]])
                           ->get();
            $inter = new inter();
            $ri = $inter->count('postId')
                        ->where([['postId',$pid]])
                        ->get();
            $ri = self::youLiked($ri);
            echo json_encode( array_merge( $rp,json_decode($ri),json_decode($rc) ) );
        }else{
            echo json_encode(["r" => false ]);
        }

    }


    /** INTERACCIONES */
    private static function youLiked($ri){
        
        if( $_SESSION['sv'] ){
            $inter = new inter();
            $ri = json_decode( $ri );
            $ri[0]->liked = json_decode($inter
                                            ->count()
                                            ->where([['postId',$ri[0]->postId],['userId',$_SESSION['id']]])
                                            ->get())[0]->tt > 0 ? true : false;
            $ri = json_encode( $ri );
        }
      
        return $ri;
    }

    public function toggleLike($params){
        $inter = new inter();
        list(,,$pid,$uid) = $params;
        $inter -> toggleLike($pid,$uid);
        $ri = $inter->count('postid')->where([['postId',$pid]])->get();
        $ri = self::youliked($ri);
        echo $ri;
    }



    /** COMENTARIOS */
    public function getComments( $params=null ){
        $comments = new comments();
        $pid = $params[2];
        echo $comments -> getComments( $pid );
    }
    
    public function saveComment( $params=null){
        $comments = new comments();
        list(,,$pid,$uid) = $params;
        $comment = filter_input_array(INPUT_POST , FILTER_SANITIZE_SPECIAL_CHARS);
        $comments -> values = [$pid,$uid,$comment['comment'],1];
        $comments -> create();
        $rc = $comments->count('postId')->where([['postId',$pid]])->get();
        echo $rc;
    }
}