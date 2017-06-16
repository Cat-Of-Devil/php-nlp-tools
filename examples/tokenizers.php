<?php

include('autoload.php');
 
use \NlpTools\Tokenizers\WhitespaceTokenizer;
use \NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;
use \NlpTools\Tokenizers\ClassifierBasedTokenizer;
use \NlpTools\Classifiers\ClassifierInterface;
use \NlpTools\Documents\DocumentInterface;
use NlpTools\Tokenizers\RegexTokenizer;

class EndOfSentence implements ClassifierInterface
{
    public function classify(array $classes, DocumentInterface $d) {
        list($token,$before,$after) = $d->getDocumentData();
 
        $dotcnt = count(explode('.',$token))-1;
        $lastdot = substr($token,-1)=='.';
 
        if (!$lastdot) // assume that all sentences end in full stops
            return 'O';
 
        if ($dotcnt>1) // to catch some naive abbreviations U.S.A.
            return 'O';
 
        return 'EOW';
    }
}

//$s = "Please allow me to introduce myself 
//        I'm a man of wealth and taste";
 
$s = "We are what we repeatedly do.
        Excellence, then, is not an act, but a habit.";
 
$rtok = new RegexTokenizer(array(
    array("/\s+/"," "),              // replace many spaces with a single space
    array("/'(m|ve|d|s)/", " '\$1"), // split I've, it's, we've, we'd, ...
    "/ /"                            // split on every space
));
$space = new WhitespaceTokenizer();
$punct = new WhitespaceAndPunctuationTokenizer();
// instantiate a binary classifier that chooses among the labels
// EOW --> End Of Word
// O   --> Other
// $cls <-- that classifier
$cls = new EndOfSentence();
$clstok = new ClassifierBasedTokenizer($cls, $punct);
 
$a = $space->tokenize($s);
// array('Please','allow','me','to','introduce','myself',
//      'I\'m','a','man','of','wealth','and','taste')

var_dump($a);

$a = $punct->tokenize($s);
// array('Please','allow','me','to','introduce','myself',
//      'I','\'','m','a','man','of','wealth','and','taste')
 
var_dump($a);

$a = $clstok->tokenize($s);
// output depends on the classifier

var_dump($a);

print_r($rtok->tokenize($s));
