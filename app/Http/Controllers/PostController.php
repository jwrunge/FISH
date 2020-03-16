<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PostController extends Controller
{
    public function save($id, Request $request) {

        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ]);

        $posted_imgs = [];

        if($request->file('images')) {
            foreach($request->file('images') as $image) {

                //abort(401, $image->path() . "; " . $image->extension() . "; " . $image);

                //$source = file_get_contents($image);
                
                //Create and optimize file
                $filenameshort = '/images/uploads/'.time().'.'.$image->extension();
                $filename = public_path() . $filenameshort;
                
                // if(!file_put_contents($filename, $source))
                //     abort(400, "Something went wrong with your upload...");

                move_uploaded_file($image, $filename);

                //Optimize it
                $op = OptimizerChainFactory::create();
                $op->optimize($filename);

                array_push($posted_imgs, $filenameshort);
            }
        }

        if($id === 'new') { 
            $post = \App\Post::create($request->all() + ['user_id' => Auth::user()->id]);

            foreach($posted_imgs as $img) {
                \App\Imagepath::create(['src'=>$img, 'post_id'=>$post->id, 'rotation'=>0]);
            }
        }
        else {
            $post = \App\Post::find($id);

            if(!Auth::user()->can('changepost', $post)){
                abort(401, 'You are not authorized to take this action! Please sign in if you have not already.');
            }
            else {
                $post->update($request->all());

                foreach($posted_imgs as $img) {
                    \App\Imagepath::create(['src'=>$img, 'post_id'=>$post->id]);
                }
                
                //For any removed images, get rid of 'em!
                $removalarray = explode(',',$request->input('removeimgs'));

                if(count($removalarray)) {
                    foreach($removalarray as $imageid) {
                        $image = \App\Imagepath::find($imageid);
                        if($image) {
                            unlink(public_path($image->src));
                            $image->delete();
                        }
                    }
                }

                $images = \App\Imagepath::where('post_id', $post->id)->get();

                //For any rotated images, add rotate class
                $r1 = explode(',',$request->input('r1'));
                $r2 = explode(',',$request->input('r2'));
                $r3 = explode(',',$request->input('r3'));

                if(count($images)) {
                    foreach($images as $image) {
                        if(in_array($image->id, $r1))
                            $image->rotation = 90;
                        else if(in_array($image->id, $r2))
                            $image->rotation = 180;
                        else if(in_array($image->id, $r3))
                            $image->rotation = 270;
                        else
                            $image->rotation = 0;
                    
                        $image->save();
                    }
                }
            }
        }

        return redirect('/posts/'.$post->id); 
    }

    public function delete($id) {
        $post = \App\Post::find($id);

        if(!Auth::user()->can('changepost', $post)){
            abort(401, 'You are not authorized to take this action! Please sign in if you have not already.');
        }
        else {
            $images = \App\Imagepath::where('post_id', $post->id)->get();
            foreach($images as $image) {
                unlink(public_path($image->src));
                $image->delete();
            }
            $post->delete();
        }

        return redirect('/home');
    }
}
