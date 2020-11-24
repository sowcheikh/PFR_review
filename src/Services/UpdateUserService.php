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
    public function PutUser(Request $request,string $fileName = null, ProfilRepository $profilRepository){
        $raw =$request->getContent();
        //dd($raw);
        //dd($request->headers->get("content-type"));
        $delimiteur = "multipart/form-data; boundary=";
        $boundary= "--" . explode($delimiteur,$request->headers->get("content-type"))[1];
        $elements = str_replace([$boundary,'Content-Disposition: form-data;',"name="],"",$raw);
        //dd($elements);
        $elementsTab = explode("\r\n\r\n",$elements);
        //dd($elementsTab);
        $data =[];
        for ($i=0;isset($elementsTab[$i+1]);$i+=2){
            //dd($elementsTab[$i+1]);
            $key = str_replace(["\r\n",' "','"'],'',$elementsTab[$i]);
            //dd($key);
            if (strchr($key,$fileName)){
                $stream =fopen('php://memory','r+');
                //dd($stream);
                fwrite($stream,$elementsTab[$i +1]);
                rewind($stream);
                $data[$fileName] = $stream;
                //dd($data);
            }else{
                $val=$elementsTab[$i+1];
                //$val = str_replace(["\r\n", "--"],'',base64_encode($elementsTab[$i+1]));
                //dd($val);
                $data[$key] = $val;
                // dd($data[$key]);
            }
        }
        //dd($data);
        //$prof=$this->profilRepository->findOneBy(['libelle'=>$data["profile"]]);
        //$data["profile"] = $prof;
        //dd($data);
        return $data;

    }
}
