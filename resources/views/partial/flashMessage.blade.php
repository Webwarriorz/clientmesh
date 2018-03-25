@if(!empty($flash = session('message')))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="flash-message" class="alert alert-success mb-5" role="alert">
                    {{$flash}}
                </div>

            </div>
        </div>
    </div>
@elseif(!empty($flash = session('message_important')))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="flash-message" class="alert alert-danger mb-5" role="alert">
                    {{$flash}}
                </div>
            </div>
        </div>
    </div>
@endif