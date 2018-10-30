<?php

namespace App;

use Auth;

trait Likeability 
{
    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function like()
    {
        $like = new Like([
            'user_id' => Auth::id()
        ]);

        $this->likes()->save($like);
    }

    public function unlike()
    {
        $this->likes()
            ->where(['user_id' => Auth::id()])
            ->delete();
    }

    public function isLiked()
    {
        return $this->likes()
                    ->where(['user_id' => Auth::id()])
                    ->exists();
    }

    public function toggle()
    {
        if($this->isLiked()){
            return $this->unlike();
        }

        return $this->like();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}