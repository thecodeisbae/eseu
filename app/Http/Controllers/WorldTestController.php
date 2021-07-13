<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class WorldTestController extends Controller
{
    //
    public function createWordDocx()
    {
        $wordTest =new \PhpOffice\PhpWord\PhpWord(); 
        $newSection = $wordTest->addSection();

        $desc1 = "1-Modélisation avec UML \n
        Pour la modélisation nous présenterons principalement le diagramme de cas d’utilisation.";
        $desc2 = "2-Modélisation avec UML \n
        Pour la modélisation nous présenterons principalement le diagramme de classes.";
        
        $newSection->addText($desc1);
        $newSection->addText($desc2);

        $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest,'Word2007');
        try{
            $objectWriter->save(storage_path('TestWordFile.docx'));
        }catch(Exception $e){
            
        }
        return response()->download(storage_path('TestWordFile.docx'));
    }
}
