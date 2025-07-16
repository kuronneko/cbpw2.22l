<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Album;
use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use App\Models\Stat;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\Else_;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha; //Trait

class LoadMoreComment extends Component
{
    public $amount = 3;
    public $albumId;
    public $name;
    public $text;

    public function render()
    {
        return view('livewire.load-more-comment', [
            'comments' => Comment::take($this->amount)->where('album_id', $this->albumId)->orderBy('updated_at', 'desc')->get(),
            'commentCheck' => $this->commentCheck(),
            'album' => Album::findOrFail($this->albumId),
        ]);
    }

    public function load()
    {
        $this->amount += 3;
    }

    public function hidden()
    {
        $this->amount = 3;
    }

    public function commentCheck()
    {
        $commentCheck = count(Comment::where('album_id', $this->albumId)->orderBy('updated_at', 'desc')->get());
        if ($commentCheck <= 3) {
            return 'minComments';
        } else if ($commentCheck <= $this->amount) {
            return 'maxComments';
        }
    }

    public function store()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to comment.');
            return;
        }

        // Simple rate limiting - 5 attempts per minute
        $key = 'comment:' . auth()->user()->id;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'text' => "Too many attempts. Try again in {$seconds} seconds."
            ]);
        }

        $this->name = auth()->user()->name;

        // Enhanced validation
        $this->validate([
            'name' => 'required|string|max:255',
            'text' => 'required|string|min:6|max:1000|regex:/^[^<>{}]*$/'
        ], [
            'text.regex' => 'Comment contains invalid characters.'
        ]);

        // Basic XSS protection
        $cleanText = strip_tags($this->text);
        $cleanText = htmlspecialchars($cleanText, ENT_QUOTES, 'UTF-8');

        // Check for duplicate recent comments
        $recentComment = Comment::where('user_id', auth()->user()->id)
            ->where('album_id', $this->albumId)
            ->where('text', $cleanText)
            ->where('created_at', '>', now()->subMinutes(2))
            ->exists();

        if ($recentComment) {
            session()->flash('error', 'You already posted this comment recently.');
            return;
        }

        try {
            $comment = new Comment();
            $comment->album_id = $this->albumId;
            $comment->user_id = auth()->user()->id;
            $comment->name = strip_tags($this->name);
            $comment->text = $cleanText;
            $comment->ip = request()->ip();
            $comment->save();

            // Update stats
            $stat = Stat::firstOrNew(['album_id' => $this->albumId]);
            $stat->qcomment = ($stat->qcomment ?? 0) + 1;
            if (!$stat->exists) {
                $stat->size = 0;
                $stat->qvideo = 0;
                $stat->qimage = 0;
                $stat->qlike = 0;
                $stat->view = 0;
            }
            $stat->save();

            Album::findOrFail($this->albumId)->touch();

            // Record attempt
            RateLimiter::hit($key, 60);

            $this->reset(['name', 'text']);
            session()->flash('message', 'Comment posted successfully');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to post comment. Please try again.');
        }
    }
}
