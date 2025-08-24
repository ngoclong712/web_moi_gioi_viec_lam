<div class="col-md-6 col-lg-4">
    <div class="rotating-card-container manual-flip" style="height: 328.875px; margin-bottom: 30px;">
        <div class="card card-rotate">
            <div class="front" style="min_height: 328.875px;">
                @if($post->is_pinned == 1)
                <svg style="height: 20px; position: absolute; top: 10px; right: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M160 96C160 78.3 174.3 64 192 64L448 64C465.7 64 480 78.3 480 96C480 113.7 465.7 128 448 128L418.5 128L428.8 262.1C465.9 283.3 494.6 318.5 507 361.8L510.8 375.2C513.6 384.9 511.6 395.2 505.6 403.3C499.6 411.4 490 416 480 416L160 416C150 416 140.5 411.3 134.5 403.3C128.5 395.3 126.5 384.9 129.3 375.2L133 361.8C145.4 318.5 174 283.3 211.2 262.1L221.5 128L192 128C174.3 128 160 113.7 160 96zM288 464L352 464L352 576C352 593.7 337.7 608 320 608C302.3 608 288 593.7 288 576L288 464z"/></svg>
                @endif
                <div class="card-content">
                    <h5 class="category-social text-success">
                        <a href="{{ route('applicant.show', $post->id) }}">
                            <i class="fa fa-newspaper-o"></i> {{ $post->job_title }}
                        </a>
                    </h5>
                    <h4 class="card-title">
                        <a href="#pablo">{{ $languages }}</a>
                    </h4>
                    <p class="card-description">
                        {{ $post->location }}
                    </p>
                    <div class="footer" style="display: flex; align-items: center; justify-content: space-between">
                        <div class="author" style="float: left">
{{--                            @todo @longvn edit link company--}}
                            <a href="#">
                                @isset($company->logo)
                                    <img src="{{ $company->logo }}" class="avatar img-raised">
                                @endisset
                                <span>{{ $company->name }}</span>
                            </a>
                        </div>
                        <div>
                            {{ $post->salary }}
                        </div>
                    </div>
                    @if($post->is_not_open)
                        <div style="position: absolute; bottom: 10px; color: red; right: 10px">
                            <i class="fa fa-close"></i>
                            {{ __('frontpage.not_open') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
