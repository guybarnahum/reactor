<?php

    $qoutes = [
    
    [ 'content' =>"Java is to JavaScript what Car is to Carpet.", 'title' =>'Chris Heilmann' ],
    [ 'content' =>"It&#39;s hard enough to find an error in your code when you&#39;re looking for it; it&#39;s even harder when you&#39;ve assumed your code is error-free.", 'title' =>'Steve McConnell' ],
    [ 'content' =>"If debugging is the process of removing software bugs,\n then programming must be the process of putting them in.", 'title'=>' Edsger Dijkstra' ],
    [ 'content' =>"Rules of Optimization:\n Rule 1: Don&#39;t do it.\n Rule 2 (for experts only): Don&#39;t do it yet.", 'title'=>'Michael A. Jackson' ],
    [ 'content' =>"The best method for accelerating a computer is the one that boosts it by 9.8 m/s2.", 'title' =>'Anonymous' ],
    [ 'content' =>"Walking on water and developing software from a specification are easy if both are frozen.", 'title'=>'Edward V Berard' ],
    [ 'content' =>"Debugging is twice as hard as writing the code in the first place. Therefore, if you write the code as cleverly as possible, you are, by definition, not smart enough to debug it.", 'title'=>'Brian Kernighan' ],
    [ 'content' =>"It&#39;s not at all important to get it right the first time.\n It&#39;s vitally important to get it right the last time.", 'title'=>'Andrew Hunt and David Thomas' ],
    [ 'content' =>"First, solve the problem. Then, write the code.", 'title'=>'John Johnson' ],
    [ 'content' =>"Should array indices start at 0 or 1? My compromise of 0.5 was rejected without, I thought, proper consideration.", 'title'=>'Stan Kelly-Bootle' ],
    [ 'content' =>"Always code as if the guy who ends up maintaining your code will be a violent psychopath who knows where you live.", 'title'=>'Rick Osborne' ],
    [ 'content' =>"Any fool can write code that a computer can understand. Good programmers write code that humans can understand.", 'title'=>'Martin Fowler' ],
    [ 'content' =>"Software sucks because users demand it to.", 'title'=>'Nathan Myhrvold' ],
    [ 'content' =>"Linux is only free if your time has no value.", 'title'=>'Jamie Zawinski' ],
    [ 'content' =>"Beware of bugs in the above code; I have only proved it correct, not tried it.", 'title'=>'Donald Knuth' ],
    [ 'content' =>"There is not now, nor has there ever been, nor will there ever be, any programming language in which it is the least bit difficult to write bad code.", 'title'=>'Flon&#39;s Law' ],
    [ 'content' =>"The first 90% of the code accounts for the first 90% of the development time. The remaining 10% of the code accounts for the other 90% of the development time.", 'title'=>'Tom Cargill' ],
    [ 'content' =>"Good code is its own best documentation. As you&#39;re about to add a comment, ask yourself, \"How can I improve the code so that this comment isn&#39;t needed?\" Improve the code and then document it to make it even clearer.", 'title'=>'Steve McConnell' ],
    [ 'content' =>"Programs must be written for people to read, and only incidentally for machines to execute.", 'title'=>'Abelson / Sussman' ],
    [ 'content' =>"Most software today is very much like an Egyptian pyramid with millions of bricks piled on top of each other, with no structural integrity, but just done by brute force and thousands of slaves.", 'title'=>'Alan Kay' ],
    [ 'content' =>"Programming can be fun, so can cryptography; however they should not be combined.", 'title'=>'Kreitzberg and Shneiderman' ],
    [ 'content' =>"Copy and paste is a design error.", 'title'=>'David Parnas' ],
    [ 'content' =>"Before software can be reusable it first has to be usable.", 'title'=>'Ralph Johnson' ],
    [ 'content' =>"Without requirements or design, programming is the art of adding bugs to an empty text file.", 'title'=>'Louis Srygley' ],
    [ 'content' =>"When someone says, \"I want a programming language in which I need only say what I want done,\" give him a lollipop.", 'title'=>'Alan Perlis' ],
    [ 'content' =>"Computers are good at following instructions, but not at reading your mind.", 'title'=>'Donald Knuth' ],
    [ 'content' =>"Any code of your own that you haven&#39;t looked at for six or more months might as well have been written by someone else.", 'title' =>'Eagleson&#39;s law</b>' ],
    [ 'content' =>"Science is what we understand well enough to explain to a computer. Art is everything else we do.", 'title' =>'Donald Knuth' ],
    
    ];

// ......................................................... get_shuffled_qoutes
    
function get_shuffled_qoutes( $qoutes, $num )
{
    return get_random_qoutes( $qoutes, $num, $shuffle = true );
}
    
// ........................................................... get_random_qoutes
    
function get_random_qoutes( $qoutes, $num, $shuffle = false )
{
    $a = array();
    $q = array();
    
    while( $num-- ){
    
        // refill source of qoutes?
        if ( count($a) == 0 ) $a = $qoutes;
    
        // pick random $qoute
        $qix   = mt_rand( 0, count( $a ) - 1 );
        $qoute = (object)$a[ $qix ];
        
        // make html
        $qoute->content = nl2br( $qoute->content,false);
        $q[] = $qoute;
        
        if ( $shuffle ){
            unset( $a[ $qix ] );
            $a = array_values( $a );
        }
    }
    
    return $q;
}
    
// .................................................................... response
function response( $qoutes )
{
    $args = $_REQUEST;
    
    if ( isset( $args[ 'max' ] ) ){
        $num = min( count( $qoutes ), $args[ 'max' ] );
    }
    else{
        $num   = isset( $args[ 'num' ] )? $args[ 'num'   ] : 16;
    }
    
    $order = isset( $args[ 'order' ] )? $args[ 'order' ] : 'rand';

    switch( $order ){

        default         :
        case 'rand'     : $q = get_random_qoutes  ( $qoutes, $num ); break;
        case 'shuffle'  : $q = get_shuffled_qoutes( $qoutes, $num ); break;
    }
    
    if ( isset( $args[ 'debug' ] ) )
        $res = (object)[ 'args' => $args, 'num'=> $num, 'response' => $q ];
    else
        $res = $q;
        
    return json_encode( $res );
}

echo response( $qoutes );
