<?php

include('autoload.php');
 
use NlpTools\Stemmers\PorterStemmer;
use NlpTools\Documents\TokensDocument;
use NlpTools\Utils\StopWords;
use NlpTools\Utils\Normalizers\Normalizer;
 
 
$s = "People are strange when you 're a stranger
      faces look ugly when you 're alone";
 
$stemmer = new PorterStemmer();
 
// standalone usage
print_r($stemmer->stemAll(explode(" ", $s)));
 
// usage via TransformationInterface
$d = new TokensDocument(explode(" ", $s));
$d->applyTransformation($stemmer);
print_r($d->getDocumentData());

//-----------------------------------

$stop = new StopWords(array(
    "are",
    "you",
    "'re",
    "a"
));
 
$d = new TokensDocument(explode(" ", $s));
$d->applyTransformation($stop);
print_r($d->getDocumentData());
 
//--------------------------------------


$norm = Normalizer::factory("English");
 
// standalone usage
print_r($norm->normalizeAll(explode(" ", $s)));
 
// usage via TransformationInterface
$d = new TokensDocument(explode(" ", $s));
$d->applyTransformation($norm);
print_r($d->getDocumentData());


//------------------------------------------


/*
use NlpTools\Classifiers\ClassifierInterface;
use NlpTools\Utils\ClassifierBasedTransformation;
use NlpTools\Stemmers;
use NlpTools\Utils\Normalizers\Normalizer;
use NlpTools\Utils\StopWords;
use NlpTools\Documents\TokensDocument;
 
class LanguageDetector extends ClassifierInterface
{
    ...
}
$lang_detector = new LanguageDetector(...);
 
$greek = array(
    Normalizer::factory("Greek"),
    new StopWords(
        explode(
            "\n",
            file_get_contents("greek_stop_words")
        )
    ),
    new Stemmers\GreekStemmer()
);
 
$english = array(
    Normalizer::factory("English"),
    new StopWords(
        explode(
            "\n",
            file_get_contents("english_stop_words")
        )
    ),
    new Stemmers\PorterStemmer()
);
 
$transform = new ClassifierBasedTransformation($lang_detector);
$transform->register("English", $english);
$transform->register("Greek", $greek);
 
$s = "This text contains both Ελληνικά and English";
$d = new TokensDocument(explode(" ", $s));
$d->applyTransformation($transform);
print_r($d->getDocumentData());
 */