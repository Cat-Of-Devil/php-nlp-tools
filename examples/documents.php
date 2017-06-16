<?php

include('autoload.php');
 
use \NlpTools\Tokenizers\WhitespaceTokenizer;
use \NlpTools\Documents\TokensDocument;
use \NlpTools\Documents\WordDocument;
 
$s1 = "Please allow me to introduce myself
        I'm a man of wealth and taste";
		
$s2 = "Hello, I love you, won't you tell me your name
        Hello, I love you, let me jump in your game";
 
$tok = new WhitespaceTokenizer();
 
 
$stones = new TokensDocument($tok->tokenize($s1)); // $stones now represents the "Sympathy for the devil" song
$doors = new TokensDocument($tok->tokenize($s2)); // $doors now represents the "Hello, I love you" song
 
 var_dump($stones);
 var_dump($doors);
 
 
 $s1 = "Please allow me to introduce myself
        I'm a man of wealth and taste";
$s2 = "Hello, I love you, won't you tell me your name
        Hello, I love you, let me jump in your game";
 
$tok = new WhitespaceTokenizer();
 
 
$stones = new WordDocument(
    $tok->tokenize($s1),
    2,
    4
); // $stones now represents the word 'me' in the context of 4
   // surrounding words in any direction
 
$doors = new WordDocument(
    $tok->tokenize($s2),
    7,
    4
); // $doors now also represents the word 'me' in the context of 4
   // surrounding words in any direction
 
 var_dump($stones);
 var_dump($doors);