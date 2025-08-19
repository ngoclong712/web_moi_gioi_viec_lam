<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Post extends Component
{
    /**
     * Create a new component instance.
     */
    public object $post;
    public string $languages;
    public ?object $company;

    public function __construct($post)
    {
        $this->post = $post;
        $this->languages = implode(", ", ($post->languages->pluck('name')->toArray()));
        $this->company = $post->company;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
