<div>
    <div class="row">
        <div class="col-1 col-md-1">
            @if(Auth::check())
            <img src="{{config('myconfig.img.url')}}{{auth()->user()->avatar}}" class="avatarComment" alt="avatar">
            @else
            <img src="{{config('myconfig.img.url')}}{{config('myconfig.img.avatar')}}" class="avatarComment" alt="avatar">
            @endif
        </div>
        <div class="col-11 col-md-11">
           @if(Auth::check())
           <div class="form-group">
            @error('text') <small><span class="text-danger"> {{$message}} </span></small> @enderror
            @error('name') <small><span class="text-danger"> {{$message}} </span></small> @enderror
            <input type="hidden" wire:model="name" />
            <textarea rows="2" placeholder="Maximum length: 1000 characters" maxlength="1000" type="text" class="form-control commentForm text-white border-dark" wire:model="text"></textarea>
            </div>
           @else
           <div class="form-group">
            <input type="hidden" />
            <textarea rows="2" placeholder="Only registered users can post" maxlength="1000" type="text" class="form-control commentForm text-white border-dark" disabled></textarea>
            </div>
           @endif
        </div>
    </div>
      @if(Auth::check())
        <button wire:click="store" wire:loading.remove class="btn loadBtn btn-sm text-white float-right">
            Send Post  <i class="fas fa-paper-plane"></i>
        </button>
        <button wire:loading wire:target="store" class="btn loadBtn btn-sm text-white float-right">
            <div class="page-load-status">
                <div class="loader-ellips infinite-scroll-request">
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                  <span class="loader-ellips__dot"></span>
                </div>
              </div>
        </button>
        <x-honey-recaptcha/>
      @else
      <button class="btn loadBtn btn-sm text-white float-right disabled">
        Send Post  <i class="fas fa-paper-plane"></i>
      </button>
      @endif
</div>









