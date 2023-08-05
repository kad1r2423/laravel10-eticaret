<?php


if(!function_exists('dosyasil')){
    function dosyasil($string){
        if(file_exists($string)){
            if(!empty($string)){
                unlink($string);
            }
        }
    }
}
if(!function_exists('klasorac')){
function klasorac($dosyayol, $izinler = 0777){
    if(!file_exists($dosyayol)) {
        mkdir($dosyayol, $izinler, true);
    }
}
}


if(!function_exists('resimyukle')){
    function resimyukle($image,$name,$yol){

        $uzanti = $image->getClientOriginalExtension();
        $dosyadi = time().'-'.Str::slug($name);
       // $resim->move(public_path('img/slider'),$dosyadi);
        if ($uzanti == 'pdf' || $uzanti == 'svg' || $uzanti == 'webp' || $uzanti == 'jiff'){
            $image->move(public_path($yol),$dosyadi.'.'.$uzanti);
            $resimurl = $yol.$dosyadi.'.'.$uzanti;
        }else{
            $image = ImageResize::make($image);
            $image->encode('webp', 75)->save($yol.$dosyadi.'.webp');
            $resimurl = $yol.$dosyadi.'.webp';
        }
         return $resimurl;
    }
}
