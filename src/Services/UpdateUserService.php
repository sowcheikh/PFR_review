<?php
namespace App\Services;



use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserService {
    private $profilRepository;

    public function __construct(ProfilRepository $profilRepository)
    {
    }


    /**
     * put image of user
     * @param Request $request
     * @param string|null $fileName
     * @param ProfilRepository $profilRepository
     * @return array
     */
    public function PutUser(Request $request, string $fileName = null){
        $raw =$request->getContent();
        $delimiteur = "multipart/form-data; boundary=";
        $boundary= "--" . explode($delimiteur,$request->headers->get("content-type"))[1];
        $elements = str_replace([$boundary,'Content-Disposition: form-data;',"name="],"",$raw);
        $elementsTab = explode("\r\n\r\n",$elements);
        //dd($elementsTab);
        $data =[];
        for ($i=0;isset($elementsTab[$i+1]);$i+=2){
            $key = str_replace(["\r\n",' "','"'],'',$elementsTab[$i]);
            if (strchr($key,$fileName)){
                $stream =fopen('php://memory','r+');
                fwrite($stream,$elementsTab[$i +1]);
                rewind($stream);
                $data[$fileName] = $stream;
            }else{
                $val=$elementsTab[$i+1];
                $data[$key] = $val;
            }
        }
        return $data;
    }
}
