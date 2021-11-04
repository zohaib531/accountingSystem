<?php
namespace App\Traits;
use Illuminate\Http\Request;

trait ImageUploadTrait{

    public function uploadImage($name,$path,$request,$old='')
    {
        if($request->hasFile($name))
        {
            $image_changed_name = time().'.'.$request->$name->getClientOriginalExtension();
            $request->file($name)->move(public_path($path), $image_changed_name);
            $path = '/public'.'/'.$path;
            $img_url = url($path)."/".$image_changed_name;
        }
        else{ $img_url = $old; }
        return $img_url;
    }

}

?>