@extends('layouts.app')

@section('content')

        <section class="mainLogo">
            <div class="container">
                <div class="searchBarIndexContainer">
                    <livewire:search-dropdown />
                </div>
            </div>
        </section>

    <livewire:load-more-album />

      <script type="text/javascript">
       $(document).ready(function() {
           if ($.cookie('pop') == null) {
               $('#stats').modal('show');
               $.cookie('pop', '1');
           }
       });
      </script>

@endsection

